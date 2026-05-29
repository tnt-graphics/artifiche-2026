<?php

/*
Element Description: Artifiche Contents and Single Poster
*/


// Map the block with vc_map()
vc_map(
	array(
		'name'        => __( 'Artifiche Text und Poster', 'artifiche' ),
		'base'        => 'artifiche_display_single_poster',
		'icon'        => get_template_directory_uri() . '/img/logo2.svg',
		'category'    => __( 'Artifiche Elements', 'artifiche' ),
		'description' => __(
			'Zeigt den Titel mit Text auf der linken Seite und das Poster rechts mit umfliessenden
		Text.',
			'artifiche'
		),
		'params'      => array_merge(
			array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Überschrift', 'artifiche' ),
					'param_name'  => 'head_title',
					'admin_label' => true,
				),
				array(
					'type'        => 'textarea_html',
					'heading'     => esc_html__( 'Text', 'artifiche' ),
					'param_name'  => 'content',
					'admin_label' => true,
				),
				array(
					'type'        => 'autocomplete',
					'heading'     => esc_html__( 'Poster auswählen', 'artifiche' ),
					'param_name'  => 'post1',
					'description' => esc_html__( 'Wählen Sie das gewünschte Poster aus.', 'artifiche' ),
					'settings'    => array(
						'multiple'      => false,
						'sortable'      => true,
						'unique_values' => true,
						'min_length'    => 1,
					),
				),
			)
		),
	)
);


add_shortcode( 'artifiche_display_single_poster', 'artifiche_display_single_poster_fun' );


// Element HTML
function artifiche_display_single_poster_fun( $atts, $content = null ) {
	global $post;

	// Params extraction
	$atts         = extract(
		shortcode_atts(
			array(
				'post1'      => '',
				'head_title' => '',
			),
			$atts
		)
	);
	$html         = '';
	$recent_posts = '';

	// if ( empty( $post1 ) ) {
	// echo '<div>' . __( 'Please select the posts first', 'artifiche' ) . '</div>';
	// return;
	// }
		$args = array(
			'post_type'      => 'product',
			'posts_per_page' => 1,
			'post__in'       => explode( ',', $post1 ),
			'orderby'        => 'post__in',
		);

		$myposts = get_posts( $args );
		foreach ( $myposts as $post ) :
			setup_postdata( $post );
			$poster_id       = get_post_meta( $post->ID, 'plakatnummer', true );
			$jahr            = get_post_meta( $post->ID, 'jahr', true );
			$alt_text        = artf_get_alt_text( $post->ID );
			$recent_posts   .=
			'<h2 class="mobile-only">' . $head_title . '</h2><div class="align-right">
	<a href="' . get_permalink( $post->ID ) . '">
	<img alt="' . $alt_text . '" src="' . site_url() . '/artifiche-images/posters_large/' . $poster_id . '.jpg" alt="" /></a>
	<a href="' . get_permalink( $post->ID ) . '"><h6>' . $post->post_title . '</h6>';
			$category_detail = get_the_terms( $post->ID, 'kunstler' );
			if ( ! empty( $category_detail ) ) {

				$i     = 0;
				$count = count( $category_detail );
				foreach ( $category_detail as $cd ) {
					$coma = ', ';

					$recent_posts .= '<span class="kunstler_name">' . $cd->name . '' . $coma . $jahr . '</span>';

				}
			}
			$recent_posts .= '</a></div><h2>' . $head_title . '</h2>';
endforeach;
		wp_reset_postdata();
		$title_ = '';
		if ( empty( $recent_posts ) && ! empty( $head_title ) ) {
			$title_ = '<h2 class="mobile-only">' . $head_title . '</h2><h2>' . $head_title . '</h2>';
		}
		$html = '<div class="img-right-block"><div>'
		. $recent_posts . $title_ . wpb_js_remove_wpautop( $content ) .
		'</div></div>';

		return $html;
}


add_filter( 'vc_autocomplete_artifiche_display_single_poster_post1_callback', 'artifiche_display_single_poster_search', 10, 1 );
add_filter( 'vc_autocomplete_artifiche_display_single_poster_post1_render', 'vc_include_field_render', 10, 1 );

function artifiche_display_single_poster_search( $search_string ) {
	$query = $search_string;
	$data  = array();

		$args       = array(
			'post_type'        => 'product',
			'post_status'      => 'publish',
			'orderby'          => 'date',
			'order'            => 'DESC',
			'posts_per_page'   => -1,
			's'                => $query,
			'suppress_filters' => false,
		);
		$page_names = array();
		// $args['vc_search_by_title_only'] = true;
		$args['posts_per_page '] = -1;
		if ( 0 === strlen( $args['s'] ) ) {
			unset( $args['s'] );
		}
		add_filter( 'posts_search', 'vc_search_by_title_only', 500, 2 );
		$posts = get_posts( $args );
		if ( is_array( $posts ) && ! empty( $posts ) ) {
			foreach ( $posts as $post ) {
				$data[] = array(
					'value' => $post->ID,
					'label' => $post->post_title,
					'group' => $post->post_type,
				);
			}
		} else {
			$args = array(
				'numberposts'      => -1,
				'post_type'        => 'product',
				'suppress_filters' => false,
				'meta_query'       => array(

					array(
						'key'     => 'plakatnummer',
						'value'   => $query,
						'compare' => 'like',
					),

				),
			);
			$posts = get_posts( $args );
			if ( is_array( $posts ) && ! empty( $posts ) ) {
				foreach ( $posts as $post ) {
					$data[] = array(
						'value' => $post->ID,
						'label' => $post->post_title,
						'group' => $post->post_type,
					);
				}
			}
		}
		return $data;
}
