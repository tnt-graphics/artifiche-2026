<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Artifiche
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */

/*
 * Including custom payment method ubersee.
 */
// require get_template_directory() . '/inc/class-ubersee-gateway.php';
require get_template_directory() . '/inc/artf-import-cron.php';

function artifiche_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'artifiche_body_classes' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function artifiche_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Main Menu Widget', 'artifiche' ),
			'id'            => 'mainmenu_widget',
			'description'   => esc_html__( 'Add widgets here.', 'artifiche' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Widget Column 1', 'artifiche' ),
			'id'            => 'footer_widget_1',
			'description'   => esc_html__( 'Add widgets here.', 'artifiche' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Widget Column 2', 'artifiche' ),
			'id'            => 'footer_widget_2',
			'description'   => esc_html__( 'Add widgets here.', 'artifiche' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Widget Column 3', 'artifiche' ),
			'id'            => 'footer_widget_3',
			'description'   => esc_html__( 'Add widgets here.', 'artifiche' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'artifiche_widgets_init' );


function my_search_form( $form ) {

	$form = '<form role="search" method="get" id="searchform" class="searchform" action="' . get_permalink( wc_get_page_id( 'shop' ) ) . '" >
    <div>
    <input type="text" placeholder="' . __( 'Suche (Titel, Künstler ...)', 'artifiche' ) . '" value="' . get_search_query() . '" name="search" id="s" />
    <input type="submit" id="searchsubmit" value="' . esc_attr__( 'Search' ) . '" />
    </div>
    </form>';

	return $form;
}

add_filter( 'get_search_form', 'my_search_form', 100 );

function custom_menu() {
	// register_nav_menu( 'artifiche-main-menu', __( 'Artifiche Primary Menu' ) );
	register_nav_menu( 'artifiche-about-menu', __( 'Artifiche About Menu' ) );
}
add_action( 'init', 'custom_menu' );

function artifiche_custom_post_type() {

	$labels = array(
		'name'                       => esc_html__( 'Drucktechnik', 'artifiche' ),
		'singular_name'              => esc_html__( 'Drucktechnik', 'artifiche' ),
		'menu_name'                  => esc_html__( 'Drucktechnik', 'artifiche' ),
		'all_items'                  => esc_html__( 'Alles Drucktechnik', 'artifiche' ),
		'parent_item'                => esc_html__( 'Elternteil Drucktechnik', 'artifiche' ),
		'parent_item_colon'          => esc_html__( 'Elternteil Drucktechnik:', 'artifiche' ),
		'new_item_name'              => esc_html__( 'Neuer Drucktechnik Name', 'artifiche' ),
		'add_new_item'               => esc_html__( 'Neue Drucktechnik hinzufügen', 'artifiche' ),
		'edit_item'                  => esc_html__( 'Bearbeiten Drucktechnik', 'artifiche' ),
		'update_item'                => esc_html__( 'Aktualisieren Drucktechnik', 'artifiche' ),
		'separate_items_with_commas' => esc_html__( 'Drucktechnik durch Kommas trennen', 'artifiche' ),
		'search_items'               => esc_html__( 'Suche Drucktechnik', 'artifiche' ),
		'add_or_remove_items'        => esc_html__( 'Drucktechnik hinzufügen oder entfernen', 'artifiche' ),
		'choose_from_most_used'      => esc_html__( 'Wählen Sie aus der am häufigsten verwendeten Drucktechnik', 'artifiche' ),
	);
	$args   = array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => false,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
	);
	register_taxonomy( 'drucktechnik', 'product', $args );

	$labels = array(
		'name'                       => esc_html__( 'Künstler', 'artifiche' ),
		'singular_name'              => esc_html__( 'Künstler', 'artifiche' ),
		'menu_name'                  => esc_html__( 'Künstler', 'artifiche' ),
		'all_items'                  => esc_html__( 'Alles Künstler', 'artifiche' ),
		'parent_item'                => esc_html__( 'Elternteil Künstler', 'artifiche' ),
		'parent_item_colon'          => esc_html__( 'Elternteil Künstler:', 'artifiche' ),
		'new_item_name'              => esc_html__( 'Neuer Künstler Name', 'artifiche' ),
		'add_new_item'               => esc_html__( 'Neue Künstler hinzufügen', 'artifiche' ),
		'edit_item'                  => esc_html__( 'Bearbeiten Künstler', 'artifiche' ),
		'update_item'                => esc_html__( 'Aktualisieren Künstler', 'artifiche' ),
		'separate_items_with_commas' => esc_html__( 'Separate Künstler mit Komma', 'artifiche' ),
		'search_items'               => esc_html__( 'Suche Künstler', 'artifiche' ),
		'add_or_remove_items'        => esc_html__( 'Hinzufügen oder entfernen Künstler', 'artifiche' ),
		'choose_from_most_used'      => esc_html__( 'Wählen Sie aus den am häufigsten verwendeten Künstler', 'artifiche' ),
	);
	$args   = array(
		'labels'             => $labels,
		'hierarchical'       => true,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_admin_column'  => false,
		'show_in_nav_menus'  => true,
		'show_tagcloud'      => true,
	);
	register_taxonomy( 'kunstler', 'product', $args );

	$labels = array(
		'name'                       => esc_html__( 'Marke', 'artifiche' ),
		'singular_name'              => esc_html__( 'Marke', 'artifiche' ),
		'menu_name'                  => esc_html__( 'Marke', 'artifiche' ),
		'all_items'                  => esc_html__( 'Alles Marke', 'artifiche' ),
		'parent_item'                => esc_html__( 'Elternteil Marke', 'artifiche' ),
		'parent_item_colon'          => esc_html__( 'Elternteil Marke:', 'artifiche' ),
		'new_item_name'              => esc_html__( 'Neuer Marke Name', 'artifiche' ),
		'add_new_item'               => esc_html__( 'Neue Marke hinzufügen', 'artifiche' ),
		'edit_item'                  => esc_html__( 'Bearbeiten Marke', 'artifiche' ),
		'update_item'                => esc_html__( 'Aktualisieren Marke', 'artifiche' ),
		'separate_items_with_commas' => esc_html__( 'Separate Marke mit Komma', 'artifiche' ),
		'search_items'               => esc_html__( 'Suche Marke', 'artifiche' ),
		'add_or_remove_items'        => esc_html__( 'Hinzufügen oder entfernen Marke', 'artifiche' ),
		'choose_from_most_used'      => esc_html__( 'Wählen Sie aus den am häufigsten verwendeten Marke', 'artifiche' ),
	);
	$args   = array(
		'labels'             => $labels,
		'hierarchical'       => true,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_admin_column'  => false,
		'show_in_nav_menus'  => true,
		'show_tagcloud'      => true,
	);
	register_taxonomy( 'marke', 'product', $args );
	$labels = array(
		'name'                       => esc_html__( 'Publikationen', 'artifiche' ),
		'singular_name'              => esc_html__( 'Publikationen', 'artifiche' ),
		'menu_name'                  => esc_html__( 'Publikationen', 'artifiche' ),
		'all_items'                  => esc_html__( 'Alle Publikationen', 'artifiche' ),
		'parent_item'                => esc_html__( 'Elternveröffentlichungen', 'artifiche' ),
		'parent_item_colon'          => esc_html__( 'Elternveröffentlichungen:', 'artifiche' ),
		'new_item_name'              => esc_html__( 'Neuer Publikationsname', 'artifiche' ),
		'add_new_item'               => esc_html__( 'Neue Publikationen hinzufügen', 'artifiche' ),
		'edit_item'                  => esc_html__( 'Publikationen bearbeiten', 'artifiche' ),
		'update_item'                => esc_html__( 'Publikationen aktualisieren', 'artifiche' ),
		'separate_items_with_commas' => esc_html__( 'Separate Veröffentlichungen mit Kommas', 'artifiche' ),
		'search_items'               => esc_html__( 'Suche Publikationen', 'artifiche' ),
		'add_or_remove_items'        => esc_html__( 'Publikationen hinzufügen oder entfernen', 'artifiche' ),
		'choose_from_most_used'      => esc_html__( 'Wählen Sie aus den am häufigsten verwendeten Publikationen', 'artifiche' ),
	);
	$args   = array(
		'labels'             => $labels,
		'hierarchical'       => true,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_admin_column'  => false,
		'show_in_nav_menus'  => true,
		'show_tagcloud'      => true,
	);
	register_taxonomy( 'publikationen', 'product', $args );

	$labels = array(
		'name'                       => esc_html__( 'Kollektionen', 'artifiche' ),
		'singular_name'              => esc_html__( 'Kollektionens', 'artifiche' ),
		'menu_name'                  => esc_html__( 'Kollektionen', 'artifiche' ),
		'all_items'                  => esc_html__( 'Alle Kollektionen', 'artifiche' ),
		'parent_item'                => esc_html__( 'Elternkollektionen', 'artifiche' ),
		'parent_item_colon'          => esc_html__( 'Elternkollektionen:', 'artifiche' ),
		'new_item_name'              => esc_html__( 'Neuer Kollektionsname', 'artifiche' ),
		'add_new_item'               => esc_html__( 'Neue Kollektionen hinzufügen', 'artifiche' ),
		'edit_item'                  => esc_html__( 'Kollektionen bearbeiten', 'artifiche' ),
		'update_item'                => esc_html__( 'Kollektionen aktualisieren', 'artifiche' ),
		'separate_items_with_commas' => esc_html__( 'Separate Kollektionen mit Kommas', 'artifiche' ),
		'search_items'               => esc_html__( 'Suche Kollektionen', 'artifiche' ),
		'add_or_remove_items'        => esc_html__( 'Kollektionen hinzufügen oder entfernen', 'artifiche' ),
		'choose_from_most_used'      => esc_html__( 'Wählen Sie aus den am häufigsten verwendeten Kollektionen', 'artifiche' ),
	);
	$args   = array(
		'labels'             => $labels,
		'hierarchical'       => true,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_admin_column'  => false,
		'show_in_nav_menus'  => true,
		'show_tagcloud'      => true,
	);
	register_taxonomy( 'Kollektionen', 'product', $args );
}
	add_action( 'init', 'artifiche_custom_post_type' );

// Including Visual composer elements
// check for plugin using plugin name
if ( defined( 'WPB_VC_VERSION' ) ) {
	// plugin is activated
	require get_template_directory() . '/artifiche-vc-elements/vc-artifiche-home-about-content.php';
	require get_template_directory() . '/artifiche-vc-elements/vc-artifiche-collections-banner.php';
	require get_template_directory() . '/artifiche-vc-elements/vc-artifiche-container-wrap.php';
	require get_template_directory() . '/artifiche-vc-elements/vc-artifiche-img-txt-banner.php';
	require get_template_directory() . '/artifiche-vc-elements/vc-artifiche-testimonial-big.php';
	require get_template_directory() . '/artifiche-vc-elements/vc-artifiche-testimonial-small.php';
	require get_template_directory() . '/artifiche-vc-elements/vc-artifiche-testimonial-three.php';
	require get_template_directory() . '/artifiche-vc-elements/vc-artifiche-testimonial-four.php';
	require get_template_directory() . '/artifiche-vc-elements/vc-artifiche-button-box.php';
	require get_template_directory() . '/artifiche-vc-elements/vc-artifiche-button-normal.php';
	require get_template_directory() . '/artifiche-vc-elements/vc-artifiche-home-collection-list.php';
	require get_template_directory() . '/artifiche-vc-elements/vc-artifiche-display-3-posters.php';
	require get_template_directory() . '/artifiche-vc-elements/vc-artifiche-content-w-singleposter.php';
	require get_template_directory() . '/artifiche-vc-elements/vc-artifiche-summary-text.php';
	require get_template_directory() . '/artifiche-vc-elements/vc-artifiche-blue-box.php';
	require get_template_directory() . '/artifiche-vc-elements/vc-artifiche-news-list.php';
	require get_template_directory() . '/artifiche-vc-elements/vc-artifiche-testimonial-wrap.php';
	require get_template_directory() . '/artifiche-vc-elements/vc-artifiche-filter-box.php';
	require get_template_directory() . '/artifiche-vc-elements/vc-artifiche-loadmore.php';
	require get_template_directory() . '/artifiche-vc-elements/vc-artifiche-kollektion.php';
	require get_template_directory() . '/artifiche-vc-elements/vc-artifiche-kollektion-filter.php';
	require get_template_directory() . '/artifiche-vc-elements/vc-artifiche-shop-posters.php';
	require get_template_directory() . '/artifiche-vc-elements/vc-artifiche-contact-form.php';
	require get_template_directory() . '/artifiche-vc-elements/vc-artifiche-display-textblock.php';
	// require get_template_directory() . '/artifiche-vc-elements/vc-artifiche-post-by-title-id.php';

}

// Creating Custom post type for Collection slider

if ( ! post_type_exists( 'collection_slider' ) ) {
	add_action( 'init', 'artf_collection_slider_custom_post_type', 0 );
}
function artf_collection_slider_custom_post_type() {
	$label_collection_slider = array(
		'name'               => _x( 'Collection Slider', 'Post Type General Name', 'artifiche' ),
		'singular_name'      => _x( 'Collection Slider', 'Post Type Singular Name', 'artifiche' ),
		'menu_name'          => __( 'Collection Slider', 'artifiche' ),
		'parent_item_colon'  => __( 'Parent Collection Slider', 'artifiche' ),
		'all_items'          => __( 'All Collection Slider', 'artifiche' ),
		'view_item'          => __( 'View ', 'artifiche' ),
		'add_new_item'       => __( 'Add New', 'artifiche' ),
		'add_new'            => __( 'Add New', 'artifiche' ),
		'edit_item'          => __( 'Edit Collection Slider', 'artifiche' ),
		'update_item'        => __( 'Update Collection Slider', 'artifiche' ),
		'search_items'       => __( 'Search Collection Slider', 'artifiche' ),
		'not_found'          => __( 'Not Found', 'artifiche' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'artifiche' ),
	);

	// Set other options for Custom Post Type

	$arg_collection_slider = array(
		'labels'             => $label_collection_slider,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'collection_slider' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'revisions' ),
		'show_in_rest'       => false,
	);

	register_post_type( 'collection_slider', $arg_collection_slider );
}


add_filter(
	'get_the_archive_title',
	function ( $title ) {
		if ( is_category() ) {
			$title = single_cat_title( '', false );
		} elseif ( is_tag() ) {
			$title = single_tag_title( '', false );
		} elseif ( is_author() ) {
			$title = '<span class="vcard">' . get_the_author() . '</span>';
		} elseif ( is_tax() ) { // for custom post types
			$title = sprintf( __( '%1$s' ), single_term_title( '', false ) );
		} elseif ( is_post_type_archive() ) {
			$title = post_type_archive_title( '', false );
		}
		return $title;
	}
);


function wpml_filter_plugin( $args ) {
	 $args['suppress_filters'] = 0;
	 return $args;
}
add_filter( 'display_posts_shortcode_args', 'wpml_filter_plugin' );

/**
 * Retrieves all künstler.
 **/

function get_künstler_options() {

	$künstler_options = '';
	$künstler_sel     = '';
	$sel              = '';
	if ( isset( $_GET['kuenstler'] ) ) {
		$künstler_sel = $_GET['kuenstler'];
	} else {
		$sel = 'selected="selected"';
	}

	$termargs         = array(
		'taxonomy' => array( 'kunstler' ), // taxonomy name
		'field'    => 'name',
		'orderby'  => 'ASC',
	);
		$recent_posts = '';
		$termslists   = get_terms( $termargs );// print_r($terms);
		$i            = 1;

		$künstler_options = '<option  value="1" ' . $sel . '>' . esc_html__( 'Alle', 'artifiche' ) . '</option>';
	foreach ( $termslists as $termone ) :
		if(is_wp_error($termone)) {
			continue;
		}
		if ( $künstler_sel == $termone->slug ) {
			$sel = 'selected="selected"';
		} else {
			$sel = '';
		}
		$künstler_options .= '<option value="' . $termone->slug . '" ' . $sel . ' >' . $termone->name . '</option>';
		endforeach;

		return $künstler_options;
}

/**
 * Retrieves all kategorie.
 **/

function get_kategorie_options() {

	$category_option = '';
	$orderby         = 'name';
	$order           = 'asc';
	$hide_empty      = true;
	$cat_args        = array(
		'orderby'          => $orderby,
		'order'            => $order,
		'hide_empty'       => $hide_empty,
		'suppress_filters' => false,

	);

	$selected_kat = '';
	if ( isset( $_GET['kategorie'] ) ) {
		$selected_kat = $_GET['kategorie'];
	}
	$product_categories = get_terms( 'product_cat', $cat_args );

	if ( ! empty( $product_categories ) ) {

		$category_option = '<option  value="1" >' . esc_html__( 'Alle', 'artifiche' ) . '</option>';
		foreach ( $product_categories as $key => $category ) { // echo 'aa'.icl_object_id( $category->term_id ,'product_cat', true, ICL_LANGUAGE_CODE );
			// echo 'aa'.$category->term_id;
			// if( $category->term_id == icl_object_id( $category->term_id ,'product_cat', true, ICL_LANGUAGE_CODE ) ) {
			if(is_wp_error($category)) {
				continue;
			}
			if ( $selected_kat == $category->slug ) {

				$sel = 'selected="selected"';
				// /$sel = '';
			} else {
				$sel = '';
			}

			$category_option .= '<option value="' . $category->slug . '" ' . $sel . ' data-id="' . $category->term_id . '">' . $category->name . '</option>';
			// }
		}
	}
	return $category_option;
}

/**
 * Retrieves all land.
 **/

function get_land_options() {

	$land_taxonomy = get_all_taxonomy();
	$land_option   = '';
	$selected_land = '';
	if ( isset( $_GET['land'] ) ) {
		$selected_land = $_GET['land'];
	}
	$land_array = $land_taxonomy['land'];
	if ( ! empty( $land_array ) ) {

		$land_option = '<option  value="1" >' . esc_html__( 'Alle', 'artifiche' ) . '</option>';
		foreach ( $land_array as $land ) {
			if(is_wp_error($land)) {
				continue;
			}
			if ( $selected_land == $land->slug ) {
				$sel = 'selected="selected"';
				// $sel = '';
			} else {
				$sel = '';
			}

			$land_option .= '<option value="' . $land->slug . '" ' . $sel . '>' . $land->name . '</option>';
		}
	}
	return $land_option;

}

/**
 * Retrieves all stilrichtung.
 **/
function get_stilrichtung_options() {

	$stilrichtung_taxonomy = get_all_taxonomy();
	$stilrichtung_option   = '';
	$selected_stilrichtung = '';
	if ( isset( $_GET['stilrichtung'] ) ) {
		$selected_stilrichtung = $_GET['stilrichtung'];
	}

	$stilrichtung_array = $stilrichtung_taxonomy['stilrichtung'];// print_r($stilrichtung_array);
	if ( ! empty( $stilrichtung_array ) ) {

		$stilrichtung_option = '<option  value="1" >' . esc_html__( 'Alle', 'artifiche' ) . '</option>';
		foreach ( $stilrichtung_array as $stilrichtung ) {
			if(is_wp_error($stilrichtung)) {
				continue;
			}
			if ( $selected_stilrichtung == $stilrichtung->slug ) {
				$sel = 'selected="selected"';
				// $sel = '';
			} else {
				$sel = '';
			}

			$stilrichtung_option .= '<option value="' . $stilrichtung->slug . '" ' . $sel . '>' . $stilrichtung->name . '</option>';
		}
	}
	return $stilrichtung_option;

}

/**
 * Retrieves all poster attribute.
 **/
function get_all_taxonomy() {

	$attribute_taxonomies = wc_get_attribute_taxonomies();
	$taxonomy_terms       = array();
	if ( $attribute_taxonomies ) :
		foreach ( $attribute_taxonomies as $tax ) :

			if ( taxonomy_exists( wc_attribute_taxonomy_name( $tax->attribute_name ) ) ) :
				$taxonomy_terms[ $tax->attribute_name ] = get_terms( wc_attribute_taxonomy_name( $tax->attribute_name ), 'orderby=name' );
		endif;
		endforeach;
		endif;

	return $taxonomy_terms;
}


/**
 * Retrieves all meta values of posters.
 **/

function get_meta_values( $key = '', $type = 'product', $status = 'publish' ) {

	global $wpdb;

	if ( empty( $key ) ) {
		return;
	}
	// $tableName = $wpdb->prefix;

	$jahrs = $wpdb->get_col(
		$wpdb->prepare(
			"
        SELECT pm.meta_value FROM {$wpdb->postmeta} pm
        LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
        WHERE pm.meta_key = %s 
        AND p.post_status = %s 
        AND p.post_type = %s ORDER BY pm.meta_value ASC
    ",
			$key,
			$status,
			$type
		)
	);

	return $jahrs;
}

/**
 * Retrieves all jahr of posters.
 **/

function get_jahr_option() {

	$jahrs         = get_meta_values( 'jahr' );
	$jahr_array    = array();
	$jahr_option   = '';
	$selected_jahr = '';
	if ( isset( $_GET['jahr'] ) ) {
		$selected_jahr = $_GET['jahr'];
	}
	if ( ! empty( $jahrs ) ) {
		foreach ( $jahrs as $jahr ) {

			if ( ! in_array( $jahr, $jahr_array ) && $jahr != '' ) {
				array_push( $jahr_array, $jahr );
			}
		}
		// print_r($jahrs);
		 $first = intval( $jahr_array[ array_key_first( $jahr_array ) ] );
		 $last  = intval( $jahr_array[ array_key_last( $jahr_array ) ] );
		$range  = $last - $first;
		$count  = $range / 20;

		$jahr_option = '<option value="1" >' . esc_html__( 'Alle', 'artifiche' ) . '</option>';
		for ( $j = 1; $j <= $count; $j++ ) {
			$jahr_first = $first;
			$jahr_last  = $jahr_first + ( 1 * 20 );
			$first      = $jahr_last;

			if ( $selected_jahr == $jahr_first . '-' . $jahr_last ) {
				 $sel = 'selected="selected"';
				// $sel = '';
			} else {
				$sel = '';
			}

			 $jahr_option .= '<option value="' . $jahr_first . '-' . $jahr_last . '" ' . $sel . '>' . $jahr_first . '-' . $jahr_last . '</option>';
		}
	}
	return $jahr_option;
}

add_action( 'pre_get_posts', 'shop_filter_cat' );
function shop_filter_cat( $query ) {
	if ( ! is_admin() && is_post_type_archive( 'product' ) && $query->is_main_query() ) {

		$metaquery  = array();
		$taxonomies = array();
		// $artf_nonce = $_REQUEST['artf_filter'];

		// if ( isset( $_GET['name'] ) || isset( $_GET['kategorie'] ) || isset( $_GET['kuenstler'] ) || isset( $_GET['land'] ) || isset( $_GET['stilrichtung'] ) || isset( $_GET['search'] ) || isset( $_GET['sold_posters'] ) || isset( $_GET['sortby'] ) || isset( $_GET['sort'] ) ) {
		if ( isset( $_SERVER['QUERY_STRING'] ) || isset( $_COOKIE['artf_sale_flag'] ) ) {
			// print_r( $query );
			$query_string      = array();
			$product_cat_query = array();
			$kategorie         = '';
			$kuenstler         = '';
			$jahr              = '';
			$land              = '';
			$stilrichtung      = '';
			$preisklasse       = '';
			$name              = '';
			$tax               = '';
			$slug              = '';
			// $show_posters        = '';
			$search_term  = '';
			$sold_posters = '';

			if ( isset( $_GET['kategorie'] ) ) {
				$kategorie = $_GET['kategorie'];
			}
			if ( isset( $_GET['kuenstler'] ) ) {
				$kuenstler = $_GET['kuenstler'];
			}
			if ( isset( $_GET['jahr'] ) ) {
				$jahr       = $_GET['jahr'];
				$jahr_array = ( explode( '-', $jahr ) );
			}
			if ( isset( $_GET['land'] ) ) {
				$land = $_GET['land'];
			}
			if ( isset( $_GET['stilrichtung'] ) ) {
				$stilrichtung = $_GET['stilrichtung'];
			}
			if ( isset( $_GET['preisklasse'] ) ) {
				$preisklasse = $_GET['preisklasse'];
				$preis_array = ( explode( '-', $preisklasse ) );
			}
			if ( isset( $_GET['filter_text'] ) ) {
				$name = $_GET['filter_text'];
			}
			if ( isset( $_GET['tax'] ) ) {
				$tax = $_GET['tax'];
			}
			if ( isset( $_GET['slug'] ) ) {
				$slug = $_GET['slug'];
			}
			if ( isset( $_COOKIE['sold_posters'] ) && $_COOKIE['sold_posters'] == true ) {
				$sold_posters = 1;
			} else {
				$sold_posters = 0;
			}

			if ( isset( $_GET['search'] ) ) {
				$search_term = $_GET['search'];
				// $search_term = preg_replace('/[^\da-z ]/i', ' ', $search_term);
				$search_term  = preg_replace( '/[,]/', ' ', $search_term );
				$search_array = explode( ' ', $search_term );
			}

			$i          = 0;
			$m          = 0;
			$s          = 0;
			$taxonomies = array();
			$metaquery  = array();

			if ( $kategorie != 1 && $kategorie != '' ) {
				$taxonomies[] = array(
					'taxonomy' => 'product_cat',
					'field'    => 'slug',
					'terms'    => array( $kategorie ),
				);
				  $i ++;
			}
			if ( $kuenstler != 1 && $kuenstler != '' ) {
				$taxonomies[] = array(
					'taxonomy' => 'kunstler',
					'field'    => 'slug',
					'terms'    => array( $kuenstler ),
				);
				$i ++;
			}
			if ( $land != 1 && $land != '' ) {
				$taxonomies[] = array(
					'taxonomy' => 'pa_land',
					'field'    => 'slug',
					'terms'    => array( $land ),
				);
				$i ++;
			}

			if ( $stilrichtung != 1 && $stilrichtung != '' ) {
				$taxonomies[] = array(
					'taxonomy' => 'pa_stilrichtung',
					'field'    => 'slug',
					'terms'    => array( $stilrichtung ),
				);
				$i ++;
			}
			if ( $name != '' ) {
				$taxonomies[] = array(
					'taxonomy' => $tax,
					'field'    => 'slug',
					'terms'    => array( $slug ),
				);
				$i ++;
			}

			if ( $jahr != 1 && $jahr != '' ) {
				$metaquery[] = array(
					'key'     => 'jahr',
					'value'   => $jahr_array[0],
					'compare' => '>=',
					'type'    => 'NUMERIC',
				);
				$metaquery[] = array(
					'key'     => 'jahr',
					'value'   => $jahr_array[1],
					'compare' => '<=',
					'type'    => 'NUMERIC',
				);

				$m ++;
			}
			if ( $preisklasse != 1 && $preisklasse != '' ) {

				if ( $preis_array[0] != 999999 ) {
					$metaquery[] = array(
						'key'     => '_regular_price',
						'value'   => $preis_array[1],
						'compare' => '<=',
						'type'    => 'NUMERIC',
					);
				}
				if ( $preis_array[0] == 999999 ) {
					   $metaquery[] = array(
						   'key'     => '_regular_price',
						   'value'   => $preis_array[0],
						   'compare' => '=',
						   'type'    => 'NUMERIC',
					   );
				} else {
					$metaquery[] = array(
						'key'     => '_regular_price',
						'value'   => $preis_array[0],
						'compare' => '>',
						'type'    => 'NUMERIC',
					);

				}
				$m ++;
			}

			if ( ! empty( $search_array ) ) {
				$metaquery_search = array();
				foreach ( $search_array as $search_term ) {
					if ( $search_term != '' && ! in_array( $search_term, $metaquery_search ) && $s < 7 ) {
						$metaquery_search[] = array(
							'key'     => 'search_term',
							'value'   => $search_term,
							'compare' => 'LIKE',
						);
						$s++;
					}
				}
				if ( $s > 1 ) {
					$metaquery_search['relation'] = 'AND';
				}
			}

			if ( $sold_posters == 1 ) {
				$metaquery[] = array(
					'key'     => '_stock_status',
					'value'   => array( 'instock' ),
					'compare' => 'IN',
				);

			} else {
				$metaquery[] = array(
					'key'     => '_stock_status',
					'value'   => array( 'outofstock', 'instock' ),
					'compare' => 'IN',
				);
			}

			// print_r($metaquery);
			$orderby = array(
				'meta_value' => 'DESC',
				'date'       => 'ASC',
			);
			// || isset( $_GET['show_posters'] )
			$query->set( 'orderby', $orderby );
			$query->set( 'meta_key', 'neu_flag' );
			if ( isset( $_COOKIE['artf_cc_flag'] ) && $_COOKIE['artf_cc_flag'] == true ) {
				$metaquery[] = array(
					'key'     => 'collectors_choice_flag',
					'value'   => 1,
					'compare' => '=',
					'type'    => 'NUMERIC',
				);
			}
			if ( isset( $_COOKIE['artf_sale_flag'] ) && $_COOKIE['artf_sale_flag'] == true ) {
				$purchase_limit = get_field( 'purchase_limit', 'option' );
				$metaquery[]    = array(
					'key'     => 'sale_flag',
					'value'   => 1,
					'compare' => '=',
					'type'    => 'NUMERIC',
				);
				$metaquery[]    = array(
					'key'     => '_regular_price',
					'value'   => $purchase_limit,
					'compare' => '<=',
					'type'    => 'NUMERIC',
				);
				$metaquery[]    = array(
					'key'     => '_regular_price',
					'value'   => '',
					'compare' => 'NOT IN',
				);
			}
			if ( isset( $_GET['sort'] ) ) {

				switch ( $_GET['sort'] ) {
					case 'jahr-desc':
						$orderby = array(
							'date' => 'DESC',
						);
						$query->set( 'orderby', $orderby );
						break;
					case 'jahr-asc':
						$orderby = array(
							'date' => 'ASC',
						);
						$query->set( 'orderby', $orderby );
						break;
					case 'price-asc':
						$query->set( 'order', 'ASC' );
						$query->set( 'meta_key', '_price' );
						$query->set( 'orderby', 'meta_value_num' );
						break;
					case 'price-desc':
						$query->set( 'order', 'DESC' );
						$query->set( 'meta_key', '_price' );
						$query->set( 'orderby', 'meta_value_num' );
						break;
					default:
						break;

						set_query_var( 'neu_flag', false );

				}
			}

			if ( $i > 1 ) {
				$taxonomies['relation'] = 'AND';

			}
			if ( $m >= 1 ) {
				$metaquery['relation'] = 'AND';

			}
			if ( $s >= 1 ) {
				$metaquery[] = array( $metaquery_search );

			}//print_r($metaquery);
			if ( ! empty( $taxonomies ) && ! empty( $metaquery ) && $search_term != '' ) {
				$query->set(
					'meta_query',
					$metaquery,
				);

				$query->set(
					'tax_query',
					$taxonomies,
				);

			} elseif ( ! empty( $taxonomies ) && empty( $metaquery ) && $search_term == '' ) {
				$query->set(
					'tax_query',
					$taxonomies,
				);
			} elseif ( ! empty( $taxonomies ) && ! empty( $metaquery ) && $search_term == '' ) {
				$query->set(
					'tax_query',
					$taxonomies,
				);
				$query->set(
					'meta_query',
					$metaquery,
				);
				// print_r($query);
			} elseif ( ! empty( $taxonomies ) && empty( $metaquery ) && $search_term != '' ) {
				$query->set(
					'tax_query',
					$taxonomies,
					// 's',
					// $search_term,
				);

			} elseif ( empty( $taxonomies ) && ! empty( $metaquery ) && $search_term == '' ) {
				$query->set(
					'meta_query',
					$metaquery
				);
			} elseif ( empty( $taxonomies ) && ! empty( $metaquery ) && $search_term != '' ) {

				$query->set(
					'meta_query',
					$metaquery,
				);
				// print_r($query);
			} elseif ( empty( $taxonomies ) && empty( $metaquery ) && $search_term != '' ) {
				// $query->set(
				// 's',
				// $search_term,
				// );
			} else {
			}

				// print_r($taxonomies);print_r($metaquery);
			// }
		} else {
			$metaquery[]           = array(
				'key'     => '_stock_status',
				'value'   => array( 'outofstock', 'instock' ),
				'compare' => 'IN',
			);
			$metaquery['relation'] = 'AND';
			$orderby               = array(
				'meta_value' => 'DESC',
				'date'       => 'ASC',
			);
			// // print_r($metaquery);
			$query->set( 'orderby', $orderby );
			$query->set( 'meta_key', 'neu_flag' );
			$query->set(
				'meta_query',
				$metaquery
			);

		}
	} elseif ( ! is_admin() && is_tax( 'Kollektionen' ) && $query->is_main_query() ) {

		if ( isset( $_COOKIE['sold_posters'] ) && $_COOKIE['sold_posters'] == true ) {
			$sold_posters = 1;
		} else {
			$sold_posters = 0;
		}
		if ( $sold_posters == 1 ) {
			$metaquery[] = array(
				'key'     => '_stock_status',
				'value'   => array( 'instock' ),
				'compare' => 'IN',
			);

		} else {
			$metaquery[] = array(
				'key'     => '_stock_status',
				'value'   => array( 'outofstock', 'instock' ),
				'compare' => 'IN',
			);
		}
		$query->set(
			'meta_query',
			$metaquery,
		);
		$orderby = array(
			'meta_value' => 'DESC',
			'date'       => 'ASC',
		);
			$query->set( 'orderby', $orderby );
			$query->set( 'meta_key', 'neu_flag' );

	} elseif ( ! is_admin() && is_tax() && $query->is_main_query() ) {

		$orderby = array(
			'meta_value' => 'DESC',
			'date'       => 'ASC',
		);
			$query->set( 'orderby', $orderby );
			$query->set( 'meta_key', 'neu_flag' );

	}

	// print_r($metaquery); print_r($taxonomies); //die;
	// var_dump($query);die;
	return $query;
}



/**
 * Remove the breadcrumbs
 */
add_action( 'init', 'woo_remove_wc_breadcrumbs' );
function woo_remove_wc_breadcrumbs() {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}

// Change the Number of WooCommerce Products Displayed Per Page
add_filter( 'loop_shop_per_page', 'artf_loop_shop_per_page', 30 );

function artf_loop_shop_per_page( $products ) {
	$products = 20;
	return $products;
}

remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );

