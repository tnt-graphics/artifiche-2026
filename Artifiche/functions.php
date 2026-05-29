<?php
/**
 * Artifiche functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Artifiche
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.2.0' );
}

if ( ! function_exists( 'artifiche_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function artifiche_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Artifiche, use a find and replace
		 * to change 'artifiche' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'artifiche', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'artifiche' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
	}
endif;
add_action( 'after_setup_theme', 'artifiche_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function artifiche_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'artifiche_content_width', 640 );
}
add_action( 'after_setup_theme', 'artifiche_content_width', 0 );


/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/general-settings.php';

/**
 * Functions which enhance the theme by options into WordPress.
 */
require get_template_directory() . '/inc/theme-options.php';

/**
 * Enqueue scripts.
 */
require get_template_directory() . '/inc/wp-scripts.php';

/**
 * Custom widgets initialization.
 */
require get_template_directory() . '/inc/wp-widgets.php';

function mytheme_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );

/**
 * Breadcrumbs initialization.
 */
require get_template_directory() . '/inc/breadcrumb.php';

/**
 * Ajax functions initialization.
 */
require get_template_directory() . '/inc/ajax-functions.php';



function wpf_dev_process_before( $fields, $entry, $form_data ) {

	// Only run on my form with ID = 5
	// if ( absint( $form_data['id'] ) !== 5 ) {
	// return;
	// }

	$hidden_textarea_f = array(
		'name'  => 'Nachricht',
		'value' => 'hello selva',
		'id'    => '3',
		'type'  => 'textarea',
	);
	array_push( $fields, $hidden_textarea_f );
	// $hidden_textarea     = array(
	// 'id'            => '3',
	// );
	array_push( $entry['fields'], 'selva sts' );
	$hidden_textarea_fd = array(
		'id'            => '3',
		'type'          => 'textarea',
		'label'         => 'Nachricht',
		'description'   => 'haha',
		'required'      => '0',
		'size'          => 'medium',
		'placeholder'   => '',
		'limit_count'   => '1',
		'limit_mode'    => 'characters',
		'default_value' => 'hello everyone',
		'css'           => '',
	);
	array_push( $form_data['fields'], $hidden_textarea_fd );
	// var_dump($form_data);
	// var_dump($entry);
	// [2]=>
	// string(6) "hgvfy6"

	// [2]=>
	// array(4) {
	// ["name"]=>
	// string(24) "Kommentar oder Nachricht"
	// ["value"]=>
	// string(7) "yguvigy"
	// ["id"]=>
	// int(2)
	// ["type"]=>
	// string(8) "textarea"
	// }

	// $form_data['fields'] = $hidden_textarea;
	// array( 11 ) {
	// array( 'id' ) =>
	// string( 1 ) '2'
	// ['type'] =>
	// string( 8 ) 'textarea'
	// ['label'] =>
	// string( 24 ) 'Kommentar oder Nachricht'
	// ['description'] =>
	// string( 0 ) ''
	// ['required'] =>
	// string( 1 ) '1'
	// ['size'] =>
	// string( 6 ) 'medium'
	// ['placeholder'] =>
	// string( 0 ) ''
	// ['limit_count'] =>
	// string( 1 ) '1'
	// ['limit_mode'] =>
	// string( 10 ) 'characters'
	// ['default_value'] =>
	// string( 0 ) ''
	// ['css'] =>
	// string( 0 ) ''
	// }
	// var_dump( $form_data );
	// die;
	// run code
}
// add_action( 'wpforms_process', 'wpf_dev_process_before', 10, 3 );
function wpf_dev_process( $fields, $entry, $form_data ) {

	// Optional, you can limit to specific forms. Below, we restrict output to
	// form #5.
	if ( absint( $form_data['id'] ) !== 15148 ) {
		return $fields;
	}

	// check the field ID 4 to see if it's empty and if it is, run the error
	if ( empty( $fields[2]['value'] ) ) {
			// Add to global errors. This will stop form entry from being saved to the database.
			// Uncomment the line below if you need to display the error above the form.
			// wpforms()->process->errors[ $form_data['id'] ]['header'] = esc_html__( 'Some error occurred.', 'plugin-domain' );

			// Check the field ID 4 and show error message at the top of form and under the specific field
			   wpforms()->process->fields[ $form_data['id'] ] ['2'] = esc_html__( 'Some error occurred.', 'plugin-domain' );

			// Add additional logic (what to do if error is not displayed)
	}
}
add_action( 'wpforms_process', 'wpf_dev_process', 10, 3 );


