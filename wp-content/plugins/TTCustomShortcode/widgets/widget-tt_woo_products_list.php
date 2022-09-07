<?php
/**
 * Widget API: WP_Widget_Products class
 *
 */

class WP_Widget_Product_lists extends WP_Widget {

	/**
	 * Sets up a new Products lists widget instance.
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget_tt_woo_product_lists_entries',
			'description' => __( 'Display Products.','megashop' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'tt-woo-products', __( 'TT Woocommerce Products lists','megashop' ), $widget_ops );
		$this->alt_option_name = 'widget_tt_woo_product_lists_entries';
	}

	/**
	 * Outputs the content for the Products lists widget instance.
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Products Posts widget instance.
	 */
	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';

		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$id = rand();

                $Products_type = empty( $instance['Products_type'] ) ? 'recent_products' : $instance['Products_type'];
		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number )
			$number = 5;
                global $woocommerce;

		/**
		 * Filters the arguments for the Products lists widget.
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the recent posts.
		 */
		
                if($Products_type == 'featured_products'){
                    $args = array(
			'post_type' => 'product',
                        'meta_key' => '_featured',  
                        'meta_value' => 'yes', 
                        'post_status'         => 'publish',
			'posts_per_page' => $number
			);
                }elseif($Products_type == 'best_selling_products'){
                    $args = array(
                            'post_type'           => 'product',
                            'post_status'         => 'publish',
                            'posts_per_page'      => $number,
                            'meta_key'            => 'total_sales',
                            'orderby'             => 'meta_value_num',
                    );	
                }elseif($Products_type == 'top_rated_products'){
                    
                     add_filter( 'posts_clauses',  array( $woocommerce->query, 'order_by_rating_post_clauses' ) );

                    $args = array('posts_per_page' => $number, 'post_status' => 'publish', 'post_type' => 'product' );

                    $args['meta_query'] = array();

                    $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                    $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                    
                }elseif($Products_type == 'sale_products'){
                    
                     $args = array(
                        'post_type'      => 'product',                         
                        'post_status'         => 'publish',
			'posts_per_page' => $number,
                        'meta_query'     => array(
                            'relation' => 'OR',
                            array( // Simple products type
                                'key'           => '_sale_price',
                                'value'         => 0,
                                'compare'       => '>',
                                'type'          => 'numeric'
                            ),
                            array( // Variable products type
                                'key'           => '_min_variation_sale_price',
                                'value'         => 0,
                                'compare'       => '>',
                                'type'          => 'numeric'
                            )
                        )
                    );
                    
                }else{
                    $args = array(
			'post_type' => 'product',
                        'orderby'     => 'date',
                        'post_status'         => 'publish',
			'posts_per_page' => $number
			);
                }
               
		$loop = new WP_Query( $args );

		if ($loop->have_posts()) :
                    $allowed_html_array = wp_kses_allowed_html('post');
                    echo wp_kses($args['before_widget'], $allowed_html_array);
                if ( $title ) {
			echo wp_kses($args['before_title'], $allowed_html_array) . $title . wp_kses($args['after_title'], $allowed_html_array);
		} ?>
                <div class="woocommerce products_block padding_0 woo_product">
                    <div class="customNavigation">
                        <a class="btn prev tt<?php echo esc_attr($Products_type.'_'. $id); ?>_prev"><?php _e('prev','megashop'); ?></a>
                        <a class="btn next tt<?php echo esc_attr($Products_type.'_'. $id); ?>_next"><?php _e('next','megashop'); ?></a>
                    </div>
		<ul class="tt-carousel Products_wrap_<?php echo esc_attr($id); ?>">
		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                    <?php echo get_the_title();
                    echo get_the_thumbnail();
                    ?>
                    
		<?php endwhile; ?>
		</ul>
                </div>
		<?php echo wp_kses($args['after_widget'], $allowed_html_array); ?>
		<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;
	}

	/**
	 * Handles updating the settings for the Products lists widget instance.
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
                if ( in_array( $new_instance['Products_type'], array( 'recent_products', 'featured_products','best_selling_products', 'top_rated_products','sale_products' ) ) ) {
			$instance['Products_type'] = $new_instance['Products_type'];
		} else {
			$instance['Products_type'] = 'recent_products';
		}
		return $instance;
	}

	/**
	 * Outputs the settings form for the Products lists widget.
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
                $Products_type    = isset( $instance['Products_type'] ) ? esc_attr( $instance['Products_type'] ) : 'recent_products';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php _e( 'Title:','megashop' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_html($title); ?>" /></p>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php _e( 'Number of products to show:','megashop' ); ?></label>
		<input class="tiny-text" id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" type="number" step="1" min="1" value="<?php echo esc_attr($number); ?>" size="3" /></p>


		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'Products_type' ) ); ?>"><?php _e( 'Products Type:','megashop' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'Products_type' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'Products_type' ) ); ?>" class="widefat">
				<option value="recent_products"<?php selected( $Products_type, 'recent_products' ); ?>><?php _e('Recent Products','megashop'); ?></option>
				<option value="featured_products"<?php selected( $Products_type, 'featured_products' ); ?>><?php _e('Featured Products','megashop'); ?></option>
                                <option value="best_selling_products"<?php selected( $Products_type, 'best_selling_products' ); ?>><?php _e('Best-Selling Products','megashop'); ?></option>
				<option value="top_rated_products"<?php selected( $Products_type, 'top_rated_products' ); ?>><?php _e('Top Rated Products ','megashop'); ?></option>
                                <option value="sale_products"<?php selected( $Products_type, 'sale_products' ); ?>><?php _e('Sale Products ','megashop'); ?></option>
			</select>
		</p>
<?php
	}
}
// Register and load the widget
	register_widget( 'WP_Widget_Product_lists' );