<?php
/**
 * Adds Blogfeatured__Widget widget.
 */
class Blog_featured_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'Blog_featured_Widget', // Base ID
			esc_html__( 'Tin tức nổi bật', 'threeus' ), // Name
			array( 'description' => esc_html__( 'Hiển thị những bài viết tin tức nổi bật', 'threeus' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		$before_widget = $args['before_widget'];
		$after_widget = $args['after_widget'];

		echo $before_widget;
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		?>
		<?php
			$args = array(
		       'posts_per_page' => 3,
		       'post_type' => 'post',
		       'meta_key' => 'wpb_post_views_count',
		       'orderby'=> 'meta_value_num', 
		       'order' => 'DESC',
		    );

		    $the_query = new WP_Query( $args );
		    if ( $the_query->have_posts() ) :
			    while ($the_query->have_posts() ) : $the_query->the_post();
					get_template_part( 'content', 'featured' );				
				endwhile; 
				wp_reset_postdata();
			endif;
			?>
		<?php

		echo $after_widget;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Tin nổi bật', 'threeus' );
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'threeus' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}

} // class Blog_featured_Widget

// register Blog_featured_Widget widget
function register_Blog_featured_Widget() {
    register_widget( 'Blog_featured_Widget' );
}
add_action( 'widgets_init', 'register_Blog_featured_Widget' );