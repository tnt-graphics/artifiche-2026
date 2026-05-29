<?php

vc_map(
	array(
		'name'                    => __( 'Artifiche unterstrichener Link', 'artifiche' ),
		'base'                    => 'artifiche_normal_button',
		'icon'                    => get_template_directory_uri() . '/img/logo2.svg',
		'category'                => __( 'Artifiche Elements', 'artifiche' ),
		'description'             => __( 'Fügt einen unterstrichenen Link mit Text hinzu.', 'artifiche' ),
		'content_element'         => true,
		'show_settings_on_create' => true,
		'params'                  => array_merge(
			array(
				array(
					'type'        => 'vc_link',
					'heading'     => esc_html__( 'Text-Link', 'artifiche' ),
					'param_name'  => 'button_link',
					'admin_label' => true,
				),
			)
		),
	)
);

add_shortcode( 'artifiche_normal_button', 'artifiche_normal_button_render' );

function artifiche_normal_button_render( $atts, $content = null ) {

	extract(
		shortcode_atts(
			array(
				'button_link'  => '',
			),
			$atts
		)
	);
	$button1 = '';
	if ( $button_link ) {
		$btn_url1  = vc_build_link( $button_link );
		$a_href1   = $btn_url1['url'];
		$a_title1  = $btn_url1['title'];
		$a_target1 = $btn_url1['target'];
		$button1   = '<a class="common-link" href="' . esc_attr( $a_href1 ) . '" target="' . esc_attr( $a_target1 ) . '">' . esc_attr( $a_title1 ) . '</a>';
	}
	$html = $button1;
	return $html;
}
