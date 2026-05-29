<?php
/*
 * Template Name: Artfiche Produkt Stichwoerter
 */
get_header();
$current_term  = get_query_var( 'tagslug' );
$current_term  = artf_replace_umlaut($current_term);
$schlagworter = str_replace("_", "*", $current_term );
$schlagworter = str_replace("-", " ", $schlagworter );
$schlagworter = str_replace("*", "-", $schlagworter );



// apply_filters( 'sanitize_title', $current_term );
 // echo $current_term;

// iconv('cp1252', 'UTF-8', html_entity_decode($current_term, ENT_QUOTES, 'cp1252'));

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


	<h1 class="page-title"><?php echo $schlagworter;?></h1>
	
</header>
	<?php

		the_archive_description( '<div class="archive-description">', '</div>' );
	?>
	</div>
	<?php
		
        // $current_term = get_queried_object()->term_id;
        
        $current_slug = sanitize_title( $schlagworter );
		$posters      = '';
		$labels       = '';
		$poster_title = '';
		$künstler_vorname = '';
		$künstle_lastname = '';
		$term_list = "";

      /*  $alltags     = array(
			'taxonomy'   => array( 'product_tag' ), // taxonomy name
			'field'      => 'term_id',
			'orderby'    => 'name',
			'order'      => 'ASC',
			'hide_empty' => true,
		);
        $tagslists   = get_terms($alltags);// print_r($terms);
        // var_dump($tagslists);
		$i            = 1;
		$term_options = '';
		foreach ( $tagslists as $termone ) :
			if ( $current_slug == $termone->slug ) {
				$selected = 'selected="selected"';
				// echo $termone->term_id;
			} else {
				$selected = '';
			}
			$term_name = str_replace(" ", "-", $termone->name );
			$term_link = get_home_url().'produkt-stichwoerter/'.$term_name;
			$term_options .= '<option value="' . $term_link . '" ' . $selected . '>' . $termone->name . '</option>';
		endforeach;
		wp_reset_postdata();

		$term_list = '<div class="cat-filter">
			<label for="name">' . __( 'Stichwörter:', 'artifiche' ) . '</label>
			<select onchange="javascript:location.href = this.value;" class="custom-select js_select">' . $term_options . '</select>
		</div>';
*/

$orderby = array(
			'meta_value' => 'DESC',
			'date'       => 'ASC',
		);
$args = array(
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
           'value' => $schlagworter, //array
           'compare' => 'LIKE',
       ),
   )
 );
 $serialized_args = base64_encode( serialize( $args ) );
 $query = new WP_Query($args);

			/* Start the Loop */
		$poster_single = '';
		// $j = 1;
		while ( $query->have_posts() ) :
				$query->the_post();

				$labels                 = '';
				$image_id               = get_post_meta( $post->ID, 'plakatnummer', true );
				$new_flag               = get_post_meta( $post->ID, 'neu_flag', true );
				$collectors_choice_flag = get_post_meta( $post->ID, 'collectors_choice_flag', true );
				$jahr = get_post_meta( $post->ID, 'jahr', true );
			  // $labels .= '<div class="poster-label">';
			  $product            = wc_get_product( $post->ID );
			  $stock_status       = $product->get_stock_status();
			if ( $new_flag != '' && $new_flag == 1 ) {
				$labels .= '<span class="poster-l-yellow">' . __( 'NEU', 'artifiche' ) . '</span>';
			}
			if ( $collectors_choice_flag != '' && $collectors_choice_flag == 1 ) {

				 if( $new_flag != '' && $new_flag == 1 ) $labels .='<span class="separator">/</span>';
				 
				$labels .= '<span class="poster-l-red">' . __( 'Collector’s Choice', 'artifiche' ) . '</span>';
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
                      $künstle_name = get_field( 'gestalter_name', $cd );

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
				   		<a href="'. get_permalink( $post->ID ) .'">
			            <div class="poster">
			                <img  src="' . site_url() . '/artifiche-images/posters_large/' . $image_id . '.jpg" alt="'. $alt_text .'" />
			            </div>
			            </a>
			            <div class="caption">
			                ' . $labels . '
			               <a href="'. get_permalink( $post->ID ).'">' . $poster_title . '</a>
			                ' . $künstler_name . '
			            </div>
			        </div>';

			?>
				<!-- poster-row repeats -->
			   <?php
				/*
				$j++;

					   if( $j > 4 ){
						$j = 1;
						$posters .= '</div>';
					 }*/
			endwhile;

			wp_reset_query();

			$html = '<div class="container"><div class="home-collection-list similartag-list">' . $term_list . '<div class="posters tax-all-list poster_grid">'
			. $posters .
			'</div></div>
			<input type="hidden" name="similarload_type" id="similarload_type" value="product_tag">
			<input type="hidden" id="tag_query" name="tag_query" value="' . $serialized_args . '">
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
