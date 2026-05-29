<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Artifiche
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>

<link rel="apple-touch-icon" sizes="57x57" href="<?php echo site_url(); ?>/artifiche-images/favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="<?php echo site_url(); ?>/artifiche-images/favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo site_url(); ?>/artifiche-images/favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo site_url(); ?>/artifiche-images/favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo site_url(); ?>/artifiche-images/favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo site_url(); ?>/artifiche-images/favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo site_url(); ?>/artifiche-images/favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo site_url(); ?>/artifiche-images/favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo site_url(); ?>/artifiche-images/favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192" href="<?php echo site_url(); ?>/artifiche-images/favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo site_url(); ?>/artifiche-images/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="<?php echo site_url(); ?>/artifiche-images/favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo site_url(); ?>/artifiche-images/favicon/favicon-16x16.png">
<link rel="manifest" href="<?php echo site_url(); ?>/artifiche-images/favicon/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="<?php echo site_url(); ?>/artifiche-images/favicon/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php echo get_field( 'google_analytics_code', 'option' ); ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div class="preloader"><div class="loader"></div></div>
<?php wp_body_open(); ?>
<header class="header">
	<?php
	// if ( is_account_page() ) {
	// echo 'yes' ;

	// } else {
	// echo 'no' ;
	// }die;
	$header_logo1       = get_field( 'header_logo_1', 'option' );
	$size               = 'medium';
	if($header_logo1 ) {
		$header_logo1_thumb = $header_logo1['sizes'][ $size ];
		$header_logo1_alt   = $header_logo1['alt'];
	}
	
	$header_logo2       = get_field( 'header_logo_2', 'option' );
	if($header_logo2) {
		$header_logo2_thumb = $header_logo2['sizes'][ $size ];
		$header_logo2_alt   = $header_logo2['alt'];
	}
	

	$sale_option = get_field( 'sale_option', 'option' );
	// var_dump($sale_option);die;
	if ( ! empty( $sale_option ) && $sale_option[0] == 'true' ) {
		?>
		<script>
		jQuery(document).ready(function(){
			jQuery('.sale-menu').show();
		});
		</script>
		<?php
	} else {
		?>
<script>
		jQuery(document).ready(function(){
			jQuery('.sale-menu').hide();
		});
		</script>

		<?php
	}


	?>
		<div class="container">
			<div class="site-logo">
				<a class="lrg-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php if ( ! empty( $header_logo1 ) ) : ?>
				<img src="<?php echo esc_url( $header_logo1_thumb ); ?>" alt="<?php echo esc_attr( $header_logo1_alt ); ?>" />
				<?php endif; ?>
				</a>			
			</div>
			<div class="header-right">		
				<div class="search-container">
			  	<div class="search-icon">
					<svg xmlns="http://www.w3.org/2000/svg" width="24.326" height="24.326" viewBox="0 0 24.326 24.326">
					  <path id="lupe" d="M23.784,21.172l-5.879-5.88c-.028-.028-.061-.046-.09-.072a9.757,9.757,0,1,0-2.6,2.6c.026.029.044.061.072.089l5.88,5.88a1.848,1.848,0,0,0,2.613-2.613M9.75,16.2A6.454,6.454,0,1,1,16.205,9.75,6.463,6.463,0,0,1,9.75,16.2" fill="#0058a1"/>
					</svg>
			  	</div>
			  	<div class="search-bar">
					<?php get_search_form(); ?>
			  	</div>
			</div>
			
			<?php
			if ( is_user_logged_in() ) {
				$user_logged = 'active';
			} else {
				$user_logged = '';
			}
			?>

			<a href="<?php echo get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ); ?>" rel="nofollow" class="user-icon <?php echo $user_logged; ?>">
			<i class="icon-profile">