function custom_rewrite_tag() {
	add_rewrite_tag( '%tagslug%', '([^&]+)' );
	add_rewrite_tag( '%product_id%', '([^&]+)' );
	add_rewrite_tag( '%kategorie%', '([^&]+)' );
	add_rewrite_tag( '%kunstler%', '([^&]+)' );
	add_rewrite_tag( '%pid%', '([^&]+)' );
	// add_rewrite_tag( '%t%', '([^&]+)' );
	// add_rewrite_tag( '%category%', '([^&]+)' );
}

function custom_rewrite_rule() {
	add_rewrite_rule( '^produkt-stichwoerter/([^/]*)/([^/]*)/?', 'index.php?page_id=22315&tagslug=$matches[1]&product_id=$matches[2]', 'top' );
	add_rewrite_rule( '^product-tag/([^/]*)/([^/]*)/?', 'index.php?page_id=22327&tagslug=$matches[1]&product_id=$matches[2]', 'top' );

	add_rewrite_rule( '^aehnliche-plakate/([^/]*)/?', 'index.php?page_id=15037&pid=$matches[1]', 'top' );
	add_rewrite_rule( '^related-posters/([^/]*)/?', 'index.php?page_id=24346&pid=$matches[1]', 'top' );
	add_rewrite_rule( '^kuenstlerdetail/([^/]*)/?', 'index.php?page_id=14971&kunstler=$matches[1]', 'top' );
	add_rewrite_rule( '^artist-detail/([^/]*)/?', 'index.php?page_id=24542&kunstler=$matches[1]', 'top' );

	// add_rewrite_rule( '^mein-konto/edit-address/([^/]*)/?', 'index.php?page_id=2276&t=$matches[1]', 'top' );
}

add_action( 'init', 'custom_rewrite_tag', 10, 0 );
add_action( 'init', 'custom_rewrite_rule', 10, 0 );
/**
 * This will prevent redirection in the secondary language for the custom rule:
 * '^products/([A-Za-z0-9\-]+)/?' => 'index.php?pagename=new-sample&type=$matches[1]'
 */
function wpmlcore_4704_block_redirect( $redirect, $post_id, $q ) {
	if ( isset( $q->query_vars['tagslug'] ) && 'Niklaus-STOECKLIN' === $q->query_vars['tagslug'] ) {
		return false;
	}

	if ( isset( $q->query_vars['kunstler'] ) && 'stoecklin-niklaus-1896-1982' === $q->query_vars['kunstler'] ) {
		return false;
	}

	return $redirect;
}
add_filter( 'wpml_is_redirected', 'wpmlcore_4704_block_redirect', 10, 3 );

function change_kunstler_taxonomies_slug( $args, $taxonomy ) {
	if ( 'kunstler' === $taxonomy ) {
		 $args['rewrite']['slug'] = 'kuenstler';
	}
	 return $args;
}
   add_filter( 'register_taxonomy_args', 'change_kunstler_taxonomies_slug', 10, 2 );

 /*
   add_action( 'admin_init', 'kunstler_url_rewrite' );
function kunstler_url_rewrite() {
		 add_rewrite_rule( '^kuenstler/([^/]*)$', 'index.php?kunstler=$matches[1]', 'top' );
		 flush_rewrite_rules();
}
*/



$sale_option = get_field( 'sale_option', 'option' );
if ( ! empty( $sale_option ) && $sale_option[0] == 'true' ) {
	add_filter( 'woocommerce_add_cart_item_data', 'add_cart_item_data', 10, 3 );
	add_action( 'woocommerce_before_calculate_totals', 'before_calculate_totals', 10, 1 );
}

function add_cart_item_data( $cart_item_data, $product_id, $variation_id ) {
	 // get product id & price
	$product                     = wc_get_product( $product_id );
	$sale_price                  = $product->get_price();
	$sale_discount               = get_post_meta( $product_id, 'sale_discount', true );
	if(!$sale_discount){
		return $cart_item_data;
	}
	$discount_price              = ( $sale_discount / 100 ) * $sale_price;
	$discount_price              = $sale_price - $discount_price;
	$cart_item_data['new_price'] = $discount_price;
	return $cart_item_data;
}



