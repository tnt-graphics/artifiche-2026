<?php

/*
Element Description: Artifiche Collection List
*/


// Map the block with vc_map()
vc_map(
	array(
		'name'        => __( 'Artifiche Link With Text', 'artifiche' ),
		'base'        => 'artifiche_link_text',
		'icon'        => get_template_directory_uri() . '/img/logo2.svg',
		'category'    => __( 'Artifiche Elements', 'artifiche' ),
		'description' => __( 'Collection list section', 'artifiche' ),
		'params'      => array_merge(
			array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Collection Bottom Content', 'artifiche' ),
					'param_name'  => 'colection_bottom_text',
					'admin_label' => true,
				),
				array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Bottom Link Text', 'artifiche' ),
				'param_name'  => 'link_text',
				'description' => __( 'Default: Kontaktieren Sie uns.', 'artifiche' ),
				'admin_label' => true,
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Link Url', 'artifiche' ),
					'param_name'  => 'link_url',
					'description' => __( 'Default: Kontakt', 'artifiche' ),
					'admin_label' => true,
				),
			)
		),
	)
);


add_shortcode( 'artifiche_link_text', 'artifiche_link_text_fun' );


// Element HTML
function artifiche_link_text_fun( $atts, $content = null ) {
	extract(
		shortcode_atts(
			array(
				'colection_bottom_text'  => '',
				'link_text'  => '',
				'link_url'  => '',
			),
			$atts
		)
	);
	$button1 = '';
	if ( $link_url ) {
		// $btn_url1  = vc_build_link( $button_link );
		// $a_href1   = $btn_url1['url'];
		// $a_title1  = $btn_url1['title'];
		// $a_target1 = $btn_url1['target'];
		$button1   = '<i class=icon-arrow_big></i>'. $colection_bottom_text .'<a class="btn" href="' . esc_attr( $link_url ) . '">' . esc_attr( $link_text ) . '</a>';
	}
	$html = $button1;
	return $html;
}
