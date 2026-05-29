<?php

vc_map(
	array(
		'name'                    => __( 'Artifiche Shop', 'artifiche' ),
		'base'                    => 'artifiche_poster_list',
		'icon'                    => get_template_directory_uri() . '/img/logo2.svg',
		'category'                => __( 'Artifiche Elements', 'artifiche' ),
		'description'             => __( 'Zeigt alle Poster in einer Listen- oder Kachelansicht an. Die Seite muss als Shop-
		Seite definiert sein.', 'artifiche' ),
		'content_element'         => true,
		'show_settings_on_create' => true,
		'params'                  => array_merge(
		),
	)
);

add_shortcode( 'artifiche_poster_list', 'artifiche_poster_list_render' );

function artifiche_poster_list_render( $atts, $content = null ) {

	extract(
		shortcode_atts(
			array(),
			$atts
		)
	);

	if ( woocommerce_product_loop() ) {

		/**
		 * Hook: woocommerce_before_shop_loop.
		 *
		 * @hooked woocommerce_output_all_notices - 10
		 * @hooked woocommerce_result_count - 20
		 * @hooked woocommerce_catalog_ordering - 30
		 */
		do_action( 'woocommerce_before_shop_loop' );
		woocommerce_product_loop_start();

		if ( wc_get_loop_prop( 'total' ) ) {
			while ( have_posts() ) {
				the_post();

				// *
				// * Hook: woocommerce_shop_loop.

				do_action( 'woocommerce_shop_loop' );

				wc_get_template_part( 'content', 'product' );

			}
		}

		woocommerce_product_loop_end();
		/**
		 * Hook: woocommerce_after_shop_loop.
		 *
		 * @hooked woocommerce_pagination - 10
		 */
		do_action( 'woocommerce_after_shop_loop' );
	} else {
		/**
		 * Hook: woocommerce_no_products_found.
		 *
		 * @hooked wc_no_products_found - 10
		 */
		
		do_action( 'woocommerce_no_products_found' );

	}

	/**
	 * Hook: woocommerce_after_main_content.
	 *
	 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
	 */
	// do_action( 'woocommerce_after_main_content' );

	/**
	 * Hook: woocommerce_sidebar.
	 *
	 * @hooked woocommerce_get_sidebar - 10
	 */
	do_action( 'woocommerce_sidebar' );
}
