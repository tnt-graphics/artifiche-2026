<?php
// Register "container" content element. It will hold all your inner (child) content elements
vc_map(
	array(
		'name'                    => __( 'Artifiche Container', 'artifiche' ),
		'base'                    => 'artifiche_container_wrap',
		'icon'                    => get_template_directory_uri() . '/img/logo2.svg',
		'category'                => __( 'Artifiche Elements', 'artifiche' ),
		// 'as_parent'               => array( 'only' => 'bbvb_benefits' ), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
		'content_element'         => true,
		'show_settings_on_create' => true,
		'is_container'            => true,
		'description'             => __( 'Wird verwendet, wenn ein Element nicht über die volle Breite des Bildschirms
		angezeigt werden soll.', 'artifiche' ),
		'js_view'                 => 'VcColumnView',
		'params'                  => array(
			// add params same as with any other content element
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Hintergrundfarbe', 'artifiche' ),
				'param_name' => 'white_back',
				'value'      => array(
					esc_html__( 'Keine Hintergrundfarbe', 'artifiche' )  => '0',
					esc_html__( 'Hellblauer Hintergrund', 'artifiche' )  => '1',
					esc_html__( 'Weißer Hintergrund', 'artifiche' )  => '2',
					esc_html__( 'Dunkelblauer Hintergrund', 'artifiche' ) => '3',

				),
			),
			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__( 'Small container (News, etc)?', 'artifiche' ),
				'param_name'  => 'isnewspost',
				'value'       => array( esc_html__( 'Yes', 'artifiche' ) => '1' ),
				'description' => __( 'Select this if it is a news post.', 'artifiche' ),
			),
			// array(
			// 	'type'        => 'checkbox',
			// 	'heading'     => esc_html__( 'Remove Container / Is Filter?', 'artifiche' ),
			// 	'param_name'  => 'isfilter',
			// 	'value'       => array( esc_html__( 'Yes', 'artifiche' ) => '1' ),
			// 	'description' => __( 'Select this if it is a filter section.', 'artifiche' ),
			// ),

		),

	)
);
  // Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_artifiche_container_wrap extends WPBakeryShortCodesContainer {
	}
}


add_shortcode( 'artifiche_container_wrap', 'artifiche_container_wrap_func' );
function artifiche_container_wrap_func( $atts, $content = null ) {
	extract(
		shortcode_atts(
			array(
				'white_back' => '',
				'isnewspost' => '',
				// 'isfilter'   => '',
			),
			$atts
		)
	);

	if ( $white_back === '3' ) {
		$bg_class = 'darkblue-bg';
	} elseif ( $white_back === '2' ) {
		$bg_class = 'white-bg';
	} elseif ( $white_back === '1' ) {
		$bg_class = 'blue-bg';
	} else {
		$bg_class = '';
	}
	$isnewspost_class = '';
	$container_class  = 'container';
	if ( ! empty( $isnewspost ) ) {

		if ( ! is_singular( 'post' ) ) {
			$container_class  = '';
			$isnewspost_class = 'single-column min-col';
		} else {
			$isnewspost_class = 'single-column';
			$container_class  = '';
		}
	}

	// $container_class = 'container';
	// if ( ! empty( $isfilter ) ) {
	// 	$container_class = '';
	// }

	return '<div class="' . $bg_class . ' ' . $isnewspost_class . '"><div class="' . $container_class . '">' . wpb_js_remove_wpautop( $content ) . '
	</div></div>';
}
