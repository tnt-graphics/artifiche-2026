<?php

/*
Element Description: Artifiche Home Collection List
*/


// Map the block with vc_map()
vc_map(
	array(
		'name'        => __( 'Artifiche Home Kollektionen-Liste', 'artifiche' ),
		'base'        => 'artifiche_home_collection_list',
		'icon'        => get_template_directory_uri() . '/img/logo2.svg',
		'category'    => __( 'Artifiche Elements', 'artifiche' ),
		'description' => __( 'Zeigt die ausgewählten Kollektionen in einer Listenansicht an.', 'artifiche' ),
		'params'      => array_merge(
			array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Überschrift', 'artifiche' ),
					'param_name'  => 'sec_title',
					'admin_label' => true,
				),
				array(
					'type'        => 'autocomplete',
					'heading'     => esc_html__( 'Kollektionen auswählen', 'artifiche' ),
					'param_name'  => 'post1',
					'description' => esc_html__( 'Choose a single product. Image will be automatically fetched.', 'artifiche' ),
					'settings'    => array(
						'multiple'      => true,
						'sortable'      => true,
						'unique_values' => true,
						'min_length'    => 1,
					),
				),
				array(
					'type'        => 'vc_link',
					'heading'     => esc_html__( 'Button Link', 'artifiche' ),
					'param_name'  => 'button_link',
					'admin_label' => true,
				),
			)
		),
	)
);


add_shortcode( 'artifiche_home_collection_list', 'artifiche_home_collection_list_fun' );


// Element HTML
function artifiche_home_collection_list_fun( $atts, $content = null ) {
	global $post;

	// Params extraction
	$atts          = extract(
		shortcode_atts(
			array(
				'post1'       => '',
				'button_link' => '',
				'sec_title'   => '',
			),
			$atts
		)
	);
	$html          = '';
	$recent_posts  = '';
	$button1       = '';
	$section_title = __( 'KOLLEKTIONEN', 'artifiche' );
	if ( ! empty( $sec_title ) ) {
		$section_title = $sec_title;
	}
	if ( $button_link ) {
		$btn_url1  = vc_build_link( $button_link );
		$a_href1   = $btn_url1['url'];
		$a_title1  = $btn_url1['title'];
		$a_target1 = $btn_url1['target'];
		$button1   = '<a class="outline-btn mb-5 collection-btn" href="' . esc_attr( $a_href1 ) . '" target="' . esc_attr( $a_target1 ) . '">
		<i class=icon-arrow_big></i>' . esc_attr( $a_title1 ) . '</a>';
	}
	if ( empty( $post1 ) ) {
		echo '<div>' . __( 'Please select the posts first', 'artifiche' ) . '</div>';
		return;
	}

		$termargs = array(
			'taxonomy' => array( 'kollektionen' ), // taxonomy name
			'field'    => 'term_id',
			'include'  => explode( ',', $post1 ),
		);

		$terms = get_terms( $termargs );// print_r($terms);
		$i     = 1;
		foreach ( $terms as $term ) :
			// setup_postdata( $post );

			// $banner_image     = get_field( 'banner_image', $post->ID );
			// $banner_image_url = $banner_image['url'];
			// $banner_image_alt = $banner_image['alt'];
			// $link             = get_field( 'banner_link', $post->ID );
			// if ( $link ) :
			// $link_url    = $link['url'];
			// $link_title  = $link['title'];
			// $link_target = $link['target'] ? $link['target'] : '_self';
			// endif;

			if ( $i == 1 ) {
				$recent_posts .= '<h1>' . $section_title . '</h1>';
			}

			$recent_posts .= '			
			<div class="collection-item">
				<div class="collection-content">
					<a href="' . get_term_link( $term ) . '"><h2>' . $term->name . '</h2></a>
					<p>' . $term->description . '</p>
					<a href="' . get_term_link( $term ) . '" class="common-link">' . __( 'Zur Kollektion', 'artifiche' ) . '</a>
				</div>
				<div class="collection-img">';
			$i             = 1;
			$image         = get_field( 'plakatauswahl', $term );
			if ( $image != '' ) {
				$poster_array = explode( ';', $image );// print_r($poster_array );

				for ( $i = 0; $i < 3; $i++ ) {
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
						'posts_per_page' => -1,
						'meta_key'       => 'plakatnummer',
						'meta_value'     => $poster_array[ $i ],
					);

					$poster_id = get_posts( $poster_args );
					global $sitepress;
					$current_lang = $sitepress->get_current_language();
					$posterid     = ( isset( $poster_id[0]->ID ) ) ? $poster_id[0]->ID : '10989';
					$alt_text     = artf_get_alt_text( $posterid );
					// echo $poster_id[0]['ID'];

					$recent_posts .= '<a href="' . get_permalink( $posterid ) . '"><img  src="' . site_url() . '/artifiche-images/posters_large/' . $poster_array[ $i ] . '.jpg" alt="' . $alt_text . '" /></a>';
					// $i++;

				}
			}
			$recent_posts .= '</div><a href="' . get_term_link( $term ) . '" class="mobile-only common-link">' . __( 'Zur Kollektion', 'artifiche' ) . '</a>
			</div>';
			$i++;