add_filter( 'woocommerce_product_add_to_cart_text', 'artf_add_symbol_add_cart_button_single' );

function artf_add_symbol_add_cart_button_single( $button ) {

	return '<i class="icon-shopping"></i>' . __( 'Bestellung', 'artifiche' );
	// return $button_new;
}


function get_dynamic_price_html( $from, $sale_check = null ) {

	global $product;
	$product_id         = $product->get_id();
	$internetpreis_flag = get_post_meta( $product_id, 'internetpreis_flag', true );
	$regular_price      = $product->get_regular_price();
	$sale_price         = $product->get_sale_price();
	if ( $sale_price == '' ) {
		$sale_price = $regular_price;
	}

	$purchase_limit = get_field( 'purchase_limit', 'option' );
	$purchase_upper = $purchase_limit + 1;

	$wcml_settings = get_option( '_wcml_settings' );
	$currency      = get_woocommerce_currency();
	$demandprice   = 999999;
	switch ( $currency ) {
		case 'CHF':
			$price_chk_upper = $purchase_upper;
			$demandprice     = $demandprice;
			break;
		case 'EUR':
			$eur             = $wcml_settings['currency_options']['EUR']['rate'];
			$price_chk_upper = $purchase_upper * $eur;
			$demandprice     = $demandprice * $eur;
			break;
		case 'USD':
			$usd             = $wcml_settings['currency_options']['USD']['rate'];
			$price_chk_upper = $purchase_upper * $usd;
			$demandprice     = $demandprice * $usd;
			break;
		default:
			// code...
			break;
	}

	switch ( $currency ) {
		case 'CHF':
			$price_chk_val = $purchase_limit;
			break;
		case 'EUR':
			$eur           = $wcml_settings['currency_options']['EUR']['rate'];
			$price_chk_val = $purchase_limit * $eur;
			break;
		case 'USD':
			$usd           = $wcml_settings['currency_options']['USD']['rate'];
			$price_chk_val = $purchase_limit * $usd;
			break;
		default:
			// code...
			break;
	}
	if ( empty( $regular_price ) ) {
		if ( $sale_check ) {
			return false;
		} else {
			return;
		}
	}

	if ( (int) $regular_price == (int) $demandprice ) {

		if ( $sale_check ) {
			return false;
		} else {
			return '<span class="woocommerce-Price-amount amount">' . __( 'Auf Anfrage', 'artifiche' ) . '</span>';
		}
	}
	global $WC;
	$setcurrency = WC()->session->get( 'wcml_client_currency' );
	// global $woocommerce_wpml;
	// $sprice_display = $woocommerce_wpml->multi_currency->prices->get_product_price_in_currency( $product_id, $setcurrency );
	$currency_symbol = get_woocommerce_currency_symbol();
	if ( $from == 'ajax' ) {
		// return $setcurrency;
		$regular_price = apply_filters( 'wcml_raw_price_amount', $regular_price, $setcurrency );
		$sale_price    = apply_filters( 'wcml_raw_price_amount', $sale_price, $setcurrency );
		switch ( $setcurrency ) {
			case 'CHF':
				$currency_symbol = $currency_symbol;
				break;
			case 'EUR':
				$currency_symbol = '€';
				break;
			case 'USD':
				$currency_symbol = '$';
				break;
			default:
				// code...
				break;
		}
	}

	// $wcml= new woocommerce_wpml();
	// $prices=$wcml->get_multi_currency()->custom_prices->get_product_custom_prices( 28697, 'EUR' );print_r($prices);
	if ( ( $regular_price >= $price_chk_upper ) && $internetpreis_flag == 0 ) {

		if ( $sale_check ) {
			return false;
		} else {
			$preiskategorie_chf = get_post_meta( $product_id, 'preiskategorie_chf', true );
			$preis_klasse = '<span class="woocommerce-Price-currencySymbol"> ' . __( ' bis ', 'artifiche' ) . 'CHF</span>' . $preiskategorie_chf . '<span class="woocommerce-Price-currencySymbol"> / EUR </span>' . $preiskategorie_chf . '<span class="woocommerce-Price-currencySymbol"> / USD </span>' . $preiskategorie_chf . ' ';
			return $preis_klasse . __( '(unverbindliche Preisempfehlung)', 'artifiche' );
			// return '<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"> ' . __( ' bis ', 'artifiche' ) . $currency_symbol . '</span>' . $regular_price . ' ' . __( '(unverbindliche Preisempfehlung)', 'artifiche' ) . '</span>';
		}
	}

	if ( ( $regular_price <= $price_chk_val ) || $internetpreis_flag == 1 ) {
		if ( $sale_check ) {
			return true;
		} else {
			return '<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">' . $currency_symbol . '</span>' . $sale_price . '</span>';
		}
	}

}


