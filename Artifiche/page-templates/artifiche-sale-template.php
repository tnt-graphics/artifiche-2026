<?php
/*
 * Template Name: Artfiche Sale Page
 */
get_header();
$homeclass = '';
if ( ! is_front_page() ) {
	$homeclass = 'otherpage-cls';
}
?>

<main id="primary" class="site-main">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<!-- .entry-header -->

	<div class="entry-content <?php echo $homeclass; ?>">
	<div class="container">
		<div class=" col-list-outer">
		<div class="single-column min-col">
		<div class="breadcrumbs ">
			<div id="crumbs">
				<?php echo get_breadcrumb(); ?>
			</div>
		</div>
		<header class="entry-header">

<?php
	the_title( '<h1 class="page-title">', '</h1>' );
?>
	
</header>
</div>
<?php
$purchase_limit = get_field( 'purchase_limit', 'option' );
		$args   = array(
			'post_type'      => 'product',
			'posts_per_page' => -1,
			'orderby'        => 'post_date',
			'order'          => 'DESC',
			'post_status'    => 'publish',
			'meta_query'     => array(
				array(
					'key'     => 'sale_flag',
					'value'   => '1',
					'compare' => '=',
				),
				array(
				'key'     => '_regular_price',
				'value'   => $purchase_limit,
				'compare' => '<=',
				'type'    => 'NUMERIC',
				),
				array(
					'key'     => '_regular_price',
					'value'   => '',
					'compare' => 'NOT IN',
					)
			),
		);

		$products = new WP_Query( $args );
			if ( $products->have_posts() ) :
			echo '<ul class="products posters poster_grid">';
			/* Start the Loop */
			$poster_single = '';
			// $j = 1;
			while ( $products->have_posts() ) :
				$products->the_post();

				wc_get_template_part( 'content', 'product' );

			endwhile;
			echo '</ul>';
			else :
				the_content();
			endif;
			wp_reset_postdata();

			?>
	</div>
	
	</div>
	</div><!-- .entry-content -->

	</article><!-- #post-<?php the_ID(); ?> -->
</main><!-- #main -->
<?php
get_footer(); ?>
