<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Artifiche
 */

global $template;
$tem = basename($template);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( (! is_home() || ! is_front_page()) && ! is_single() && $tem != 'index.php' ) {
			the_title( '<h2 class="entry-title df"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		}
		?>
			
	</header><!-- .entry-header -->

	<div class="entry-content">
				<div class="single-column">
				<div class="breadcrumbs ">
				<div id="crumbs">
					<?php echo get_breadcrumb(); ?>
				</div>
			</div>
			</div>
			
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'artifiche' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links ">' . esc_html__( 'Pages:', 'artifiche' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->
	<footer class="entry-footer">
		
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