/*
function artf_custom_available_payment_gateways( $gateways ) {
	if ( ! is_admin() && is_checkout() ) { //print_r($gateways);
		$chosen_shipping_rates = WC()->session->get( 'chosen_shipping_methods' );
		$all_gateways          = WC()->payment_gateways->payment_gateways();//print_r($all_gateways);
		// When 'local delivery' has been chosen as shipping rate
		if ( in_array( 'flat_rate:4', $chosen_shipping_rates ) ) {

			// // Remove bank transfer payment gateway
			foreach ( $all_gateways as $gateway ) {


				// if( $gateway->enabled == 'yes' ) {

				if ( $gateway->id != 'ubersee' ) {
					unset( $gateways[ $gateway->id ] );
				}
				// }
			}
			// add_filter( 'woocommerce_cart_needs_payment', '__return_false' );

		} else {
			unset( $gateways['ubersee'] );
		}


	}


	return $gateways;
}*/
// add_filter( 'woocommerce_available_payment_gateways', 'artf_custom_available_payment_gateways' );



// add_filter( 'woocommerce_order_button_html', 'remove_order_button_html' );
/*
function remove_order_button_html( $button ) {
	// HERE define your targeted shipping class

	$found         = false;
	$product_array = array();
	// Loop through cart items
	foreach ( WC()->cart->get_cart() as $cart_item ) {
		$product_id = $cart_item['product_id'];
		array_push( $product_array, $product_id );
	}
	$products = implode( ',', $product_array );

	$length = count( $product_array );

	$key = ( $length > 1 ) ? 'mpid' : 'pid';

	$chosen_shipping_rates = WC()->session->get( 'chosen_shipping_methods' );

	// When 'local delivery' has been chosen as shipping rate
	if ( in_array( 'flat_rate:4', $chosen_shipping_rates ) ) {
		$found = true;
	}

	// If found we remove the button
	if ( $found ) {
		$kontakt_url = get_permalink(get_field( 'set_contact_page', 'option' ));
		$button = '<a href="' . $kontakt_url . '?' . $key . '=' . $products . '">
				<button class="btn-blue"><i class="icon-arrow_big"></i> ' . __( 'Anfrage versenden', 'artifiche' ) . '</button>
					</a>';
	}

	return $button;
}
*/
function cart_notempty_add_class() {
	global $woocommerce;
	if ( is_cart() && WC()->cart->cart_contents_count != 0 ) {
		echo '<script type="text/javascript">
		jQuery(document).ready(function() {
                        jQuery("a.cart").addClass("count-visible"); 
                    });
               </script>';
		// exit;
	} else {
		echo '<script type="text/javascript">
		jQuery(document).ready(function() {
                        jQuery("a.cart").removeClass("count-visible"); 
                    });
               </script>';
	}
}
add_action( 'wp_head', 'cart_notempty_add_class' );


