<?php
/**
 * Widget API: WP_Widget_OurService class
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.4.0
 */

/**
 *
 * @since 2.8.0
 *
 * @see WP_Widget
 */
class WP_Widget_OurService extends WP_Widget {

	/**
	 * Sets up a new Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget_ourservice_entries',
			'description' => __( 'Display Our Brands.','megashop' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'ourservice-posts', __( 'TT Our Services','megashop' ), $widget_ops );
		$this->alt_option_name = 'widget_ourservice_entries';
	}

	/**
	 * Outputs the content for the current Our Brand Posts widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Recent Posts widget instance.
	 */
	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Our Brands','megashop' );

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$id = rand();
		$allowed_html_array = wp_kses_allowed_html('post');
		echo wp_kses($args['before_widget'], $allowed_html_array);
                if ( $title ) {
			echo wp_kses($args['before_title'], $allowed_html_array) . $title . wp_kses($args['after_title'], $allowed_html_array);
		} 
                echo wp_kses($args['after_widget'], $allowed_html_array);
                
	}

	/**
	 * Handles updating the settings for the current Testimonial Posts widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		
		return $instance;
	}

	/**
	 * Outputs the settings form for the Testimonial Posts widget.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		
?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php _e( 'Title:','megashop' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		
<?php
	}
}
function register_WP_Widget_ourservices() {
    register_widget( 'WP_Widget_ourservices' );
}
add_action( 'widgets_init', 'register_WP_Widget_ourservices' );