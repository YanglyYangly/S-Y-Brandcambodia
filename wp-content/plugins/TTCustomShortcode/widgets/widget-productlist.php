<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * List products. One widget to rule them all.
 *
 * @category Widgets
 * @extends  WC_Widget
 */
class TT_Widget_Products extends WC_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->widget_cssclass    = 'woocommerce widget_products';
		$this->widget_description = __( 'Display a list of your products on your site.', 'megashop' );
		$this->widget_id          = 'woocommerce_products_list';
		$this->widget_name        = __( 'TT WooCommerce Products List', 'megashop' );
		$this->settings           = array(
			'title'  => array(
				'type'  => 'text',
				'std'   => __( 'Products', 'megashop' ),
				'label' => __( 'Title', 'megashop' )
			),
			'number' => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => '',
				'std'   => 5,
				'label' => __( 'Number of products to show', 'megashop' )
			),
			'show' => array(
				'type'  => 'select',
				'std'   => '',
				'label' => __( 'Show', 'megashop' ),
				'options' => array(
					''         => __( 'All Products', 'megashop' ),
					'featured' => __( 'Featured Products', 'megashop' ),
					'onsale'   => __( 'On-sale Products', 'megashop' ),
                                        'bestselling'   => __( 'Best-Selling Products', 'megashop' ),
				)
			),
			'orderby' => array(
				'type'  => 'select',
				'std'   => 'date',
				'label' => __( 'Order by', 'megashop' ),
				'options' => array(
					'date'   => __( 'Date', 'megashop' ),
					'price'  => __( 'Price', 'megashop' ),
					'rand'   => __( 'Random', 'megashop' ),
					'sales'  => __( 'Sales', 'megashop' ),
				)
			),
			'order' => array(
				'type'  => 'select',
				'std'   => 'desc',
				'label' => _x( 'Order', 'Sorting order', 'megashop' ),
				'options' => array(
					'asc'  => __( 'ASC', 'megashop' ),
					'desc' => __( 'DESC', 'megashop' ),
				)
			),
			'hide_free' => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Hide free products', 'megashop' )
			),
			'show_hidden' => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Show hidden products', 'megashop' )
			)
		);

		parent::__construct();
	}

	/**
	 * Query the products and return them.
	 * @param  array $args
	 * @param  array $instance
	 * @return WP_Query
	 */
	public function get_products( $args, $instance ) {
		$number  = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : $this->settings['number']['std'];
		$show    = ! empty( $instance['show'] ) ? sanitize_title( $instance['show'] ) : $this->settings['show']['std'];
		$orderby = ! empty( $instance['orderby'] ) ? sanitize_title( $instance['orderby'] ) : $this->settings['orderby']['std'];
		$order   = ! empty( $instance['order'] ) ? sanitize_title( $instance['order'] ) : $this->settings['order']['std'];

		$query_args = array(
			'posts_per_page' => $number,
			'post_status'    => 'publish',
			'post_type'      => 'product',
			'no_found_rows'  => 1,
			'order'          => $order,
			'meta_query'     => array()
		);

		if ( empty( $instance['show_hidden'] ) ) {
			$query_args['meta_query'][] = WC()->query->visibility_meta_query();
			$query_args['post_parent']  = 0;
		}

		if ( ! empty( $instance['hide_free'] ) ) {
			$query_args['meta_query'][] = array(
				'key'     => '_price',
				'value'   => 0,
				'compare' => '>',
				'type'    => 'DECIMAL',
			);
		}

		$query_args['meta_query'][] = WC()->query->stock_status_meta_query();
		$query_args['meta_query']   = array_filter( $query_args['meta_query'] );

		switch ( $show ) {
			case 'featured' :
				$query_args['meta_query'][] = array(
					'key'   => '_featured',
					'value' => 'yes'
				);
				break;
			case 'onsale' :
				$product_ids_on_sale    = wc_get_product_ids_on_sale();
				$product_ids_on_sale[]  = 0;
				$query_args['post__in'] = $product_ids_on_sale;
				break;
                        case 'bestselling' :
                                $query_args['meta_key'] = 'total_sales';
				$query_args['orderby']  = 'meta_value_num';
                            break;
                            
		}

		switch ( $orderby ) {
			case 'price' :
				$query_args['meta_key'] = '_price';
				$query_args['orderby']  = 'meta_value_num';
				break;
			case 'rand' :
				$query_args['orderby']  = 'rand';
				break;
			case 'sales' :
				$query_args['meta_key'] = 'total_sales';
				$query_args['orderby']  = 'meta_value_num';
				break;
			default :
				$query_args['orderby']  = 'date';
		}

		return new WP_Query( apply_filters( 'woocommerce_products_widget_query_args', $query_args ) );
	}

	/**
	 * Output widget.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		if ( $this->get_cached_widget( $args ) ) {
			return;
		}

		ob_start();

		if ( ( $products = $this->get_products( $args, $instance ) ) && $products->have_posts() ) {
			$this->widget_start( $args, $instance );

			echo apply_filters( 'woocommerce_before_widget_product_list', '<ul class="product_list_widget">' );

			while ( $products->have_posts() ) {
				$products->the_post();
				wc_get_template( 'content-widget-product.php', array( 'show_rating' => true ) );
			}

			echo apply_filters( 'woocommerce_after_widget_product_list', '</ul>' );

			$this->widget_end( $args );
		}

		wp_reset_postdata();

		echo do_shortcode($this->cache_widget( $args, ob_get_clean() ));
	}
}
function widget_TT_Widget_Products() {
	register_widget('TT_Widget_Products');
}
add_action('widgets_init', 'widget_TT_Widget_Products');