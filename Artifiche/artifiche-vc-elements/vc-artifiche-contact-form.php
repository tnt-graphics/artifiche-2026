<?php

vc_map(
	array(
		'name'                    => __( 'Artifiche Kontaktformular', 'artifiche' ),
		'base'                    => 'artifiche_contactform',
		'icon'                    => get_template_directory_uri() . '/img/logo2.svg',
		'category'                => __( 'Artifiche Elements', 'artifiche' ),
		'description'             => __( 'Über den Shorcode wird das Kontaktformular angezeigt.', 'artifiche' ),
		'content_element'         => true,
		'show_settings_on_create' => true,
		'params'                  => array_merge(
			array(
				array(
					'type'        => 'textarea',
					'heading'     => esc_html__( 'Contact Form Shortcode', 'artifiche' ),
					'param_name'  => 'cf7_shortcode',
					'admin_label' => true,
				),
			)
		),
	)
);

add_shortcode( 'artifiche_contactform', 'artifiche_contactform_render' );

function artifiche_contactform_render( $atts, $content = null ) {

	extract(
		shortcode_atts(
			array(
				'cf7_shortcode' => '',
			),
			$atts
		)
	);
	$cf7_shortcode = str_replace( '``', '"', $cf7_shortcode );
	$cf7_shortcode = str_replace( '`}`', ']', $cf7_shortcode );
	$cf7_shortcode = str_replace( '`{`', '[', $cf7_shortcode );
	$contact_form      = do_shortcode( $cf7_shortcode );
	$html = '<div class="artifiche-cf7">' . $contact_form . '</div>';
	return $html;
}
