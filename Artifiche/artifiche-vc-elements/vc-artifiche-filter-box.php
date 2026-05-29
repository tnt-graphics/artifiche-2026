<?php

vc_map(
	array(
		'name'                    => __( 'Artifiche Filter', 'artifiche' ),
		'base'                    => 'artifiche_filterbox',
		'icon'                    => get_template_directory_uri() . '/img/logo2.svg',
		'category'                => __( 'Artifiche Elements', 'artifiche' ),
		'description'             => __( 'Zeigt den Filter entweder für Home oder für die normalen Seiten an.', 'artifiche' ),
		'content_element'         => true,
		'show_settings_on_create' => true,
		'params'                  => array_merge(
			array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Titel', 'artifiche' ),
					'param_name'  => 'filter_box_title',
					'admin_label' => true,
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Such-Button Text', 'artifiche' ),
					'param_name'  => 'search_btn_txt',
					'admin_label' => true,
				),
					array(
					'type'        => 'checkbox',
					'heading'     => esc_html__( 'Wird dieser Filter auf der Homeseite angezeigt?', 'artifiche' ),
					'param_name'  => 'ishomefilter',
					'value'       => array( esc_html__( 'Ja', 'artifiche' ) => '1' ),
				),
			)
		),
	)
);

add_shortcode( 'artifiche_filterbox', 'artifiche_filterbox_render' );

