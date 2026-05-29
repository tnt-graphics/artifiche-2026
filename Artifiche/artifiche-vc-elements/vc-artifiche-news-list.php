<?php

vc_map(
	array(
		'name'                    => __( 'Artifiche News Liste', 'artifiche' ),
		'base'                    => 'artifiche_newslist',
		'icon'                    => get_template_directory_uri() . '/img/logo2.svg',
		'category'                => __( 'Artifiche Elements', 'artifiche' ),
		'content_element'         => true,
		'show_settings_on_create' => true,
		'description'             => __(
			'Es werden alle News automatisch oder nur die ausgewählten in einer Listenansicht
		angezeigt.',
			'artifiche'
		),
		'params'                  => array_merge(
			array(
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Select Manually?', 'artifiche' ),
					'param_name'  => 'ismanual',
					'value'       => array(
						esc_html__( 'No', 'artifiche' )  => '0',
						esc_html__( 'Yes', 'artifiche' ) => '1',
					),
					'std'         => '0',
					'description' => __( 'Wenn manuell nicht ausgewählt ist, werden alle News angezeigt.', 'artifiche' ),
				),
				array(
					'type'       => 'autocomplete',
					'heading'    => esc_html__( 'Select News', 'artifiche' ),
					'param_name' => 'news_list_auto',
					'settings'   => array(
						'multiple'      => true,
						'sortable'      => true,
						'unique_values' => true,
						'min_length'    => 1,
					),
					'dependency' => array(
						'element' => 'ismanual',
						'value'   => '1',
					),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Mehr laden Button-Text', 'artifiche' ),
					'param_name'  => 'loadmore_btn_txt',
					'admin_label' => true,
				),
				array(
					'type'       => 'autocomplete',
					'heading'    => esc_html__( 'Select News Category', 'artifiche' ),
					'param_name' => 'news_cat_auto',
					'settings'   => array(
						'multiple'      => false,
						'sortable'      => true,
						'unique_values' => true,
						'min_length'    => 1,
					),
					'dependency' => array(
						'element' => 'ismanual',
						'value'   => '0',
					),
				),
			)
		),
	)
);

add_shortcode( 'artifiche_newslist', 'artifiche_newslist_render' );

