<?php







add_action( 'wp_ajax_nopriv_kollektion_load_more', 'kollektion_load_more' );

add_action( 'wp_ajax_kollektion_load_more', 'kollektion_load_more' );





function kollektion_load_more() {

	$count = $_POST['count'];



	$orderby = array(

		//'meta_value' => 'DESC',

		'date'       => 'ASC',

	);

	$termargs = array(

		'taxonomy'         => array( 'Kollektionen' ), // taxonomy name

		'field'            => 'term_id',

		'offset'           => $count,

		'number'           => 5,

		'suppress_filters' => false,

		'orderby'          => 'date',

		'order'            => 'ASC',

		// 'meta_query'       => array(

		// array(

		// 'key' => 'neu_flag',

		// ),

		// ),

	);

	$recent_posts = '';

	// var_dump($termargs);

	// die;

	$termslists = get_terms( $termargs );

	// var_dump( $termslists );

	// die;

	if ( ! empty( $termslists ) ) {



		foreach ( $termslists as $term ) :

			

			$sale_flag = get_post_meta( $spost->ID, 'sale_flag', true );



			$content = wp_trim_words( $term->description, 15 );

			$recent_posts .= '			

			<div class="collection-item">

				<div class="collection-content">

					<h2><a href="' . get_term_link( $term ) . '">' . $term->name . '</a></h2>

					<p>' . $content . '</p>

					<a href="' . get_term_link( $term ) . '" class="common-link">' . __( 'Zur Kollektion', 'artifiche' ) . '</a>

				</div>

				<div class="collection-img">';

				$i         = 1;

				$image     = get_field( 'plakatauswahl', $term );

			if ( $image != '' ) {

				$poster_array = explode( ';', $image );// print_r($poster_array );

				$pacount = count($poster_array)-1;

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

					$posterid     = ( isset( $poster_id[0]->ID ) ) ? $poster_id[0]->ID : '10989';

					// echo $poster_id[0]['ID'];

					$alt_text      = artf_get_alt_text( $posterid );

					$recent_posts .= '<a href="' . get_permalink( $posterid ) . '"><img  src="' . site_url() . '/artifiche-images/posters_large/' . $poster_array[ $i ] . '.jpg" alt="' . $alt_text . '" width="' . $w . '" height="' . $h . '" /></a>';

					// $i++;



				}

			}

				$recent_posts .= '</div><a href="' . get_term_link( $term ) . '" class="mobile-only common-link">' . __( 'Zur kollektion', 'artifiche' ) . '</a>

		</div>';

			$i++;



			   endforeach;

	}

			   $ar_posts[] = $recent_posts;

			   // var_dump( $ar_posts );

			   wp_reset_postdata();

			   echo json_encode( $ar_posts );

			   die();



}





add_action( 'wp_ajax_nopriv_shop_load_more', 'shop_load_more' );

add_action( 'wp_ajax_shop_load_more', 'shop_load_more' );