/*
 WooCommerce: The Code Below Removes Checkout Fields */
/*
add_filter( 'woocommerce_checkout_fields', 'artf_custom_override_checkout_fields' );
function artf_custom_override_checkout_fields( $fields ) {

	$chosen_shipping_rates = WC()->session->get( 'chosen_shipping_methods' );
	if ( in_array( 'flat_rate:4', $chosen_shipping_rates ) ) {

		unset( $fields['billing']['billing_first_name'] );
		unset( $fields['billing']['billing_last_name'] );
		unset( $fields['billing']['billing_company'] );
		unset( $fields['billing']['billing_address_1'] );
		unset( $fields['billing']['billing_address_2'] );
		unset( $fields['billing']['billing_city'] );
		unset( $fields['billing']['billing_postcode'] );
		unset( $fields['billing']['billing_country'] );
		unset( $fields['billing']['billing_state'] );
		unset( $fields['billing']['billing_phone'] );
		unset( $fields['order']['order_comments'] );
		unset( $fields['billing']['billing_email'] );
		unset( $fields['account']['account_username'] );
		unset( $fields['account']['account_password'] );
		unset( $fields['account']['account_password-2'] );

		unset( $fields['shipping']['shipping_first_name'] );
		unset( $fields['shipping']['shipping_last_name'] );
		unset( $fields['shipping']['shipping_company'] );
		unset( $fields['shipping']['shipping_country'] );
		unset( $fields['shipping']['shipping_address_1'] );
		unset( $fields['shipping']['shipping_address_2'] );
		unset( $fields['shipping']['shipping_city'] );
		unset( $fields['shipping']['shipping_state'] );
		unset( $fields['shipping']['shipping_postcode'] );

	}
	return $fields;
}
*/

