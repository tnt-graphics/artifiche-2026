<?php
/**
 * Nächtlicher Import: Kategorien sauber halten.
 *
 * 1) Oberkategorie per Nummer statt per Name setzen.
 *    WP All Import sucht die Oberkategorie über den Namen (Kategorie_D_Haupt / Kategorie_E_Haupt).
 *    Das geht schief, wenn
 *    - DE und EN gleich heissen ("Restaurants & Hotels") -> EN-Unterkategorie landet unter DE-Oberkategorie
 *    - Unterkategorie gleich heisst wie Oberkategorie ("Verschiedenes" > "Verschiedenes").
 *    Die CSV-Nummern sind eindeutig: die Oberkategorie von "30.01" ist "30" (= Spalte Unterkat_Link).
 *    Nach jedem Kategorien-Import setzen wir die Oberkategorie deshalb über die Import-Zuordnung
 *    Nummer -> Begriff desselben Imports (also immer dieselbe Sprache).
 *
 * 2) Nach dem letzten Import der Kette: Mail, falls Begriffe mit Plakaten keinen DE/EN-Partner haben.
 */

/**
 * Kategorien-Imports: Import-ID => Taxonomie.
 */
function artf_category_fix_imports() {
	return array(
		138 => 'product_cat', // Kategorien_DE.
		139 => 'product_cat', // Kategorien_EN.
	);
}

/**
 * Oberkategorien eines Kategorien-Imports anhand der Nummern korrigieren.
 *
 * @param int $import_id WP All Import ID.
 * @return int Anzahl korrigierter Begriffe.
 */
function artf_fix_category_parents( $import_id ) {
	$imports   = artf_category_fix_imports();
	$import_id = (int) $import_id;

	if ( ! isset( $imports[ $import_id ] ) ) {
		return 0;
	}

	global $wpdb;
	$taxonomy = $imports[ $import_id ];
	$logger   = function_exists( 'wc_get_logger' ) ? wc_get_logger() : null;

	// Nummer (unique_key) => term_id, nur Begriffe dieses Imports (= eine Sprache).
	$rows = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT p.unique_key, p.post_id AS term_id, tt.parent
			 FROM {$wpdb->prefix}pmxi_posts p
			 JOIN {$wpdb->term_taxonomy} tt ON tt.term_id = p.post_id AND tt.taxonomy = %s
			 WHERE p.import_id = %d",
			$taxonomy,
			$import_id
		)
	);

	$by_key = array();
	foreach ( $rows as $row ) {
		$by_key[ (string) $row->unique_key ] = (int) $row->term_id;
	}

	$fixed = 0;
	foreach ( $rows as $row ) {
		$key = (string) $row->unique_key;

		// "30.01" -> "30"; Hauptkategorien ("30") haben keine Oberkategorie.
		$pos        = strrpos( $key, '.' );
		$parent_key = ( false === $pos ) ? '' : substr( $key, 0, $pos );

		if ( '' === $parent_key ) {
			$wanted = 0;
		} elseif ( isset( $by_key[ $parent_key ] ) ) {
			$wanted = $by_key[ $parent_key ];
		} else {
			// Oberkategorie (noch) nicht importiert -> nichts anfassen.
			continue;
		}

		if ( (int) $row->parent === $wanted || (int) $row->term_id === $wanted ) {
			continue;
		}

		$result = wp_update_term( (int) $row->term_id, $taxonomy, array( 'parent' => $wanted ) );

		if ( is_wp_error( $result ) ) {
			$logger && $logger->warning(
				sprintf( 'Kategorie %s (Term %d): Oberkategorie konnte nicht gesetzt werden: %s', $key, $row->term_id, $result->get_error_message() ),
				array( 'source' => 'artf-all-import-log' )
			);
			continue;
		}

		$fixed++;
		$logger && $logger->info(
			sprintf( 'Kategorie %s (Term %d): Oberkategorie %d -> %d', $key, $row->term_id, $row->parent, $wanted ),
			array( 'source' => 'artf-all-import-log' )
		);
	}

	if ( $fixed ) {
		delete_option( $taxonomy . '_children' );
		clean_term_cache( array_values( $by_key ), $taxonomy );
	}

	return $fixed;
}

