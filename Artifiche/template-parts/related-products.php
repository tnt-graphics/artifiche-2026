
<?php
$product_cat = get_the_terms( $post->ID, 'product_cat' );
$main_jahr   = get_post_meta( $post->ID, 'jahr', true );
$cat_arr     = array();
if ( ! empty( $product_cat ) ) {
	foreach ( $product_cat as $cat ) {
		array_push( $cat_arr, $cat->term_id );
	}
}
// var_dump($cat_arr);
if ( ! empty( $cat_arr ) ) {
	$related_posters_title = get_field( 'product_detail_page', 'option' );
	$related_posters_title = $related_posters_title['related_posters_title'];
	if ( empty( $related_posters_title ) ) {
		$related_posters_title = __( 'Plakate in dieser Kategorie', 'artifiche' );
	}

	$main_content = '';
	$yearargs  = array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'post__not_in'   => array( get_the_ID() ),
		'tax_query'      => array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'term_id', // This is optional, as it defaults to 'term_id'
				'terms'    => $cat_arr,
				// 'terms'    => $cat_arr,
				// 'terms'    => array(30149, 30147, 30148, 30150),
				'operator' => 'IN', // Possible values are 'IN', 'NOT IN', 'AND'.
			),
		),
	);
	$yearposts = get_posts( $yearargs );
	$yrshigh   = array();
	$yrslow    = array();
	foreach ( $yearposts as $key => $posty ) {
		$yr_jahr = get_post_meta( $posty->ID, 'jahr', true );
		if ( $yr_jahr >= $main_jahr ) {
			array_push( $yrshigh, $yr_jahr );
		} else {
			array_push( $yrslow, $yr_jahr );
		}
	}
	wp_reset_postdata();
	$yrshigh = array_unique( $yrshigh );
	$yrslow  = array_unique( $yrslow );
	sort( $yrshigh );
	rsort( $yrslow );
	if ( count( $yrshigh ) >= 2 ) {
		$output_high  = array_slice( $yrshigh, 0, 2 );
		$filtered_arr = $output_high;
		$output_low   = array_slice( $yrslow, 0, 2 );
		$filtered_arr = array_merge( $filtered_arr, $output_low );
	} elseif ( count( $yrshigh ) == 1 ) {
		$output_high  = array_slice( $yrshigh, 0, 1 );
		$filtered_arr = $output_high;
		$output_low   = array_slice( $yrslow, 0, 3 );
		$filtered_arr = array_merge( $filtered_arr, $output_low );
	} elseif ( count( $yrshigh ) < 1 ) {
		$output_low   = array_slice( $yrslow, 0, 4 );
		$filtered_arr = $output_low;
	}
	$yr_meta_query = array();
	foreach ( $filtered_arr as $key => $filtered_arr_val ) {
		$cur_arr = array(
			'key'     => 'jahr',
			'value'   => $filtered_arr_val,
			'compare' => '=',
			'type'    => 'NUMERIC',
		);
		array_push( $yr_meta_query, $cur_arr );
	}
	$yr_meta_query['relation'] = 'OR';
	$args                      = array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => 4,
		'post__not_in'   => array( get_the_ID() ),
		'order'          => 'DESC',
		'orderby'        => 'meta_value',
		'no_found_rows'  => true,
		'meta_query'     => $yr_meta_query,
		'tax_query'      => array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'term_id', // This is optional, as it defaults to 'term_id'
				'terms'    => $cat_arr,
				'operator' => 'IN', // Possible values are 'IN', 'NOT IN', 'AND'.
			),
		),
	);
	$products                  = new WP_Query( $args );
	if ( $products->have_posts() ) {
		while ( $products->have_posts() ) {

			$products->the_post();
			$jahr_arr = array(); // Initializing $jahr_arr as an empty array
			$jahr = get_post_meta( get_the_ID(), 'jahr', true );
				array_push( $jahr_arr, $jahr );
				$image_id               = get_post_meta( get_the_ID(), 'plakatnummer', true );
				$new_flag               = get_post_meta( get_the_ID(), 'neu_flag', true );
				$collectors_choice_flag = get_post_meta( get_the_ID(), 'collectors_choice_flag', true );
				$product = wc_get_product( get_the_ID() );
				$regular_price      = $product->get_regular_price();
				$regular_price      = get_post_meta( get_the_ID(), 'preiskategorie_chf', true );
				$sale_price         = $product->get_sale_price();
				$internetpreis_flag = get_post_meta( get_the_ID(), 'internetpreis_flag', true );
				$stock_status       = $product->get_stock_status();
				$sale_flag   = get_post_meta( $post->ID, 'sale_flag', true );
				$sale_option = get_field( 'sale_option', 'option' );
				$labels = '';
				$purchase_limit     = get_field( 'purchase_limit', 'option' );
				$purchase_upper     = $purchase_limit + 1;
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
			if (! empty( $sale_option ) && $sale_option[0] == 'true' && get_dynamic_price_html( 'normal', true ) == true 
			&& $sale_flag == 1 ) {
			$labels .= '<span class="poster-l-cyan">' . __( 'SALE', 'artifiche' ) . '</span>';
		}
			$category_detail = get_the_terms( get_the_ID(), 'kunstler' );

			 if( ! empty( $category_detail ) ){
                    
                    $i = 0;
                    $count = count( $category_detail );
                    foreach( $category_detail as $cd ){
                  
                      $künstler_vorname = get_field( 'gestalter_vorname', $cd );
                      	$künstle_lastname = get_field( 'gestalter_name', $cd );
                    // echo sanitize_title( 'Künstler' );
                      	if( $künstler_vorname != '' || $künstle_lastname != '')
                      		$gestler = $künstler_vorname.' '. $künstle_lastname;
                      	else
                      		$gestler = explode("(", $cd->name)[0];


					  if ($gestler != '' ) {         

                      	$coma = ( $gestler != '') ? ',' : '';

                        $künstler_name = '<a href="'. get_term_link( $cd ).'"><span class="kunstler_name">'.$gestler.$coma.$jahr.'</span></a>';    
                        $künstler_woy = '<a href="'. get_term_link( $cd ).'"><span class="kunstler_name">'.$gestler.'</span></a>';
                     
					  }else{
					  	$k_flag = true;
					  	
					  }
                      	
                    }                    
                }else{
                	$k_flag = true;
                }
				
				if (isset($k_flag) && $k_flag) {
					$künstler_name = '<span class="kunstler_name">'.$jahr.'</span>';
					// Rest of your code
				}

                
               // old code created error in PHP 8
			   // if( $k_flag ) $künstler_name = '<span class="kunstler_name">'.$jahr.'</span>';

$alt_text = artf_get_alt_text( $post->ID );

$main_content .= '<div class="poster-single"><a href="'.get_permalink( get_the_ID() ).'">
<div class="poster" style="height: 369.34px;">
<img src="'.site_url() . '/artifiche-images/posters_large/' . $image_id . '.jpg" alt="'.$alt_text.'" />
</div>
</a>
<div class="caption">'.$labels.'
<h5><a href="'.get_permalink( get_the_ID() ).'">'.get_the_title( get_the_ID() ).'</a></h5>
'.$künstler_name.'
</div>
</div>
';
		}
	}
	wp_reset_query();
if (!empty($main_content)) {
	?>
<div class="container related-posters">
<h2><?php echo $related_posters_title; ?></h2>
<ul class="products posters poster_grid" id="poster">
	<?php
	echo $main_content;
	?>
</ul>
</div>
<?php } } ?>

