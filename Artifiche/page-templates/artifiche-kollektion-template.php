<?php
/*
 * Template Name: Artfiche Kollektion Page
 */
get_header();
$homeclass = '';
if (!is_front_page()) {
	$homeclass = "otherpage-cls";
}
?>

<main id="primary" class="site-main">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<!-- .entry-header -->

	<div class="entry-content <?php echo $homeclass; ?>">
	<div class="">
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
		the_content();
	?>

	</div>
	
	</div>
	</div><!-- .entry-content -->

	</article><!-- #post-<?php the_ID(); ?> -->
</main><!-- #main -->
<?php
get_footer(); ?>
