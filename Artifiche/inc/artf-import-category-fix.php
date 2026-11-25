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

	// Mail nur, wenn ein Empfänger gesetzt ist (admin_email gehört noch der früheren Agentur).
	$to = apply_filters( 'artf_import_check_mail_to', '' );
	if ( $to ) {
		wp_mail( $to, 'Artifiche: Begriffe ohne Übersetzung nach Import', $message );
	}
}
add_action( 'pmxi_after_xml_import', 'artf_after_import_check_unlinked_terms', 1000, 1 );
