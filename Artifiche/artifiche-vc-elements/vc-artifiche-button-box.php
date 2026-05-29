<?php

vc_map(
	array(
		'name'                    => __( 'Artifiche Button', 'artifiche' ),
		'base'                    => 'artifiche_box_button',
		'icon'                    => get_template_directory_uri() . '/img/logo2.svg',
		'category'                => __( 'Artifiche Elements', 'artifiche' ),
		'description'             => __( 'Fügt einen Button mit Text und schwarzen Rahmen hinzu.', 'artifiche' ),
		'content_element'         => true,
		'show_settings_on_create' => true,
		'params'                  => array_merge(
			array(
				array(
					'type'        => 'vc_link',
					'heading'     => esc_html__( 'Button Link', 'artifiche' ),
					'param_name'  => 'button_link',
					'admin_label' => true,
				),
				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__( 'Add some space at the bottom of the button.', 'artifiche' ),
					'param_name'  => 'isextraclass',
					'value'       => array( esc_html__( 'Yes', 'artifiche' ) => '1' ),
					'description' => __( 'Select this if you want to add some space at the bottom.', 'artifiche' ),
				),
				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__( 'Is mobile only?', 'artifiche' ),
					'param_name'  => 'ismobileclass',
					'value'       => array( esc_html__( 'Yes', 'artifiche' ) => '1' ),
					'description' => __( 'Select this if the button only needs to display in mobile.', 'artifiche' ),
				),
			)
		),
	)
);

add_shortcode( 'artifiche_box_button', 'artifiche_box_button_render' );

function artifiche_box_button_render( $atts, $content = null ) {

	extract(
		shortcode_atts(
			array(
				'button_link'   => '',
				'isextraclass'  => '',
				'ismobileclass' => '',
			),
			$atts
		)
	);
	$extra_class = '';
	if ( ! empty( $isextraclass ) ) {
		$extra_class = 'mb-5';
	}
	$mbl_class = '';
	if ( ! empty( $ismobileclass ) ) {
		$mbl_class = 'mobile-only';
	}

	$button1 = '';
	if ( $button_link ) {
		$btn_url1  = vc_build_link( $button_link );
		$a_href1   = $btn_url1['url'];
		$a_title1  = $btn_url1['title'];
		$a_target1 = $btn_url1['target'];
		$button1   = '<a class="outline-btn ' . $extra_class .' '. $mbl_class . '" href="' . esc_attr( $a_href1 ) . '" target="' . esc_attr( $a_target1 ) . '"><i class=icon-arrow_big></i>' . esc_attr( $a_title1 ) . '</a>';
	}
	$html = $button1;
	return $html;
}