<svg xmlns="http://www.w3.org/2000/svg" width="32" height="36.004" viewBox="0 0 32 36.004">
			  <g id="user" transform="translate(-1112.999 -284)">
				<path id="Pfad_86" data-name="Pfad 86" d="M15.394,15.5h0a7.749,7.749,0,1,0-5.485-2.271A7.758,7.758,0,0,0,15.4,15.5M11.571,3.924A5.41,5.41,0,1,1,15.4,13.16h0a5.41,5.41,0,0,1-3.824-9.236" transform="translate(1113.61 284)" fill="#0058a1"/>
				<path id="Pfad_87" data-name="Pfad 87" d="M31.918,27.2a21.259,21.259,0,0,0-.3-2.322,17.93,17.93,0,0,0-.592-2.382A12.139,12.139,0,0,0,30,20.212a9.1,9.1,0,0,0-1.631-2.088,7.365,7.365,0,0,0-2.409-1.489,8.146,8.146,0,0,0-3.008-.537l-.12.007a3.859,3.859,0,0,0-1.986.805c-.4.255-.859.549-1.343.853a7.162,7.162,0,0,1-1.617.7,6.1,6.1,0,0,1-3.813-.009,7.087,7.087,0,0,1-1.552-.67c-.509-.319-.972-.611-1.376-.871A3.852,3.852,0,0,0,9.162,16.1L9.041,16.1a8.4,8.4,0,0,0-3.008.537,7.43,7.43,0,0,0-2.419,1.5A8.964,8.964,0,0,0,2,20.2,12.211,12.211,0,0,0,.971,22.512a18.52,18.52,0,0,0-.589,2.365,21.919,21.919,0,0,0-.3,2.338C.031,27.9.005,28.625.006,29.3a7.01,7.01,0,0,0,2.161,5.362A7.522,7.522,0,0,0,7.181,36.6c.1,0,.207,0,.311-.007H24.454a7.609,7.609,0,0,0,5.413-1.96,6.945,6.945,0,0,0,2.126-5.26c.007-.731-.017-1.459-.074-2.168m-3.763,5.589a5.086,5.086,0,0,1-3.649,1.287H7.44a5.027,5.027,0,0,1-3.563-1.255,4.517,4.517,0,0,1-1.36-3.467c0-.675.023-1.336.069-1.963a18.789,18.789,0,0,1,.267-2.069,16.022,16.022,0,0,1,.507-2.041,9.775,9.775,0,0,1,.822-1.834,6.512,6.512,0,0,1,1.152-1.484,4.9,4.9,0,0,1,1.59-.984,5.7,5.7,0,0,1,2.027-.374,1.355,1.355,0,0,1,.665.292l.116.085c.424.272.914.582,1.484.94a9.521,9.521,0,0,0,2.111.922,8.507,8.507,0,0,0,5.307.01,9.651,9.651,0,0,0,2.176-.95c.545-.343,1.034-.653,1.451-.922l.117-.085a1.347,1.347,0,0,1,.665-.292,5.755,5.755,0,0,1,2.029.375,4.828,4.828,0,0,1,1.576.969,6.5,6.5,0,0,1,1.172,1.508,9.633,9.633,0,0,1,.814,1.816,16.007,16.007,0,0,1,.51,2.056,19.305,19.305,0,0,1,.269,2.062V27.4c.051.634.073,1.287.067,2.012a4.452,4.452,0,0,1-1.326,3.379" transform="translate(1113 283.404)" fill="#0058a1"/>
			  </g>
			</svg>
	</i>
</a>
<?php
$wishlist_page_id = get_option( 'yith_wcwl_wishlist_page_id' );
?>
<a href="<?php echo get_permalink( $wishlist_page_id ); ?>" rel="nofollow" class="add-to-wishlist">
<i class="icon-wishlist">
<svg xmlns="http://www.w3.org/2000/svg" width="35" height="30.001" viewBox="0 0 35 30.001">
  <path id="favorit" d="M17.5,30H17.5a3.222,3.222,0,0,1-2.055-.74c-1.054-.879-2.08-1.713-3.018-2.478l-.638-.517a68.873,68.873,0,0,1-8.217-7.348A12.415,12.415,0,0,1,0,10.571,10.591,10.591,0,0,1,2.914,3.086,10.274,10.274,0,0,1,10.341,0a9.666,9.666,0,0,1,5.851,1.931A11.355,11.355,0,0,1,17.5,3.068a11.447,11.447,0,0,1,1.307-1.139A9.766,9.766,0,0,1,24.678,0h.1a10.238,10.238,0,0,1,7.3,3.074A10.6,10.6,0,0,1,35,10.555a12.449,12.449,0,0,1-3.575,8.378,68.725,68.725,0,0,1-8.208,7.333c-1.11.9-2.362,1.918-3.66,3A3.233,3.233,0,0,1,17.5,30M17.5,27.54H17.5a.7.7,0,0,0,.445-.16c1.306-1.083,2.564-2.1,3.678-3.009a66.817,66.817,0,0,0,7.992-7.134A10.014,10.014,0,0,0,32.5,10.5a8.154,8.154,0,0,0-2.245-5.739,7.717,7.717,0,0,0-5.5-2.3h-.12a7.229,7.229,0,0,0-4.321,1.428,8.967,8.967,0,0,0-1.812,1.806l-1,1.336L16.5,5.7a8.963,8.963,0,0,0-1.813-1.8A7.214,7.214,0,0,0,10.38,2.459h-.121A7.731,7.731,0,0,0,4.728,4.774,8.141,8.141,0,0,0,2.5,10.516a9.988,9.988,0,0,0,2.876,6.7,66.716,66.716,0,0,0,7.6,6.84H13l1.018.825c.945.77,1.976,1.61,3.038,2.495a.7.7,0,0,0,.443.159Z" transform="translate(-0.001 0.001)" fill="#0058a1"/>