function artifiche_filterbox_render( $atts, $content = null ) {

	extract(
		shortcode_atts(
			array(
				'filter_box_title' => '',
				'search_btn_txt'   => '',
				'ishomefilter'     => '',
			),
			$atts
		)
	);
	$searchbtn = __( 'Suchen / Anzeigen', 'artifiche' );
	if ( ! empty( $search_btn_txt ) ) {
		$searchbtn = $search_btn_txt;
	}
	$headtext        = __( 'Plakatsuche', 'artifiche' );
	if ( ! empty( $filter_box_title ) ) {
		$headtext = $filter_box_title;
	}

	if( ! empty( $ishomefilter ) ){
		$btn_class = 'btn-light';
		$filter_fieldsextra = '';
		$titletext = '<h1>' . $headtext . '</h1>';
		$outer_class = "";
		$light = 'light';
		$select_class = "js_select";
		$container_class = "container";
	}else{

		$btn_class = '';
		$filter_fieldsextra = 'filter-fields-wht';
		$titletext = '';
		$outer_class = 'filter-light';
		$light = '';
		$select_class = "js_select";
		$container_class = '';
	}

		$category_option = get_kategorie_options();
		$künstler_options = get_künstler_options();
		$land_options = get_land_options();
		$stilrichtung_options = get_stilrichtung_options();
		$jahr_options = get_jahr_option();
	//global $product;
//echo wc_display_product_attributes( $product );
		
$sel_0 = '';
$sel_250 = '';
$sel_500 = '';
$sel_1000 = '';
$sel_2000 = '';
$sel_3000 = '';
$sel_4000 = '';
$sel_5000 = '';
$sel_6000 = '';
$sel_7000 = '';
$sel_8000 = '';
$sel_9000 = '';
$sel_10000 = '';

if( isset( $_GET['preisklasse'] ) ){

	$selected_price = $_GET['preisklasse'];
switch ( $selected_price ) {
	case '0-250':
		$sel_0 = "selected='selected'";
		break;
	case '250-500':
		$sel_250 = "selected='selected'";
		break;
	case '500-1000':
		$sel_500 = "selected='selected'";
		break;
	case '1000-2000':
		$sel_1000 = "selected='selected'";
		break;
	case '2000-3000':
		$sel_2000 = "selected='selected'";
		break;
	case '3000-4000':
		$sel_3000 = "selected='selected'";
		break;
	case '4000-5000':
		$sel_4000 = "selected='selected'";
		break;
	case '5000-6000':
		$sel_5000 = "selected='selected'";
		break;
	case '6000-7000':
		$sel_6000 = "selected='selected'";
		break;
	case '7000-8000':
		$sel_7000 = "selected='selected'";
		break;
	case '8000-9000':
		$sel_8000 = "selected='selected'";
		break;
	case '9000-10000':
		$sel_9000 = "selected='selected'";
		break;
	case '999999':
		$sel_10000 = "selected='selected'";
		break;
	default:
		# code...
		break;
	}
}
	$filter_contents = '';

	/*if( ! empty( $ishomefilter ) ){
		$content = 
		'<label class="custom-checkbox">
		<span class="check-label">'. esc_html__( 'Verkaufte Plakate auch anzelgen', 'artifiche').'</span>
		<input name="sold_posters" class="sold_posters" type="checkbox" value="1"> <span class="checkmark"></span>
		</label>';
	}else{
		$sold_sel = '';
		$all_sel = '';
		if( isset($_GET['show_posters'] ) ){

			if( $_GET['show_posters'] == 'sold' )
				$sold_sel = 'checked="checked"';
			else
				$all_sel = 'checked="checked"';
		}
		
		$content = '<label class="custom-radio">
		<span class="radio-label">'. esc_html__( 'Alle Plakate anzeigen', 'artifiche').'</span>
		<input name="show_posters" class="all_posters" '. $all_sel.' type="radio" value="all"><span class="radmark"></span>
		</label>
		<label class="custom-radio">
		<span class="radio-label">'. esc_html__( 'Verkaufte Plakate nicht anezgien', 'artifiche').'</span>
		<input name="show_posters" class="sold_posters" '. $sold_sel .' type="radio" value="sold"><span class="radmark"></span>
		</label>';
	}*/
	$search = '';
	
		// if( isset( $_GET['search'] ) ) $search = $_GET['search'];
		// if( isset( $_GET['sold_posters'] ) ){
		// 	 $sold_posters = ( $_GET['sold_posters'] == 1 ) ? 'checked="checked"' : '';
		// 	 $sold_poster_val = ( $_GET['sold_posters'] == 1 ) ? 1 : 0;
		// }else{
		// 	$sold_posters = '';
		// 	$sold_poster_val = 0;
		// }
		if ( isset( $_COOKIE['sold_posters'] )  && $_COOKIE['sold_posters'] == true ) {
			$sold_posters    = ( $_COOKIE['sold_posters'] == true ) ? 'checked="checked"' : '';
			$sold_poster_val = ( $_COOKIE['sold_posters'] == true ) ? 1 : 0;
		} else {
			$sold_posters    = '';
			$sold_poster_val = 0;
		}
	//	wp_nonce_field( "artf_filter_nonce_action", "artf_filter" );

	$filter_contents .= '<div class="filter-contents">
	<form accept-charset="UTF-8" action="'.get_permalink( wc_get_page_id( 'shop' ) ).'" autocomplete="off" name="posterFilter" method="GET">

	<div class="'. $container_class .'">
		'. $titletext .'
		<div class="searchbox">
			<input name="search" class="filter_text" value="'.$search.'" autocomplete="off" type="text" placeholder="'.esc_html__("Suche (Titel, Künstler ...)", "artifiche") .'" value=""/>
			<input type="hidden" name="tax" class="tax" value="">
			<input type="hidden" name="slug" class="slug" value="">
			<select class="filter_select" name="filter_select" style="display:none;">
			</select>
			<button class="outline-btn '. $btn_class .'" id="artifiche-filter" type="button" >'. esc_html__('Erweiterte Suche', 'artifiche') .'<i class="icon-dropdown"></i></button>
		</div>
	</div>
<div class="filter-fields '. $filter_fieldsextra .'">
	<div class="container">
		<div class="filter-row">
			<div>
				<label for="name">'. esc_html__('Kategorie', 'artifiche').'</label>
				<select class="'.$select_class.'"  lang="de" name="kategorie">
				'. $category_option .'
				</select>
			</div>
			<div>
				<label for="name">'. esc_html__('Künstler', 'artifiche').'</label>
				<select class="'.$select_class.'"  lang="de" name="kuenstler">
				'. $künstler_options .'
				</select>
			</div>
			<div>
				<label for="name">'. esc_html__('Land', 'artifiche').'</label>
				<select class="'.$select_class.'"  name="land">
				'. $land_options .'
				</select>
			</div>
			</div>
				<div class="filter-row">
				<div>
				<label for="name">'. esc_html__('Jahr', 'artifiche').'</label>
				<select class="'.$select_class.'" name="jahr">
				'. $jahr_options .'
				</select>
			</div>
			<div>
				<label for="name">'. esc_html__('Stilrichtung', 'artifiche').'</label>
				<select class="'.$select_class.'" name="stilrichtung">
				'. $stilrichtung_options .'
				</select>
			</div>
			<div>
				<label for="name">'. esc_html__('Preisklasse', 'artifiche').'</label>
				<select class="'.$select_class.'" name="preisklasse">
				<option  value="1" >'. esc_html__('Alle', 'artifiche').'</option>
				<option value="0-250" '.$sel_0.'>'. esc_html__('bis CHF 250', 'artifiche').'</option>
				<option value="250-500" '.$sel_250.'> '. esc_html__(' bis ', 'artifiche').'CHF 500</option>
				<option value="500-1000" '.$sel_500.'> '. esc_html__(' bis ', 'artifiche').'CHF 1000</option>
				<option value="1000-2000" '.$sel_1000.'> '. esc_html__(' bis ', 'artifiche').'CHF 2000</option>
				<option value="2000-3000" '.$sel_2000.'> '. esc_html__(' bis ', 'artifiche').'CHF 3000</option>
				<option value="3000-4000" '.$sel_3000.'> '. esc_html__(' bis ', 'artifiche').'CHF 4000</option>
				<option value="4000-5000" '.$sel_4000.'> '. esc_html__(' bis ', 'artifiche').'CHF 5000</option>
				<option value="5000-6000" '.$sel_5000.'> '. esc_html__(' bis ', 'artifiche').'CHF 6000</option>
				<option value="6000-7000" '.$sel_6000.'> '. esc_html__(' bis ', 'artifiche').'CHF 7000</option>
				<option value="7000-8000" '.$sel_7000.'> '. esc_html__(' bis ', 'artifiche').'CHF 8000</option>
				<option value="8000-9000" '.$sel_8000.'> '. esc_html__(' bis ', 'artifiche').'CHF 9000</option>
				<option value="9000-10000" '.$sel_9000.'> '. esc_html__(' bis ', 'artifiche').'CHF 10000</option>
				<option value="999999" '.$sel_10000.'> '. esc_html__('Auf Anfrage', 'artifiche').' </option>
				</select>
			</div>
		</div>';
		$filter_contents .= '<div class="filter-row">

		<label class="custom-checkbox">
		<span class="check-label">'. esc_html__( 'Verkaufte Plakate ausblenden', 'artifiche').'</span>
		
		<input name="csold_posters"  class="csold_posters" '.$sold_posters.' type="checkbox" value="'. $sold_poster_val .'"> <span class="checkmark"></span>
		</label>
		
			</div>
	
	<div class="filter-button">
		<button class="outline-btn '. $btn_class .'" type="submit" value="Submit"><i class="icon-arrow_big"></i>' . $searchbtn . '</button>
		
		<a class="common-link '.$light.' filter_back">'. esc_html__('Filter zurücksetzen', 'artifiche') .'</a>
	</div>
	</div>
	

</div>

</form>
<input type="hidden" name="shop_url" class="shop_url" value="'. get_permalink( wc_get_page_id( 'shop' ) ) .'">
		<input type="hidden" name="site_url" class="site_url" value="'.site_url() .'">
	</div>';
	
	$html = '<div class="artifiche-filterbox '.$outer_class.'">' . $filter_contents . '</div>';
	return $html;
}
