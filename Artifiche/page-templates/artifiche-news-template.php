<?php
/*
 * Template Name: News page
 */

get_header();
$homeclass = '';
if (!is_front_page()) {
	$homeclass = "otherpage-cls";
}
?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();
?>
			
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content <?php echo $homeclass; ?>">
			<div class="">
				<div class="single-column">
				<div class="breadcrumbs ">
				<div id="crumbs">
					<?php echo get_breadcrumb(); ?>
				</div>
			</div>
			
		<?php
		if ( ! empty( get_field( 'custom_page_name' ) ) ) {
			echo '<h1 class="page-title">' . get_field( 'custom_page_name' ) . '</h1>';
		} else {
			if ( ( ! is_front_page() ) && ! is_singular( 'post' ) ) {
				the_title( '<h1 class="page-title">', '</h1>' );
			}
		}

		?>
	<?php

		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'artifiche' ),
				'after'  => '</div>',
			)
		);
		?>
	</div>
	</div>
	</div><!-- .entry-content -->


</article><!-- #post-<?php the_ID(); ?> -->
<?php

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>
			
	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