function artifiche_newslist_render( $atts, $content = null ) {

	extract(
		shortcode_atts(
			array(
				'ismanual'         => '',
				'news_list_auto'   => '',
				'loadmore_btn_txt' => '',
				'news_cat_auto'    => '',
			),
			$atts
		)
	);
	$html     = '';
	$newslist = '';
	// print_r($news_cat_auto);
	$single_news = '';

	if ( $ismanual == 1 || ! empty( $ismanual ) ) {
		if ( ! empty( $news_list_auto ) ) {
			$newslist        = $news_list_auto;
			$args            = array(
				'post_type'        => 'post',
				'post__in'         => explode( ',', $newslist ),
				'orderby'          => 'post__in',
				'posts_per_page'   => 5,
				'suppress_filters' => false,
			);
			$serialized_args = base64_encode( serialize( $args ) );
			$single_news    .= '<input type="hidden" id="news_view_type" name="news_view_type" value="' . $serialized_args . '">
			<input type="hidden" id="news_cat_val" name="news_cat_val" value="">';
		} else {
			$args = array(
				'post_type'        => 'post',
				'posts_per_page'   => 5,
				'orderby'          => 'date',
				'order'            => 'DESC',
				'suppress_filters' => false,

			);
			$single_news .= '<input type="hidden" name="news_view_type" id="news_view_type" value="normal">
			<input type="hidden" id="news_cat_val" name="news_cat_val" value="">';
			if ( ! empty( $news_cat_auto ) ) {
				$args['category'] = explode( ',', $news_cat_auto );
			}
		}
	} else {
		$args = array(
			'post_type'        => 'post',
			'posts_per_page'   => 5,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'suppress_filters' => false,

		);
		if ( ! empty( $news_cat_auto ) ) {
			$args['category'] = explode( ',', $news_cat_auto );
		}
		$single_news .= '<input type="hidden" name="news_view_type" id="news_view_type" value="normal">
		<input type="hidden" id="news_cat_val" name="news_cat_val" value="' . $news_cat_auto . '">';
	}

	// print_r($args);
	$myposts = get_posts( $args );
	foreach ( $myposts as $spost ) {
		setup_postdata( $spost );
		$recent_news = '';
		$news_option = get_field( 'news_list_options', $spost->ID );
		if ( ! empty( $news_option ) && ! empty( $news_option['news_option'] )
		&& $news_option['news_option'] == 'dni' && ! empty( $news_option['news_image'] ) ) {
			$news_image     = $news_option['news_image'];
			$size           = 'thumbnail';
			$news_image_url = $news_image['sizes'][ $size ];
			$news_image_alt = artf_get_alt_text( $spost->ID );

			$recent_news .= '<div class="news-list-posters"><img src="' . esc_url( $news_image_url ) . '" alt="' . $news_image_alt . '"></div>';
		} elseif ( ! empty( $news_option ) && ! empty( $news_option['news_option'] )
		&& $news_option['news_option'] == 'dp' && ! empty( $news_option['select_posters'] ) ) {
			$select_posters = $news_option['select_posters'];
			$recent_news   .= '<div class="news-list-posters">';
			foreach ( $select_posters as $posterkey => $poster_value ) {
				$poster_id      = get_post_meta( $poster_value, 'plakatnummer', true );
				$news_image_alt = artf_get_alt_text( $poster_value );
				$recent_news   .= '<a href="' . get_permalink( $poster_value ) . '">
				<img src="' . site_url() . '/artifiche-images/posters_large/' . $poster_id . '.jpg" alt="' . $news_image_alt . '" />
				</a>';
			}
			$recent_news .= '</div>';
			// $recent_news    = '<img src="' . $news_image_url . '" alt="' . $news_image_alt . '">';
		}
		$catinfo  = get_category( $news_cat_auto );
		$haystack = array( 'news', 'news-en' );
		if ( in_array( $catinfo->slug, $haystack ) ) {
			$post_date = get_the_time( 'd.m.Y', $spost->ID ) . ' / ';
		} else {
			$post_date = '';
		}
			$recent_news .= '<div class="news-list-content"><h2>' . get_the_title( $spost->ID ) . '</h2>
			<p>' . $post_date . get_the_excerpt( $spost->ID ) . '</p>
			</div>';

			$news_btns_all    = '';
			$news_btn1        = '';
			
			 $news_link_option = get_field( 'news_list_linking_options', $spost->ID );
			// echo $news_link_option['button_text_1'];
		if ( ! empty( $news_link_option['button_text_1'] ) ) {
			if ( $news_link_option['link_option1'] === '3' ) {
				$news_btn1 = '<a class="outline-btn" href="' . $news_link_option['int_ext_url1'] . '"><i class="icon-arrow_big"></i>' . $news_link_option['button_text_1'] . '</a>';
			} elseif ( $news_link_option['link_option1'] === '2' ) {
				$news_btn1 = '<a class="outline-btn" target="_blank" href="' . $news_link_option['int_ext_url1'] . '"><i class="icon-arrow_big"></i>' . $news_link_option['button_text_1'] . '</a>';
			} elseif ( $news_link_option['link_option1'] === '1' ) {
				$news_btn1 = '<a class="outline-btn" href="' . get_permalink( $spost->ID ) . '"><i class="icon-arrow_big"></i>' . $news_link_option['button_text_1'] . '</a>';
			} else {
				$news_btn1 = '<a class="outline-btn" href="#"><i class="icon-arrow_big"></i>' . $news_link_option['button_text_1'] . '</a>';
			}
		}

		$news_btn2 = '';
		if ( ! empty( $news_link_option['button_text_2'] ) ) {
			if ( $news_link_option['link_option2'] === '3' ) {
				$news_btn2 = '<a class="outline-btn" href="' . $news_link_option['int_ext_url2'] . '"><i class="icon-arrow_big"></i>' . $news_link_option['button_text_2'] . '</a>';
			} elseif ( $news_link_option['link_option2'] === '2' ) {
				$news_btn2 = '<a class="outline-btn" target="_blank" href="' . $news_link_option['int_ext_url2'] . '"><i class="icon-arrow_big"></i>' . $news_link_option['button_text_2'] . '</a>';
			} elseif ( $news_link_option['link_option2'] === '1' ) {
				$news_btn2 = '<a class="outline-btn" href="' . get_permalink( $spost->ID ) . '"><i class="icon-arrow_big"></i>' . $news_link_option['button_text_2'] . '</a>';
			} else {
				$news_btn2 = '<a class="outline-btn" href="#"><i class="icon-arrow_big"></i>' . $news_link_option['button_text_2'] . '</a>';
			}
		}

		$news_btns_all = '<div class="news-links">' . $news_btn1 . $news_btn2 . '</div>';

			$single_news .= '<div class="news-list-single">' . $recent_news . $news_btns_all . '</div>';
	}
	wp_reset_postdata();
	$loadmoretxt = __( 'Weitere News', 'artifiche' );
	if ( ! empty( $loadmore_btn_txt ) ) {
		$loadmoretxt = $loadmore_btn_txt;
	}
	if ( empty( $myposts ) ) {
		$html .= '<div><h3>' . __( 'No results found', 'artifiche' ) . '</h3></div>';
	} else {
		$html .= '<div class="artifiche-newslist ">' . $single_news . '</div>
		<div class="artifiche-readmore">
		
			<a href="javascript:void(0);" id="news-loadmore" class="outline-btn loadmore"><i class="icon-plus"></i>
			' . $loadmoretxt . '</a>
			</div>
		';
	}
	return $html;
}