/**
 * Läuft nach WP All Import (Prio 10, setzt Oberkategorien per Name) und vor der Import-Kette (Prio 999).
 */
function artf_after_import_fix_category_parents( $import_id ) {
	artf_fix_category_parents( $import_id );
}
add_action( 'pmxi_after_xml_import', 'artf_after_import_fix_category_parents', 20, 1 );

/**
 * URLs schützen: Wenn WP All Import eine bestehende Kategorie aktualisiert, bleibt der Slug (URL) gleich.
 * Ohne das würde WordPress den Slug aus dem Namen neu bilden ("restaurants-hotels-en" -> "restaurants-hotels").
 */
function artf_keep_category_slug_on_import( $data, $term_id, $taxonomy ) {
	if ( 'product_cat' !== $taxonomy || ! function_exists( 'artifiche_is_wp_all_import_request' ) ) {
		return $data;
	}
	if ( ! artifiche_is_wp_all_import_request() && ! ( defined( 'WP_CLI' ) && WP_CLI ) ) {
		return $data;
	}
	$term = get_term( (int) $term_id, $taxonomy );
	if ( $term instanceof WP_Term && '' !== $term->slug ) {
		$data['slug'] = $term->slug;
	}
	return $data;
}
add_filter( 'wp_update_term_data', 'artf_keep_category_slug_on_import', 10, 3 );

/**
 * Einmalige Bereinigung: bestehende EN-Kategorien (mit Plakaten) übernehmen statt löschen.
 *
 * Pro Nummer:
 * - leere Doppel (0 Plakate) löschen
 * - die EN-Kategorie mit Plakaten in WPML mit der DE-Kategorie verknüpfen
 * - die EN-Kategorie dem Import Kategorien_EN (139) unter dieser Nummer zuordnen
 * Namen, Slugs (URLs) und Plakat-Zuordnungen bleiben unverändert.
 *
 * Bricht ab, ohne etwas zu ändern, wenn ein Begriff nicht dem erwarteten Stand entspricht.
 *
 * @param bool $dry_run Nur prüfen.
 * @return array Protokollzeilen.
 */
