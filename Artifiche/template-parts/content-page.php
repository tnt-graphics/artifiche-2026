<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Artifiche
 */
$homeclass = '';
if ( ! is_front_page() ) {
	$homeclass = 'otherpage-cls';
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php
if ( ( ! is_front_page() ) ) {

	if ( is_account_page() || is_cart() || is_checkout() ) {
		$class = '';
	} else {
		$class = 'min-col';
	}
	$wishlist_class = '';
	if ( defined( 'YITH_WCWL' ) && isset($wishlist_token) && $wishlist_token != '' ) {
		$wishlist_class = 'wishlist-listing';
	} else {
		$wishlist_token = "";
	}


	?>
	<div class="entry-content <?php echo $homeclass; ?>">
			<div class="container <?php echo $wishlist_token; ?>">
				<div class="single-column <?php echo $class; ?>">
				<div class="breadcrumbs ">
				<div id="crumbs">
					<?php echo get_breadcrumb(); ?>
				</div>
			</div>
	<?php } ?>			
		<?php
		if ( ! empty( get_field( 'custom_page_name' ) ) ) {
			echo '<h1 class="page-title">' . get_field( 'custom_page_name' ) . '</h1>';
		} elseif ( is_account_page() ) {
			echo '<h1 class="page-title">' . __( 'My account', 'artifiche' ) . '</h1>';
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
		<?php if ( ( ! is_front_page() ) ) { ?>
	</div>
	</div>
	</div><!-- .entry-content -->
	<?php } ?>

</article><!-- #post-<?php the_ID(); ?> -->