function shop_load_more() {

	//add_filter('wcml_client_currency', WC()->session->get('client_currency'));

	//  global $WC;

    //  $setcurrency = WC()->session->get( 'client_currency' );

	//  print_r($setcurrency);exit;



	$count             = $_POST['count'];

	$show_type         = $_POST['show_type'];

	$shop_filter_query = $_POST['shop_filter_query'];

	$display_grid      = 'none';

	$display_list      = 'none';

	if ( $show_type == 'grid' ) {

		$display_grid = 'block';

	}



	if ( $show_type == 'list' ) {

		$display_list = 'block';

	}



	if ( $shop_filter_query == '1' ) {

		$orderby = array(

			'meta_value' => 'DESC',

			'date'       => 'ASC',

		);

		// || isset( $_GET['show_posters'] )

		// $query->set( 'orderby', $orderby );

		// $query->set( 'meta_key', 'neu_flag' );



		// echo $show_type.$display_list;exit;

		$args = array(

			'post_type'        => 'product',

			'post_status'      => 'publish',

			'orderby'          => $orderby,

			// 'order'            => 'ASC',

			'offset'           => $count,

			'posts_per_page'   => 20,

			'suppress_filters' => false,

			'meta_query'       => array(

				'relation' => 'AND',

				array(

					'key' => 'neu_flag',

				),

				array(

					'key'     => '_stock_status',

					'value'   => array( 'instock' ),

					'compare' => 'IN',

				)

			),

		);

	} else {



		$shop_filter_query                     = unserialize( base64_decode( $shop_filter_query ) );

		$shop_filter_query['offset']           = $count;

		$shop_filter_query['suppress_filters'] = false;

		$args                                  = $shop_filter_query;

	}

	// var_dump( $shop_filter_query );

	// die;

	$recent_posts = '';

	$myposts      = get_posts( $args );

	if ( ! empty( $myposts ) ) {



		foreach ( $myposts as $spost ) :

			setup_postdata( $spost );

			$posters           = '';

			$labels            = '';

			$poster_title      = '';

			$poster_list_label = '';

			$poster_title_list = '';

			$poster_title      = '';

			$size_list_label   = '';

			$sale_flag = get_post_meta( $spost->ID, 'sale_flag', true );

				$image_id      = get_post_meta( $spost->ID, 'plakatnummer', true );

				$new_flag      = get_post_meta( $spost->ID, 'neu_flag', true );

				$jahr          = get_post_meta( $spost->ID, 'jahr', true );

				$breite_cm     = get_post_meta( $spost->ID, 'breite_cm', true );

				$breite_inch   = get_post_meta( $spost->ID, 'breite_inch', true );

				$hohe_cm       = get_post_meta( $spost->ID, 'hohe_cm', true );

				$hohe_inch     = get_post_meta( $spost->ID, 'hohe_inch', true );

			   // $price       = get_post_meta( $post->ID, 'unit_price', true );

			   $product            = wc_get_product( $spost->ID );

			   $stock_status       = $product->get_stock_status();

				// $price                  = $product->get_price_html();

				$price                  = get_dynamic_price_html( 'ajax' );

				$collectors_choice_flag = get_post_meta( $spost->ID, 'collectors_choice_flag', true );



				$product_cat = get_the_terms( $spost->ID, 'product_cat' );



				$labels = '';

			  // $labels .= '<div class="poster-label">';

			if ( $new_flag != '' && $new_flag == 1 ) {

				$labels .= '<span class="poster-l-yellow">' . __( 'NEU', 'artifiche' ) . '</span>';

			}

			if ( $collectors_choice_flag != '' && $collectors_choice_flag == 1 ) {

				// if ( $new_flag != '' && $new_flag == 1 ) {

				// $labels .= '<span>/</span>';

				// }



				$labels .= '<span class="poster-l-red">' . __( 'Collector’s Choice', 'artifiche' ) . '</span>';

			}

			if ( $stock_status == 'outofstock' ) {

				$labels .= '<span class="poster-l-grey">' . __( 'SOLD', 'artifiche' ) . '</span>';

			}

			$sale_option = get_field( 'sale_option', 'option' );

			if (! empty( $sale_option ) && $sale_option[0] == 'true' && get_dynamic_price_html( 'ajax', true ) == true && $sale_flag == 1 ) {

				$labels .= '<span class="poster-l-cyan">' . __( 'SALE', 'artifiche' ) . '</span>';

			}

				$collectors_choice_flag = get_post_meta( $spost->ID, 'collectors_choice_flag', true );

			if ( get_the_title( $spost->ID ) ) {

				$poster_title = '<b class="bold-txt">' . get_the_title( $spost->ID ) . '</b>';



			}

				 $category_detail = get_the_terms( $spost->ID, 'kunstler' );



			$k_flag = false;

			 if( ! empty( $category_detail ) ){

                    

                    foreach( $category_detail as $cd ){

                       



                      $künstler_vorname = get_field( 'gestalter_vorname', $cd );

                      $künstle_name = get_field( 'gestalter_name', $cd );

                      $coma = ',';

					  if ($künstler_vorname != '' || $künstle_name != '') { 

					  

                      		$gestler = $künstler_vorname.' '. $künstle_name;                		

                      	

                      	  }

                      	  else{

                      		$gestler = explode("(", $cd->name)[0];       

                      	}

                      	

                        $künstler_name = '<a href="'. get_term_link( $cd ).'"><span class="kunstler_name">'.$gestler. $coma.$jahr.'</span></a>';    

                        $künstler_woy = '<a href="'. get_term_link( $cd ).'"><span class="kunstler_name">'. $gestler .'</span></a>';               				

                      	

                    }                    

                }else{

                	$k_flag = true;

                }

                

                if( $k_flag ) $künstler_name = '<span class="kunstler_name">'.$jahr.'</span>';



			if ( $jahr != '' ) {

				$jahr_list_label  = '';

				$jahr_list_label .= '<span class="list_jahr">' . __( 'Jahr', 'artifiche' ) . ': </span><span class="jahr">' . $jahr . '</span><span> / </span>';

			}

			if ( get_the_title( $spost->ID ) ) {

				$poster_title_list = '<h2>' . get_the_title( $spost->ID ) . '</h2>';



			}



			if ( $künstler_name != '' ) {

				$kunstler_list_label = '<span class="list_kunstler">' . __( 'Künstler', 'artifiche' ) . ': </span>' . $künstler_woy . '<span> / </span>';

			}



			if ( $breite_cm != '' || $breite_inch != '' || $hohe_cm != '' || $hohe_inch != '' ) {



				$grosse           = get_post_meta( $spost->ID, 'grosse', true );

				$size_list_label .= '<strong>' . __( 'Grösse:', 'artifiche' ) . ' </strong>' . $grosse;

				// $size_list_label .= $breite_cm . ' x ' . $hohe_cm . ' cm';

				// if ( ! empty( $breite_inch ) && ! empty( $hohe_inch ) ) {

				// $size_list_label .= ' / ' . $breite_inch . ' x ' . $hohe_inch.'″<br>';

				// }

			}

			$price_list_label = '';

			if ( $price != '' ) {

				$price_list_label = '<span class="list_price">' . __( 'Preisklasse', 'artifiche' ) . ': </span>' . $price;

			}



			if ( ! empty( $product_cat ) ) {



				foreach ( $product_cat as $cat ) {

					$sub_cat_list_label  = '';

					$main_cat_list_label = '';

					if ( $cat->parent == 0 ) {

						$main_cat_list_label .= '<a href="' . get_term_link( $cat ) . '"><span class="main_cat">' . $cat->name . '</span></a>';



					} else {

						$sub_cat_list_label .= '<a href="' . get_term_link( $cat ) . '"><span class="sub_cat">' . $cat->name . '</span></a>';

					}

				}

			}

			$alt_text = artf_get_alt_text( $spost->ID );



				$recent_posts .= '<div class="poster-single loadmore-focus">

				<a href="' . get_permalink( $spost->ID ) . '">

			 <div class="poster">

				 <img  src="' . site_url() . '/artifiche-images/posters_large/' . $image_id . '.jpg" alt="' . $alt_text . '" />

			 </div>

			 </a>

			 <div class="caption" style="display: ' . $display_grid . ';">

				 ' . $labels . '

				<a href="' . get_permalink( $spost->ID ) . '">' . $poster_title . '</a>

				 ' . $künstler_name . '

				 

			 </div>

			 <div class="poster_list_caption" style="display: ' . $display_list . ';">

				 ' . $labels . '

				<a href="' . get_permalink( $spost->ID ) . '">' . $poster_title_list . '</a>

				' . $jahr_list_label . '

				' . $kunstler_list_label . '

				' . $size_list_label . '

				<br/>

				' . $price_list_label . '

				<br/>

					<span class="catLabel">

				 ' . $künstler_woy . '

				 ' . $main_cat_list_label . '

				 ' . $sub_cat_list_label . '

				 </span>

			 </div>

		 </div>';



			   endforeach;

	}

			   $ar_posts[] = $recent_posts;

			   // var_dump( $ar_posts );

			   wp_reset_postdata();

			   echo json_encode( $ar_posts );

			   die();



}