add_shortcode( 'search_widget', 'artf_search_widget' );

function artf_search_widget() {

	$form = '<form role="search" method="get" id="searchform" class="searchform mobile-search" action="' . get_permalink( wc_get_page_id( 'shop' ) ) . '" >
    <div>
    <input type="text" placeholder="' . __( 'Suche (Künstler, Marke, Land etc.)', 'artifiche' ) . '" value="' . get_search_query() . '" name="search" id="s" />
    <input type="submit" id="searchsubmit" value="' . esc_attr__( 'Search' ) . '" />
    </div>
    </form>';

	return $form;
}


add_shortcode( 'language_switcher_widget', 'artf_language_switcher_widget' );

function artf_language_switcher_widget() {

	$form = '<div class="lang-switcher">
				' . do_action( 'wpml_add_language_selector' ) . '
			</div>';

	return $form;
}



// Function preventing page delete
function artf_restrict_page_deletion( $post_ID ) {
	$user              = get_current_user_id();
	$restricted_pageId = array();

	$kunstler_detail_page = get_field( 'kunstler_detail_page', 'option' );
	$k_id                 = $kunstler_detail_page->ID;

	if ( $k_id != '' ) {
		array_push( $restricted_pageId, $k_id );
	}

	$kontakt_url = get_field( 'set_contact_page', 'option' );
	$kontact_id  = $kontakt_url->ID;

	if ( $kontact_id != '' ) {
		array_push( $restricted_pageId, $kontact_id );
	}

	$similar_poster_page = get_field( 'similar_poster_page', 'option' );
	$similar_poster_id   = $similar_poster_page->ID;

	if ( $similar_poster_id != '' ) {
		array_push( $restricted_pageId, $similar_poster_id );
	}

	$set_tag_page = get_field( 'set_tag_page', 'option' );
	$tag_page_id  = $set_tag_page->ID;

	if ( $tag_page_id != '' ) {
		array_push( $restricted_pageId, $tag_page_id );
	}

	$news_page    = get_field( 'set_news_page', 'option' );
	$news_page_id = $news_page->ID;

	if ( $news_page_id != '' ) {
		array_push( $restricted_pageId, $news_page_id );
	}

	$collection_page    = get_field( 'set_plakatkollektionen_page', 'option' );
	$collection_page_id = $collection_page->ID;

	if ( $collection_page_id != '' ) {
		array_push( $restricted_pageId, $collection_page_id );
	}

	// $restricted_pageId = array( 22315, 22327, 60 );

	if ( in_array( $post_ID, $restricted_pageId ) ) {
		echo __( 'You are not authorized to delete this page.', 'artifiche' );
		exit;
	}
}
add_action( 'wp_trash_post', 'artf_restrict_page_deletion', 10, 1 );