function before_calculate_totals( $cart_obj ) {
	if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
		return;
	}
	// Iterate through each cart item
	foreach ( $cart_obj->get_cart() as $key => $value ) {
		if ( isset( $value['new_price'] ) ) {
			$price = $value['new_price'];
			$value['data']->set_price( ( $price ) );
		}
	}
}

function get_client_currency_() {
	$currency_symbol = get_woocommerce_currency_symbol();
	switch ( $currency_symbol ) {
		case 'CHF':
			break;
		case 'EUR':
			$currency_symbol = '€';
			break;
		case 'USD':
			$currency_symbol = '$';
			break;
		default:
			break;
	}
	return $currency_symbol;
}

// Register Mega Menu
function register_my_menus() {
	register_nav_menus( array(
		'primary'    => __( 'Primary Menu' ),
		'mega_menu'  => __( 'Mega Menu' ), // Register your Mega Menu location
	));
}
add_action( 'after_setup_theme', 'register_my_menus' );

// Enqueue Mega Menu Styles
function enqueue_mega_menu_styles() {
	$theme_version = wp_get_theme()->get('Version');
	wp_enqueue_style('mega-menu', get_stylesheet_directory_uri() . '/css/mega-menu.css', array(), $theme_version);
}
add_action('wp_enqueue_scripts', 'enqueue_mega_menu_styles');

// Add custom fields for Column and Button to Menu Items
function add_menu_item_custom_fields($item_id, $item, $depth, $args) {
	// Column field
	$is_column = get_post_meta($item_id, '_menu_item_is_column', true);
	?>
	<p class="description">
		<label for="edit-menu-item-is-column-<?php echo $item_id; ?>">
			<input type="checkbox" id="edit-menu-item-is-column-<?php echo $item_id; ?>" 
				   name="menu-item-is-column[<?php echo $item_id; ?>]" 
				   value="1" <?php checked($is_column, '1'); ?> />
			<?php esc_html_e('Use as Column', 'textdomain'); ?>
		</label>
	</p>
	<?php

	// Button field
	$is_button = get_post_meta($item_id, '_menu_item_is_button', true);
	?>
	<p class="description">
		<label for="edit-menu-item-is-button-<?php echo $item_id; ?>">
			<input type="checkbox" id="edit-menu-item-is-button-<?php echo $item_id; ?>" 
				   name="menu-item-is-button[<?php echo $item_id; ?>]" 
				   value="1" <?php checked($is_button, '1'); ?> />
			<?php esc_html_e('Use as Button', 'textdomain'); ?>
		</label>
	</p>
	<?php
}
add_action('wp_nav_menu_item_custom_fields', 'add_menu_item_custom_fields', 10, 4);

// Save custom fields
function save_menu_item_custom_fields($menu_id, $menu_item_db_id) {
	// Save "Column" field
	if (isset($_POST['menu-item-is-column'][$menu_item_db_id])) {
		update_post_meta($menu_item_db_id, '_menu_item_is_column', '1');
	} else {
		delete_post_meta($menu_item_db_id, '_menu_item_is_column');
	}

	// Save "Button" field
	if (isset($_POST['menu-item-is-button'][$menu_item_db_id])) {
		update_post_meta($menu_item_db_id, '_menu_item_is_button', '1');
	} else {
		delete_post_meta($menu_item_db_id, '_menu_item_is_button');
	}
}
add_action('wp_update_nav_menu_item', 'save_menu_item_custom_fields', 10, 2);

// Add 'column' and 'button' classes to marked menu items
function add_custom_classes_to_menu_items($classes, $item, $args, $depth) {
	// Add Column class
	if (get_post_meta($item->ID, '_menu_item_is_column', true)) {
		$classes[] = 'menu-column';
	}

	// Add Button class
	if (get_post_meta($item->ID, '_menu_item_is_button', true)) {
		$classes[] = 'menu-button';
	}

	return $classes;
}
add_filter('nav_menu_css_class', 'add_custom_classes_to_menu_items', 10, 4);

/**
 * Kollektionen taxonomy helpers (DE /kollektionen/ + EN /collections/ via WPML).
 * Live DB may use "Kollektionen", code may use "kollektionen" — support both.
 */
function artifiche_get_kollektionen_taxonomies() {
	return array( 'kollektionen', 'Kollektionen' );
}

