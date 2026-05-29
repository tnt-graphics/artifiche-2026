<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Artifiche
 */

// Safety net: EN /collections/ URLs may hit archive.php instead of the taxonomy template.
// Uses URL-aware helper from functions.php (not is_tax() alone).
if ( function_exists( 'artifiche_should_use_kollektionen_template' ) && artifiche_should_use_kollektionen_template() ) {
	$kollektionen_template = get_template_directory() . '/woocommerce/taxonomy-kollektionen.php';
	if ( file_exists( $kollektionen_template ) ) {
		load_template( $kollektionen_template );
		exit;
	}
}

get_header();
?>

	<main id="primary" class="site-main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_type() );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