/*
function artf_redirect_from_tagpage( $params ) {
	global $post;
	// $current_term  = get_query_var( 'tagslug' );
	//
	// Redirect the French language to the home page if the current page ID is 123
	if ( $post->ID === 22315 &&  get_query_var( 'tagslug' ) != '' && get_query_var( 'product_id' ) != '' ) {
		echo get_query_var( 'product_id' );
		$params['pageLanguage'] = 'de';
		$params['languageUrls'] = [ 'en' => 'https://ifekigub.myhostpoint.ch/en' ];

	   // print_r($params);exit;
	}
	return $params;
}
add_filter( 'wpml_browser_redirect_language_params', 'artf_redirect_from_tagpage' );

*/
add_filter( 'WPML_filter_link', 'artf_redirect_another', 99999, 2 );
function artf_redirect_another( $url, $lang ) {

	if ( get_query_var( 'kunstler' ) != '' ) {

		global $sitepress;
		$category_id = get_query_var( 'kunstler' );
		$category    = get_term_by( 'slug', $category_id, 'kunstler' );
		if($category) {
			$cat_id      = $category->term_id;
		} else {
			$cat_id = 0;
		}
		

		switch ( get_the_ID() ) {
			case 14971:
				 $en_page_id = icl_object_id( 14971, 'page', false, 'en' );
				 $post_id    = $en_page_id;
				 $post       = get_post( $post_id );
				 $slug       = $post->post_name;
				global $icl_adjust_id_url_filter_off;
				$default_term_id = (int) icl_object_id( $cat_id, 'kunstler', true, 'en' );

				$orig_flag_value = $icl_adjust_id_url_filter_off;

				$icl_adjust_id_url_filter_off = true;
				$term                         = get_term( $default_term_id, 'kunstler' );// print_r($term);
				$icl_adjust_id_url_filter_off = $orig_flag_value;
				if(!is_wp_error($term)) {
					$en_cat_slug = $term->slug;
				} else {
					$en_cat_slug = "";
				}
				

				 $url = site_url() . '/en/' . $slug . '/' . $en_cat_slug;
				break;

			case 24542:
				$de_page_id = icl_object_id( 24542, 'page', false, 'de' );
				$post_id    = $de_page_id;
				$post       = get_post( $post_id );
				$slug       = $post->post_name;
				global $icl_adjust_id_url_filter_off;
				$default_term_id = (int) icl_object_id( $cat_id, 'kunstler', true, 'de' );

				$orig_flag_value = $icl_adjust_id_url_filter_off;

				$icl_adjust_id_url_filter_off = true;
				$term                         = get_term( $default_term_id, 'kunstler' );// print_r($term);
				$icl_adjust_id_url_filter_off = $orig_flag_value;
				if(!is_wp_error($term)) {
					$en_cat_slug = $term->slug;
				} else {
					$en_cat_slug = "";
				}
				

				$url = site_url() . '/' . $slug . '/' . $en_cat_slug;
				break;

			default:
				break;
		}
	}
	if ( get_query_var( 'pid' ) != '' ) {

		switch ( get_the_ID() ) {
			case 15037:
				 $en_page_id    = icl_object_id( 15037, 'page', false, 'en' );
				 $post_id       = $en_page_id;
				 $post          = get_post( $post_id );
				 $slug          = $post->post_name;
				 $p_id          = get_query_var( 'pid' );
				 $en_product_id = icl_object_id( $p_id, 'product', false, 'en' );
				 $url           = site_url() . '/en/' . $slug . '/' . $en_product_id;
				break;

			case 24346:
				$de_page_id = icl_object_id( 24346, 'page', false, 'de' );
				$post_id    = $de_page_id;
				$post       = get_post( $post_id );
				$slug       = $post->post_name;
				$p_id       = get_query_var( 'pid' );
				$de_p_id    = icl_object_id( $p_id, 'product', false, 'de' );
				$url        = site_url() . '/' . $slug . '/' . $de_p_id;
				break;

			default:
				break;
		}
	}

	if ( get_query_var( 'tagslug' ) != '' && get_query_var( 'product_id' ) != '' ) {

		$product_id = get_query_var( 'product_id' );
		$languages  = icl_get_languages( 'skip_missing=1' );
		switch ( get_the_ID() ) {
			case 22315:
				// $en_product_id = icl_object_id( $product_id, 'product', false, ICL_LANGUAGE_CODE );
				$en_product_id  = icl_object_id( $product_id, 'product', false, 'en' );
				$en_prodct_url  = get_the_permalink( $en_product_id );
				$wpml_permalink = apply_filters( 'wpml_permalink', $en_prodct_url, 'en' );

				$lang = $lang['language_code'];
				if ( isset( $languages[ $lang ] ) ) {

					switch ( $lang ) {
						case 'en':
							$url = $wpml_permalink;
							break;
						case 'de':
							$url = $url;
							break;
						default:
							$url = $url;
							break;
					}
				}

				break;

			case 22327:
				// $en_product_id = icl_object_id( $product_id, 'product', false, ICL_LANGUAGE_CODE );
				$en_product_id  = icl_object_id( $product_id, 'product', false, 'de' );
				$en_prodct_url  = get_the_permalink( $en_product_id );
				$wpml_permalink = apply_filters( 'wpml_permalink', $en_prodct_url, 'de' );

				$lang = $lang['language_code'];
				if ( isset( $languages[ $lang ] ) ) {

					switch ( $lang ) {
						case 'en':
							$url = $url;
							break;
						case 'de':
							$url = $wpml_permalink;
							break;
						default:
							$url = $url;
							break;
					}
				}

				break;

			default:
				// code...
				break;
		}
	}

	return $url;
}