function artifiche_is_kollektionen_taxonomy( $taxonomy ) {
	return in_array( $taxonomy, artifiche_get_kollektionen_taxonomies(), true );
}

/**
 * Front end only: clone kollektionen ↔ Kollektionen so old code paths still resolve.
 * Never register the alias in admin — that creates a duplicate "collections" menu item.
 */
function artifiche_kollektionen_register_taxonomy_alias() {
	if ( is_admin() ) {
		return;
	}

	global $wp_taxonomies;

	$registered = null;
	foreach ( artifiche_get_kollektionen_taxonomies() as $slug ) {
		if ( isset( $wp_taxonomies[ $slug ] ) ) {
			$registered = $slug;
			break;
		}
	}

	if ( ! $registered ) {
		return;
	}

	foreach ( artifiche_get_kollektionen_taxonomies() as $slug ) {
		if ( isset( $wp_taxonomies[ $slug ] ) ) {
			continue;
		}

		$alias                  = clone $wp_taxonomies[ $registered ];
		$alias->name            = $slug;
		$alias->show_ui         = false;
		$alias->show_in_menu    = false;
		$alias->show_admin_column = false;
		$wp_taxonomies[ $slug ] = $alias;
	}
}
add_action( 'init', 'artifiche_kollektionen_register_taxonomy_alias', 99 );

/**
 * Skip RSS feed link markup when Kollektionen slug is not registered (avoids wp_head warnings).
 */
function artifiche_kollektionen_disable_broken_tax_feed( $show ) {
	$term = null;

	if ( is_tax( artifiche_get_kollektionen_taxonomies() ) ) {
		$term = get_queried_object();
	} elseif ( artifiche_kollektionen_term_from_request() instanceof WP_Term ) {
		$term = artifiche_kollektionen_term_from_request();
	}

	if ( ! ( $term instanceof WP_Term ) || ! artifiche_is_kollektionen_taxonomy( $term->taxonomy ) ) {
		return $show;
	}

	if ( ! taxonomy_exists( $term->taxonomy ) ) {
		return false;
	}

	return $show;
}
add_filter( 'feed_links_extra_show_tax_feed', 'artifiche_kollektionen_disable_broken_tax_feed' );

/**
 * Registered Kollektionen taxonomy slug on this site (Kollektionen on live, kollektionen locally).
 */
function artifiche_get_kollektionen_taxonomy_slug() {
	static $slug = null;

	if ( null !== $slug ) {
		return $slug;
	}

	foreach ( artifiche_get_kollektionen_taxonomies() as $taxonomy ) {
		if ( taxonomy_exists( $taxonomy ) ) {
			$slug = $taxonomy;
			return $slug;
		}
	}

	$slug = 'kollektionen';

	return $slug;
}

/**
 * List Kollektionen terms; tries both taxonomy slugs and falls back to DB lookup.
 */
function artifiche_get_kollektionen_terms( $args = array() ) {
	$registered = array();
	foreach ( artifiche_get_kollektionen_taxonomies() as $taxonomy ) {
		if ( taxonomy_exists( $taxonomy ) ) {
			$registered[] = $taxonomy;
		}
	}
	if ( empty( $registered ) ) {
		$registered = artifiche_get_kollektionen_taxonomies();
	}

	// Same pattern as plakatkollektionen VC dropdown (known working on live).
	foreach ( $registered as $taxonomy ) {
		$terms = get_terms(
			array(
				'taxonomy'   => array( $taxonomy ),
				'field'      => 'term_id',
				'orderby'    => 'include',
				'hide_empty' => false,
			)
		);
		if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
			return $terms;
		}
	}

	$defaults = array(
		'hide_empty'       => false,
		'orderby'          => 'name',
		'order'            => 'ASC',
		'suppress_filters' => false,
	);
	$args = wp_parse_args( $args, $defaults );

	foreach ( $registered as $taxonomy ) {
		$term_args             = $args;
		$term_args['taxonomy'] = $taxonomy;
		$terms                 = get_terms( $term_args );

		if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
			return $terms;
		}

		$term_args['suppress_filters'] = true;
		$terms                         = get_terms( $term_args );
		if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
			return $terms;
		}
	}

	global $wpdb;

	$placeholders = implode( ',', array_fill( 0, count( $registered ), '%s' ) );
	$rows         = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT t.term_id, tt.taxonomy
			FROM {$wpdb->terms} t
			INNER JOIN {$wpdb->term_taxonomy} tt ON t.term_id = tt.term_id
			WHERE tt.taxonomy IN ($placeholders)
			ORDER BY t.name ASC",
			...$registered
		)
	);

	$terms = array();
	foreach ( (array) $rows as $row ) {
		$term = get_term( (int) $row->term_id, $row->taxonomy );
		if ( $term instanceof WP_Term && ! is_wp_error( $term ) ) {
			$terms[] = $term;
		}
	}

	return $terms;
}

