<?php

/*
Element Description: Artifiche Display 3 Posters
*/


// Map the block with vc_map()
vc_map(
	array(
		'name'        => __( 'Artifiche 3 bis 4 Poster', 'artifiche' ),
		'base'        => 'artifiche_display3posters',
		'icon'        => get_template_directory_uri() . '/img/logo2.svg',
		'category'    => __( 'Artifiche Elements', 'artifiche' ),
		'description' => __( 'Es werden 3 oder 4 Poster ausgewählt und nebeneinander angezeigt.', 'artifiche' ),
		'params'      => array_merge(
			array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Section Title', 'artifiche' ),
					'param_name'  => 'poster_section_title',
					'admin_label' => true,
				),
				array(
					'type'        => 'autocomplete',
					'heading'     => esc_html__( 'Poster auswählen', 'artifiche' ),
					'param_name'  => 'post1',
					'description' => esc_html__( 'Choose a single product. Wählen Sie das gewünschte Poster aus.', 'artifiche' ),
					'settings'    => array(
						'multiple'      => true,
						'sortable'      => true,
						'unique_values' => true,
						'min_length'    => 1,
					),
				),
			)
		),
	)
);


add_shortcode( 'artifiche_display3posters', 'artifiche_display3posters_fun' );


// Element HTML
function artifiche_display3posters_fun( $atts, $content = null ) {
	global $post;

	// Params extraction
	$atts = extract(
		shortcode_atts(
			array(
				'post1'                => '',
				'poster_section_title' => '',
			),
			$atts
		)
	);

	$html         = '';
	$recent_posts = '';

	if ( empty( $post1 ) ) {
		echo '<div>' . __( 'Please select the posts first', 'artifiche' ) . '</div>';
		return;
	}
		$args = array(
			'post_type'      => 'product',
			'posts_per_page' => 4,
			'post__in'       => explode( ',', $post1 ),
			'orderby'        => 'post__in',
		);

		$myposts            = get_posts( $args );
		$poster_enter_count = count( $myposts );
		$dispposter_class   = 'display-3-posters';
		$gen_poster_class   = 'img-block';
		$headtext           = '';
		if ( $poster_enter_count >= 4 ) {
			$dispposter_class = 'display-4-posters';
			$gen_poster_class = 'general-poster';
		} elseif ( $poster_enter_count <= 3 ) {
			$dispposter_class = 'display-3-posters';
			$gen_poster_class = 'img-block';
		}

		if ( ! empty( $poster_section_title ) ) {
			$headtext = $poster_section_title;
		}
		foreach ( $myposts as $post ) :
			setup_postdata( $post );
			$poster_id = get_post_meta( $post->ID, 'plakatnummer', true );
			$jahr        = get_post_meta( $post->ID, 'jahr', true );
			$alt_text = artf_get_alt_text( $post->ID );
			$recent_posts   .=
			'<div class="item">
	<a class="' . $gen_poster_class . '" href="' . get_permalink( $post->ID ) . '"><img  src="' . site_url() . '/artifiche-images/posters_extralarge/' . $poster_id . '.jpg" alt="'. $alt_text .'" /></a>
	<div>
	<a href="' . get_permalink( $post->ID ) . '"><h6>' . $post->post_title . '</h6>';
			$category_detail = get_the_terms( $post->ID, 'kunstler' );
			if ( ! empty( $category_detail ) ) {

				$i     = 0;
				$count = count( $category_detail );
				foreach ( $category_detail as $cd ) {
					$i++;
					$coma = ', ';

					$recent_posts .= '<span class="kunstler_name">' . $cd->name . '' . $coma . $jahr.'</span>';

				}
			}
			$recent_posts .= '</a></div>
	</div>';
endforeach;
		wp_reset_postdata();
		if ( ! empty( $recent_posts ) ) {

			$html .= '<div class="' . $dispposter_class . '"><h2>' . $headtext . '</h2><div class="item-wrapper">'
			. $recent_posts .
			'</div></div>';
		}

		return $html;
}


add_filter( 'vc_autocomplete_artifiche_display3posters_post1_callback', 'artifiche_display3posters_search', 10, 1 );
add_filter( 'vc_autocomplete_artifiche_display3posters_post1_render', 'vc_include_field_render', 10, 1 );

function artifiche_display3posters_search( $search_string ) {
	$query = $search_string;
	$data  = array();

	$args       = array(
		'post_type'        => 'product',
		'post_status'      => 'publish',
		'orderby'          => 'date',
		'posts_per_page'   => -1,
		'order'            => 'DESC',
		's'                => $query,
		'suppress_filters' => false,
	);
	$page_names = array();
	// $args['vc_search_by_title_only'] = true;
	// $args['posts_per_page '] = -1;
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
			'numberposts' => -1,
			'post_type'   => 'product',
			'suppress_filters' => false,
			'meta_query'  => array(

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
