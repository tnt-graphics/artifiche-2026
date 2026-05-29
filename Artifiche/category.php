<?php

get_header();

$homeclass = '';

if ( ! is_front_page() ) {

	$homeclass = 'otherpage-cls';

}

?>



	<main id="primary" class="site-main">

<?php

$news_cat_auto = get_queried_object_id();

$cat           = get_queried_object();

$cat_name      = $cat->cat_name;

$args          = array(

	'post_type'        => 'post',

	'posts_per_page'   => 5,

	'orderby'          => 'date',

	'order'            => 'DESC',

	'suppress_filters' => false,

	'category'         => $news_cat_auto,



);

$myposts = get_posts( $args );
$single_news = "";
$html = "";
?>

		

			

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>



	<div class="entry-content <?php echo $homeclass; ?>">

			<div class="">

				<div class="single-column">

				<div class="breadcrumbs ">

				<div id="crumbs">

					<?php echo get_breadcrumb(); ?>

				</div>

			</div>

			<h1 class="page-title"><?php echo $cat_name; ?></h1>

			<?php

			 $single_news .= '<input type="hidden" name="news_view_type" id="news_view_type" value="normal">

             <input type="hidden" id="news_cat_val" name="news_cat_val" value="' . $news_cat_auto . '">';

			foreach ( $myposts as $spost ) {

				setup_postdata( $spost );

				$recent_news = '';

				$news_option = get_field( 'news_list_options', $spost->ID );

				if ( ! empty( $news_option ) && ! empty( $news_option['news_option'] )

				&& $news_option['news_option'] == 'dni' && ! empty( $news_option['news_image'] ) ) {

					$news_image     = $news_option['news_image'];

					$size           = 'thumbnail';

					$news_image_url = $news_image['sizes'][ $size ];

					$news_image_alt = artf_get_alt_text( $spost->ID );



					$recent_news .= '<div class="news-list-posters"><img src="' . esc_url( $news_image_url ) . '" alt="' . $news_image_alt . '"></div>';

				} elseif ( ! empty( $news_option ) && ! empty( $news_option['news_option'] )

				&& $news_option['news_option'] == 'dp' && ! empty( $news_option['select_posters'] ) ) {

					$select_posters = $news_option['select_posters'];

					$recent_news   .= '<div class="news-list-posters">';

					foreach ( $select_posters as $posterkey => $poster_value ) {

						$poster_id      = get_post_meta( $poster_value, 'plakatnummer', true );

						$news_image_alt = artf_get_alt_text( $poster_value );

						$recent_news   .= '<a href="' . get_permalink( $poster_value ) . '">

            <img src="' . site_url() . '/artifiche-images/posters_large/' . $poster_id . '.jpg" alt="' . $news_image_alt . '" />

            </a>';

					}

					$recent_news .= '</div>';

					// $recent_news    = '<img src="' . $news_image_url . '" alt="' . $news_image_alt . '">';

				}

				$catinfo  = get_category( $news_cat_auto );

				$haystack = array( 'news', 'news-en' );

				if ( in_array( $catinfo->slug, $haystack ) ) {

					$post_date = get_the_time( 'd.m.Y', $spost->ID ) . ' / ';

				} else {

					$post_date = '';

				}

					$recent_news .= '<div class="news-list-content"><h2>' . get_the_title( $spost->ID ) . '</h2>

        <p>' . $post_date . get_the_excerpt( $spost->ID ) . '</p>

        </div>';



					$news_btns_all    = '';

					$news_btn1        = '';

					$news_link_option = get_field( 'news_list_linking_options', $spost->ID );

				if ( ! empty( $news_link_option['button_text_1'] ) ) {

					if ( $news_link_option['link_option1'] === '3' ) {

						$news_btn1 = '<a class="outline-btn" href="' . $news_link_option['int_ext_url1'] . '">' . $news_link_option['button_text_1'] . '</a>';

					} elseif ( $news_link_option['link_option1'] === '2' ) {

						$news_btn1 = '<a class="outline-btn" target="_blank" href="' . $news_link_option['int_ext_url1'] . '">' . $news_link_option['button_text_1'] . '</a>';

					} elseif ( $news_link_option['link_option1'] === '1' ) {

						$news_btn1 = '<a class="outline-btn" href="' . get_permalink( $spost->ID ) . '">' . $news_link_option['button_text_1'] . '</a>';

					} else {

						$news_btn1 = '<a class="outline-btn" href="#">' . $news_link_option['button_text_1'] . '</a>';

					}

				}



				$news_btn2 = '';

				if ( ! empty( $news_link_option['button_text_2'] ) ) {

					if ( $news_link_option['link_option2'] === '3' ) {

						$news_btn2 = '<a class="outline-btn" href="' . $news_link_option['int_ext_url2'] . '">' . $news_link_option['button_text_2'] . '</a>';

					} elseif ( $news_link_option['link_option2'] === '2' ) {

						$news_btn2 = '<a class="outline-btn" target="_blank" href="' . $news_link_option['int_ext_url2'] . '">' . $news_link_option['button_text_2'] . '</a>';

					} elseif ( $news_link_option['link_option2'] === '1' ) {

						$news_btn2 = '<a class="outline-btn" href="' . get_permalink( $spost->ID ) . '">' . $news_link_option['button_text_2'] . '</a>';

					} else {

						$news_btn2 = '<a class="outline-btn" href="#">' . $news_link_option['button_text_2'] . '</a>';

					}

				}



				$news_btns_all = '<div class="news-links">' . $news_btn1 . $news_btn2 . '</div>';



					$single_news .= '<div class="news-list-single">' . $recent_news . $news_btns_all . '</div>';

			}

			wp_reset_postdata();

			$loadmoretxt = __( 'Weitere News', 'artifiche' );

			if ( ! empty( $loadmore_btn_txt ) ) {

				$loadmoretxt = $loadmore_btn_txt;

			}

			if ( empty( $myposts ) ) {

				$html .= '<div><h3>' . __( 'No results found', 'artifiche' ) . '</h3></div>';

			} else {

				$html .= '<div class="artifiche-newslist ">' . $single_news . '</div>

    <div class="artifiche-readmore">

    

        <a href="javascript:void(0);" id="news-loadmore" class="outline-btn loadmore"><i class="icon-plus"></i>

        ' . $loadmoretxt . '</a>

        </div>

    ';

			}

			echo $html;



			?>

			

			

	</div>

	</div>

	</div><!-- .entry-content -->





</article><!-- #post-<?php the_ID(); ?> -->

			

			

	</main><!-- #main -->



<?php

get_sidebar();

get_footer();