function artf_get_alt_text( $product_id ) {

	$künstler_vorname = '';
	$künstle_lastname = '';
	$category_detail  = get_the_terms( $product_id, 'kunstler' );

	if ( ! empty( $category_detail ) ) {
		foreach ( $category_detail as $cd ) {

				$künstler_vorname = get_field( 'gestalter_vorname', $cd );
				$künstle_lastname = get_field( 'gestalter_name', $cd );
				$gestler          = $künstler_vorname . ' ' . $künstle_lastname;
				$gestler          = trim( $gestler );

		}
	}

	$alt_text = get_the_title( $product_id );
	if ( $künstler_vorname != '' || $künstle_lastname != '' ) {

		$alt_text .= ', ' . $gestler;
	}

		return $alt_text;

}


function make_slug( $str ) {
	if ( $str !== mb_convert_encoding( mb_convert_encoding( $str, 'UTF-32', 'UTF-8' ), 'UTF-8', 'UTF-32' ) ) {
		$str = mb_convert_encoding( $str, 'UTF-8', mb_detect_encoding( $str ) );
	}
		$str = htmlentities( $str, ENT_NOQUOTES, 'UTF-8' );
		$str = preg_replace( '`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\\1', $str );
		$str = html_entity_decode( $str, ENT_NOQUOTES, 'UTF-8' );
		$str = preg_replace( array( '`[^a-z0-9]`i', '`[-]+`' ), '-', $str );
		$str = strtolower( trim( $str, '-' ) );
		// $str = substr($str, 0, 100);
		return $str;
}


function artf_replace_umlaut( $text ) {
	$char    = array(
		'%C3%84',
		'%C3%A4',
		'%C3%9C',
		'%C3%BC',
		'%C3%96',
		'%C3%B6',
		'%C3%82',
		'%C3%A2',
		'%C3%81',
		'%C3%A1',
	);
	$url     = array(
		'Ä',
		'ä',
		'Ü',
		'ü',
		'Ö',
		'ö',
		'Â',
		'â',
		'Á',
		'á',
	);
	$str     = str_replace( $char, $url, $text );
	$str_new = str_replace( ' ', '', $str );
	return $str_new;
}


add_action( 'admin_head', 'artf_custom_admin_css' );

function artf_custom_admin_css() {
	echo '<style type="text/css">
			[data-gateway_id|="ubersee"] {
			    display: none;
			}
		</style>';
}
/*
add_filter('icl_ls_languages', 'artf_wpml_ls_filter');

function artf_wpml_ls_filter($languages) {

   foreach ($languages as $lang_code => $language) {

	   $mTempString = $languages[$lang_code]['url'];

			  // If "tax" is found in that string, replace it with "" - remove it.
	   if (strpos($mTempString, "news-en") !== false) {

			  $languages[$lang_code]['url'] = str_replace("news-en", "news", $mTempString);
	   }

   }
return $languages;
}*/
add_action( 'admin_menu', 'artf_admin_menu' );

