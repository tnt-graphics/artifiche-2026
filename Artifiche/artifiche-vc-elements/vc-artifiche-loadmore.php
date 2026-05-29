<?php

vc_map(
	array(
		'name'                    => __( 'Artifiche Weitere laden Button', 'artifiche' ),
		'base'                    => 'artifiche_loadmore_button',
		'icon'                    => get_template_directory_uri() . '/img/logo2.svg',
		'category'                => __( 'Artifiche Elements', 'artifiche' ),
		'description'             => __( 'Zeigt den Button um weitere Elemente zu laden an und rechts davon, den Pfeil und
		Text mit Kontakt-Link.', 'artifiche' ),
		'content_element'         => true,
		'show_settings_on_create' => true,
		'params'                  => array_merge(
			array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Weitere laden Button Text', 'artifiche' ),
					'param_name'  => 'loadmore_btn_txt',
					'admin_label' => true,
				),
				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__( 'Seitentyp', 'artifiche' ),
					'param_name' => 'loadmore_page_type',
					'value'      => array(
						esc_html__( 'Kollektion List Page', 'artifiche' )  => '1',
						esc_html__( 'Shop Page', 'artifiche' )  => '2',

					),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Kontakt Text', 'artifiche' ),
					'param_name'  => 'right_contents',
					'admin_label' => true,
				),
				array(
					'type'        => 'vc_link',
					'heading'     => esc_html__( 'Kontakt Button Text und Link', 'artifiche' ),
					'param_name'  => 'right_btn',
					'admin_label' => true,
				),
			)
		),
	)
);

add_shortcode( 'artifiche_loadmore_button', 'artifiche_loadmore_button_render' );

function artifiche_loadmore_button_render( $atts, $content = null ) {

	extract(
		shortcode_atts(
			array(
				'loadmore_btn_txt'   => '',
				'loadmore_page_type' => '',
				'right_contents'     => '',
				'right_btn'          => '',
			),
			$atts
		)
	);
	$shop_filter      = '';
	$loadmore_type_id = 'collection-loadmore';
	$loadmoretxt      = __( 'Weitere Kollektionen', 'artifiche' );
	if ( $loadmore_page_type == '2' ) {
		$loadmore_type_id = 'shop-loadmore';
		$loadmoretxt      = __( 'Weitere Plakate', 'artifiche' );
		if ( isset( $_GET['name'] ) || isset( $_GET['kategorie'] ) ||
		isset( $_GET['künstler'] ) || isset( $_GET['land'] ) ||
		isset( $_GET['stilrichtung'] ) || isset( $_GET['search'] ) ||
		isset( $_GET['sold_posters'] ) || isset( $_GET['sortby'] ) ) {
			$shop_filter_query = get_shop_filter_query();
			$serialized_args   = base64_encode( serialize( $shop_filter_query ) );
			//  print_r( $shop_filter_query );
			$shop_filter = '<input type="hidden" id="shop_filter_query" value="' . $serialized_args . '">';
		}else{
			$shop_filter_query = get_shop_filter_query();
			$serialized_args   = base64_encode( serialize( $shop_filter_query ) );
			$shop_filter = '<input type="hidden" id="shop_filter_query" value="' . $serialized_args . '">';
		}
	}
	if ( ! empty( $loadmore_btn_txt ) ) {
		$loadmoretxt = $loadmore_btn_txt;
	}
		$button1 = '';
	if ( $right_btn ) {
		$right_btn1 = vc_build_link( $right_btn );
		$a_href1    = $right_btn1['url'];
		$a_title1   = $right_btn1['title'];
		$a_target1  = $right_btn1['target'];
		$button1    = '<a class="common-link " href="' . esc_attr( $a_href1 ) . '" target="' . esc_attr( $a_target1 ) . '" style="
		display: inline-block;">' . esc_attr( $a_title1 ) . '</a>';
	}
		$allcontents = '<div id="loader-icon"></div>
	<div class="artifiche-readmore">
	' . $shop_filter . '
			<a href="javascript:void(0);" id="' . $loadmore_type_id . '" class="outline-btn loadmore"><i class="icon-plus"></i><span>
			' . $loadmoretxt . '</span></a><i class="icon-arrow_big"></i>
			<div class="rm-rt-contents"><p>' . $right_contents .' '. $button1 . '</p>
		</div></div></div>';
		$html        = $allcontents;
		return $html;
}
