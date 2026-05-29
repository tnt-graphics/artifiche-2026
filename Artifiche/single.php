<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Artifiche
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php
		if ( has_post_thumbnail()) {
			echo '<div class="banner post-banner"><img src="'.get_the_post_thumbnail_url(null,'full').'" alt="" /></div>';
		 }

		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