/**
 * Term link for Kollektionen dropdown; falls back when query_var / rewrites fail on tax archives.
 */
function artifiche_build_kollektionen_term_path( $term ) {
	if ( ! $term instanceof WP_Term ) {
		return '';
	}

	$slug         = $term->slug;
	$lang         = has_filter( 'wpml_current_language' ) ? apply_filters( 'wpml_current_language', null ) : null;
	$default_lang = has_filter( 'wpml_default_language' ) ? apply_filters( 'wpml_default_language', null ) : 'de';

	if ( $lang && $default_lang && $lang !== $default_lang ) {
		$path = user_trailingslashit( $lang . '/collections/' . $slug );
	} else {
		$path = user_trailingslashit( 'kollektionen/' . $slug );
	}

	return home_url( $path );
}

function artifiche_get_kollektionen_term_link( $term ) {
	if ( ! $term instanceof WP_Term ) {
		return '';
	}

	if ( artifiche_is_kollektionen_taxonomy( $term->taxonomy ) && ! taxonomy_exists( $term->taxonomy ) ) {
		return artifiche_build_kollektionen_term_path( $term );
	}

	$link = get_term_link( $term );
	if ( ! is_wp_error( $link ) ) {
		return $link;
	}

	return artifiche_build_kollektionen_term_path( $term );
}

/**
 * Resolve a Kollektionen term by ID regardless of K/k taxonomy slug.
 */
function artifiche_get_kollektionen_term_by_id( $term_id, $preferred_taxonomy = '' ) {
	$term_id = (int) $term_id;
	if ( ! $term_id ) {
		return null;
	}

	if ( $preferred_taxonomy && artifiche_is_kollektionen_taxonomy( $preferred_taxonomy ) ) {
		$term = get_term_by( 'term_id', $term_id, $preferred_taxonomy );
		if ( $term instanceof WP_Term && ! is_wp_error( $term ) ) {
			return $term;
		}
	}

	foreach ( artifiche_get_kollektionen_taxonomies() as $taxonomy ) {
		if ( ! taxonomy_exists( $taxonomy ) ) {
			continue;
		}

		$term = get_term_by( 'term_id', $term_id, $taxonomy );
		if ( $term instanceof WP_Term && ! is_wp_error( $term ) ) {
			return $term;
		}
	}

	$term = get_term( $term_id );
	if ( $term instanceof WP_Term && ! is_wp_error( $term ) && artifiche_is_kollektionen_taxonomy( $term->taxonomy ) ) {
		return $term;
	}

	return null;
}

/**
 * Resolve collection term from URL when WPML leaves a generic archive query (EN /collections/…).
 */
