<?php

vc_map(
	array(
		'name'                    => __( 'Artifiche Zitat', 'artifiche' ),
		'base'                    => 'artifiche_summary_text',
		'icon'                    => get_template_directory_uri() . '/img/logo2.svg',
		'category'                => __( 'Artifiche Elements', 'artifiche' ),
		'description'             => __( 'Zeigt eine Linie und darunter den Text in grösser.', 'artifiche' ),
		'content_element'         => true,
		'show_settings_on_create' => true,
		'params'                  => array_merge(
			array(
				array(
					'type'        => 'textarea',
					'heading'     => esc_html__( 'Zitat-Text', 'artifiche' ),
					'param_name'  => 'summary_text',
					'admin_label' => true,
				),
			)
		),
	)
);

add_shortcode( 'artifiche_summary_text', 'artifiche_summary_text_render' );

function artifiche_summary_text_render( $atts, $content = null ) {

	extract(
		shortcode_atts(
			array(
				'summary_text' => '',
			),
			$atts
		)
	);
	$summary = '';
	if ( ! empty( $summary_text ) ) {
		$summary = '<div class="artifiche-summary-text"><h1>' . $summary_text . '</h1></div>';
	}
	$html = $summary;
	return $html;
}
