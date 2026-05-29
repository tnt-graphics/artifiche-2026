<?php

vc_map(
	array(
		'name'                    => __( 'Artifiche Text blaue Box', 'artifiche' ),
		'base'                    => 'artifiche_bluebox',
		'icon'                    => get_template_directory_uri() . '/img/logo2.svg',
		'category'                => __( 'Artifiche Elements', 'artifiche' ),
		'description'             => __( 'Es wird eine blaue Box mit weissem Titel, Text und Button angezeigt.', 'artifiche' ),
		'content_element'         => true,
		'show_settings_on_create' => true,
		'params'                  => array_merge(
			array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Titel', 'artifiche' ),
					'param_name'  => 'box_title',
					'admin_label' => true,
				),
				array(
					'type'        => 'textarea',
					'heading'     => esc_html__( 'Text', 'artifiche' ),
					'param_name'  => 'box_content',
					'admin_label' => true,
				),
				array(
					'type'        => 'vc_link',
					'heading'     => esc_html__( 'Button Link', 'artifiche' ),
					'param_name'  => 'button_link',
					'admin_label' => true,
				),
			)
		),
	)
);

add_shortcode( 'artifiche_bluebox', 'artifiche_bluebox_render' );

function artifiche_bluebox_render( $atts, $content = null ) {

	extract(
		shortcode_atts(
			array(
				'box_title'   => '',
				'box_content' => '',
				'button_link' => '',
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
		$button1   = '<a class="outline-btn btn-light" href="' . esc_attr( $a_href1 ) . '" target="' . esc_attr( $a_target1 ) . '">
		<i class=icon-arrow_big></i>' . esc_attr( $a_title1 ) . '</a>';
	}
	$html = '<div class="artifiche-bluebox"><h5>' . $box_title . '</h5><p>' . $box_content . '</p>' . $button1 . '</div>';
	return $html;
}
