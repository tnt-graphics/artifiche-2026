<?php

/*
Element Description: Artifiche Home Banner
*/


// Map the block with vc_map()
vc_map(
	array(
		'name'        => __( 'Artifiche Home Slider', 'artifiche' ),
		'base'        => 'artifiche_home_banner',
		'icon'        => get_template_directory_uri() . '/img/logo2.svg',
		'category'    => __( 'Artifiche Elements', 'artifiche' ),
		'description' => __( 'Die Slider werden unter Home Slider erstellt und hier automatisch oder über die
		Auswahl angezeigt.', 'artifiche' ),
		'params'      => array_merge(
			array(
				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__( 'Manuell auswählen?', 'artifiche' ),
					'param_name'  => 'ismanual',
					'value'       => array( esc_html__( 'Yes', 'artifiche' ) => '1' ),
					'description' => __( 'Wenn manuell nicht ausgewählt ist, werden alle Slider welche sich unter Home Slider befinden
					angezeigt.', 'artifiche' ),
				),
				array(
					'type'        => 'autocomplete',
					'heading'     => esc_html__( 'Select Collection Slider', 'artifiche' ),
					'param_name'  => 'post1',
					'description' => esc_html__( 'Choose multiple collection sliders.', 'artifiche' ),
					'settings'    => array(
						'multiple'      => true,
						'sortable'      => true,
						'unique_values' => true,
						'min_length'    => 1,
					),
					'dependency'  => array(
						'element' => 'ismanual',
						'value'   => '1',
					),
				),
			)
		),
	)
);


add_shortcode( 'artifiche_home_banner', 'artifiche_home_banner_fun' );


// Element HTML
function artifiche_home_banner_fun( $atts, $content = null ) {
	global $post;

	// Params extraction
	$atts         = extract(
		shortcode_atts(
			array(
				'ismanual' => '',
				'post1'    => '',
			),
			$atts
		)
	);
	$html         = '';
	$recent_posts = '';

	if ( ! empty( $ismanual ) ) {
		if ( empty( $post1 ) ) {
			echo '<div>' . __( 'Please select the posts first', 'artifiche' ) . '</div>';
			return;
		}
		$args = array(
			'post_type'      => 'collection_slider',
			'posts_per_page' => -1,
			'post__in'       => explode( ',', $post1 ),
			'orderby'        => 'post__in',
		);
	} else {
			$args = array(
				'post_type'        => 'collection_slider',
				'posts_per_page'   => -1,
				'orderby'          => 'date',
				'suppress_filters' => false,
				'order'            => 'DESC',
				'post_status'      => 'publish',
				'suppress_filters' => false,
			);
	}

	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) :
		setup_postdata( $post );
		$banner_image     = get_field( 'banner_image', $post->ID );
		$banner_image_url = $banner_image['url'];
		$banner_image_alt = $banner_image['alt'];
		$link             = get_field( 'banner_link', $post->ID );
		$alt_text = 'artifiche';

		if ( $link ) :
			$link_url    = $link['url'];
			$link_title  = $link['title'];
			$link_target = $link['target'] ? $link['target'] : '_self';
		endif;
			$recent_posts .= '<div class="item">
	<img  src="' . esc_url( $banner_image_url ) . '" alt="' . esc_url( $banner_image_alt ) . '" />
	<div class="banner-nav">
            <a href="' . esc_url( $link_url ) . '" target="' . esc_attr( $link_target ) . '"><span>' . get_field( 'sub_title_content', $post->ID ) . '</span>
            <h2>' . get_the_title( $post->ID ) . '</h2></a>
            <div class="banner-nav_icon">
                <i class="icon-forward"></i>
                <i class="icon-backward"></i>
            </div>
        </div>
	</div>';
endforeach;
	wp_reset_postdata();
	if ( ! empty( $recent_posts ) ) {
		$html = '<div class="banner banner-carousel">'
		. $recent_posts .
		'</div>';
	}

	return $html;
}


add_filter( 'vc_autocomplete_artifiche_home_banner_post1_callback', 'artifiche_home_banner_search', 10, 1 );
add_filter( 'vc_autocomplete_artifiche_home_banner_post1_render', 'vc_include_field_render', 10, 1 );

function artifiche_home_banner_search( $search_string ) {
	$query = $search_string;
	$data  = array();

	$args       = array(
		'post_type'        => 'collection_slider',
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