add_action( 'wp_ajax_nopriv_news_load_more', 'news_load_more' );

add_action( 'wp_ajax_news_load_more', 'news_load_more' );





function news_load_more() {

	$count          = $_POST['count'];

	$news_view_type = $_POST['news_view_type'];

	$news_cat_val = $_POST['news_cat_val'];

	

	if ( $news_view_type != 'normal' ) {

		$news_view_type           = unserialize( base64_decode( $news_view_type ) );

		$news_view_type['offset'] = $count;

		$args                     = $news_view_type;

	} else {

		$args = array(

			'post_type'        => 'post',

			'offset'           => $count,

			'posts_per_page'   => 5,

			'suppress_filters' => false,

			'orderby'          => 'date',

			'order'            => 'DESC',

		);

		if ( ! empty( $news_cat_val ) ) {

			$args['category'] = explode( ',', $news_cat_val );

		} 

	}



	// var_dump($news_view_type);die;

	$recent_posts = '';

	$myposts      = get_posts( $args );

	if (!empty($myposts)) {

	foreach ( $myposts as $spost ) :

		setup_postdata( $spost );

		$recent_news = '';

		$news_option = get_field( 'news_list_options', $spost->ID );

		if ( ! empty( $news_option ) && ! empty( $news_option['news_option'] )

		&& $news_option['news_option'] == 'dni' && ! empty( $news_option['news_image'] ) ) {

			$news_image     = $news_option['news_image'];

			$size           = 'thumbnail';

			$news_image_url = $news_image['sizes'][ $size ];

			$news_image_alt = artf_get_alt_text( $spost->ID );



			$recent_news .= '<div class="news-list-posters news-img"><img src="' . esc_url( $news_image_url ) . '" alt="' . $news_image_alt . '"></div>';

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

		$catinfo = get_category( $news_cat_val );

		if ( $catinfo->slug === 'news' ) {

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

			   endforeach;

			}

			   $ar_posts[] = $single_news;

			   // var_dump( $ar_posts );

			   wp_reset_postdata();

			   echo json_encode( $ar_posts );

			   die();



}





add_action( 'wp_ajax_nopriv_similar_load_more', 'similar_load_more' );

add_action( 'wp_ajax_similar_load_more', 'similar_load_more' );

function similar_load_more() {

	$count                         = $_POST['count'];

	$similar_query                 = $_POST['similar_query'];

	$similarloadmore_arr           = unserialize( base64_decode( $similar_query ) );

	$similarloadmore_arr['offset'] = $count;

	$args                          = $similarloadmore_arr;

	// var_dump($args);die;

	$recent_posts     = '';

	$products         = new WP_Query( $args );

		$posters      = '';

		$labels       = '';

		$poster_title = '';



			/* Start the Loop */

		$poster_single = '';

		// $j = 1;

		if (!empty($products)) {

	while ( $products->have_posts() ) :

		$products->the_post();



			$labels                 = '';

			$image_id               = get_post_meta( get_the_ID(), 'plakatnummer', true );

			$new_flag               = get_post_meta( get_the_ID(), 'neu_flag', true );

			$collectors_choice_flag = get_post_meta( get_the_ID(), 'collectors_choice_flag', true );

			$sale_flag = get_post_meta( get_the_ID(), 'sale_flag', true );

			$jahr                   = get_post_meta( get_the_ID(), 'jahr', true );



			$product            = wc_get_product( get_the_ID() );

			$stock_status       = $product->get_stock_status();

		  // $labels .= '<div class="poster-label">';

		if ( $new_flag != '' && $new_flag == 1 ) {

			$labels .= '<span class="poster-l-yellow">' . __( 'NEU', 'artifiche' ) . '</span>';

		}

		if ( $collectors_choice_flag != '' && $collectors_choice_flag == 1 ) {



			if ( $new_flag != '' && $new_flag == 1 ) {

				$labels .= '<span class="separator">/</span>';

			}



			$labels .= '<span class="poster-l-red">' . __( 'Collector’s Choice', 'artifiche' ) . '</span>';

		}

		if ( $stock_status == 'outofstock' ) {

			$labels .= '<span class="poster-l-grey">' . __( 'SOLD', 'artifiche' ) . '</span>';

		}

		$sale_option = get_field( 'sale_option', 'option' );

		if (! empty( $sale_option ) && $sale_option[0] == 'true' && get_dynamic_price_html( 'ajax', true ) == true && $sale_flag == 1 ) {

			$labels .= '<span class="poster-l-cyan">' . __( 'SALE', 'artifiche' ) . '</span>';

		}

			$collectors_choice_flag = get_post_meta( get_the_ID(), 'collectors_choice_flag', true );

			 $poster_title          = '<b class="bold-txt">' . get_the_title() . '</b>';

			 $category_detail       = get_the_terms( get_the_ID(), 'kunstler' );



			$k_flag = false;

			 if( ! empty( $category_detail ) ){

                    

                    foreach( $category_detail as $cd ){

                       



                      $künstler_vorname = get_field( 'gestalter_vorname', $cd );

                      $künstle_name = get_field( 'gestalter_name', $cd );

                      $coma = ',';

					  if ($künstler_vorname != '' || $künstle_name != '') { 

					  

                      		$gestler = $künstler_vorname.' '. $künstle_name;                		

                      	

                      	  }

                      	  else{

                      		$gestler = explode("(", $cd->name)[0];       

                      	}

                      	

                        $künstler_name = '<a href="'. get_term_link( $cd ).'"><span class="kunstler_name">'.$gestler. $coma.$jahr.'</span></a>';    

                        $künstler_woy = '<a href="'. get_term_link( $cd ).'"><span class="kunstler_name">'. $gestler .'</span></a>';               				

                      	

                    }                    

                }else{

                	$k_flag = true;

                }

                

                if( $k_flag ) $künstler_name = '<span class="kunstler_name">'.$jahr.'</span>';



			  // $labels .='</div>';



		// if( $j % 4 == 1)

		// $posters .= '<div class="poster-row">';

				$alt_text = artf_get_alt_text( get_the_ID() );



			   $posters .= '<div class="poster-single">

				   <a href="' . get_permalink( get_the_ID() ) . '">

			            <div class="poster">

			                <img src="' . site_url() . '/artifiche-images/posters_large/' . $image_id . '.jpg" alt="' . $alt_text . '" />

			            </div>

			            </a>

			            <div class="caption">

			                ' . $labels . '

			               <a href="' . get_permalink( get_the_ID() ) . '">' . $poster_title . '</a>

			                ' . $künstler_name . '

			            </div>

			        </div>';



		?>

		   <?php

			/*

			$j++;



				   if( $j > 4 ){

					$j = 1;

					$posters .= '</div>';

				 }*/

			endwhile;

		}

			   $ar_posts[] = $posters;

			   // var_dump( $ar_posts );

			   wp_reset_query();

			   echo json_encode( $ar_posts );

			   die();



}





add_action( 'wp_ajax_nopriv_tax_load_more', 'tax_load_more' );

add_action( 'wp_ajax_tax_load_more', 'tax_load_more' );





function tax_load_more() {

	$count         = $_POST['count'];

	$tax_page_type = $_POST['tax_page_type'];

	$current_tax   = $_POST['current_tax'];

	$orderby       = array(

		'meta_value' => 'DESC',

		'date'       => 'ASC',

	);

	if( isset( $_COOKIE['sold_posters'] ) && $_COOKIE['sold_posters'] == true  ) {

		$sold_posters = 1;

	} else {

		$sold_posters = 0;

	}

	$metaquery[] = array(

		'key' => 'neu_flag',

	);

	$tax_query = array();

	if ( $sold_posters == 1 ) {

		$metaquery[] = array(

			'key'     => '_stock_status',

			'value'   => array( 'instock' ),

			'compare' => 'IN',

		);



	} else {

		$metaquery[] = array(

			'key'     => '_stock_status',

			'value'   => array( 'outofstock', 'instock' ),

			'compare' => 'IN',

		);

	}

	if( $tax_page_type == 'Kollektionen' ) { 

		$ck = get_term_by('term_id',  $current_tax, 'Kollektionen' );

		$plakatzuweisungen = get_field( 'plakatzuweisungen', $ck );

			if ( $plakatzuweisungen != '' ) {

				$poster_array = explode( ';', $plakatzuweisungen );

				if( ! empty( $poster_array ) ){

					$metaquery[] = array(

						'key'     => 'plakatnummer',

						'value'   => $poster_array,

						'compare' => 'IN',

					);

				}	

			}	

	}else{

		$tax_query[] = array(

			'taxonomy' => $tax_page_type,

			'field'    => 'term_id',

			'terms'    => $current_tax,

		);

	}

	$args          = array(

		'post_type'        => 'product',

		'post_status'      => 'publish',

		'orderby'          => $orderby,

		// 'order'            => 'DESC',

		'offset'           => $count,

		'posts_per_page'   => 20,

		'suppress_filters' => false,

		// 'tax_query'        => array(

		// 	array(

		// 		'taxonomy' => $tax_page_type,

		// 		'field'    => 'term_id',

		// 		'terms'    => $current_tax,

		// 	),

		// )

	);

	$args['meta_query'] = $metaquery;

	$args['meta_query']['relation'] = 'AND';

	$args['tax_query'] = $tax_query;

	// print_r($args);die;

	$posters      = '';

	$labels       = '';

	$poster_title = '';

	$recent_posts = '';

	$postslists   = get_posts( $args );

if (!empty($postslists)) {

	foreach ( $postslists as $tpost ) :



		$labels                 = '';

		$image_id               = get_post_meta( $tpost->ID, 'plakatnummer', true );

		$new_flag               = get_post_meta( $tpost->ID, 'neu_flag', true );

		$collectors_choice_flag = get_post_meta( $tpost->ID, 'collectors_choice_flag', true );

		$sale_flag = get_post_meta( $tpost->ID, 'sale_flag', true );

		$jahr                   = get_post_meta( $tpost->ID, 'jahr', true );



		$product            = wc_get_product( $tpost->ID );

		$stock_status       = $product->get_stock_status();

		// $labels .= '<div class="poster-label">';

		if ( $new_flag != '' && $new_flag == 1 ) {

			$labels .= '<span class="poster-l-yellow">' . __( 'NEU', 'artifiche' ) . '</span>';

		}

		if ( $collectors_choice_flag != '' && $collectors_choice_flag == 1 ) {



			// if ( $new_flag != '' && $new_flag == 1 ) {

			// $labels .= '<span class="separator">/</span>';

			// }



			$labels .= '<span class="poster-l-red">' . __( 'Collector’s Choice', 'artifiche' ) . '</span>';

		}

		if ( $stock_status == 'outofstock' ) {

			$labels .= '<span class="poster-l-grey">' . __( 'SOLD', 'artifiche' ) . '</span>';

		}

		if (! empty( $sale_option ) && $sale_option[0] == 'true' && get_dynamic_price_html( 'ajax', true ) == true && $sale_flag == 1 ) {

			$labels .= '<span class="poster-l-cyan">' . __( 'SALE', 'artifiche' ) . '</span>';

		}

		$collectors_choice_flag = get_post_meta( $tpost->ID, 'collectors_choice_flag', true );

		 $poster_title          = '<b class="bold-txt">' . get_the_title( $tpost->ID ) . '</b>';

		 $category_detail       = get_the_terms( $tpost->ID, 'kunstler' );



		

			$k_flag = false;

			 if( ! empty( $category_detail ) ){

                    

                    foreach( $category_detail as $cd ){

                       



                      $künstler_vorname = get_field( 'gestalter_vorname', $cd );

                      $künstle_name = get_field( 'gestalter_name', $cd );

                      $coma = ',';

					  if ($künstler_vorname != '' || $künstle_name != '') { 

					  

                      		$gestler = $künstler_vorname.' '. $künstle_name;                		

                      	

                      	  }

                      	  else{

                      		$gestler = explode("(", $cd->name)[0];       

                      	}

                      	

                        $künstler_name = '<a href="'. get_term_link( $cd ).'"><span class="kunstler_name">'.$gestler. $coma.$jahr.'</span></a>';    

                        $künstler_woy = '<a href="'. get_term_link( $cd ).'"><span class="kunstler_name">'. $gestler .'</span></a>';               				

                      	

                    }                    

                }else{

                	$k_flag = true;

                }

                

                if( $k_flag ) $künstler_name = '<span class="kunstler_name">'.$jahr.'</span>';

		// $labels .='</div>';



		// if( $j % 4 == 1)

		// $posters .= '<div class="poster-row">';

		   $alt_text = artf_get_alt_text( $tpost->ID );

		   $posters .= '<div class="poster-single">

				   <a href="' . get_permalink( $tpost->ID ) . '">

				<div class="poster">

					<img  src="' . site_url() . '/artifiche-images/posters_large/' . $image_id . '.jpg" alt="' . $alt_text . '" />

				</div>

				</a>

				<div class="caption">

					' . $labels . '

				   <a href="' . get_permalink( $tpost->ID ) . '">' . $poster_title . '</a>

					' . $künstler_name . '

				</div>

			</div>';

			   endforeach;

			}

			   $ar_posts[] = $posters;

			// var_dump( $ar_posts );

			   wp_reset_postdata();

			   echo json_encode( $ar_posts );

			   die();



}





add_action( 'wp_ajax_nopriv_autocomplete', 'ajax_autocomplete' );

add_action( 'wp_ajax_autocomplete', 'ajax_autocomplete' );

function ajax_autocomplete() {



	$filter_text = $_REQUEST['filter_text'];



	$termargs = array(

		'taxonomy'   => array( 'kunstler', 'pa_land', 'marke' ), // taxonomy name

			// 'field'    => 'slug',

			// 'terms'  => $filter_text,

		'orderby'    => 'name',

		'order'      => 'ASC',

		'hide_empty' => true,

		'name__like' => $filter_text,

			// 'compare' => 'like',

	);

		$recent_posts = '';

		$termslists   = get_terms( $termargs );

		// print_r($termslists);

	$html = '';

	if ( ! empty( $termslists ) ) {

		foreach ( $termslists as $term ) {



			$html .= '<option class="filter_list"  data-tax="' . $term->taxonomy . '" data-slug="' . $term->slug . '" value="' . $term->slug . '">' . $term->name . '</option>';

		}

	}

	echo $html;

	exit;

	// print_r($filter_text);

}