add_filter( 'vc_autocomplete_artifiche_newslist_news_list_auto_callback', 'artifiche_search_news', 10, 1 );
add_filter( 'vc_autocomplete_artifiche_newslist_news_list_auto_render', 'vc_include_field_render', 10, 1 );


function artifiche_search_news( $search_string ) {
	$query = $search_string;
	$data  = array();

	$args       = array(
		'post_type'        => 'post',
		'post_status'      => 'publish',
		'orderby'          => 'date',
		'order'            => 'DESC',
		'suppress_filters' => false,
		's'                => $query,
	);
	$page_names = array();
	$posts      = get_posts( $args );
	// $args['vc_search_by_title_only'] = true;
	$args['numberposts'] = -1;
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
	}
	wp_reset_postdata();
	return $data;
}

add_filter( 'vc_autocomplete_artifiche_newslist_news_cat_auto_callback', 'artifiche_search_cat', 10, 1 );
add_filter( 'vc_autocomplete_artifiche_newslist_news_cat_auto_render', 'vc_autocomplete_taxonomies_field_render', 10, 1 );


function artifiche_search_cat( $search_string ) {
	$query = $search_string;
	$data  = array();
	$args  =
		array(
			'taxonomy'         => 'category',
			'orderby'          => 'id',
			'order'            => 'ASC',
			'hide_empty'       => false,
			'suppress_filters' => false,
			'name__like'       => $query,
		);
	// $args['vc_search_by_title_only'] = true;
	// $args['numberposts'] = -1;
	$page_names = array();
	// $args['vc_search_by_title_only'] = true;
	$args['posts_per_page '] = -1;
	if ( 0 === strlen( $args['s'] ) ) {
		unset( $args['s'] );
	}
	add_filter( 'posts_search', 'vc_search_by_title_only', 500, 2 );
	$terms = get_terms( $args );// print_r($posts);
	if ( is_array( $terms ) && ! empty( $terms ) ) {
		foreach ( $terms as $term ) {
			$data[] = array(
				'value' => $term->term_id,
				'label' => $term->name,
				// 'group' => $post->post_type,
			);
		}
	}
	// print_r($data);
	wp_reset_postdata();
	return $data;
}

