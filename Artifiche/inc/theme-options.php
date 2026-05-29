<?php



add_action( 'acf/init', 'add_acf_functionality' );

function add_acf_functionality() {
	if ( function_exists( 'acf_add_options_page' ) ) {

		acf_add_options_page(
	
			array(
	
				'page_title' => 'Theme Options',
	
				'menu_title' => 'Theme Options',
	
				'menu_slug'  => 'theme-options',
	
				'capability' => 'edit_posts',
	
				'redirect'   => false,
	
			)
	
		);
	
	}
}



// add_filter( 'woocommerce_add_to_cart_fragments', 'woo_cart_but', 30, 1 );



function get_thewidget() {

	$sidebar_contents = '';

	ob_start();

	dynamic_sidebar( the_widget( 'WC_Widget_Cart', 'title=' ) );

	$sidebar_contents = ob_get_clean();



	return $sidebar_contents;

}

add_filter( 'woocommerce_add_to_cart_fragments', 'wc_refresh_cart_fragments', 50, 1 );

function wc_refresh_cart_fragments( $fragments ) {

	$cart_count      = WC()->cart->get_cart_contents_count();

	$cartcount_class = '';

	if ( $cart_count == 0 ) {

		$cartcount_class = 'empty-basket';

	}

	$widcontents = '';

	if ( $cart_count > 0 ) {

		$minicart_class = '';

		if ( ! is_checkout() && ! is_cart() ) {

			$minicart_class = 'artifiche-mini-cart';

		}

		$widcontents = '<div class="' . $minicart_class . '">' . get_thewidget() . '</div>';

	}?>
	<?php echo $widcontents; ?>
	<!-- <div class="<?php //echo $minicart_class; ?>"><?php //echo get_thewidget(); ?></div> -->

	<span class="count <?php echo $cartcount_class; ?>" id="count-cart-items"><?php echo $cart_count; ?></span>

	<?php

	// Normal version

	// $count_normal = '<span class="count ' . $cartcount_class . '" id="count-cart-items">' . $cart_count . '

	// </span>' . $widcontents;



	$fragments['#count-cart-items'] = ob_get_clean();

	// $fragments['#count-cart-items'] = $count_normal;



	return $fragments;

}



add_shortcode( 'woo_cart_but', 'woo_cart_but' );

/**

 * Create Shortcode for WooCommerce Cart Menu Item

 */

function woo_cart_but() {



		ob_start();



		// $cart_count = WC()->cart->cart_contents_count; // Set variable for cart item count

		$cart_count = WC()->cart->get_cart_contents_count(); // Set variable for cart item count

		$cart_url   = wc_get_cart_url();  // Set Cart URL



	?>

		<a class="cart" data-click-state="1" href="<?php echo $cart_url; ?>">

		<i class="icon-cart">

		<svg xmlns="http://www.w3.org/2000/svg" width="36.046" height="36" viewBox="0 0 36.046 36">

			<defs>

				<style>

				.a,

				.b {

					fill: none;

					stroke-width: 2px;

				}



				.a {

					stroke-miterlimit: 10;

				}



				.b {

					stroke-linecap: round;

					stroke-linejoin: round;

				}

				</style>

			</defs>

			<g transform="translate(-352.248 -410.235)">

				<ellipse class="a" cx="3.456" cy="3.436" rx="3.456" ry="3.436" transform="translate(363.445 438.361)"></ellipse>

				<path class="a" d="M378.871,438.686h0a3.437,3.437,0,1,0,3.458,3.436,3.435,3.435,0,0,0-3.458-3.436Z" transform="translate(-0.262 -0.324)"></path>

				<path class="a" d="M361.415,429.347h20.17a1.331,1.331,0,0,0,1.242-.838l4.435-11.119a1.32,1.32,0,0,0-.741-1.714l-.009,0a1.319,1.319,0,0,0-.494-.092H359.049" transform="translate(-0.068 -0.051)"></path>

				<path class="b" d="M353.248,411.235h4.973l4.017,23.341h21.177" transform="translate(0 0)"></path>

			</g>

		</svg>

	</i>

		<?php

		$cartcount_class = '';

		if ( $cart_count == 0 ) {

			$cartcount_class = 'empty-basket';

		}

		if ( $cart_count > 0 ) {

			$minicart_class = '';

			if ( ! is_checkout() && ! is_cart() ) {

				$minicart_class = 'artifiche-mini-cart';

			}



			?>

			<span class="count <?php echo $cartcount_class; ?>" id="count-cart-items"><?php echo $cart_count; ?></span>

			<div class="<?php echo $minicart_class; ?>"><?php the_widget( 'WC_Widget_Cart', 'title=' ); ?></div>

			<?php

		} else {

			?>

			<span class="count <?php echo $cartcount_class; ?>" id="count-cart-items"><?php echo $cart_count; ?></span>

			<div class="artifiche-mini-cart <?php echo $cartcount_class; ?>"><?php the_widget( 'WC_Widget_Cart', 'title=' ); ?></div>

			<?php

		}

		?>

		

		</a>

		<?php



		return ob_get_clean();



}



