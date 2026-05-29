<?php

vc_map(
	array(
		'name'                    => __( 'Artifiche Kollektionen Dropdown-Filter', 'artifiche' ),
		'base'                    => 'artifiche_kollektion_filter',
		'icon'                    => get_template_directory_uri() . '/img/logo2.svg',
		'category'                => __( 'Artifiche Elements', 'artifiche' ),
		'description'             => __( 'Zeigt den Dropdown-Filter mit allen Kollektionen an.', 'artifiche' ),
		'content_element'         => true,
		'show_settings_on_create' => true,
		'params'                  => array_merge(
		),
	)
);

add_shortcode( 'artifiche_kollektion_filter', 'artifiche_kollektion_filter_render' );

function artifiche_kollektion_filter_render( $atts, $content = null ) {

	extract(
		shortcode_atts(
			array(
			),
			$atts
		)
	);
	
	$html = '';
	$termargs     = array(
		'taxonomy' => array( 'Kollektionen' ), // taxonomy name
		'field'    => 'term_id',
		'orderby'  => 'include',
	);
	$recent_posts = '';
	$termslists   = get_terms( $termargs );// print_r($terms);
	$i            = 1;
	$term_options = '<option selected="selected" value="1" >' . __( 'Alle Kollektionen', 'artifiche' ) . '</option>';
	foreach ( $termslists as $termone ) :
		$term_options .= '<option value="' . get_term_link( $termone ) . '">' . $termone->name . '</option>';
	endforeach;
	wp_reset_postdata();

	$term_list = '<div class="container"><div class="cat-filter spacer-2">
		<label for="name">' . __( 'Unsere Kollektionen:', 'artifiche' ) . '</label>
		<select onchange="javascript:location.href = this.value;" class="custom-select js_select">' . $term_options . '</select>
	</div>';
	$html = $term_list;
	return $html;
}