function artifiche_kollektionen_term_from_request() {
	static $resolved = null;

	if ( null !== $resolved ) {
		return $resolved ? $resolved : null;
	}

	$path = wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH );
	if ( ! is_string( $path ) ) {
		$resolved = false;
		return null;
	}

	if ( ! preg_match( '#/(?:[a-z]{2}/)?(?:kollektionen|collections)/([^/]+)/?$#i', $path, $matches ) ) {
		$resolved = false;
		return null;
	}

	$slug = sanitize_title( $matches[1] );
	$term = null;

	foreach ( artifiche_get_kollektionen_taxonomies() as $taxonomy ) {
		$term = get_term_by( 'slug', $slug, $taxonomy );
		if ( $term instanceof WP_Term ) {
			break;
		}
	}

	// WPML can hide a term in EN when slug matches DE (e.g. collectors-choice).
	if ( ! ( $term instanceof WP_Term ) ) {
		global $wpdb;

		$row = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT t.term_id, tt.taxonomy
				FROM {$wpdb->terms} t
				INNER JOIN {$wpdb->term_taxonomy} tt ON t.term_id = tt.term_id
				WHERE t.slug = %s AND tt.taxonomy IN (%s, %s)
				LIMIT 1",
				$slug,
				'kollektionen',
				'Kollektionen'
			)
		);

		if ( $row ) {
			$term = get_term( (int) $row->term_id, $row->taxonomy );
		}
	}

	// Last resort: resolve from default language (DE term with no EN WPML entry).
	if ( ! ( $term instanceof WP_Term ) && has_filter( 'wpml_current_language' ) ) {
		$default_lang = apply_filters( 'wpml_default_language', null );
		$current_lang = apply_filters( 'wpml_current_language', null );

		if ( $default_lang && $current_lang && $default_lang !== $current_lang && function_exists( 'do_action' ) ) {
			do_action( 'wpml_switch_language', $default_lang );

			foreach ( artifiche_get_kollektionen_taxonomies() as $taxonomy ) {
				$term = get_term_by( 'slug', $slug, $taxonomy );
				if ( $term instanceof WP_Term ) {
					break;
				}
			}

			do_action( 'wpml_switch_language', $current_lang );
		}
	}

	if ( $term instanceof WP_Term && has_filter( 'wpml_object_id' ) ) {
		$lang = apply_filters( 'wpml_current_language', null );
		if ( $lang ) {
			$translated_id = apply_filters( 'wpml_object_id', $term->term_id, $term->taxonomy, true, $lang );
			if ( $translated_id ) {
				$translated = get_term( (int) $translated_id, $term->taxonomy );
				if ( $translated instanceof WP_Term && ! is_wp_error( $translated ) ) {
					$term = $translated;
				}
			}
		}
	}

	$resolved = ( $term instanceof WP_Term ) ? $term : false;

	return $resolved ? $resolved : null;
}

function artifiche_get_kollektionen_queried_term() {
	static $cached = null;

	if ( null !== $cached ) {
		return $cached ? $cached : null;
	}

	$object = get_queried_object();
	if ( $object instanceof WP_Term && artifiche_is_kollektionen_taxonomy( $object->taxonomy ) ) {
		$cached = $object;
		return $cached;
	}

	$term = artifiche_kollektionen_term_from_request();
	$cached = ( $term instanceof WP_Term ) ? $term : false;

	return $cached ? $cached : null;
}

function artifiche_should_use_kollektionen_template() {
	if ( is_tax( artifiche_get_kollektionen_taxonomies() ) ) {
		return true;
	}

	return (bool) artifiche_kollektionen_term_from_request();
}

/**
 * WPML sometimes serves /en/collections/{slug}/ as a generic archive (no tax-* body class).
 * Fix the main query before templates run.
 */
function artifiche_fix_kollektionen_taxonomy_archive() {
	if ( is_admin() || is_tax( artifiche_get_kollektionen_taxonomies() ) ) {
		return;
	}

	$term = artifiche_kollektionen_term_from_request();
	if ( ! $term instanceof WP_Term ) {
		return;
	}

	global $wp_query;

	$wp_query->queried_object    = $term;
	$wp_query->queried_object_id = (int) $term->term_id;
	$wp_query->is_tax            = true;
	$wp_query->is_archive        = true;
	$wp_query->is_home           = false;
	$wp_query->is_singular       = false;
	$wp_query->is_404            = false;

	status_header( 200 );
}
add_action( 'wp', 'artifiche_fix_kollektionen_taxonomy_archive', 1 );

/**
 * Use the registered taxonomy slug in the main query so WPML can resolve term translations.
 */
function artifiche_kollektionen_normalize_queried_term_for_wpml() {
	if ( is_admin() ) {
		return;
	}

	$term = artifiche_get_kollektionen_queried_term();
	if ( ! $term instanceof WP_Term ) {
		return;
	}

	$registered = artifiche_get_kollektionen_taxonomy_slug();
	if ( $term->taxonomy === $registered || ! taxonomy_exists( $registered ) ) {
		return;
	}

	$normalized = get_term( (int) $term->term_id, $registered );
	if ( ! ( $normalized instanceof WP_Term ) || is_wp_error( $normalized ) ) {
		return;
	}

	global $wp_query;

	$wp_query->queried_object    = $normalized;
	$wp_query->queried_object_id = (int) $normalized->term_id;
}
add_action( 'wp', 'artifiche_kollektionen_normalize_queried_term_for_wpml', 0 );

/**
 * @return string[]
 */
