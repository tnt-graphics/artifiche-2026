<?php

/**
 * Table of Contents:
 *
 * 1.0 - Enqeue stylesheets
 * 2.0 - Enqeue JavaScripts
 * ----------------------------------------------------------------------------
 */
function artifiche_theme_scripts() {
	/**
		 * 1.0 - Enqeue stylesheets
		 * ----------------------------------------------------------------------------
		 */

	wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/css/bootstrap.min.css', false, _S_VERSION, 'all' );
	wp_enqueue_style( 'slick-css', get_template_directory_uri() . '/css/slick.css', false, _S_VERSION, 'all' );
	wp_enqueue_style( 'slick-theme-css', get_template_directory_uri() . '/css/slick-theme.css', false, _S_VERSION, 'all' );
	wp_enqueue_style( 'icons-css', get_template_directory_uri() . '/css/icons.css', false, _S_VERSION, 'all' );
	wp_enqueue_style( 'magnific-popup-css', get_template_directory_uri() . '/css/magnific-popup.css', false, _S_VERSION, 'all' );
	wp_enqueue_style( 'minicolor-css', get_template_directory_uri() . '/css/jquery.minicolors.css', false, _S_VERSION, 'all' );
	wp_enqueue_style( 'select-css', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css', false, _S_VERSION, 'all' );
	wp_enqueue_style( 'custom-css', get_template_directory_uri() . '/css/custom.css', false, _S_VERSION, 'all' );
	wp_enqueue_style( 'responsive-css', get_template_directory_uri() . '/css/responsive.css', false, _S_VERSION, 'all' );

	/**
	 * 2.0 - Enqeue JavaScripts
	 * ----------------------------------------------------------------------------
	 */
	// wp_deregister_script( 'jquery' );
	// wp_enqueue_script( 'jquery-js', get_template_directory_uri() . '/js/jquery-3.3.1.min.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'slick-min-js', get_template_directory_uri() . '/js/slick.min.js', array(), _S_VERSION, true );
	wp_localize_script( 'slick-min-js', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
// function xx_change_jquery() {
// 	wp_deregister_script( 'jquery' );
// 	wp_deregister_script( 'jquery-core' );
// 	wp_register_script( 'jquery', get_template_directory_uri() . '/js/jquery-3.3.1.min.js', '3.3.1' );
// }
// add_action( 'wp_enqueue_scripts', 'xx_change_jquery' );

add_action( 'wp_enqueue_scripts', 'artifiche_theme_scripts' );


add_action( 'admin_enqueue_scripts', 'load_admin_styles' );
function load_admin_styles() {
	wp_enqueue_style( 'admin_custom_css', get_template_directory_uri() . '/css/admin-custom.css', false, '1.0.0' );
}
