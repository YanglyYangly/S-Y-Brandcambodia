<?php
/**
 * Widget API: TT_Widget_Products_Tab class
 */

class TT_Widget_Products_Tab extends WP_Widget {

	/**
	 * Sets up a new Products Tabs widget instance.
	 *
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget_tt_wootab_products_entries',
			'description' => esc_html__( 'Display Products.' ,'megashop'),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'tt-wootab-products', esc_html__( 'TT Woocommerce Products For Tabbing','megashop' ), $widget_ops );
		$this->alt_option_name = 'widget_tt_wootab_products_entries';
	}

	/**
	 * Outputs the content for the Products Tabs widget instance.
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

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$id = rand();

		$Products_columns = empty( $instance['Products_columns'] ) ? '1_column' : $instance['Products_columns'];
                $Products_type =  isset( $instance['Products_type'] ) ? $instance['Products_type'] : array('all');
		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
                $autoslide_speed = ( ! empty( $instance['autoslide_speed'] ) ) ? absint( $instance['autoslide_speed'] ) : 1000;
                $show_autoslide = isset( $instance['show_autoslide'] ) ? $instance['show_autoslide'] : false;
		if ( ! $number )
			$number = 5;
                global $woocommerce;

		/**
		 * Filters the arguments for the Products Tabs widget.
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the Products Tabs.
		 */

		if($Products_columns == '1_column'){
			$Products_columns = 1;
		}elseif($Products_columns == '2_column'){
			$Products_columns = 2;
		}
                elseif($Products_columns == '3_column'){
			$Products_columns = 3;
		}
                elseif($Products_columns == '4_column'){
			$Products_columns = 4;
		}
                if($show_autoslide){
                    $show_autoslide = 'true';
                }else{
                    $show_autoslide = 'false';
                }
		?>

		<?php $allowed_html_array = wp_kses_allowed_html('post');
                echo wp_kses($args['before_widget'], $allowed_html_array);
                ?>
		<?php if ( $title ) {
			echo wp_kses($args['before_title'], $allowed_html_array) . $title . wp_kses($args['after_title'], $allowed_html_array);
		} ?>
            <div class="padding_0 TTProduct-Tab woo_product">
                <div class="tab-box-heading">
                    <ul id="home-page-tabs" class="nav nav-tabs clearfix">
                        <?php
                            for($i = 0; $i < count($Products_type); $i++){ ?>
                            <li class="<?php if($i == 0){ echo 'active'; } ?>">
                                <a class="tt<?php echo esc_attr($Products_type[$i]); ?>" data-toggle="tab" href="#<?php echo esc_attr($Products_type[$i]); ?>"><?php echo str_replace('_', ' ', $Products_type[$i]); ?></a>
                            </li>
                        <?php
                            }
                        ?>
                    </ul>
                </div>
                <div class="tttab-content">

