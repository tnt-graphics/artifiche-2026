<?php
/*
 * Template Name: Künstler Detail Page
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
		<div class=" col-list-outer mb-8">
		<div class="single-column">
		<div class="breadcrumbs ">
			<div id="crumbs">
				<?php echo get_breadcrumb(); ?>
			</div>
		</div>
		<header class="entry-header">

<?php 
	$kunstler = get_query_var( 'kunstler' );

if( $kunstler ){

	$kunstler_name = $kunstler;

	$kunstler = get_term_by( 'slug', $kunstler_name, 'kunstler' );
	if( !empty( $kunstler ) ){
		$name = $kunstler->name;
		 $künstler_vorname = get_field( 'gestalter_vorname', $kunstler );
         $künstle_lastname = get_field( 'gestalter_name', $kunstler );

		echo '<h1 class="page-title">'. $künstler_vorname . ' '. $künstle_lastname .'</h1>';
	
?>
	
</header>

	<?php
			$bio_lang = get_field( 'bio_lang', $kunstler );
			echo '<p class="kunstler-det">'. $bio_lang .'</p>';
			echo '<a href="'. get_term_link( $kunstler ) .'" class="common-link">'. __( 'Plakate von', 'artifiche' ).' '.$künstler_vorname . ' '. $künstle_lastname .' </a>';
			}
		}
	?>
	</div>
	</div>

	</div><!-- .entry-content -->

	</article><!-- #post-<?php the_ID(); ?> -->
</main><!-- #main -->
<?php
get_footer(); ?>
