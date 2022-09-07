<?php

/*
Plugin Name: Custom Portfolio Widget
Plugin URI: http://twitter.com/hellott/
Description: A simple but powerful widget to display Portfolio Items.
Version: 1.0
Author: tt
Author URI: http://twitter.com/hellott/
*/

class widget_portfolio extends WP_Widget { 
	
	// Widget Settings
	function widget_portfolio() {
		$widget_ops = array('description' => __('Display your latest Portfolio', 'megashop') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'portfolio' );
		parent::__construct( 'portfolio', __('tt.Portfolio', 'megashop'), $widget_ops, $control_ops );
	}
	
	// Widget Output
	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', esc_html($instance['title']));
		$number = intval($instance['number']);
		$allowed_html_array = wp_kses_allowed_html('post');
		echo wp_kses($args['before_widget'], $allowed_html_array);

		if($title) {
			echo wp_kses($args['before_title'], $allowed_html_array) . $title . wp_kses($args['after_title'], $allowed_html_array);
		}
		?>
		<div class="recent-works-items clearfix">
		<?php
		$args = array(
			'post_type' => 'portfolio',
			'posts_per_page' => $number
		);
		$portfolio = new WP_Query($args);
		if($portfolio->have_posts()):
		?>
		<?php while($portfolio->have_posts()): $portfolio->the_post(); ?>
		<div class="portfolio-widget-item">
            <?php if (has_post_thumbnail()) { ?>
            	<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="portfolio-pic"><?php the_post_thumbnail( 'mini' ); ?><span class="portfolio-overlay"><i class="icon-tt-plus"></i></span></a>
            <?php } ?>
       </div>
		<?php endwhile; endif; ?>
		</div>

		<?php echo wp_kses($args['after_widget'], $allowed_html_array);
	}
	
	// Update
	function update( $new_instance, $old_instance ) {  
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = $new_instance['number'];
		
		return $instance;
	}
	
	// Backend Form
	function form($instance) {
		
		$defaults = array('title' => 'Latest Project', 'number' => 6);
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Title:</label><br />
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('number')); ?>">Number of items to show:</label><br />
			<input type="text"  class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" value="<?php echo esc_attr($instance['number']); ?>" />
		</p>
	<?php
	}
}

// Add Widget
function widget_portfolio_init() {
	register_widget('widget_portfolio');
}
add_action('widgets_init', 'widget_portfolio_init');

?>