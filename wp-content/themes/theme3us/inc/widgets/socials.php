<?php
/**
 * Adds Widget_Socials widget.
 */
// register Socials widget
function register_Widget_Socials() {
	register_widget( 'Widget_Socials' );
}
add_action( 'widgets_init', 'register_Widget_Socials' );
class Widget_Socials extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'Widget_Socials', // Base ID
			esc_html__( 'Mạng xã hội', 'threeus' ), // Name
			array( 'description' => esc_html__( 'Widget hiển thị mạng xã hội', 'threeus' ), ) // Args
);
	}


	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$default = array(
			'title'	=>	'Tiêu đề widget',
		);
		$instance = wp_parse_args( (array) $instance, $default);
		$title = esc_attr( $instance['title'] );

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Tiêu đề:', 'threeus' ); ?></label>
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
	function update( $new_instance, $old_instance ) {
		$instance= $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
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

		include get_template_directory() .'/template/socials.php';

		echo $after_widget;
	}



} // class Socials
