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
 * Load the Kollektionen taxonomy template without changing general-settings.php.
 * Live registers "Kollektionen", local uses "kollektionen" — both use the same file.
 */
function artifiche_kollektionen_taxonomy_template( $template ) {
	if ( ! is_tax( array( 'kollektionen', 'Kollektionen' ) ) ) {
		return $template;
	}

	$kollektionen_template = locate_template( 'woocommerce/taxonomy-kollektionen.php' );
	if ( $kollektionen_template ) {
		return $kollektionen_template;
	}

	return $template;
}
add_filter( 'template_include', 'artifiche_kollektionen_taxonomy_template', 99 );