endforeach;
		wp_reset_postdata();
		if ( ! empty( $recent_posts ) ) {
			$html = '<div class="home-collection-list">'
			. $recent_posts .
			'</div>
			' . $button1 . '
			';
		}

		return $html;
}


add_filter( 'vc_autocomplete_artifiche_home_collection_list_post1_callback', 'artifiche_home_collection_list_search', 10, 1 );
add_filter( 'vc_autocomplete_artifiche_home_collection_list_post1_render', 'vc_autocomplete_taxonomies_field_render', 10, 1 );

function artifiche_home_collection_list_search( $search_string ) {
	$query = $search_string;
	$data  = array();

	$args       = array(
		'taxonomy'         => array( 'kollektionen' ), // taxonomy name
		'orderby'          => 'id',
		'order'            => 'ASC',
		'hide_empty'       => false,
		'name__like'       => $query,
		'suppress_filters' => false,
	);
	$page_names = array();
	// $args['vc_search_by_title_only'] = true;
	$args['posts_per_page '] = -1;
	if ( 0 === strlen( $args['s'] ) ) {
		unset( $args['s'] );
	}
	add_filter( 'posts_search', 'vc_search_by_title_only', 500, 2 );
	$terms = get_terms( $args );
	if ( is_array( $terms ) && ! empty( $terms ) ) {
		foreach ( $terms as $term ) {
			$data[] = array(
				'value' => $term->term_id,
				'label' => $term->name,
				// 'group' => $post->post_type,
			);
		}
	} else {
		// $args = array(
		// 'numberposts' => -1,
		// 'post_type'   => 'product',
		// 'suppress_filters' => false,
		// 'meta_query'  => array(

		// array(
		// 'key'     => 'plakatnummer',
		// 'value'   => $query,
		// 'compare' => 'like',
		// ),

		// ),
		// );
		$args  = array(
			'taxonomy'         => 'kollektionen',
			'hide_empty'       => false,
			'suppress_filters' => false,
			'meta_query'       => array(
				array(
					'key'     => 'id',
					'value'   => $query,
					'compare' => 'like',
				),
			),
		);
		$terms = get_terms( $args );
		if ( is_array( $terms ) && ! empty( $terms ) ) {
			foreach ( $terms as $term ) {
				$data[] = array(
					'value' => $term->term_id,
					'label' => $term->name,
					// 'group' => $post->post_type,
				);
			}
		}
	}
	// ---------------
	// $args       = array(
	// 'taxonomy'         => array( 'Kollektionen' ), // taxonomy name
	// 'orderby'          => 'id',
	// 'order'            => 'ASC',
	// 'hide_empty'       => false,
	// 'name__like'       => $query,
	// 'suppress_filters' => false,
	// );
	// $page_names = array();
	// // $args['vc_search_by_title_only'] = true;
	// $args['posts_per_page '] = -1;
	// if ( 0 === strlen( $args['name__like'] ) ) {
	// unset( $args['name__like'] );
	// }
	// add_filter( 'posts_search', 'vc_search_by_title_only', 500, 2 );
	// $terms  = get_terms( $args );
	// $count = count( $terms );
	// if ( is_array( $terms ) && ! empty( $terms ) ) {
	// foreach ( $terms as $term ) {
	// $data[] = array(
	// 'value' => $term->term_id,
	// 'label' => $term->name,
	// 'group' => $post->post_type,
	// );
	// }
	// }
	return $data;
}
