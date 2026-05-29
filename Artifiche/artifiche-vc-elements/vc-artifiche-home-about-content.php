<?php
/**
 * VC element for Home page about content.
 */
vc_map(
	array(
		'name'                    => __( 'Artifiche Home Intro mit News', 'artifiche' ),
		'base'                    => 'artf_home_about_content',
		'icon'                    => get_template_directory_uri() . '/img/logo2.svg',
		'category'                => __( 'Artifiche Elements', 'artifiche' ),
		'content_element'         => true,
		'show_settings_on_create' => true,
		'description'             => __( 'Zeigt links einen freien Text mit Navigation an und rechts immer die aktuelle oder
		eine ausgewählte News an.', 'artifiche' ),
		'params'                  => array_merge(
			array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Untertitel', 'artifiche' ),
					'param_name'  => 'about_sub_heading',
					'admin_label' => true,
				),
				array(
					'type'        => 'textarea_html',
					'heading'     => esc_html__( 'Text', 'artifiche' ),
					'param_name'  => 'content',
					'admin_label' => true,
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Titel weisse Box', 'artifiche' ),
					'param_name'  => 'news_sec_title',
					'admin_label' => true,
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Select Manually?', 'artifiche' ),
					'param_name'  => 'ismanual',
					'value'       => array(
						esc_html__( 'No', 'artifiche' )  => '0',
						esc_html__( 'Yes', 'artifiche' ) => '1',
					),
					'std'         => '0',
					'description' => __( 'Wenn manuell nicht ausgewählt ist, wird die neuste News angezeigt.', 'artifiche' ),
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
				array(
					'type'        => 'autocomplete',
					'heading'     => esc_html__( 'Select news', 'artifiche' ),
					'param_name'  => 'news',
					'description' => esc_html__( 'Choose a news.', 'artifiche' ),
					'settings'    => array(
						'multiple'      => false,
						'sortable'      => true,
						'unique_values' => true,
						'min_length'    => 1,
					),
					'dependency'  => array(
						'element' => 'ismanual',
						'value'   => '1',
					),
				),
				// array(
				// 'type'        => 'textfield',
				// 'heading'     => esc_html__( 'Button Text', 'artifiche' ),
				// 'param_name'  => 'button_text',
				// 'description' => __( 'Default: von zürich', 'artifiche' ),
				// 'admin_label' => true,
				// ),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Button Url', 'artifiche' ),
					'param_name'  => 'button_url',
					'description' => __( 'Default: #', 'artifiche' ),
					'admin_label' => true,
				),
			)
		),
	)
);


add_shortcode( 'artf_home_about_content', 'artf_home_about_content_fun' );

/**
 * Element HTML
 *
 * @param string $atts attributes.
 * @param string $content content.
 * @return boolean
 */
