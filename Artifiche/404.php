<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Artifiche
 */

get_header();
?>

	<main id="primary" class="site-main container">

		<section class="error-404 not-found ">
			<header class="page-header">
				<h1 class="page-title"><?php esc_html_e( 'This page could not be found.', 'artifiche' ); ?></h1>
			</header><!-- .page-header -->

			<div class="page-content not-found-content">
				<p><?php esc_html_e( 'Maybe you try one of the links below or use the poster search?', 'artifiche' ); ?></p>

					<?php
					get_search_form();

					the_widget( 'WP_Widget_Recent_Posts' );
					?>

			</div><!-- .page-content -->
		</section><!-- .error-404 -->

	</main><!-- #main -->

<?php
get_footer();