function artf_admin_menu() {
	add_menu_page( __( 'Manual Cronjob', 'artifiche' ), __( 'Manual Cronjob', 'artifiche' ), 'manage_options', 'manual-cron-job', 'artf_manual_cronjob_fun', 'dashicons-tickets', 112 );
}
function artf_manual_cronjob_fun() {
	// update_option('cron_status', 'completed');
	$cron_status = get_option( 'cron_status' );
	if ( $cron_status == 'started' ) {
		$class_name   = 'disabled';
		$display_text = 'block';
	} else {
		$class_name   = '';
		$display_text = 'none';
	}
	echo '<div class="cron-outer">';
	echo '<h2>' . __( 'Manual Cronjob', 'artifiche' ) . '</h2>';
	echo '<p>' . __( "Click this button to trigger the import. Once you click the button import will trigger and the button will deactivated until all the import is finished.<br/>Import processing URL should be configured in server's cron tab for all imports.", 'artifiche' ) . '</p>';
	echo '<button name="manual_cron" class="button-primary manual-cron ' . $class_name . '" type="submit" value="Start manual cronjob">' . __( 'Start manual cronjob', 'artifiche' ) . '</button>';
	echo '<p class="cron_success" style="display: none;">' . __( 'Import successfully triggered!', 'artifiche' ) . '</p>';
	echo '<p class="cron_process" style="display: ' . $display_text . ';">' . __( 'Import is in progress.', 'artifiche' ) . '</p>';
	echo '<p class="cron_fail" style="display: none;">' . __( 'Something went wrong! Please try again.', 'artifiche' ) . '</p>';
	echo '</div>';
}

function artf_custom_admin_js() {

	echo '<script type="text/javascript">

	jQuery(".manual-cron").on("click", function(){
		jQuery.ajax({
			type : "post",
			url : "' . admin_url( 'admin-ajax.php' ) . '",
			data : {action: "artf_manual_cron_action"},
			beforeSend: function() {
				},
			complete: function() {
				jQuery("this").addClass("disabled")
			},
			success: function(response) {		
				if(response == "success") {					
					jQuery(".manual-cron").addClass("disabled")
					jQuery(".cron_success").show()
					jQuery(".cron_fail").hide()
				 }
				 else {
					jQuery(".cron_fail").show()
					jQuery(".cron_success").hide()
				 }
			},
			error: function() {
				alert()

			}
		 })   
	});
	
	</script>';
}
add_action( 'admin_footer', 'artf_custom_admin_js' );

add_action( 'wp_ajax_artf_manual_cron_action', 'artf_manual_cron_action' );
add_action( 'wp_ajax_nopriv_artf_manual_cron_action', 'artf_manual_cron_action' );



function artf_manual_cron_action() {

	update_option( 'cron_status', 'started' );
	$trigger_url = site_url() . '/wp-cron.php?import_key=1UhjOBTd&import_id=114&action=trigger';
	$response    = wp_remote_get( $trigger_url );
	$status      = $response['response']['code'];
	if ( $status == 200 ) {
		echo 'success';
	} else {
		echo 'error';
	}

	die();
}

if ( defined( 'YITH_WCWL' ) && ! function_exists( 'yith_wcwl_get_items_count' ) ) {
	function yith_wcwl_get_items_count() {
		ob_start();

		echo esc_html( yith_wcwl_count_all_products() );
		return ob_get_clean();
	}
	add_shortcode( 'yith_wcwl_items_count', 'yith_wcwl_get_items_count' );
}
if ( defined( 'YITH_WCWL' ) && ! function_exists( 'yith_wcwl_ajax_update_count' ) ) {
	function yith_wcwl_ajax_update_count() {
		wp_send_json(
			array(
				'count' => yith_wcwl_count_all_products(),
			)
		);
	}
	add_action( 'wp_ajax_yith_wcwl_update_wishlist_count', 'yith_wcwl_ajax_update_count' );
	add_action( 'wp_ajax_nopriv_yith_wcwl_update_wishlist_count', 'yith_wcwl_ajax_update_count' );
}

if ( defined( 'YITH_WCWL' ) && ! function_exists( 'yith_wcwl_enqueue_custom_script' ) ) {
	function yith_wcwl_enqueue_custom_script() {
		wp_add_inline_script(
			'jquery-yith-wcwl',
			"
		 jQuery( function( $ ) {
			$( document ).on( 'added_to_wishlist removed_from_wishlist', function() {
			  $.get( yith_wcwl_l10n.ajax_url, {
				action: 'yith_wcwl_update_wishlist_count'
			  }, function( data ) {
				  if( data.count > 0 ){
				    if( ! $('#wishlist-items-cnt').hasClass('count') ) {
						$('#wishlist-items-cnt').addClass('count');
					}

					$('#wishlist-items-cnt').html( data.count );
				  }else{
					$('#wishlist-items-cnt').html('');
					$('#wishlist-items-cnt').removeClass('count');
				  }
			  } );
			} );
		  } );
		 "
		);
	}
	add_action( 'wp_enqueue_scripts', 'yith_wcwl_enqueue_custom_script', 20 );
}
   add_filter( 'woocommerce_account_menu_items', 'artf_remove_downloads_my_account', 999 );

function artf_remove_downloads_my_account( $items ) {
	unset( $items['downloads'] );
	return $items;
}
if ( defined( 'WPFDA_PLUGIN_FILE' ) ) {
	function action_wp_frontend_delete_account_before_content( $html ) {

		// remove_action( 'woocommerce_account_wpf-delete-account_endpoint', 'wp_frontend_delete_account_before_content', 10, 2 );

		if ( ! is_user_logged_in() ) {
			return;
		}
		$button           = get_option( 'wpfda_button_label', esc_html__( 'Confirm', 'wp-frontend-delete-account' ) );
		$user_id          = get_current_user_id();
		$security         = get_option( 'wpfda_security', 'password' );
		$password_text    = get_option( 'wpfda_security_password_text', esc_html__( 'Please enter your password and then click "Confirm"', 'wp-frontend-delete-account' ) );
		$captcha_question = get_option( 'wpfda_security_custom_captcha_question', 'Enter PERMANENTLY DELETE to confirm:' );
		$captcha_answer   = get_option( 'wpfda_security_custom_captcha_answer', 'PERMANENTLY DELETE' );
		$site_key         = get_option( 'wpfda_security_recaptcha_site_key' );
		$site_secret      = get_option( 'wpfda_security_recaptcha_site_secret' );
		$class            = apply_filters( 'wpfda_container_class', 'wpfda-delete-account-container' );
		$html             = '<div class="' . $class . ' custom-delete">';

		// if ( current_user_can( 'administrator' ) ) {
		$html .= esc_html__(
			'If you delete your account, all data will be permanently erased.
		You can create a new account at any time.',
			'wp-frontend-delete-account'
		);

		if ( 'password' === $security ) {
			$html .= '<div class="wpfda-password-confirm">';
			$html .= '<label>' . $password_text . '</label>';
			$html .= ' <input type="password" name="wpfda-password" />';
			$html .= '</div>';
		} elseif ( 'custom_captcha' === $security && $captcha_question != '' ) {
			$html .= '<div class="wpfda-custom-captcha">';
			$html .= '<label>' . $captcha_question . '</label>';
			$html .= '<input type="text" name="wpfda-custom-captcha-answer" />';
			$html .= '</div">';
		}

		$html .= '<div class="wpfda-error">';
		$html .= '<span style="color:red"></span>';
		$html .= '</div>';

		$html .= '<div class="wpfda-submit">';
		$html .= '<a class="wpf-delete-account-button" href="#">';
		$html .= '<button>' . $button . '</button></a>';
		$html .= '</div>';

		$html .= '</div>';
		echo $html;
	}

	add_action( 'woocommerce_account_wpf-delete-account_endpoint', 'action_wp_frontend_delete_account_before_content', 9 );
	remove_action( 'woocommerce_account_wpf-delete-account_endpoint', array( 'WooCommerce', 'add_content' ) );

}

/*
 * Including custom text for emails and notifications
 */
require get_template_directory() . '/inc/text-change.php';