function artifiche_get_wpml_language_codes() {
	global $sitepress;

	if ( isset( $sitepress ) && is_object( $sitepress ) && method_exists( $sitepress, 'get_active_languages' ) ) {
		$active = $sitepress->get_active_languages();
		if ( is_array( $active ) && ! empty( $active ) ) {
			return array_keys( $active );
		}
	}

	return array( 'de', 'en' );
}

/**
 * ACF plakatzuweisungen for a Kollektionen term (K/k + WPML-safe).
 */
function artifiche_get_kollektionen_plakatzuweisungen( $term ) {
	if ( ! $term instanceof WP_Term ) {
		return '';
	}

	$read_term    = $term;
	$default_lang = apply_filters( 'wpml_default_language', 'de' );
	$current_lang = apply_filters( 'wpml_current_language', null );
	$switched     = false;

	if ( has_filter( 'wpml_object_id' ) && $default_lang ) {
		foreach ( artifiche_get_kollektionen_taxonomies() as $tax_slug ) {
			$source_id = apply_filters( 'wpml_object_id', (int) $term->term_id, $tax_slug, true, $default_lang );
			if ( $source_id ) {
				$resolved = artifiche_get_kollektionen_term_by_id( (int) $source_id );
				if ( $resolved instanceof WP_Term ) {
					$read_term = $resolved;
					break;
				}
			}
		}
	}

	if ( $default_lang && $current_lang && $default_lang !== $current_lang ) {
		do_action( 'wpml_switch_language', $default_lang );
		$switched = true;
	}

	$try_terms = array( $read_term );
	foreach ( artifiche_get_kollektionen_taxonomies() as $tax_slug ) {
		$alt = get_term( (int) $read_term->term_id, $tax_slug );
		if ( $alt instanceof WP_Term && ! is_wp_error( $alt ) ) {
			$try_terms[] = $alt;
		}
	}

	foreach ( $try_terms as $try_term ) {
		$value = get_field( 'plakatzuweisungen', $try_term );
		if ( is_string( $value ) && $value !== '' ) {
			if ( $switched && $current_lang ) {
				do_action( 'wpml_switch_language', $current_lang );
			}
			return $value;
		}

		foreach ( artifiche_get_kollektionen_taxonomies() as $tax_slug ) {
			$value = get_field( 'plakatzuweisungen', $tax_slug . '_' . $try_term->term_id );
			if ( is_string( $value ) && $value !== '' ) {
				if ( $switched && $current_lang ) {
					do_action( 'wpml_switch_language', $current_lang );
				}
				return $value;
			}
		}
	}

	if ( $switched && $current_lang ) {
		do_action( 'wpml_switch_language', $current_lang );
	}

	return '';
}

/**
 * Build DE /kollektionen/{slug}/ or EN /en/collections/{slug}/ for a collection term.
 */
function artifiche_kollektionen_language_url( $lang_code, $term = null ) {
	if ( ! is_string( $lang_code ) || $lang_code === '' ) {
		return '';
	}

	if ( ! $term instanceof WP_Term ) {
		$term = artifiche_get_kollektionen_queried_term();
	}

	if ( ! $term instanceof WP_Term ) {
		return '';
	}

	$default_lang   = apply_filters( 'wpml_default_language', 'de' );
	$registered_tax = artifiche_get_kollektionen_taxonomy_slug();
	$target_slug    = $term->slug;

	if ( $lang_code !== $default_lang && is_string( $lang_code ) && $lang_code !== '' && has_filter( 'wpml_object_id' ) ) {
		$translated_id = apply_filters( 'wpml_object_id', $term->term_id, $registered_tax, false, $lang_code );
		if ( ! $translated_id ) {
			$translated_id = apply_filters( 'wpml_object_id', $term->term_id, $term->taxonomy, false, $lang_code );
		}
		if ( $translated_id ) {
			$translated = get_term( (int) $translated_id, $registered_tax );
			if ( ! ( $translated instanceof WP_Term ) || is_wp_error( $translated ) ) {
				$translated = get_term( (int) $translated_id );
			}
			if ( $translated instanceof WP_Term && ! is_wp_error( $translated ) ) {
				$target_slug = $translated->slug;
			}
		}
	}

	if ( $lang_code === $default_lang ) {
		$path = user_trailingslashit( 'kollektionen/' . $target_slug );
	} else {
		$path = user_trailingslashit( $lang_code . '/collections/' . $target_slug );
	}

	$url = home_url( $path );

	global $sitepress;
	if ( isset( $sitepress ) && is_object( $sitepress ) && method_exists( $sitepress, 'convert_url' ) ) {
		$url = $sitepress->convert_url( $url, $lang_code );
	}

	return $url;
}