                    <div class="tab-content">
                        <?php
                        $theme_layout = of_get_option('theme_layout');
                        if($theme_layout == 'both_sidebar_layout'){
                            $product_col = 2;
                        }else{
                            $product_col = 3;
                        }
                        $jquery_code = "";
                            for($i = 0; $i < count($Products_type); $i++){
                                $jquery_code .= "\n jQuery(document).ready(function () {var ttfeature = jQuery('.tt". $Products_type[$i]."_". $id."');\n";
                                $jquery_code .= "\n jQuery('.tt ".$Products_type[$i]."_". $id."').owlCarousel({\n";
                                $jquery_code .= "\n items : ". $Products_columns.",\n";
                                $jquery_code .= "\n itemsDesktop : [1200," .$product_col."],\n";
                                $jquery_code .= "\n itemsDesktopSmall : [991,". $product_col."],\n";
                                $jquery_code .= "\n itemsTablet: [767,2],itemsMobile : [480,1],\n";
                                $jquery_code .= "\n navigation:true,pagination: false,stopOnHover:true,\n";
                                $jquery_code .= "\n autoPlay : ".$show_autoslide.",slideSpeed: ".$autoslide_speed." });\n";
                                $jquery_code .= "\n if(jQuery('.tt".$Products_type[$i]."_". $id." .owl-controls.clickable').css('display') == 'none'){\n";
                                $jquery_code .= "\n jQuery('.". $Products_type[$i]."_". $id." .customNavigation').hide();\n";
                                $jquery_code .= "\n }else{\n";
                                $jquery_code .= "\n jQuery('.".$Products_type[$i]."_". $id." .customNavigation').show();\n";
                                $jquery_code .= "\n jQuery('.tt".$Products_type[$i].'_'. $id."_next').click(function(){\n";
                                $jquery_code .= "\n jQuery('.tt ".$Products_type[$i]."_". $id."').trigger('owl.next'); });\n";
                                $jquery_code .= "\n jQuery('.tt". $Products_type[$i]."_". $id."_prev').click(function(){\n";
                                $jquery_code .= "\n jQuery('.tt ".$Products_type[$i]."_". $id."').trigger('owl.prev'); });\n";
                                $jquery_code .= "\n }); } }); \n";
                                wp_add_inline_script( 'bootstrapjs', $jquery_code );
                                ?>

                                <div id="<?php echo esc_attr($Products_type[$i]); ?>" class="slick-slider <?php echo esc_attr($Products_type[$i].'_'. $id); ?> tab-pane row block products_block clearfix <?php if($i == 0){ echo 'active'; } ?>">
                                    <div class="customNavigation">
                                    <a class="tt<?php echo esc_attr($Products_type[$i].'_'. $id); ?>_prev btn prev">Prev</a>
                                    <a class="tt<?php echo esc_attr($Products_type[$i].'_'. $id); ?>_next btn next">Next</a>
                                    </div>
                                    <div class="block_content">
                                        <ul class="tt<?php echo esc_attr($Products_type[$i].'_'. $id); ?>">
                                    <?php
                                    if($Products_type[$i] == 'featured_products'){
                                        $args = array(
                                            'post_type' => 'product',
                                            'meta_key' => '_featured',
                                            'meta_value' => 'yes',
                                            'post_status'         => 'publish',
                                            'posts_per_page' => $number
                                            );
                                    }elseif($Products_type[$i] == 'best_selling_products'){
                                        $args = array(
                                                'post_type'           => 'product',
                                                'post_status'         => 'publish',
                                                'posts_per_page'      => $number,
                                                'meta_key'            => 'total_sales',
                                                'orderby'             => 'meta_value_num',
                                        );
                                    }elseif($Products_type[$i] == 'top_rated_products'){

                                        add_filter( 'posts_clauses',  array( $woocommerce->query, 'order_by_rating_post_clauses' ) );

                                        $args = array('posts_per_page' => $number, 'post_status' => 'publish', 'post_type' => 'product' );

                                        $args['meta_query'] = array();

                                        $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                                        $args['meta_query'][] = $woocommerce->query->visibility_meta_query();

                                    }elseif($Products_type[$i] == 'sale_products'){

                                        $args = array(
                                            'post_type'      => 'product',
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

                                    }elseif($Products_type[$i] == 'recent_products' || $Products_type[$i] == 'all'){
                                        $args = array(
                                            'post_type' => 'product',
                                            'orderby'     => 'date',
                                            'post_status'         => 'publish',
                                            'posts_per_page' => $number
                                            );
                                    }
                                    $cnt = 1;
                                    $loop1 = new WP_Query($args);
                                    $found_posts = $loop1->found_posts;
                                    while ($loop1->have_posts()) : $loop1->the_post();
                                        if (($found_posts >= $Products_columns * 2) && ($number >= ($Products_columns * 2))) {
                                            if ($cnt % 2 != 0) {
                                            echo "<li><ul class='single-column'>";
                                            }
                                        }
                                        $content = return_get_template_part('woocommerce/content', 'product');
                                        echo do_shortcode($content);
                                        if (($found_posts >= $Products_columns * 2) && ($number >= ($Products_columns * 2))) {
                                            if ($cnt % 2 == 0) {
                                                echo '</ul></li>';
                                            }
                                        }
                                        $cnt++;
                                    endwhile;
                                    if(($found_posts > $Products_columns * 2) && ($number > ($Products_columns * 2))) { if($cnt % 2 == 0) { echo '</li></ul>>'; } }
                                    ?>
                                        </ul>
                                </div>
                                </div>
                        <?php
                         wp_reset_postdata();
                            }
                        ?>
                    </div>
                </div>
</div>
		<?php echo wp_kses($args['after_widget'], $allowed_html_array); ?>
		<?php
		// Reset the global $the_post as this query will have stomped on it


	}