/**
 * Contact Form 7: poster inquiry (?pid= / ?mpid=) and local mail.
 */
add_action( 'init', 'artifiche_store_inquiry_query_params', 1 );

function artifiche_store_inquiry_query_params() {
	if ( headers_sent() ) {
		return;
	}

	$cookie_path   = COOKIEPATH ? COOKIEPATH : '/';
	$cookie_domain = COOKIE_DOMAIN;
	$secure        = is_ssl();
	$httponly      = true;
	$expires       = time() + HOUR_IN_SECONDS;

	if ( ! empty( $_GET['pid'] ) && is_numeric( $_GET['pid'] ) ) {
		$pid = (string) absint( $_GET['pid'] );
		setcookie( 'artifiche_inquiry_pid', $pid, $expires, $cookie_path, $cookie_domain, $secure, $httponly );
		$_COOKIE['artifiche_inquiry_pid'] = $pid;
	}

	if ( ! empty( $_GET['mpid'] ) ) {
		$mpid = sanitize_text_field( wp_unslash( $_GET['mpid'] ) );
		setcookie( 'artifiche_inquiry_mpid', $mpid, $expires, $cookie_path, $cookie_domain, $secure, $httponly );
		$_COOKIE['artifiche_inquiry_mpid'] = $mpid;
	}
}

function artifiche_preserve_inquiry_query_args( $redirect_url, $requested_url ) {
	if ( empty( $redirect_url ) ) {
		return $redirect_url;
	}

	foreach ( array( 'pid', 'mpid' ) as $param ) {
		if ( ! empty( $_GET[ $param ] ) ) {
			$redirect_url = add_query_arg( $param, sanitize_text_field( wp_unslash( $_GET[ $param ] ) ), $redirect_url );
		}
	}

	return $redirect_url;
}
add_filter( 'redirect_canonical', 'artifiche_preserve_inquiry_query_args', 10, 2 );

/**
 * WPML browser-language redirect uses languageUrls without query strings — keep ?pid= / ?mpid=.
 */
function artifiche_wpml_append_inquiry_to_language_urls( $params ) {
	if ( empty( $params['languageUrls'] ) || ! is_array( $params['languageUrls'] ) ) {
		return $params;
	}

	$query_args = array();

	if ( ! empty( $_GET['pid'] ) ) {
		$query_args['pid'] = sanitize_text_field( wp_unslash( $_GET['pid'] ) );
	}

	if ( ! empty( $_GET['mpid'] ) ) {
		$query_args['mpid'] = sanitize_text_field( wp_unslash( $_GET['mpid'] ) );
	}

	if ( empty( $query_args ) ) {
		return $params;
	}

	foreach ( $params['languageUrls'] as $code => $url ) {
		$params['languageUrls'][ $code ] = add_query_arg( $query_args, $url );
	}

	return $params;
}
add_filter( 'wpml_browser_redirect_language_params', 'artifiche_wpml_append_inquiry_to_language_urls', 10, 1 );

add_action( 'wpcf7_init', 'artifiche_register_cf7_custom_tags' );

function artifiche_register_cf7_custom_tags() {
	wpcf7_add_form_tag( 'artifiche_custom_pid_cf7', 'wpcf7_get_pid_shortcode_handler1', true );
}

add_filter( 'wpcf7_skip_spam_check', '__return_true' );

