<?php

vc_map(
	array(
		'name'                    => __( 'Artifiche Home Bild mit Buttons', 'artifiche' ),
		'base'                    => 'artifiche_imgtxt',
		'icon'                    => get_template_directory_uri() . '/img/logo2.svg',
		'category'                => __( 'Artifiche Elements', 'artifiche' ),
		'description'             => __( 'Zeigt ein Bild über die gesamte Breite der Webseite mit Titel und zwei Buttons.', 'artifiche' ),
		'content_element'         => true,
		'show_settings_on_create' => true,
		'params'                  => array_merge(
			array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Überschrift', 'artifiche' ),
					'param_name'  => 'head_title',
					'admin_label' => true,
				),
				array(
					'type'       => 'attach_image',
					'param_name' => 'single_img',
					'heading'    => __( 'Bild', 'artifiche' ),
				),
				array(
					'type'        => 'vc_link',
					'heading'     => esc_html__( 'Button Link 1', 'artifiche' ),
					'param_name'  => 'btn_url1',
					'admin_label' => true,
				),
				array(
					'type'        => 'vc_link',
					'heading'     => esc_html__( 'Button Link 2', 'artifiche' ),
					'param_name'  => 'btn_url2',
					'admin_label' => true,
				),
			)
		),
	)
);

add_shortcode( 'artifiche_imgtxt', 'artifiche_imgtxt_render' );

function artifiche_imgtxt_render( $atts, $content = null ) {

	extract(
		shortcode_atts(
			array(
				'head_title' => '',
				'single_img' => '',
				'btn_url1'   => '',
				'btn_url2'   => '',
			),
			$atts
		)
	);
	$bg_img = '';
	if ( isset( $single_img ) ) {

		$single_img_url = wp_get_attachment_image_src( $single_img, 'full' );
		$bg_img         = 'style="background: url(' . $single_img_url[0] . ') no-repeat;"';
	}
	$button1 = '';
	$button2 = '';
	if ( $btn_url1 ) {
		$btn_url1  = vc_build_link( $btn_url1 );
		$a_href1   = $btn_url1['url'];
		$a_title1  = $btn_url1['title'];
		$a_target1 = $btn_url1['target'];
		$button1   = '<a class="outline-btn btn-light" href="' . esc_attr( $a_href1 ) . '" target="' . esc_attr( $a_target1 ) . '"><i class=icon-mapmarker></i>' . esc_attr( $a_title1 ) . '</a>';
	}
	if ( $btn_url2 ) {
		$btn_url2  = vc_build_link( $btn_url2 );
		$a_href2   = $btn_url2['url'];
		$a_title2  = $btn_url2['title'];
		$a_target2 = $btn_url2['target'];
		$button2   = '<a class="outline-btn btn-light" href="' . esc_attr( $a_href2 ) . '" target="' . esc_attr( $a_target2 ) . '"><i class=icon-oeffnungszeiten></i>' . esc_attr( $a_title2 ) . '</a>';
	}
	$html = '<div class="artifiche-single-img-txt" ' . $bg_img . '>
	<div class=" single-img-content container">
	<h1>' . $head_title . '</h1>
	' . $button1 . $button2 . '
	</div>
	</div>';
	return $html;
	// <img src="' . $single_img_url[0] . '" alt="' . $head_title . '" />
}
