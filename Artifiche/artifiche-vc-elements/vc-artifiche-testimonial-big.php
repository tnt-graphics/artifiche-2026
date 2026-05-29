<?php

/*
Element Description: Artifiche Testimonial Big
*/


// Map the block with vc_map()
vc_map(
	array(
		'name'        => __( 'Artifiche', 'artifiche' ),
		'base'        => 'artifiche_testimonial_big',
		'icon'        => get_template_directory_uri() . '/img/logo2.svg',
		'category'    => __( 'Artifiche Elements', 'artifiche' ),
		'description' => __( 'Artifiche Home-Poster (links gross)', 'artifiche' ),
		'params'      => array_merge(
			array(
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


add_shortcode( 'artifiche_testimonial_big', 'artifiche_testimonial_big_fun' );


// Element HTML
function artifiche_testimonial_big_fun( $atts, $content = null ) {
	global $post;

	// Params extraction
	$atts         = extract(
		shortcode_atts(
			array(
				'post1' => '',
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
			'posts_per_page' => 1,
			'post__in'       => explode( ',', $post1 ),
			'orderby'        => 'post__in',
		);

		$myposts = get_posts( $args );
		foreach ( $myposts as $post ) :
			setup_postdata( $post );
			// $post->ID;
			$poster_id              = get_post_meta( $post->ID, 'plakatnummer', true );
			$new_flag               = get_post_meta( $post->ID, 'neu_flag', true );
			$collectors_choice_flag = get_post_meta( $post->ID, 'collectors_choice_flag', true );
			$class                  = 'col-item-one';
			$alt_text               = artf_get_alt_text( $post->ID );
			// $poster_id = 1;

			$product            = wc_get_product( $post->ID );
			$stock_status       = $product->get_stock_status();
			// $banner_image     = get_field( 'banner_image', $post->ID );
			// $banner_image_url = $banner_image['url'];
			// $banner_image_alt = $banner_image['alt'];
			// $link             = get_field( 'banner_link', $post->ID );
			// if ( $link ) :
			// $link_url    = $link['url'];
			// $link_title  = $link['title'];
			// $link_target = $link['target'] ? $link['target'] : '_self';
			// endif;
			$recent_posts .= '<div class="item ' . $class . '">
	<a href="' . get_permalink( $post->ID ) . '">
	<img  src="' . site_url() . '/artifiche-images/posters_extralarge/' . $poster_id . '.jpg" alt="' . $alt_text . '" />
	</a>
	<div class="poster-outer">
	<div class="poster-outer">';
			if ( $new_flag != 0 || $collectors_choice_flag != 0 || $stock_status == 'outofstock' ) {
				$recent_posts .= '<div class="poster-label">';
				if ( $new_flag != '' && $new_flag == 1 ) {
					$recent_posts .= '<span class="poster-l-yellow">' . __( 'NEU', 'artifiche' ) . '</span>';
				}
				if ( $collectors_choice_flag != '' && $collectors_choice_flag == 1 ) {
					$recent_posts .= '<span class="poster-l-red">' . __( 'Collector’s Choice', 'artifiche' ) . '</span>';
				}
				if ( $stock_status == 'outofstock' ) {
					$recent_posts .= '<span class="poster-l-grey">' . __( 'SOLD', 'artifiche' ) . '</span>';
				}
				$recent_posts .= '</div>';
			}
			$recent_posts   .= '<h6><a href="' . get_permalink( $post->ID ) . '">' . $post->post_title . '</a></h6>';
			$category_detail = get_the_terms( $post->ID, 'kunstler' );
			$jahr            = get_post_meta( $post->ID, 'jahr', true );

			if ( ! empty( $category_detail ) ) {

					$i     = 0;
					$count = count( $category_detail );
				foreach ( $category_detail as $cd ) {
					 $künstler_vorname = get_field( 'gestalter_vorname', $cd );
					 $künstle_name     = get_field( 'gestalter_name', $cd );
					$coma              = '';
					if ( $künstler_vorname != '' || $künstle_name != '' ) {

						$coma = ',';
					}

					$recent_posts .= '<span class="kunstler_name">' . $künstler_vorname . ' ' . $künstle_name . $coma . ' ' . $jahr . '</span>';

				}
			}

			$recent_posts .= '</div></div></div>';// echo $j;

endforeach;
		wp_reset_postdata();
		if ( ! empty( $recent_posts ) ) {
			$html = '<div class="testimonial-small">'
			. $recent_posts .
			'</div>';
		}

		return $html;
}


add_filter( 'vc_autocomplete_artifiche_testimonial_big_post1_callback', 'artifiche_testimonial_big_search', 10, 1 );
add_filter( 'vc_autocomplete_artifiche_testimonial_big_post1_render', 'vc_include_field_render', 10, 1 );

function artifiche_testimonial_big_search( $search_string ) {
	$query = $search_string;
	$data  = array();

	$args       = array(
		'post_type'        => 'product',
		'post_status'      => 'publish',
		'orderby'          => 'date',
		'order'            => 'DESC',
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