function artf_adopt_category_terms( $dry_run = true ) {
	global $wpdb;

	$tax = 'product_cat';
	$map = array(
		// Nummer => DE (Import 138), EN zu übernehmen, leere Begriffe zum Löschen.
		'30'    => array( 'de' => 90906, 'en' => 79264, 'delete' => array() ),
		'30.01' => array( 'de' => 90907, 'en' => 91944, 'delete' => array( 91087 ) ),
		'30.02' => array( 'de' => 90908, 'en' => 79265, 'delete' => array( 91088, 91765 ) ),
		'35'    => array( 'de' => 90956, 'en' => 75503, 'delete' => array() ),
		'35.01' => array( 'de' => 90957, 'en' => 79263, 'delete' => array( 75603 ) ),
		'35.02' => array( 'de' => 90958, 'en' => 75504, 'delete' => array() ),
	);
	$expected_names = array(
		90906 => 'Restaurants & Hotels', 79264 => 'Restaurants & Hotels',
		90907 => 'Restaurants', 91944 => 'Restaurants', 91087 => 'Restaurants',
		90908 => 'Hotels, Grand Hotels', 79265 => 'Hotels, Grand Hotels', 91088 => 'Hotels, Grand Hotels', 91765 => 'Hotels, Grand Hotels',
		90956 => 'Transport und Fracht', 75503 => 'Transport & Freight',
		90957 => 'Transport, verschiedene', 79263 => 'Freight, various', 75603 => 'Freight, various',
		90958 => 'Post', 75504 => 'Post',
	);

	$log  = array();
	$info = function ( $term_id ) use ( $wpdb, $tax ) {
		return $wpdb->get_row(
			$wpdb->prepare(
				"SELECT t.term_id, t.name, t.slug, tt.term_taxonomy_id, tt.count, i.language_code, i.trid
				 FROM {$wpdb->terms} t
				 JOIN {$wpdb->term_taxonomy} tt ON tt.term_id = t.term_id AND tt.taxonomy = %s
				 LEFT JOIN {$wpdb->prefix}icl_translations i ON i.element_id = tt.term_taxonomy_id AND i.element_type = %s
				 WHERE t.term_id = %d",
				$tax,
				'tax_' . $tax,
				$term_id
			)
		);
	};

	// 1) Prüfen.
	$errors = array();
	foreach ( $map as $key => $m ) {
		$de = $info( $m['de'] );
		$en = $info( $m['en'] );
		$de_owned = (int) $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM {$wpdb->prefix}pmxi_posts WHERE import_id = 138 AND unique_key = %s", $key ) );

		if ( ! $de || 'de' !== $de->language_code || html_entity_decode( $de->name ) !== $expected_names[ $m['de'] ] || $de_owned !== (int) $m['de'] ) {
			$errors[] = "$key: DE-Begriff {$m['de']} entspricht nicht dem erwarteten Stand.";
		}
		if ( ! $en || 'en' !== $en->language_code || html_entity_decode( $en->name ) !== $expected_names[ $m['en'] ] ) {
			$errors[] = "$key: EN-Begriff {$m['en']} entspricht nicht dem erwarteten Stand.";
		}
		foreach ( $m['delete'] as $del_id ) {
			$del = $info( $del_id );
			if ( ! $del ) {
				$log[] = "$key: Begriff $del_id existiert nicht mehr (ok).";
				continue;
			}
			if ( (int) $del->count !== 0 || html_entity_decode( $del->name ) !== $expected_names[ $del_id ] ) {
				$errors[] = "$key: Begriff $del_id ({$del->name}) hat {$del->count} Plakate oder anderen Namen - wird nicht gelöscht.";
			}
		}
	}

	if ( $errors ) {
		return array_merge( array( 'ABBRUCH - nichts geändert:' ), $errors );
	}

	$iteration = (int) $wpdb->get_var( "SELECT MAX(iteration) FROM {$wpdb->prefix}pmxi_posts WHERE import_id = 139" );

	// 2) Ausführen.
	foreach ( $map as $key => $m ) {
		$de = $info( $m['de'] );
		$en = $info( $m['en'] );

		foreach ( $m['delete'] as $del_id ) {
			if ( ! $info( $del_id ) ) {
				continue;
			}
			$log[] = "$key: leeren Begriff $del_id löschen";
			if ( ! $dry_run ) {
				$wpdb->delete( $wpdb->prefix . 'pmxi_posts', array( 'post_id' => $del_id, 'import_id' => 139 ) );
				$wpdb->delete( $wpdb->prefix . 'pmxi_hash', array( 'post_id' => $del_id, 'import_id' => 139 ) );
				wp_delete_term( $del_id, $tax );
			}
		}

		$log[] = sprintf( '%s: EN %d "%s" (%s, %d Plakate) mit DE %d "%s" verknüpfen und Import 139 zuordnen', $key, $en->term_id, html_entity_decode( $en->name ), $en->slug, $en->count, $de->term_id, html_entity_decode( $de->name ) );

		if ( $dry_run ) {
			continue;
		}

		do_action(
			'wpml_set_element_language_details',
			array(
				'element_id'           => (int) $en->term_taxonomy_id,
				'element_type'         => 'tax_' . $tax,
				'trid'                 => (int) $de->trid,
				'language_code'        => 'en',
				'source_language_code' => 'de',
			)
		);

		$wpdb->delete( $wpdb->prefix . 'pmxi_posts', array( 'import_id' => 139, 'unique_key' => $key ) );
		$wpdb->insert(
			$wpdb->prefix . 'pmxi_posts',
			array(
				'post_id'     => (int) $en->term_id,
				'import_id'   => 139,
				'unique_key'  => $key,
				'product_key' => 'taxonomy_term',
				'iteration'   => $iteration,
				'specified'   => 0,
			)
		);
	}

	if ( ! $dry_run ) {
		artf_fix_category_parents( 138 );
		artf_fix_category_parents( 139 );
		delete_option( $tax . '_children' );
		update_option( 'artf_adopt_category_terms_done', current_time( 'mysql' ), false );
		$log[] = 'Fertig.';
	}

	return $log;
}

