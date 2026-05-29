<?php



/*

Element Description: Artifiche Textblock

*/





// Map the block with vc_map()

vc_map(

	array(

		'name'        => __( 'Artifiche Textblock', 'artifiche' ),

		'base'        => 'artifiche_display_textblock',

		'icon'        => get_template_directory_uri() . '/img/logo2.svg',

		'category'    => __( 'Artifiche Elements', 'artifiche' ),

		'params'      => array_merge(

			array(

				

				array(

					'type'        => 'textarea_html',

					'heading'     => esc_html__( 'Text', 'artifiche' ),

					'param_name'  => 'content',

					'admin_label' => true,

				),

			

			)

		),

	)

);



add_shortcode( 'artifiche_display_textblock', 'artifiche_display_textblock_fun' );





// Element HTML

function artifiche_display_textblock_fun( $atts, $content = null ) {

	global $post;

	$sentences = preg_split('/(?<=[.?!;])\s+(?=\p{Lu})/', $content);



	$ii = 0;

	$paragraphs = array();

	foreach ( $sentences as $value ) {

		if ( isset($paragraphs[$ii]) ) { $paragraphs[$ii] .= $value; }

		else { $paragraphs[$ii] = $value; }

		if ( 20 < str_word_count($paragraphs[$ii]) ) {

			$ii++;

		}

	}

$html = '';

$html .= '<div class="desktop-only">

			<p>'. $content .'</p>

	</div>
	<div class="mobile-only">';

if(isset($paragraphs[0])) {
	$html .= '

	<div class="brief-txt">

		

		'. $paragraphs[0] .'

		<span class="ellipsis">...</span>

	</div>';
}
if(isset($paragraphs[1])) {
	$html .= '<div class="moretext">

	 '.$paragraphs[1] .'

	

	</div>';
}

$html .= '<a class="moreless-button">'. __( 'mehr', 'artifiche' ) .'</a>

</div>';
return $html;



}