</svg>
	</i>
	<?php
	$wishlist_count = do_shortcode( '[yith_wcwl_items_count]' );
	if ( $wishlist_count >= 1 ) {
		?>
<span class="count " id="wishlist-items-cnt"><?php echo $wishlist_count; ?></span>
		<?php } else { ?>
<span id="wishlist-items-cnt"></span>
<?php } ?>
</a>		
			<?php echo do_shortcode( '[woo_cart_but]' ); ?>	
			<div class="menu-container" onclick="this.classList.toggle('active')">
				<div class="hamburger">
					<div class="line"></div>
					<div class="line"></div>
					<div class="line"></div>
				</div>
			</div>
			<div class="lang-switcher">
				<?php
				ob_start();
				do_action( 'wpml_add_language_selector' );
				$wpml_desktop_switcher = trim( ob_get_clean() );
				if ( $wpml_desktop_switcher !== '' ) {
					echo $wpml_desktop_switcher; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				} elseif ( function_exists( 'artifiche_render_kollektionen_language_switcher' ) ) {
					artifiche_render_kollektionen_language_switcher();
				}
				?>
			</div>
			</div>	
			
			<div class="mobile-lang-switcher">
	<?php
			$languages = apply_filters('wpml_active_languages', NULL, array('skip_missing' => 0));
			
			if (!empty($languages)) {
				// Sort languages: German first
				$ordered_languages = [];
				foreach ($languages as $lang) {
					if ($lang['language_code'] === 'de') {
						$ordered_languages[0] = $lang;
					} else {
						$ordered_languages[1] = $lang;
					}
				}
				ksort($ordered_languages);
			
				// Render languages
				foreach ($ordered_languages as $lang) {
					$label = ($lang['language_code'] === 'de') ? 'Deutsch' : 'English';
					$class = $lang['active'] ? 'current-lang' : '';
					echo '<a href="' . esc_url($lang['url']) . '" class="' . $class . '">' . esc_html($label) . '</a>';
				}
			}
			?>


	</div>

			<?php
			wp_nav_menu(array(
				'theme_location'  => 'mega_menu',
				'container'       => 'div',
				'container_class' => 'menu-mega-menu-container',
				'menu_class'      => 'mega-menu',
				'fallback_cb'     => false,
			));
			?>

			<div class="mobile-search-container">
				  
				  <div class="search-bar">
					<?php get_search_form(); ?>
				  </div>
				  
				  <div class="search-icon">
					  <svg xmlns="http://www.w3.org/2000/svg" width="24.326" height="24.326" viewBox="0 0 24.326 24.326">
						<path id="lupe" d="M23.784,21.172l-5.879-5.88c-.028-.028-.061-.046-.09-.072a9.757,9.757,0,1,0-2.6,2.6c.026.029.044.061.072.089l5.88,5.88a1.848,1.848,0,0,0,2.613-2.613M9.75,16.2A6.454,6.454,0,1,1,16.205,9.75,6.463,6.463,0,0,1,9.75,16.2" fill="#0058a1"/>
					  </svg>
					</div>
			</div>
	</div>
	
</header>