/**
 * Auslösen als Admin: /wp-admin/?artf_adopt_categories=check (nur prüfen) bzw. =run (ausführen).
 */
function artf_adopt_category_terms_admin_trigger() {
	if ( empty( $_GET['artf_adopt_categories'] ) || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$run = ( 'run' === $_GET['artf_adopt_categories'] );
	$log = artf_adopt_category_terms( ! $run );
	wp_die( '<h1>Kategorien übernehmen (' . ( $run ? 'AUSGEFÜHRT' : 'nur Prüfung' ) . ')</h1><pre>' . esc_html( implode( "\n", $log ) ) . '</pre>' );
}
add_action( 'admin_init', 'artf_adopt_category_terms_admin_trigger' );

/**
 * Begriffe mit Plakaten, die keinen DE/EN-Partner haben.
 *
 * @return array Liste von Zeilen (taxonomy, term_id, name, lang, count).
 */
function artf_find_unlinked_terms() {
	global $wpdb;

	$taxonomies = array( 'product_cat', 'kollektionen', 'drucktechnik', 'publikationen', 'marke', 'kunstler', 'pa_land', 'pa_stilrichtung' );
	$in         = implode( ',', array_fill( 0, count( $taxonomies ), '%s' ) );

	return $wpdb->get_results(
		$wpdb->prepare(
			"SELECT tt.taxonomy, t.term_id, t.name, i.language_code AS lang, tt.count
			 FROM {$wpdb->term_taxonomy} tt
			 JOIN {$wpdb->terms} t ON t.term_id = tt.term_id
			 JOIN {$wpdb->prefix}icl_translations i
			   ON i.element_id = tt.term_taxonomy_id AND i.element_type = CONCAT('tax_', tt.taxonomy)
			 WHERE tt.taxonomy IN ($in)
			   AND tt.count > 0
			   AND ( SELECT COUNT(*) FROM {$wpdb->prefix}icl_translations i2 WHERE i2.trid = i.trid ) < 2
			 ORDER BY tt.taxonomy, t.name",
			$taxonomies
		)
	);
}

/**
 * Nach dem letzten Import (Plakatexport_EN) prüfen und bei Problemen eine Mail schicken.
 */
function artf_after_import_check_unlinked_terms( $import_id ) {
	if ( 147 !== (int) $import_id ) {
		return;
	}

	$rows = artf_find_unlinked_terms();
	if ( empty( $rows ) ) {
		return;
	}

	$lines = array();
	foreach ( $rows as $row ) {
		$lines[] = sprintf( '- [%s] %s (%s, ID %d, %d Plakate)', $row->taxonomy, html_entity_decode( $row->name ), strtoupper( $row->lang ), $row->term_id, $row->count );
	}

	$message = "Nach dem nächtlichen Import haben folgende Begriffe keine Übersetzung (DE/EN).\n"
		. "Der Sprachwechsel auf diesen Seiten funktioniert deshalb nicht.\n\n"
		. implode( "\n", $lines ) . "\n";

	if ( function_exists( 'wc_get_logger' ) ) {
		wc_get_logger()->warning( $message, array( 'source' => 'artf-all-import-log' ) );
	}

	// Bewusst nicht admin_email (gehört noch der früheren Agentur).
	$to = apply_filters( 'artf_import_check_mail_to', 'webteam@tnt-graphics.ch' );
	if ( $to ) {
		wp_mail( $to, 'Artifiche: Begriffe ohne Übersetzung nach Import', $message );
	}
}
add_action( 'pmxi_after_xml_import', 'artf_after_import_check_unlinked_terms', 1000, 1 );
