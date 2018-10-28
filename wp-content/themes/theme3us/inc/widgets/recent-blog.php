<?php
/**
 * Adds Recent_Blog_Widget widget.
 */
class Recent_Blog_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'Recent_Blog_Widget', // Base ID
			esc_html__( 'Tin tức', 'threeus' ), // Name
			array( 'description' => esc_html__( 'Hiển thị những bài viết tin tức mới nhất bao gồm hình ảnh', 'threeus' ), ) // Args
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
		<ul>
			<?php 
				$args = array(
					'post_type' => 'post',
					'posts_per_page' => $instance['limit'],
					'offset' => $instance['offset'],
				);
                $my_query = new WP_Query( $args );
                if ( $my_query->have_posts() ) :
                    while ( $my_query->have_posts() ) : $my_query->the_post();
            ?>
			<li class="clearfix">
				<a class="thumb" href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail('thumbnail'); ?>
				</a>
				<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
				<span><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' trước'; ?></span>
			</li>
			<?php endwhile; wp_reset_postdata(); ?> 
            <?php else: ?>
                <li><?php _e('Không có bài viết nào!'); ?></li>
            <?php endif; ?>
		</ul>
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
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Tin tức', 'threeus' );
		$limit = ! empty( $instance['limit'] ) ? $instance['limit'] : 5;
		$offset = ! empty( $instance['offset'] ) ? $instance['offset'] : 0;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'threeus' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php esc_attr_e( 'Limit:', 'threeus' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" type="text" value="<?php echo esc_attr( $limit ); ?>">
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>"><?php esc_attr_e( 'Offset:', 'threeus' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'offset' ) ); ?>" type="text" value="<?php echo esc_attr( $offset ); ?>">
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
		$instance['limit'] = ( ! empty( $new_instance['limit'] ) ) ? strip_tags( $new_instance['limit'] ) : 5;
		$instance['offset'] = ( ! empty( $new_instance['offset'] ) ) ? strip_tags( $new_instance['offset'] ) : 0;

		return $instance;
	}

} // class Recent_Blog_Widget

// register Recent_Blog_Widget widget
function register_Recent_Blog_Widget() {
    register_widget( 'Recent_Blog_Widget' );
}
add_action( 'widgets_init', 'register_Recent_Blog_Widget' );