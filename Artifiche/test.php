<?php 
/**
 * * Template Name: test11
 * */

get_header();
//failed

$mailer = WC()->mailer();
$mails = $mailer->get_emails();echo "asasssssssssssssssssssssssssssssssssssss";
 print_r($mails);
if ( ! empty( $mails ) ) {
    foreach ( $mails as $mail ) {
        if ( $mail->id == 'customer_on_hold_order' ) {
        $mail->trigger( 28683 );
        }
     }
}

exit;
// 	$some_args = array(
//     'tax_query' => array(
//         'taxonomy' => 'Kollektionen',
        
//      ),
//     'posts_per_page' => -1,
//     'post_type' => 'product',
//     'post_status'      => 'publish',
// 		'orderby'          => 'date',
// 		'order'            => 'DESC',
// 		's'                => $query,
// 		'suppress_filters' => false,
// );
// $categories = get_terms( ['taxonomy' => 'Kollektionen'] );print_r($categories); 



?>




<?php
// echo "xj";
// echo bp_wpml_custom_language_selector();
// echo print_taxonomy_ranks( get_the_terms( 10130, 'product_cat' ) );


//     $product_array = get_the_terms( 10395, 'product_cat');print_r($product_array);
     
// $product_cat = '';
//       if( ! empty( $product_array ) ){
//                     $product_cat = '<li><strong class="list-title">'.__( 'Kategorie:','artifiche' ).'</strong>';
//                     foreach( $product_array as $cat ){
//                         // $product_cat .= "saa";
//                         if( $cat->parent == 0 ){
//                             $product_cat .=  '<span class="list-info main"><a href="'. get_term_link( $cat ) .'">'.$cat->name.'</a></span>';
//                         }else{
//                             $product_cat .=  '<span class="list-info"><a href="'. get_term_link( $cat ) .'">'.$cat->name.'</a></span>';
//                         }
                        
//                     }
//                     $product_cat .= '</li>';
//                 }

// echo $product_cat;
// $orderby = array(
// 			'meta_value' => 'DESC',
// 			'date'       => 'ASC',
// 		);

// $q1 = get_posts(array(
//         //'fields' => 'ids',
//         'post_type' => 'product',
//         's' => 'bally'
// ));

// $q2 = get_posts(array(
// 			'post_type'        => 'product',
// 			'post_status'      => 'publish',
// 			'orderby'          => 'date',
// 			 'order'            => 'ASC',
// 			//'offset'           => $count,
// 			// 's' => 'bally',
// 			//'posts_per_page'   => 20,
// 			'suppress_filters' => false,
// 			'meta_query'       =>  array(
// 				'relation' => 'AND',
// 				array(
// 					'key' => 'schlagworter',
// 					'value'    => 'bally',
// 					'compare'  => 'LIKE',
// 				),
// 				array(
// 					'key' => '_stock_status',
// 						'value' => array( 'outofstock', 'instock' ),
// 						'compare' => 'IN',
// 				)
// 			)
					
// 		));

// // 
// $unique = array_merge( $q1, $q2 );

// // $unique = array_unique( $q );
// // print_r( $unique );

// 	$i=1;
// 	$myposts      = get_posts(array(
//     'post_type' => 'product',
//     'post__in' => $unique,
//     'post_status' => 'publish',
//     'posts_per_page' => -1
// ));
//  // print_r($myposts);
// 	foreach ( $myposts as $spost ){

// 		 echo $product_id = $spost->ID;
		//echo "aaaa";
		 // $product = wc_get_product($product_id);//($product);
		 // echo $product->get_price();echo "ssss";
//   $internetpreis_flag = get_post_meta( $product_id, 'internetpreis_flag', true );
//     $regular_price = $spost->regular_price;
//     $sale_price = $spost->sale_price;
//     //if( empty( $regular_price ) ) return;
//     if( ( $regular_price >= 1001 ) && $internetpreis_flag == 0 ){

//     	echo '<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">'. get_woocommerce_currency_symbol() .'</span> '. $regular_price .' '.__( '(unverbindliche Preisempfehlung)','artifiche' ). '</span>';
//     }

//     if( ( $regular_price <= 1000 ) || $internetpreis_flag == 1){
//    echo '<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">'. get_woocommerce_currency_symbol() .'</span> '. $sale_price .'</span>';
// }
// echo "**************";

	// }
echo 'aaaaaaaaaaaaaaaaaaa';




// $q1 = get_posts(array(
//          'fields' => 'ids',
//         'post_type' => 'product',
//         's' => 'historical'
// ));

// $q2 = get_posts(array(
//        'fields' => 'ids',
//         'post_type' => 'product',
//         'meta_query' => array(
//             array(
//                'key' => 'schlagworter',
//                'value' => 'historical',
//                'compare' => 'LIKE'
//             )
//          )
// ));

// $unique = array_unique( array_merge( $q1, $q2 ) );