if ( function_exists( 'wp_get_environment_type' ) && 'local' === wp_get_environment_type() ) {
	add_action(
		'phpmailer_init',
		static function ( $phpmailer ) {
			$phpmailer->isSMTP();
			$phpmailer->Host       = '127.0.0.1';
			$phpmailer->Port       = 1025;
			$phpmailer->SMTPAuth   = false;
			$phpmailer->SMTPAutoTLS = false;

			if ( empty( $phpmailer->From ) ) {
				$from_email = get_option( 'admin_email' );
				if ( ! $from_email || ! is_email( $from_email ) ) {
					$host       = wp_parse_url( home_url(), PHP_URL_HOST );
					$from_email = 'wordpress@' . ( $host ? $host : 'localhost' );
				}
				$phpmailer->setFrom( $from_email, get_bloginfo( 'name' ) );
			}
		}
	);

	add_action(
		'wp_mail_failed',
		static function ( $error ) {
			if ( is_wp_error( $error ) ) {
				error_log( 'Artifiche local wp_mail_failed: ' . $error->get_error_message() );
			}
		}
	);
}

function artifiche_get_inquiry_single_pid() {
	if ( isset( $_GET['pid'] ) && is_numeric( $_GET['pid'] ) ) {
		return absint( $_GET['pid'] );
	}

	if ( ! empty( $_COOKIE['artifiche_inquiry_pid'] ) && is_numeric( $_COOKIE['artifiche_inquiry_pid'] ) ) {
		return absint( $_COOKIE['artifiche_inquiry_pid'] );
	}

	return 0;
}

function artifiche_get_inquiry_mpid_list() {
	if ( ! empty( $_GET['mpid'] ) ) {
		return sanitize_text_field( wp_unslash( $_GET['mpid'] ) );
	}

	if ( ! empty( $_COOKIE['artifiche_inquiry_mpid'] ) ) {
		return sanitize_text_field( wp_unslash( $_COOKIE['artifiche_inquiry_mpid'] ) );
	}

	return '';
}

function artifiche_build_poster_inquiry_content( $product_id ) {
	$product_id = absint( $product_id );

	if ( ! $product_id || 'product' !== get_post_type( $product_id ) ) {
		return '';
	}

	$poster_id    = get_post_meta( $product_id, 'plakatnummer', true );
	$poster_url   = get_permalink( $product_id );
	$poster_title = get_the_title( $product_id );

	return 'Poster ID: ' . $poster_id . '&#10;Poster Url: ' . $poster_url . '&#10;Poster Title: ' . $poster_title;
}

function wpcf7_get_pid_shortcode_handler1( $tag ) {
	$name            = $tag['name'];
	$poster_contents = '';
	$html            = '';

	$pid_val = artifiche_get_inquiry_single_pid();

	if ( $pid_val ) {
		$poster_contents = artifiche_build_poster_inquiry_content( $pid_val );
	} else {
		$mpid_raw = artifiche_get_inquiry_mpid_list();

		if ( $mpid_raw ) {
			$mpid_val_arr = array_filter( array_map( 'absint', explode( ',', $mpid_raw ) ) );

			foreach ( $mpid_val_arr as $mpid_val ) {
				$line = artifiche_build_poster_inquiry_content( $mpid_val );

				if ( $line ) {
					$poster_contents .= ( $poster_contents ? '&#10;&#10;' : '&#10;' ) . $line;
				}
			}
		}
	}

	if ( $poster_contents ) {
		$html = '<textarea name="' . esc_attr( $name ) . '" class="hidden-textarea">' . $poster_contents . '</textarea>';
	}

	return $html;
}

add_action( 'wpcf7_mail_sent', 'artifiche_clear_inquiry_cookies' );

function artifiche_clear_inquiry_cookies( $contact_form ) {
	if ( headers_sent() ) {
		return;
	}

	$cookie_path   = COOKIEPATH ? COOKIEPATH : '/';
	$cookie_domain = COOKIE_DOMAIN;
	$secure        = is_ssl();
	$httponly      = true;
	$past          = time() - YEAR_IN_SECONDS;

	setcookie( 'artifiche_inquiry_pid', '', $past, $cookie_path, $cookie_domain, $secure, $httponly );
	setcookie( 'artifiche_inquiry_mpid', '', $past, $cookie_path, $cookie_domain, $secure, $httponly );
}







// function wpcf7_get_pid_shortcode_handler( $tag ) {



// $name    = $tag['name'];

// $pid_val = $_GET['pid'];

// $html    = '';

// if ( $name == 'posterid' ) {

// $poster_id = get_post_meta( $pid_val, 'plakatnummer', true );

// $html      = '<input type="hidden" name="' . $name . '" value="' . $poster_id . '">';

