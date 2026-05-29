<?php



/* Newsletter widget* */



add_action( 'widgets_init', 'mfc_init' );



function mfc_init() {

	register_widget( 'mfc_widget' );

}



class mfc_widget extends WP_Widget {



	public function __construct() {

		$widget_details = array(

			'classname'   => 'mfc_widget',

			'description' => 'Add Newsletter.',

		);



		parent::__construct( 'mfc_widget', 'Artifiche Newsletter ', $widget_details );



		// add_action('admin_enqueue_scripts', array($this, 'mfc_assets'));

	}



	public function widget( $args, $instance ) {

		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {

			// echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];

		}

		global $post;

		if(isset($post) && isset($post->ID)) {
			$colour  = get_field( 'bottom_widget', $post->ID );
		}

		$options = get_option( 'theme_options' );

		?>





		<div class="home-news-letter">

			<h3 class="widget-title"><?php echo $instance['title']; ?></h3>

			<div class="textwidget">

			<div class="newsletter">

				<?php echo wpautop( esc_html( $instance['description_news_letter'] ) ); ?>

			</div>

			<div class="side-content">

				<?php echo do_shortcode( $instance['shortcode'] ); ?>

			</div>

			</div>

		</div>





		<?php

		echo $args['after_widget'];

	}



	public function update( $new_instance, $old_instance ) {

		return $new_instance;

	}



	public function form( $instance ) {



		$title = '';

		if ( ! empty( $instance['title'] ) ) {

			$title = $instance['title'];

		}



		$shortcode = '';

		if ( ! empty( $instance['shortcode'] ) ) {

			$shortcode = $instance['shortcode'];

		}



		$description_news_letter = '';

		if ( ! empty( $instance['description_news_letter'] ) ) {

			$description_news_letter = $instance['description_news_letter'];

		}

		?>

		<p>

			<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:', 'artifiche' ); ?></label>

			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />

		</p>

		<p>

			<label for="<?php echo $this->get_field_name( 'shortcode' ); ?>"><?php _e( 'News letter shortcode:', 'artifiche' ); ?></label>

			<input class="widefat" id="<?php echo $this->get_field_id( 'shortcode' ); ?>" name="<?php echo $this->get_field_name( 'shortcode' ); ?>" type="text" value="<?php echo esc_attr( $shortcode ); ?>" />

		</p>           



		<p>

			<label for="<?php echo $this->get_field_name( 'description_news_letter' ); ?>"><?php _e( 'Description For news letter:' ); ?></label>

			<textarea class="widefat" id="<?php echo $this->get_field_id( 'description_news_letter' ); ?>" name="<?php echo $this->get_field_name( 'description_news_letter' ); ?>" type="text" ><?php echo esc_attr( $description_news_letter ); ?></textarea>

		</p>   



		<?php

	}



}