// $posts = get_posts(array(
//     'post_type' => 'product',
//     'post__in' => $unique,
//     'post_status' => 'publish',
//     'posts_per_page' => -1
// ));

// // print_r($q2);
// // print_r($q1);
// 	foreach ( $posts as $spost ){

// $id = $spost;
//  $label = get_the_title( $id);
// $data[] = array(
// 					'value' => $id,
// 					'label' => $label,
// 					'group' => 'product',
// 				);

// }
// print_r($data);
// 	foreach ( $q1 as $spost ){
// echo $spost->ID;echo "-";

// }

if(!empty(trim(strip_tags(get_post_field( 'post_content', 24771 ))))){

echo '111'.trim(strip_tags(get_post_field( 'post_content', 24771 )));


echo '<p>'. strip_tags(get_post_field( 'post_content', 24771 )).'</p>';
//get_post_field( 'post_content', 24771 );

}

// $st = str_replace('&nbsp;', '', strip_tags(get_post_field( 'post_content', $post->ID )));
//       if($st != '')
//         echo 'aa'.trim($st);

exit;

$product = wc_get_product(23095);
echo $stock_status = $product->get_stock_quantity();


exit;

$category_detail = get_the_terms( 25148, 'kunstler');

print_r($category_detail);
exit;


$pattern = array("'é'", "'è'", "'ë'", "'ê'", "'É'", "'È'", "'Ë'", "'Ê'", "'á'", "'à'", "'ä'", "'â'", "'å'", "'Á'", "'À'", "'Ä'", "'Â'", "'Å'", "'ó'", "'ò'", "'ö'", "'ô'", "'Ó'", "'Ò'", "'Ö'", "'Ô'", "'í'", "'ì'", "'ï'", "'î'", "'Í'", "'Ì'", "'Ï'", "'Î'", "'ú'", "'ù'", "'ü'", "'û'", "'Ú'", "'Ù'", "'Ü'", "'Û'", "'ý'", "'ÿ'", "'Ý'", "'ø'", "'Ø'", "'œ'", "'Œ'", "'Æ'", "'ç'", "'Ç'");

$replace = array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E', 'a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A', 'A', 'o', 'o', 'o', 'o', 'O', 'O', 'O', 'O', 'i', 'i', 'i', 'I', 'I', 'I', 'I', 'I', 'u', 'u', 'u', 'u', 'U', 'U', 'U', 'U', 'y', 'y', 'Y', 'o', 'O', 'a', 'A', 'A', 'c', 'C'); 

echo $chain = preg_replace($pattern, $replace, 'Hans');


// echo $schlagworter =    iconv('utf-8', 'ISO-8859-1//TRANSLIT', 'Hans THÖNI');
// echo $schlagworter = mb_convert_encoding('Hans TH%C3%96NI', "HTML-ENTITIES", "UTF-8"); 

echo "nbzxbzx";
$orderby = array(
      'meta_value' => 'DESC',
      'date'       => 'ASC',
    );
$args = array(
  'fields' => 'ids',
  'post_type'        => 'product',
    'post_status'      => 'publish',
    'orderby'          => $orderby,
    //'order'            => 'ASC',
    'suppress_filters' => false,
    'posts_per_page'    => 20,
   'meta_query' => array(
    array(
          'key' => 'neu_flag',
        ),
       array(
           'key' => 'schlagworter',
           'value' => $chain, //array
           'compare' => 'LIKE',
       ),
   )
 );

print_r(get_posts( $args));



exit;

$serch_term = 'Bieri Ch.';
// $serch_term = 'Bieri';
$q1 = array(
         'fields' => 'ids',
        'post_type' => 'product',
        's' => $serch_term,
        'posts_per_page' => -1,
        'suppress_filters' => false,
);

$q2 = array(
       'fields' => 'ids',
        'post_type' => 'product',
        'posts_per_page' => -1,
        'suppress_filters' => false,
        'meta_query' => array(
            array(
               'key' => 'plakatnummer',
               'value' => $serch_term,
               'compare' => 'LIKE'
               // 'type' => 'NUMERIC'
            )
         )
);

// if ( 0 === strlen( $q1['s'] ) ) {
// 		unset( $q1['s'] );
// 	}
// add_filter( 'posts_search', 'vc_search_by_title_only', 500, 2 );
	 $q1_args = get_posts( $q1 );//print_r($q1_args);
	$q2_args = get_posts( $q2 );//print_r($q2_args);

$unique = array_unique( array_merge( $q1_args, $q2_args ) );

$posts = get_posts(array(
    'post_type' => 'product',
    'post__in' => $unique,
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'suppress_filters' => false,
));

$data = array();
	//$posts = get_posts( $args );
	if ( is_array( $posts ) && ! empty( $posts ) ) {
		foreach ( $posts as $post ) {
			$id = $post;
 $label = get_the_title( $id);
$data[] = array(
					//'value' => $id,
					'label' => $label,
					//'group' => 'product',
				);
		}
	}

	print_r($data);die;
	// echo "dsds";print_r($unique);

get_footer();
