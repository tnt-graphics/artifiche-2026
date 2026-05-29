<?php
// Register "container" content element. It will hold all your inner (child) content elements
vc_map(
	array(
		'name'                    => __( 'Artifiche', 'artifiche' ),
		'base'                    => 'artifiche_testimonial_wrap',
		'icon'                    => get_template_directory_uri() . '/img/logo2.svg',
		'category'                => __( 'Artifiche Elements', 'artifiche' ),
		// 'as_parent'               => array( 'only' => 'bbvb_benefits' ), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
		'content_element'         => true,
		'show_settings_on_create' => true,
		'is_container'            => true,
		'description'             => __( 'Artifiche Home-Poster Container', 'artifiche' ),
		'params'                  => array(
			// add params same as with any other content element
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Hintergrundfarbe', 'artifiche' ),
				'param_name' => 'white_back',
				'value'      => array(
					esc_html__( 'Hellblauer Hintergrund', 'artifiche' )  => '1',
					esc_html__( 'Weißer Hintergrund', 'artifiche' )  => '2',
					esc_html__( 'Dunkelblauer Hintergrund', 'artifiche' ) => '3',

				),
			),


		),
		'js_view'                 => 'VcColumnView',
	)
);
  // Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_artifiche_testimonial_wrap extends WPBakeryShortCodesContainer {
	}
}


add_shortcode( 'artifiche_testimonial_wrap', 'artifiche_testimonial_wrap_func' );
function artifiche_testimonial_wrap_func( $atts, $content = null ) {
	extract(
		shortcode_atts(
			array(
				'white_back' => '',
			),
			$atts
		)
	);
	if ( $white_back === '3' ) {
		$bg_class = 'darkblue-bg';
	} elseif ( $white_back === '2' ) {
		$bg_class = 'white-bg';
	} else {
		$bg_class = 'blue-bg';

	}
	return "<div class='$bg_class'><div class='container masonry-layout'>" . wpb_js_remove_wpautop( $content ) . '</div></div>';
}
