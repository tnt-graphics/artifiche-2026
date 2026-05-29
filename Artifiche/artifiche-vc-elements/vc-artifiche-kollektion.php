<?php

vc_map(
	array(
		'name'                    => __( 'Artifiche Kollektionen Liste', 'artifiche' ),
		'base'                    => 'artifiche_kollektion_list',
		'icon'                    => get_template_directory_uri() . '/img/logo2.svg',
		'category'                => __( 'Artifiche Elements', 'artifiche' ),
		'description'             => __( 'Zeigt alle Kollektionen in einer Listenansicht an. Das Template Artifiche Kollektion
		Page muss ausgewählt sein.', 'artifiche' ),
		'content_element'         => true,
		'show_settings_on_create' => true,
		'params'                  => array_merge(
		),
	)
);

add_shortcode( 'artifiche_kollektion_list', 'artifiche_kollektion_list_render' );

function artifiche_kollektion_list_render( $atts, $content = null ) {

	extract(
		shortcode_atts(
			array(),
			$atts
		)
	);

	$html = '';
	// Display all categories
	$termargs = array(
		'taxonomy'         => array( 'kollektionen' ), // taxonomy name
		'field'            => 'term_id',
		// 'offset'           => 1,
		'number'           => 5,
		'suppress_filters' => false,
		'orderby'          => 'date',
		'order'            => 'ASC',
	);
	$recent_posts = '';
	$termslists   = get_terms( $termargs );

	foreach ( $termslists as $term ) :

		$content = wp_trim_words( $term->description, 15 );			
		$recent_posts .= '			
		<div class="collection-item">
			<div class="collection-content">
				<h2><a href="' . get_term_link( $term ) . '">' . $term->name . '</a></h2>
				<p>' . $content . '</p>
				<a href="' . get_term_link( $term ) . '" class="common-link">' . __( 'Zur Kollektion', 'artifiche' ) . '</a>
			</div>
			<div class="collection-img">';
			$i         = 0;
			$image     = get_field( 'plakatauswahl', $term );
		if ( $image != '' ) {
			$poster_array = explode( ';', $image );
			// print_r($poster_array );
			$pacount = count($poster_array)-1;
			// var_dump($pacount);
			for ( $i = 0; $i < $pacount; $i++ ) {
				// if( $poster == '' ) return;
				if ( $i == 0 ) {

					$w = '210px';
					$h = '336px';
				} elseif ( $i == 1 ) {
					$w = '260px';
					$h = '376px';
				} else {
					$w = '210px';
					$h = '298px';
				}
				$poster_args = array(
					'post_type'      => 'product',
					// 'posts_per_page' => -1,
					'meta_key'       => 'plakatnummer',
					'meta_value'     => $poster_array[ $i ],
				);

				$poster_id = get_posts( $poster_args );
				if(isset($poster_id[0])) {
					$posterid     = $poster_id[0]->ID;
				} else {
					$posterid = 0;
				}
				
				// echo $poster_id[0]['ID'];
				$alt_text = artf_get_alt_text( $posterid );
				$recent_posts .= '<a href="' . get_permalink( $posterid ) . '"><img alt="'. $alt_text .'" src="' . site_url() . '/artifiche-images/posters_large/' . $poster_array[ $i ] . '.jpg" alt="" width="' . $w . '" height="' . $h . '" /></a>';
				// $i++;

			}
		}
			$recent_posts .= '</div><a href="' . get_term_link( $term ) . '" class="mobile-only common-link">' . __( 'Zur Kollektion', 'artifiche' ) . '</a>
		</div>';
		$i++;
endforeach;
	wp_reset_postdata();
	if ( ! empty( $recent_posts ) ) {
		$html = '<div class="home-collection-list col-list">'
		. $recent_posts .
		'
	</div>';
	}
	return $html;
}
