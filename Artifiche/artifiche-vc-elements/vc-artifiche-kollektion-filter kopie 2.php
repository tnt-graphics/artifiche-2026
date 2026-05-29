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
	$termslists   = function_exists( 'artifiche_get_kollektionen_terms' )
		? artifiche_get_kollektionen_terms()
		: get_terms(
			array(
				'taxonomy'   => array( 'kollektionen' ),
				'field'      => 'term_id',
				'orderby'    => 'include',
				'hide_empty' => false,
			)
		);
	if ( is_wp_error( $termslists ) ) {
		$termslists = array();
	}
	$i            = 1;
	$overview_link = get_permalink( get_field( 'set_plakatkollektionen_page', 'option' ) );
	$term_options = '<option selected="selected" value="' . esc_url( $overview_link ) . '">' . esc_html__( 'Alle Kollektionen', 'artifiche' ) . '</option>';
	foreach ( $termslists as $termone ) :
		$term_link = '';
		if ( function_exists( 'artifiche_build_kollektionen_term_path' ) ) {
			$term_link = artifiche_build_kollektionen_term_path( $termone );
		}
		if ( ! $term_link ) {
			$slug         = $termone->slug;
			$lang         = apply_filters( 'wpml_current_language', null );
			$default_lang = apply_filters( 'wpml_default_language', null );
			if ( $lang && $default_lang && $lang !== $default_lang ) {
				$term_link = home_url( user_trailingslashit( $lang . '/collections/' . $slug ) );
			} else {
				$term_link = home_url( user_trailingslashit( 'kollektionen/' . $slug ) );
			}
		}
		if ( ! $term_link ) {
			continue;
		}
		$term_options .= '<option value="' . esc_url( $term_link ) . '">' . esc_html( $termone->name ) . '</option>';
	endforeach;
	wp_reset_postdata();

	$term_list = '<div class="container"><div class="cat-filter spacer-2">
		<label for="name">' . __( 'Unsere Kollektionen:', 'artifiche' ) . '</label>
		<select onchange="javascript:location.href = this.value;" class="custom-select js_select">' . $term_options . '</select>
	</div>';
	$html = $term_list;
	return $html;
}