	/**
	 * Handles updating the settings for the Products Tabs widget instance.
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
                $instance['autoslide_speed'] = (int) $new_instance['autoslide_speed'];
		if ( in_array( $new_instance['Products_columns'], array( '1_column', '2_column','3_column', '4_column' ) ) ) {
			$instance['Products_columns'] = $new_instance['Products_columns'];
		} else {
			$instance['Products_columns'] = '4_column';
		}

		$instance['Products_type'] =  $new_instance['Products_type'];
                $instance['show_autoslide'] = isset( $new_instance['show_autoslide'] ) ? (bool) $new_instance['show_autoslide'] : false;
		return $instance;
	}

	/**
	 * Outputs the settings form for the Products Tabs widget.
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$Products_columns    = isset( $instance['Products_columns'] ) ? esc_attr( $instance['Products_columns'] ) : '4_column';
                $Products_type = isset( $instance['Products_type'] ) ?  $instance['Products_type'] : array('all') ;
		$show_autoslide = isset( $instance['show_autoslide'] ) ? (bool) $instance['show_autoslide'] : true;
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
                $autoslide_speed    = isset( $instance['autoslide_speed'] ) ? absint( $instance['autoslide_speed'] ) : 1000;
?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php _e( 'Title:','megashop' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_html($title); ?>" /></p>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php _e( 'Number of products to show:','megashop' ); ?></label>
		<input class="tiny-text" id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" type="number" step="1" min="1" value="<?php echo esc_attr($number); ?>" size="3" /></p>


		<p>
                    <?php //print_r($Products_type); ?>
			<label for="<?php echo esc_attr( $this->get_field_id( 'Products_type' ) ); ?>"><?php _e( 'Products Type:','megashop' ); ?></label>
			<select multiple="multiple"  name="<?php echo esc_attr( $this->get_field_name( 'Products_type' ) ); ?>[]" id="<?php echo esc_attr( $this->get_field_id( 'Products_type' ) ); ?>" class="widefat">
				<option value="all" <?php if(in_array('all' , $Products_type )) { echo 'selected="selected"'; } ?>><?php _e('All Products','megashop'); ?></option>
                                <option value="recent_products" <?php if(in_array('recent_products' , $Products_type )) { echo 'selected="selected"'; } ?>><?php _e('Recent Products','megashop'); ?></option>
				<option value="featured_products" <?php if(in_array('featured_products' , $Products_type )) { echo 'selected="selected"'; } ?>><?php _e('Featured Products','megashop'); ?></option>
                                <option value="best_selling_products" <?php if(in_array('best_selling_products' , $Products_type )) { echo 'selected="selected"'; } ?>><?php _e('Best-Selling Products','megashop'); ?></option>
				<option value="top_rated_products" <?php if(in_array('top_rated_products' , $Products_type )) { echo 'selected="selected"'; } ?>><?php _e('Top Rated Products ','megashop'); ?></option>
                                <option value="sale_products" <?php if(in_array('sale_products' , $Products_type )) { echo 'selected="selected"'; } ?>><?php _e('Sale Products ','megashop'); ?></option>
			</select>
		</p>
                <p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'Products_columns' ) ); ?>"><?php _e( 'Products Columns:','megashop' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'Products_columns' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'Products_columns' ) ); ?>" class="widefat">
				<option value="1_column"<?php selected( $Products_columns, '1_column' ); ?>><?php _e('1 Column','megashop'); ?></option>
				<option value="2_column"<?php selected( $Products_columns, '2_column' ); ?>><?php _e('2 Columns','megashop'); ?></option>
                                <option value="3_column"<?php selected( $Products_columns, '3_column' ); ?>><?php _e('3 Column','megashop'); ?></option>
				<option value="4_column"<?php selected( $Products_columns, '4_column' ); ?>><?php _e('4 Columns','megashop'); ?></option>
			</select>
		</p>
                <p><input class="checkbox" type="checkbox"<?php checked( $show_autoslide ); ?> id="<?php echo esc_attr($this->get_field_id( 'show_autoslide' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'show_autoslide' )); ?>" />
		<label for="<?php echo esc_attr($this->get_field_id( 'show_autoslide' )); ?>"><?php _e( 'Display Slider Auto slide?','megashop' ); ?></label></p>

                <p class="slide_speed"><label for="<?php echo esc_attr($this->get_field_id( 'autoslide_speed' )); ?>"><?php _e( 'Slide Speed:','megashop' ); ?></label>
		<input class="tiny-text" id="<?php echo esc_attr($this->get_field_id( 'autoslide_speed' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'autoslide_speed' )); ?>" type="number" step="" min="" value="<?php echo esc_attr($autoslide_speed); ?>" size="6" /></p>

<?php
	}
}
function widget_TT_Widget_Products_Tab() {
	register_widget('TT_Widget_Products_Tab');
}
add_action('widgets_init', 'widget_TT_Widget_Products_Tab');