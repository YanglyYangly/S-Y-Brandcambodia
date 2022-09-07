<?php

class TT_Product_SortBy_Widget extends WP_Widget {
	protected $defaults;

	function __construct() {
		$this->defaults = array(
			'title' => '',
		);

		parent::__construct(
			'product-sort-by',
			esc_html__( 'TT - Product Sort By', 'megashop' ),
			array(
				'classname'   => 'product-sort-by',
				'description' => esc_html__( 'Sort Product By', 'megashop' ),
			)
		);
	}

	/**
	 * Outputs the HTML for this widget.
	 *
	 * @param array $args     An array of standard parameters for widgets in this theme
	 * @param array $instance An array of settings for this widget instance
	 *
	 * @return void Echoes it's output
	 */
	function widget( $args, $instance ) {
		$instance = wp_parse_args( $instance, $this->defaults );

		extract( $args );
                $allowed_html_array = wp_kses_allowed_html('post');
		echo wp_kses($args['before_widget'], $allowed_html_array);

		if ( $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) ) {
			echo wp_kses($args['before_title'], $allowed_html_array) . $title . wp_kses($args['after_title'], $allowed_html_array);
		}
		if ( function_exists( 'woocommerce_catalog_ordering' ) ) {
			woocommerce_catalog_ordering();
		}

		echo wp_kses($args['after_widget'], $allowed_html_array);
	}

	/**
	 * Deals with the settings when they are saved by the admin.
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array
	 */
	function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}

	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 *
	 * @param array $instance
	 *
	 * @return array
	 */
	function form( $instance ) {
		$instance = wp_parse_args( $instance, $this->defaults );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'megashop' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
		</p>
		<?php
	}
}
function tt_sort_register_widgets() {
	if ( class_exists( 'WC_Widget' ) ) {
		register_widget( 'TT_Product_SortBy_Widget' );
	}
}
add_action( 'widgets_init', 'tt_sort_register_widgets' );