// } elseif ( $name == 'posterlink' ) {

// $poster_url = get_permalink( $pid_val );

// $html       = '<input type="hidden" name="' . $name . '" value="' . $poster_url . '">';

// } elseif ( $name == 'postertitle' ) {

// $poster_title = get_the_title( $pid_val );

// $html         = '<input type="hidden" name="' . $name . '" value="' . $poster_title . '">';

// }

// return $html;

// }



function get_shop_filter_query() {
	//added by Rilana due to error logs and search function not working
	$query = array(); 
	//
	if ( ! is_admin() && is_post_type_archive( 'product' ) ) {

		$query = array(

			'post_type'      => 'product',

			'post_status'    => 'publish',

			'posts_per_page' => 20,

			// 'suppress_filters' => false,

		);

		$taxonomies = array();

		$metaquery  = array();

		// $artf_nonce = $_REQUEST['artf_filter'];

		//if ( isset( $_GET['name'] ) || isset( $_GET['kategorie'] ) || isset( $_GET['kuenstler'] ) || isset( $_GET['land'] ) || isset( $_GET['stilrichtung'] ) || isset( $_GET['search'] ) || isset( $_GET['sold_posters'] ) || isset( $_GET['sortby'] ) || isset( $_GET['sort'] ) ) {

	if ( isset( $_SERVER['QUERY_STRING'] ) || isset( $_COOKIE['artf_sale_flag'] ) ) {

			$query_string      = array();

			$product_cat_query = array();

			$kategorie         = '';

			$kuenstler         = '';

			$jahr              = '';

			$land              = '';

			$stilrichtung      = '';

			$preisklasse       = '';

			$name              = '';

			$tax               = '';

			$slug              = '';

			// $show_posters        = '';

			$search_term  = '';

			$sold_posters = '';



			if ( isset( $_GET['kategorie'] ) ) {

				$kategorie = $_GET['kategorie'];

			}

			if ( isset( $_GET['kuenstler'] ) ) {

				$kuenstler = $_GET['kuenstler'];

			}

			if ( isset( $_GET['jahr'] ) ) {

				$jahr       = $_GET['jahr'];

				$jahr_array = ( explode( '-', $jahr ) );

			}

			if ( isset( $_GET['land'] ) ) {

				$land = $_GET['land'];

			}

			if ( isset( $_GET['stilrichtung'] ) ) {

				$stilrichtung = $_GET['stilrichtung'];

			}

			if ( isset( $_GET['preisklasse'] ) ) {

				$preisklasse = $_GET['preisklasse'];

				$preis_array = ( explode( '-', $preisklasse ) );

			}

			if ( isset( $_GET['filter_text'] ) ) {

				$name = $_GET['filter_text'];

			}

			if ( isset( $_GET['tax'] ) ) {

				$tax = $_GET['tax'];

			}

			if ( isset( $_GET['slug'] ) ) {

				$slug = $_GET['slug'];

			}



			if ( isset( $_COOKIE['sold_posters'] )  && $_COOKIE['sold_posters'] == true ) {

				$sold_posters = 1;

			} else {

				$sold_posters = 0;

			}



			if ( isset( $_GET['search'] ) ) {

				$search_term = $_GET['search'];

				// $search_term = preg_replace('/[^\da-z ]/i', ' ', $search_term);

				$search_term  = preg_replace( '/[,]/', ' ', $search_term );

				$search_array = explode( ' ', $search_term );

			}

			// print_r($preis_array);

			$i          = 0;

			$m          = 0;

			$s          = 0;

			$taxonomies = array();

			$metaquery  = array();



			if ( $kategorie != 1 && $kategorie != '' ) {

				$taxonomies[] = array(

					'taxonomy' => 'product_cat',

					'field'    => 'slug',

					'terms'    => array( $kategorie ),

				);

				  $i ++;

			}

			if ( $kuenstler != 1 && $kuenstler != '' ) {

				$taxonomies[] = array(

					'taxonomy' => 'kunstler',

					'field'    => 'slug',

					'terms'    => array( $kuenstler ),

				);

				$i ++;

			}

			if ( $land != 1 && $land != '' ) {

				$taxonomies[] = array(

					'taxonomy' => 'pa_land',

					'field'    => 'slug',

					'terms'    => array( $land ),

				);

				$i ++;

			}



			if ( $stilrichtung != 1 && $stilrichtung != '' ) {

				$taxonomies[] = array(

					'taxonomy' => 'pa_stilrichtung',

					'field'    => 'slug',

					'terms'    => array( $stilrichtung ),

				);

				$i ++;

			}

			if ( $name != '' ) {

				$taxonomies[] = array(

					'taxonomy' => $tax,

					'field'    => 'slug',

					'terms'    => array( $slug ),

				);

				$i ++;

			}



			if ( $jahr != 1 && $jahr != '' ) {

				$metaquery[] = array(

					'key'     => 'jahr',

					'value'   => $jahr_array[0],

					'compare' => '>=',

					'type'    => 'NUMERIC',

				);

				$metaquery[] = array(

					'key'     => 'jahr',

					'value'   => $jahr_array[1],

					'compare' => '<=',

					'type'    => 'NUMERIC',

				);



				$m ++;

			}

			if ( $preisklasse != 1 && $preisklasse != '' ) {

				if ( $preis_array[0] != 999999 ) {

					$metaquery[] = array(

						'key'     => '_regular_price',

						'value'   => $preis_array[1],

						'compare' => '<=',

						'type'    => 'NUMERIC',

					);

				}

				if ( (int) $preis_array[0] == 999999 ) {

					   $metaquery[] = array(

						   'key'     => '_regular_price',

						   'value'   => $preis_array[0],

						   'compare' => '=',

						   'type'    => 'NUMERIC',

					   );

				} else {

					$metaquery[] = array(

						'key'     => '_regular_price',

						'value'   => $preis_array[0],

						'compare' => '>',

						'type'    => 'NUMERIC',

					);



				}

				$m ++;

			}

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

			if ( ! empty( $search_array ) ) {

				$metaquery_search = array();

				foreach ( $search_array as $search_term ) {

					if ( $search_term != '' && ! in_array( $search_term, $metaquery_search ) && $s < 7 ) {

						$metaquery_search[] = array(

							'key'     => 'search_term',

							'value'   => $search_term,

							'compare' => 'LIKE',

						);

						$s++;

					}

				}

				if ( $s > 1 ) {

					$metaquery_search['relation'] = 'AND';

				}

			}



			if ( $i > 1 ) {

				   $taxonomies['relation'] = 'AND';



			}

			if ( $m >= 1 ) {

				   $metaquery['relation'] = 'AND';



			}

			if ( $s >= 1 ) {

				$metaquery[] = array( $metaquery_search );



			}



			$orderby           = array(

				'meta_value' => 'DESC',

				'date'       => 'ASC',

			);

			$query['orderby']  = $orderby;

			$query['meta_key'] = 'neu_flag';

			if( isset( $_COOKIE['artf_cc_flag'] ) && $_COOKIE['artf_cc_flag'] == true  ) {

				$metaquery[] = array(

					'key'     => 'collectors_choice_flag',

					'value'   => 1,

					'compare' => '=',

					'type'	  => 'NUMERIC'

				);

			}

			if( isset( $_COOKIE['artf_sale_flag'] ) && $_COOKIE['artf_sale_flag'] == true  ) {

				$purchase_limit = get_field( 'purchase_limit', 'option' );

				$metaquery[] = array(

					'key'     => 'sale_flag',

					'value'   => 1,

					'compare' => '=',

					'type'	  => 'NUMERIC'

				);

				$metaquery[] = array(

					'key'     => '_regular_price',

					'value'   => $purchase_limit,

					'compare' => '<=',

					'type'    => 'NUMERIC',

				);

				$metaquery[] = array(

					'key'     => '_regular_price',

					'value'   => '',

					'compare' => 'NOT IN',

				);

			}

			// var_dump($metaquery);

			if( isset( $_GET['sort'] ) ) {



				switch( $_GET['sort'] ){

					case 'jahr-desc':

						$orderby = array(

							'date' => 'DESC',

						);

						$query['orderby'] = $orderby;

						break;

					case 'jahr-asc':

						$orderby = array(

							'date' => 'ASC',

						);

						$query['orderby'] = $orderby;

						break;

					case 'price-asc':

						$query['order']    = 'ASC';

						$query['meta_key'] = '_price';

						$query['orderby']  = 'meta_value_num';

						break;

					case 'price-desc':

						$query['order']    = 'DESC';

						$query['meta_key'] = '_price';

						$query['orderby']  = 'meta_value_num';

						break;

					default:

						break;

						$query['neu_flag'] = false;

						//set_query_var('neu_flag', false);



				}

			}



			if ( ! empty( $taxonomies ) && ! empty( $metaquery ) && $search_term != '' ) {

				// $query['s']          = $search_term;

				$query['tax_query']  = $taxonomies;

				$query['meta_query'] = $metaquery;



			} elseif ( ! empty( $taxonomies ) && empty( $metaquery ) && $search_term == '' ) {

				$query['tax_query'] = $taxonomies;



			} elseif ( ! empty( $taxonomies ) && ! empty( $metaquery ) && $search_term == '' ) {

				$query['tax_query']  = $taxonomies;

				$query['meta_query'] = $metaquery;



			} elseif ( ! empty( $taxonomies ) && empty( $metaquery ) && $search_term != '' ) {

				// $query['s']         = $search_term;

				$query['tax_query'] = $taxonomies;



			} elseif ( empty( $taxonomies ) && ! empty( $metaquery ) && $search_term == '' ) {

				$query['meta_query'] = $metaquery;



			} elseif ( empty( $taxonomies ) && ! empty( $metaquery ) && $search_term != '' ) {

				// $query['s']          = $search_term;

				$query['meta_query'] = $metaquery;



			} elseif ( empty( $taxonomies ) && empty( $metaquery ) && $search_term != '' ) {

				// $query['s'] = $search_term;



			} else {

			}



				// print_r($taxonomies);



			// }

		} elseif ( isset( $_GET['sortby'] ) && $_GET['sortby'] == 'jahr' ) {

			$stock_arr = ( isset( $_GET['sold_posters'] ) && $_GET['sold_posters'] == 1 ) ?

							 array( 'instock' )

							 :

							 array( 'outofstock', 'instock' );



			$metaquery_j[]       = array(

				'key'     => '_stock_status',

				'value'   => $stock_arr,

				'compare' => 'IN',

			);

			$query['meta_query'] = $metaquery_j;

			$query['orderby']    = 'date';

			$query['order']      = 'ASC';



		} elseif ( isset( $_GET['sortby'] ) && $_GET['sortby'] == 'cchoice' ) {



			$metaquery_cc   = array();

			$metaquery_cc[] = array(

				'key'     => 'collectors_choice_flag',

				'value'   => 1,

				'compare' => '=',

				'type'    => 'NUMERIC',

			);

			$stock_arr      = ( isset( $_GET['sold_posters'] ) && $_GET['sold_posters'] == 1 ) ?

			array( 'instock' )

			:

			array( 'outofstock', 'instock' );



			$metaquery_cc[] = array(

				'key'     => '_stock_status',

				'value'   => $stock_arr,

				'compare' => 'IN',

			);

			$orderby        = 'date';

			$order          = 'ASC';

			   // $query->set( 'orderby', 'date' );



			   // $query->set( 'order', 'ASC' );

			   $query['meta_query'] = $metaquery_cc;

			   $query['orderby']    = $orderby;

			   $query['order']      = $order;



		}elseif ( isset( $_GET['sortby'] ) && $_GET['sortby'] == 'sale' ) {



			$metaquery_cc   = array();

			$metaquery_cc[] = array(

				'key'     => 'sale_flag',

				'value'   => 1,

				'compare' => '=',

				'type'    => 'NUMERIC',

			);

			$stock_arr      = ( isset( $_GET['sold_posters'] ) && $_GET['sold_posters'] == 1 ) ?

			array( 'instock' )

			:

			array( 'outofstock', 'instock' );



			$metaquery_cc[] = array(

				'key'     => '_stock_status',

				'value'   => $stock_arr,

				'compare' => 'IN',

			);

			$orderby        = 'date';

			$order          = 'ASC';

			$query['meta_query'] = $metaquery_cc;

			$query['orderby']    = $orderby;

			$query['order']      = $order;



			//    var_dump($query);

		}

		 elseif ( isset( $_GET['sortby'] ) && $_GET['sortby'] == 'preis-asc' ) {



			$stock_arr = ( isset( $_GET['sold_posters'] ) && $_GET['sold_posters'] == 1 ) ?

							 array( 'instock' )

							 :

							 array( 'outofstock', 'instock' );



			$metaquery_j[]       = array(

				'key'     => '_stock_status',

				'value'   => $stock_arr,

				'compare' => 'IN',

			);

			$query['meta_query'] = $metaquery_j;

			$query['orderby']    = 'meta_value_num';

			$query['order']      = 'ASC';

			$query['meta_key']   = '_price';



		} elseif ( isset( $_GET['sortby'] ) && $_GET['sortby'] == 'preis-desc' ) {



			$stock_arr = ( isset( $_GET['sold_posters'] ) && $_GET['sold_posters'] == 1 ) ?

							 array( 'instock' )

							 :

							 array( 'outofstock', 'instock' );



			$metaquery_j[] = array(

				'key'     => '_stock_status',

				'value'   => $stock_arr,

				'compare' => 'IN',

			);



			$query['meta_query'] = $metaquery_j;

			$query['orderby']    = 'meta_value_num';

			$query['order']      = 'DESC';

			$query['meta_key']   = '_price';



		} else {



			$metaquery             = array(

				'key'     => '_stock_status',

				'value'   => array( 'outofstock', 'instock' ),

				'compare' => 'IN',

			);

			$metaquery['relation'] = 'AND';

			$orderby               = array(

				'meta_value' => 'DESC',

				'date'       => 'ASC',

			);

			$query['orderby']      = $orderby;

			$query['meta_key']     = 'neu_flag';

			$query['meta_query']   = $metaquery;

		}

	} elseif ( ! is_admin() && is_tax() ) {



		$orderby           = array(

			'meta_value' => 'DESC',

			'date'       => 'ASC',

		);

		$query['meta_key'] = 'neu_flag';

		$query['orderby']  = $orderby;

		// array_push($query, array(

		// 'orderby' => $orderby,

		// 'meta_key'=> 'neu_flag'));

			// $query->set( 'orderby', $orderby );

			// $query->set( 'meta_key', 'neu_flag' );

	}

	// $query['orderby'] = 'title';

	// $query['order']   = 'ASC';

	// print_r( $query );

	// die;

	return $query;

}



remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );



function my_woocommerce_widget_shopping_cart_button_view_cart() {

	echo '<a href="' . esc_url( wc_get_cart_url() ) . '" class="button wc-forward">' . esc_html__( 'Zum Warenkorb', 'artifiche' ) . '</a>';

}



add_action( 'woocommerce_widget_shopping_cart_buttons', 'my_woocommerce_widget_shopping_cart_button_view_cart', 10 );



function poster_image_check_init() {

	add_submenu_page(

		'edit.php?post_type=product',       // parent slug

		'Poster Image Check',    // page title

		'Poster Image Check',             // menu title

		'manage_options',           // capability

		'missing-poster-images', // slug

		'missing_poster_images_fun' // callback

	);

}



add_action( 'admin_menu', 'poster_image_check_init' );



function missing_poster_images_fun() {

	?>

		<h1>

			<?php esc_html_e( 'Poster Image Check', 'artifiche' ); ?>

		</h1>

	<?php

	$args = array(

		'post_type'        => 'product',

		'post_status'      => 'publish',

		'orderby'          => 'date',

		'order'            => 'DESC',

		'posts_per_page'   => -1,

		'suppress_filters' => false,

	);



	$all_posts = get_posts( $args );



	// Get the taxonomy's terms

	$publication_terms = get_terms(

		array(

			'taxonomy'   => 'publikationen',

			'hide_empty' => false,

		)

	);

	// $the_query = new WP_Query( $args );

	// $plakatnummer_all = wp_list_pluck( $all_posts, 'plakatnummer' );

	// echo count($all_posts);

	// echo $_SERVER['DOCUMENT_ROOT'];

	echo '<div class="admin-missing-img">';

	$i            = 0;

	$main_content = '<table style="margin-top: 19px;">

	<tr>

		<th>' . __( 'No', 'artifiche' ) . '</th>

		<th>' . __( 'Plakatnummer', 'artifiche' ) . '</th>

		<th>' . __( 'Title', 'artifiche' ) . '</th>

		<th>' . __( 'Folder Path', 'artifiche' ) . '</th>

		<th>' . __( 'Type', 'artifiche' ) . '</th>

		<th>' . __( 'View', 'artifiche' ) . '</th>

	</tr>';

	if ( ! empty( $all_posts ) && is_array( $all_posts ) ) {

		$i = 1;

		foreach ( $all_posts as $pkey => $pvalue ) {

			$image_id    = get_post_meta( $pvalue->ID, 'plakatnummer', true );

			$image_path1 = $_SERVER['DOCUMENT_ROOT'] . '/artifiche-images/posters_large/' . $image_id . '.jpg';

			$image_path2 = $_SERVER['DOCUMENT_ROOT'] . '/artifiche-images/posters_extralarge/' . $image_id . '.jpg';

			// $image_path3 = $_SERVER['DOCUMENT_ROOT'] . '/artifiche-images/posters_small/' . $image_id . '.jpg'; // removed

			if ( ! file_exists( $image_path1 ) || ! file_exists( $image_path2 ) ) {

				$folder_loc = array();

				if ( ! file_exists( $image_path1 ) ) {

					// $folder_loc = 'posters_large';

					array_push( $folder_loc, 'posters_large' );

				}

				if ( ! file_exists( $image_path2 ) ) {

					array_push( $folder_loc, 'posters_extralarge' );

				}

				// if ( ! file_exists( $image_path3 ) ) {

				// array_push( $folder_loc, 'posters_small' ); // removed

				// }

				$folder_loc_noa = implode( ', ', $folder_loc );

				$main_content  .= '

			<tr>

				<td>' . $i . '</td>

				<td>' . $image_id . '</td>

				<td>' . get_the_title( $pvalue->ID ) . '</td>

				<td>' . $folder_loc_noa . '</td>

				<td> Poster </td>

				<td>

				

				<a target="_blank" href="' . get_permalink( $pvalue->ID ) . '">' . __( 'View', 'artifiche' ) . '</a>

				</td>

			</tr>

		';



				$i++;

			}

			// var_dump(file_exists($image_path));

			// echo $image_path;

		}

	}



	$j = 0;

	// Check if any term exists

	if ( ! empty( $publication_terms ) && is_array( $publication_terms ) ) {

		// Run a loop and print them all

		$j = $i;

		if ( $i == 0 ) {

			$j = 1;

		}

		foreach ( $publication_terms as $term ) {

			$image_id   = get_field( 'id', $term );

			$image_path = $_SERVER['DOCUMENT_ROOT'] . '/artifiche-images/publications/' . $image_id . '.jpg';

			if ( ! file_exists( $image_path ) ) {

				$main_content .= '

				<tr>

					<td>' . $j . '</td>

					<td>' . $image_id . '</td>

					<td>' . $term->name . '</td>

					<td>publications</td>

					<td>Publikation</td>

					<td>

					

					<a target="_blank" href="' . get_term_link( $term ) . '">' . __( 'View', 'artifiche' ) . '</a>

					</td>

				</tr>

			';

				$j++;

			}

		}

	}



	if ( $i == 0 && $j == 0 ) {

		$main_content .= '<tr><td colspan="6" style="text-align: center;">' . __( 'No missing images found', 'artifiche' ) . '</td></tr>';

		// echo '<div class="no-poster-missing updated" style="margin: 5px 1px 2px;"><h2>' . __( 'No missing images found', 'artifiche' ) . '</h2></div>';

	}

	if ( $i != 0 ) {

		$tot = $i - 1;

		echo '<div class="no-poster-missing notice notice-error" style="margin: 5px 1px 2px;padding: 5px 3px 7px 7px;">' . __( ' Missing image(s) in Posters : ', 'artifiche' ) . $tot . '</div>';

	}

	if ( $j != 0 ) {

		$tot = $j - $i;

		if ( $i == 0 ) {

			$tot = $j - 1;

		}

		echo '<div class="no-poster-missing notice notice-error" style="margin: 5px 1px 2px;padding: 5px 3px 7px 7px;">' . __( ' Missing image(s) in Publikationen : ', 'artifiche' ) . $tot . '</div>';

	}

	$main_content .= '</table>';

	echo $main_content . '</div>';



	// Get the taxonomy's terms

	$terms = get_terms(

		array(

			'taxonomy'   => 'publikationen',

			'hide_empty' => false,

		)

	);



	// if ( $the_query->have_posts() ) {

	// echo '<ul>';

	// while ( $the_query->have_posts() ) {

	// $the_query->the_post();

	// echo '<li>' . get_the_title() . '</li>';

	// }

	// echo '</ul>';

	// } else {

	// no posts found

	// }

	/* Restore original Post Data */

	wp_reset_postdata();



	// var_dump($all_posts);

	// wp_reset_postdata();

}



