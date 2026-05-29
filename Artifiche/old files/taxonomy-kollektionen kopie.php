<?php
/**
 * Kollektionen taxonomy template (theme root loader).
 *
 * WordPress looks here before archive.php. The layout lives in woocommerce/.
 *
 * @package Artifiche
 */

$kollektionen_template = get_template_directory() . '/woocommerce/taxonomy-kollektionen.php';

if ( file_exists( $kollektionen_template ) ) {
	load_template( $kollektionen_template );
	exit;
}

// Fallback should not normally run.
get_header();
echo '<main id="primary" class="site-main"><p>' . esc_html__( 'Kollektionen template missing.', 'artifiche' ) . '</p></main>';
get_footer();