function artifiche_kollektionen_wpml_ls_language_url( $url, $data ) {
	if ( ! artifiche_should_use_kollektionen_template() ) {
		return $url;
	}

	$lang_code = '';
	if ( is_array( $data ) ) {
		if ( ! empty( $data['language_code'] ) && is_string( $data['language_code'] ) ) {
			$lang_code = $data['language_code'];
		} elseif ( ! empty( $data['code'] ) && is_string( $data['code'] ) ) {
			$lang_code = $data['code'];
		}
	} elseif ( is_string( $data ) ) {
		$lang_code = $data;
	}

	if ( ! is_string( $lang_code ) || $lang_code === '' ) {
		return $url;
	}

	$fixed = artifiche_kollektionen_language_url( $lang_code );

	return $fixed ? $fixed : $url;
}
add_filter( 'wpml_ls_language_url', 'artifiche_kollektionen_wpml_ls_language_url', 10, 2 );

function artifiche_kollektionen_wpml_active_languages( $languages, $args = null ) {
	if ( ! artifiche_should_use_kollektionen_template() ) {
		return $languages;
	}

	$term = artifiche_get_kollektionen_queried_term();
	if ( ! $term instanceof WP_Term ) {
		return $languages;
	}

	$current = apply_filters( 'wpml_current_language', 'de' );

	if ( empty( $languages ) || ! is_array( $languages ) ) {
		$languages = array();
		foreach ( artifiche_get_wpml_language_codes() as $code ) {
			$url = artifiche_kollektionen_language_url( $code, $term );
			if ( ! $url ) {
				continue;
			}
			$languages[ $code ] = array(
				'code'          => $code,
				'language_code' => $code,
				'active'        => ( $code === $current ),
				'url'           => $url,
			);
		}

		return $languages;
	}

	foreach ( $languages as $code => $lang ) {
		$lang_code = ( is_array( $lang ) && ! empty( $lang['language_code'] ) && is_string( $lang['language_code'] ) )
			? $lang['language_code']
			: $code;
		if ( ! is_string( $lang_code ) || $lang_code === '' ) {
			continue;
		}
		$url = artifiche_kollektionen_language_url( $lang_code, $term );
		if ( $url ) {
			$languages[ $code ]['url'] = $url;
		}
	}

	return $languages;
}
add_filter( 'wpml_active_languages', 'artifiche_kollektionen_wpml_active_languages', 20, 2 );

/**
 * Fallback desktop switcher when WPML outputs nothing on Kollektionen archives.
 */
function artifiche_render_kollektionen_language_switcher() {
	if ( ! artifiche_should_use_kollektionen_template() ) {
		return;
	}

	$languages = apply_filters( 'wpml_active_languages', null, array( 'skip_missing' => 0 ) );
	if ( empty( $languages ) || ! is_array( $languages ) ) {
		return;
	}

	$current = apply_filters( 'wpml_current_language', 'de' );

	echo '<ul class="artifiche-kollektionen-lang-switcher">';
	foreach ( $languages as $lang ) {
		if ( empty( $lang['url'] ) ) {
			continue;
		}
		$code   = isset( $lang['language_code'] ) ? $lang['language_code'] : '';
		$label  = ( $code === 'de' ) ? 'DE' : strtoupper( $code );
		$active = ! empty( $lang['active'] ) || $code === $current;
		echo '<li class="' . ( $active ? 'lang-active' : '' ) . '">';
		echo '<a href="' . esc_url( $lang['url'] ) . '"><span>' . esc_html( $label ) . '</span></a>';
		echo '</li>';
	}
	echo '</ul>';
}

/**
 * Load the Kollektionen taxonomy template without changing general-settings.php.
 */
function artifiche_kollektionen_taxonomy_template( $template ) {
	if ( ! artifiche_should_use_kollektionen_template() ) {
		return $template;
	}

	$kollektionen_template = get_template_directory() . '/woocommerce/taxonomy-kollektionen.php';
	if ( file_exists( $kollektionen_template ) ) {
		return $kollektionen_template;
	}

	return $template;
}
add_filter( 'template_include', 'artifiche_kollektionen_taxonomy_template', 999 );