function artf_home_about_content_fun( $atts, $content = null ) {
	$atts           = extract(
		shortcode_atts(
			array(
				'about_sub_heading' => '',
				'news_sec_title'    => '',
				'ismanual'          => '',
				'news'              => '',
				// 'button_text'       => '',
				'button_url'        => '',
				'news_cat_auto'    => '',
			),
			$atts
		)
	);
	$html           = '';
	$recent_posts   = '';
	$menu_list      = '';
	$locations = get_nav_menu_locations();
	$menu_id = wp_get_nav_menu_object( $locations[ 'artifiche-about-menu' ] );
	$menu_items     = wp_get_nav_menu_items( $menu_id );
	if( ! empty( $menu_items ) ){

		$menu_list = '<ul class="about-menu">';

			foreach ( (array) $menu_items as $key => $menu_item ) {
				$title = $menu_item->title;
				$url = $menu_item->url;
				$menu_list .= '<li><a class="common-link" href="' . $url . '">' . $title . '</a></li>';
			}

		 $menu_list .= '</ul>';
	}

		$abtcontent = '
					<div class="about-left-content">
					<div class="desktop-only">
					<h2>' . $about_sub_heading . '</h2>
						<p>' . wpb_js_remove_wpautop( $content ) . '</p>
					
					<div class="menu-outer">
						' . $menu_list . '
					</div>
					</div>
					
					<div class="mobile-only">
					<h2>' . $about_sub_heading . '</h2>
						<p>' . wpb_js_remove_wpautop( $content ) . '</p>
					
					<div class="menu-outer">
						' . $menu_list . '
					</div>
					</div>
						</div>
					<div class="about-right-content">';
	
	if ( ! empty( $ismanual ) ) {
		if ( empty( $news ) ) {
			echo '<div>' . esc_html__( 'Please select the news first', 'artifiche' ) . '</div>';
			return;
		}
		$args = array(
			'post_type'      => 'post',
			'posts_per_page' => 1,
			'post__in'       => array( $news ),
			'orderby'        => 'post__in',
		);
	} else {
			

			$args = array(
				'post_type'        => 'post',
				'posts_per_page'   => 1,
				'orderby'          => 'date',
				'suppress_filters' => false,
				'order'            => 'DESC',
				'post_status'      => 'publish',
				'suppress_filters' => false,
			);
			if ( ! empty( $news_cat_auto ) ) {
				$args['category'] = explode( ',', $news_cat_auto );
			}

	}
	$myposts = get_posts( $args );
	if ( ! empty( $myposts ) ) {

		foreach ( $myposts as $post ) :
			setup_postdata( $post );

			$news_link_option = get_field( 'news_list_linking_options', $post->ID );
		if ( ! empty( $news_link_option['button_text_1'] ) ) {
			if ( $news_link_option['link_option1'] === '3' ) {
				$news_link_btn_url = $news_link_option['int_ext_url1'];
				$target = "";
			} elseif ( $news_link_option['link_option1'] === '2' ) {
				$news_link_btn_url = $news_link_option['int_ext_url1'];
				$target = "target='_blank'";
			} elseif ( $news_link_option['link_option1'] === '1' ) {
				$news_link_btn_url = get_permalink( $post->ID );
				$target = "";
			} else {
				$news_link_btn_url = get_permalink( $post->ID );
				$target = "";
			}
		}

			$post_date = strtotime( $post->post_date );
			$date = '<span class="news-date">'. date( "d.m.Y", $post_date ) .'</span><br/>';
			$recent_posts .= '<li>
				'. $date .'
				<b>
			' . $post->post_title . '
			»</b></li>';
	endforeach;
		wp_reset_postdata();
		$button_url1 = '#';
		if ( ! empty( $button_url ) ) {
			$button_url1 = get_site_url() . $button_url;
		} else {
			$button_url1 = get_permalink(get_field( 'set_news_page', 'option' ));
		}
		$button_url1 = get_permalink(get_field( 'set_news_page', 'option' ));
		$abtcontent .= '<div>
					<a '.$target.' href="' . $news_link_btn_url. '">		
						<h2 class="head_main">' . $news_sec_title . '</h2>
							<div class="vc_row">'
								. $recent_posts .
							'</div>
					</a>
				</div>
				</div>
				';

	}

	$html .= '<h1>'.strtoupper( get_bloginfo( 'name' ) ).'</h1><div class="home-about-content column-content">' . $abtcontent . '</div>';
		return $html;
}

add_filter( 'vc_autocomplete_artf_home_about_content_news_callback', 'artf_search_single_blog', 10, 1 );
add_filter( 'vc_autocomplete_artf_home_about_content_news_render', 'vc_include_field_render', 10, 1 );

function artf_search_single_blog( $search_string ) {
	$query = $search_string;
	$data  = array();

	$args       = array(
		'post_type'        => 'post',
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
	}
	return $data;
}


add_filter( 'vc_autocomplete_artf_home_about_content_news_cat_auto_callback', 'artifiche_search_cat1', 10, 1 );
add_filter( 'vc_autocomplete_artf_home_about_content_news_cat_auto_render', 'vc_autocomplete_taxonomies_field_render', 10, 1 );


function artifiche_search_cat1( $search_string ) {
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