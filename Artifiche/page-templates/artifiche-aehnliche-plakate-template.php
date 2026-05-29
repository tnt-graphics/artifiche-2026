<?php

/*

 * Template Name: Artfiche Ähnliche Plakate Page

 */

get_header();

$pid = '';

$term_list = "";

if( get_query_var( 'pid' ) != ''){

	$pid = get_query_var( 'pid' );

}

// else if( get_query_var( 'category' ) != ''){

// 	echo 'category'.$cat = get_query_var( 'category' );

// }







	$homeclass = '';

	if (!is_front_page()) {

		$homeclass = "otherpage-cls";

	}

?>



<main id="primary" class="site-main">

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<!-- .entry-header -->



	<div class="entry-content <?php echo $homeclass; ?>">

		<div class="single-column">

			<div class="breadcrumbs ">

			<div id="crumbs">

				<?php echo get_breadcrumb(); ?>

			</div>

		</div>

		<header class="entry-header">





	<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>

	

</header>

	<?php



		the_content( '<div class="archive-description">', '</div>' );

	?>

	</div>

	<?php

		// $current_term = get_queried_object()->term_id;

		// $termargs     = array(

		// 'taxonomy'   => array( 'product_cat' ), // taxonomy name

		// 'field'      => 'term_id',

		// 'orderby'    => 'name',

		// 'order'      => 'ASC',

		// 'hide_empty' => true,

		// );

		$category_detail= get_the_terms( $pid, 'product_cat' );

		$cat_id_array = array();



if ( ! empty( $category_detail ) ) {

		foreach ( $category_detail as $cat ) {

			array_push( $cat_id_array, $cat->term_id );

		}

	}



	$orderby = array(

		'meta_value' => 'DESC',

		'date'       => 'ASC',

	);

	// print_r($cat_id_array);

	$args            = array(

		'posts_per_page'   => 20,

		'post_type'        => 'product',

		'suppress_filters' => false,

		'orderby'          => $orderby,

		'tax_query'        => array(

			array(

				'taxonomy' => 'product_cat',

				'field'    => 'id',

				'terms'    => $cat_id_array,

			),

		),

		'meta_query'       => array(

			array(

				'key' => 'neu_flag',

			),

		),

	);

	$serialized_args = base64_encode( serialize( $args ) );

	$products        = new WP_Query( $args );



		 // $args = array( 'post_type' => 'product', 'posts_per_page' => 1, 'product_cat' => 'shoes', 'orderby' => 'rand' );

	// $loop = new WP_Query( $args );

		$posters      = '';

		$labels       = '';

		$poster_title = '';







			/* Start the Loop */

		$poster_single = '';

		// $j = 1;

	while ( $products->have_posts() ) :

		$products->the_post();



			$labels                 = '';

			$image_id               = get_post_meta( $post->ID, 'plakatnummer', true );

			$new_flag               = get_post_meta( $post->ID, 'neu_flag', true );

			$collectors_choice_flag = get_post_meta( $post->ID, 'collectors_choice_flag', true );

			$jahr                   = get_post_meta( $post->ID, 'jahr', true );

		  // $labels .= '<div class="poster-label">';

		$product            = wc_get_product( $post->ID );

		$stock_status       = $product->get_stock_status();

		if ( $new_flag != '' && $new_flag == 1 ) {

			$labels .= '<span class="poster-l-yellow">' . __( 'NEU', 'artifiche' ) . '</span>';

		}

		if ( $collectors_choice_flag != '' && $collectors_choice_flag == 1 ) {



			if ( $new_flag != '' && $new_flag == 1 ) {

				$labels .= '<span class="separator">/</span>';

			}



			$labels .= '<span class="poster-l-red">' . __( 'Collectors Choice', 'artifiche' ) . '</span>';

		}

		if ( $stock_status == 'outofstock' ) {

			$labels .= '<span class="poster-l-grey">' . __( 'SOLD', 'artifiche' ) . '</span>';

		}



			$collectors_choice_flag = get_post_meta( $post->ID, 'collectors_choice_flag', true );

			 $poster_title          = '<b class="bold-txt">' . get_the_title() . '</b>';

			 $category_detail       = get_the_terms( $post->ID, 'kunstler' );



		$k_flag = false;

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

                

                if( $k_flag ) $künstler_name = '<span class="kunstler_name">'.$jahr.'</span>';

                

	$alt_text = artf_get_alt_text( $post->ID );

		  // $labels .='</div>';



		// if( $j % 4 == 1)

		// $posters .= '<div class="poster-row">';



			   $posters .= '<div class="poster-single">

				   <a href="' . get_permalink( $post->ID ) . '">

			            <div class="poster">

			                <img  src="' . site_url() . '/artifiche-images/posters_large/' . $image_id . '.jpg" alt="'. $alt_text .'" />

			            </div>

			            </a>

			            <div class="caption">

			                ' . $labels . '

			                <a href="' . get_permalink( $post->ID ) . '">' . $poster_title . '</a>

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



			wp_reset_query();



			$html = '<div class="container"><div class="home-collection-list similartag-list">' . $term_list . '<div class="posters poster_grid">'

			. $posters .

			'</div></div>

			<input type="hidden" name="similarload_type" id="similarload_type" value="similar_product">

			<input type="hidden" id="similar_query" name="similar_query" value="' . $serialized_args . '">

			<div class="artifiche-readmore">

		

			<a href="javascript:void(0);" id="similar-loadmore" class="outline-btn loadmore"><i class="icon-plus"></i>

			' . __( 'Weitere', 'artifiche' ) . '</a>

			</div></div>';



		echo $html;

	?>





	</div><!-- .entry-content -->



	</article><!-- #post-<?php the_ID(); ?> -->

</main><!-- #main -->

<?php

get_footer(); ?>

