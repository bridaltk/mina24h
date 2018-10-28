<?php
/**
 * Adds Widget_Info_footer widget.
 */
function register_Info_footer() {
	register_widget( 'Info_footer' );
}
add_action( 'widgets_init', 'register_Info_footer' );

class Info_footer extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'Info_footer', // Base ID
			esc_html__( 'Infomation top footer', 'threeus' ), // Name
			array( 'description' => esc_html__( ' Display top footer information ', 'threeus' ), ) // Args
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
	      
		);
		$instance = wp_parse_args( (array) $instance, $default);

		?>
		
    	
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
		$widget_id =  $args['widget_id'];

		echo $before_widget;
	    ?>

	    <?php if( have_rows('info_footer','widget_' . $widget_id) ): ?>
			    <div class="row">
			    	<?php while( have_rows('info_footer','widget_' . $widget_id) ): the_row();

						$title = get_sub_field('title');
						$content_1 = get_sub_field('content_1');
						$content_2 = get_sub_field('content_2');
					?>
					<div class="col-lg-4 col-md-4 col-sm-12 col-12">
						<div class="associate-wrapper">
							<div class="associate">
								<p class="associate-title"><?php echo $title; ?></p>
								<p><?php echo $content_1; ?></p>
								<p><?php echo $content_2; ?></p>
							</div><!-- .associate -->
						</div>
					</div>
					<?php endwhile; ?>
				</div>
		<?php endif; ?>


	    <?php
			echo $after_widget;
		}



} // class Blog_Widget
