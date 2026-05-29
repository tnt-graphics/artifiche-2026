<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Artifiche
 */
// global $template;
// echo basename($template);
?>

<footer>
	
			<div class="footer_light">
				<div class="container">
					<?php dynamic_sidebar( 'footer_widget_1' ); ?>
					<?php dynamic_sidebar( 'footer_widget_2' ); ?>
					<?php dynamic_sidebar( 'footer_widget_3' ); ?>
				</div>
			</div>
			<div class="footer_dark">
				<div class="container">
				<div class="footer-txt">
					<div class="copyright-txt">
					<?php
					// echo $options['copyright'];
					_e( '© ', 'artifiche' );
					echo date( 'Y' ) . ' ';
					the_field( 'copyright_contents', 'option' );
					?>
					</div>
					<div class="footer-links">
				<a href="<?php the_field( 'presse_link', 'option' ); ?>"><?php _e( 'Presse', 'artifiche' ); ?> / </a>
					<a href="<?php the_field( 'links', 'option' ); ?>"><?php _e( 'Links', 'artifiche' ); ?> / </a>
					<a href="<?php the_field( 'agbs_url', 'option' ); ?>"><?php _e( 'AGBs', 'artifiche' ); ?> / </a>
					<a href="<?php the_field( 'datenschutzerklarung_url', 'option' ); ?>"><?php _e( 'Datenschutzerklärung', 'artifiche' ); ?></a>
				</div>
			   </div>													
				<ul  class="social-share">
				<li class="instagram"><a href="<?php the_field( 'instagram_url', 'option' ); ?>" target="_blank"><i class="icon-instagram"></i></a></li>
					<li class="facebook"><a href="<?php the_field( 'facebook_url', 'option' ); ?>" target="_blank"><i class="icon-facebook"></i></a></li>
					<li class="gruppe"><a href="<?php the_field( 'gruppe_url', 'option' ); ?>" target="_blank"><i class="icon-yelp"></i></a></li>
					<li class="linkedin"><a href="<?php the_field( 'linkedin_url', 'option' ); ?>" target="_blank"><i class="icon-linkedin"></i></a></li>
					<li class="pinterest"><a href="<?php the_field( 'pinterest_url', 'option' ); ?>" target="_blank"><i class="icon-pinterest"></i></a></li>
					
					
				</ul>
				</div>			
			</div>
		</footer>

	</main>
<?php wp_footer(); ?>
<script src="<?php echo get_template_directory_uri() . '/js/imagesloaded.pkgd.min.js'; ?>"></script>
<script src="<?php echo get_template_directory_uri() . '/js/jquery.matchHeight.js'; ?>"></script>
<script src="<?php echo get_template_directory_uri() . '/js/magnific-popup.js'; ?>"></script>
<script src="<?php echo get_template_directory_uri() . '/js/jquery.minicolors.min.js'; ?>"></script>
<script src="<?php echo get_template_directory_uri() . '/js/select2.min.js'; ?>"></script>
<script src="<?php echo get_template_directory_uri() . '/js/de.js'; ?>"></script>
<script src="<?php echo get_template_directory_uri() . '/js/fastClick.js'; ?>"></script>
<script src="<?php echo get_template_directory_uri() . '/js/custom.js'; ?>"></script>
<script src="<?php echo get_template_directory_uri() . '/js/admin.js'; ?>"></script>
<script>
		var getLangCode = '<?php echo apply_filters( 'wpml_current_language', null ); ?>';
if (getLangCode == 'en') {
	jQuery(".newsletter-lang select option[value=en]").attr('selected','selected');
}else{
	jQuery(".newsletter-lang select option[value=de]").attr('selected','selected');
}
</script>
</body>
</html>
