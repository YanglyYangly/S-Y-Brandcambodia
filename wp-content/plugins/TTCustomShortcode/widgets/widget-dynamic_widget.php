<?php



/**

 * Core class used to implement a Blog Posts widget.

 *

 * @since 2.8.0

 *

 * @see WP_Widget

 */

class Add_new_Block extends WP_Widget {



	/**

	 * Sets up a new Recent Posts widget instance.

	 *

	 * @since 2.8.0

	 * @access public

	 */

	public function __construct() {

		$widget_ops = array(

			'classname' => 'widget_add_new_block',

			'description' => __( 'Display Category Blocks.','megashop' ),

			'customize_selective_refresh' => true,

		);

		parent::__construct( 'add_new_block-widget', __( 'Display Category Blocks','megashop' ), $widget_ops );

		$this->alt_option_name = 'widget_add_new_block';

	}



	/**

	 * Outputs the content for the current Blog Posts widget instance.

	 *

	 * @since 2.8.0

	 * @access public

	 *

	 * @param array $args     Display arguments including 'before_title', 'after_title',

	 *                        'before_widget', and 'after_widget'.

	 * @param array $instance Settings for the current Blog Posts widget instance.

	 */

	public function widget( $args, $instance ) {

		if ( ! isset( $args['widget_id'] ) ) {

			$args['widget_id'] = $this->id;

		}



		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';



		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */

		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

                $cat_title = $instance['cat_title'];

                $cat_link = $instance['cat_link'];                

		$cat_image = $instance['cat_image'];

                $total = count($cat_title);

		$id= rand();

		?>

		

		<?php $allowed_html_array = wp_kses_allowed_html('post');

                        echo wp_kses($args['before_widget'], $allowed_html_array); ?>

		<?php if ( $title ) {

			echo wp_kses($args['before_title'], $allowed_html_array) . $title . wp_kses($args['after_title'], $allowed_html_array);

		} 

                if(!empty($cat_title)){

                    $i = 0;

                    ?>

                        <div id="ttcategory">

                            <div class="ttcmscategory">

                            <div class="ttcategory-main">

                            <ul id="ttcategory-carousel" class="list-unstyled category_carousel<?php echo esc_attr($id); ?>">

                                <?php

                        for ($i = 0; $i < $total; $i++) {

                            ?>                            

                            <li class="ttcategory inner">

                            <div class="tticon categoryimg">

                            <a href="<?php echo esc_url($cat_link[$i]); ?>"><img src="<?php echo esc_url($cat_image[$i]); ?>" alt="<?php echo esc_attr($cat_title[$i]); ?>"></a>

                            </div>

                            <div class="tt-title"><?php echo esc_attr($cat_title[$i]); ?></div>

                            </li>

                            

                            <?php

                        }

                        ?>

                            </ul>

                            </div>

                            </div>

                            <script type="text/javascript">

                                jQuery(document).ready(function(){

                                    jQuery(".category_carousel<?php echo esc_js($id); ?>").owlCarousel({

                                                autoPlay : true,

                                        items :5, //10 items above 1000px browser width

                                        itemsDesktop : [1200,4], 

                                        itemsDesktopSmall : [991,4], 

                                        itemsTablet: [767,3], 

                                        itemsMobile : [480,2],

                                                navigation: false,

                                                pagination: false

                                    });

                                });

                                </script>

                            </div>

                            <?php

                }

                ?>

		<?php echo wp_kses($args['after_widget'], $allowed_html_array);

		// Reset the global $the_post as this query will have stomped on it

		

	}



	/**

	 * Handles updating the settings for the current Blog Posts widget instance.

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

                $instance['cat_title'] = $new_instance['cat_title'];

                $instance['cat_link'] = $new_instance['cat_link'];

                $instance['cat_image'] = $new_instance['cat_image'];	

		return $instance;

	}



	/**

	 * Outputs the settings form for the Blog Posts widget.

	 *

	 * @since 2.8.0

	 * @access public

	 *

	 * @param array $instance Current settings.

	 */

	public function form( $instance ) {

		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';

                 $id = rand();

            $cat_title = isset( $instance['cat_title'] ) ?  $instance['cat_title'] : '';

            $cat_image = isset( $instance['cat_image'] ) ? ( $instance['cat_image'] ) : '';

            $cat_link = isset( $instance['cat_link'] ) ? ( $instance['cat_link'] ) : '';

        ?>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php _e( 'Title:','megashop' ); ?></label>

		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_html($title); ?>" /></p>

		

                <div class="wrap_<?php echo esc_attr($id); ?>">

                    <div class="our_text">

                    <div class="cat_block">

                                    <div class="drag_icon"> 

                                        <div></div>

                                        <div></div>

                                        <div></div>                                        

                                    </div>

                    <p class="">

                        <label for=""><?php _e( 'Cat Title:','megashop' ); ?></label> 

                        <input class="widefat cat_title" id="" name="<?php echo esc_attr($this->get_field_name( 'cat_title' )); ?>[]" type="text" value="<?php if(!empty($cat_title[0])) echo esc_attr($cat_title[0]); ?>">

                    </p>

                    <p class="">

                        <label for=""><?php _e( 'Cat Link:','megashop' ); ?></label> 

                        <input class="widefat cat_link" id="" name="<?php echo esc_attr($this->get_field_name( 'cat_link' )); ?>[]" type="text" value="<?php if(!empty($cat_link[0])) echo esc_attr($cat_link[0]); ?>">

                    </p>

                    <p class="image_div">

                        <label for=""><?php _e( 'Cat Image:','megashop' ); ?></label>

                        <input class="widefat image_input" id="" name="<?php echo esc_attr($this->get_field_name( 'cat_image' )); ?>[]" type="text" value="<?php if(!empty($cat_image[0])) echo esc_attr($cat_image[0]); ?>" />

                        <input type="button" class="button secondary upload_image" value="upload"/>

                        <span class="image_wrap">

                        <?php if(!empty($cat_image[0])){ ?>

                        <img src="<?php echo esc_url($cat_image[0]);  ?>" >

                        <a class="remove-image">remove</a>		

                        <?php } ?>		

                        </span>

                        </p>

                    </div>

                        <?php

                        $total = count($cat_title);

                        $i = 1;

                        for ($i = 1; $i < $total; $i++) {

                            if ($cat_title[$i] != "") {

                                ?>

                                <div class="cat_block">

                                    <div class="drag_icon"> 

                                        <div></div>

                                        <div></div>

                                        <div></div>                                        

                                    </div>

                                    <p class="">

                                        <label for=""><?php _e('Cat Title:','megashop'); ?></label> 

                                        <input class="widefat" id="" name="<?php echo esc_attr($this->get_field_name('cat_title')); ?>[]" type="text" value="<?php if (!empty($cat_title[$i])) echo esc_attr($cat_title[$i]); ?>">

                                    </p>

                                    <p class="">

                                        <label for=""><?php _e('Cat Link:','megashop'); ?></label> 

                                        <input class="widefat" id="" name="<?php echo esc_attr($this->get_field_name('cat_link')); ?>[]" type="text" value="<?php if (!empty($cat_link[$i])) echo esc_attr($cat_link[$i]); ?>">

                                    </p>

                                    <p class="image_div">

                                    <label for="<?php echo esc_attr($this->get_field_id( 'cat_image' )); ?>"><?php _e( 'Cat Image:','megashop' ); ?></label>

                                    <input class="widefat" id="" name="<?php echo esc_attr($this->get_field_name( 'cat_image' )); ?>[]" type="text" value="<?php if (!empty($cat_image[$i])) echo esc_attr($cat_image[$i]); ?>" />

                                    <input type="button" class="button secondary upload_image" value="upload"/>

                                    <span class="image_wrap">

                                    <?php if(!empty($cat_image[$i])){ ?>

                                    <img src="<?php echo esc_url($cat_image[$i]);  ?>" >

                                    <a class="remove-image">remove</a>		

                                    <?php } ?>		

                                    </span>

                                    </p>

                                    <input type="button" class="remove_div" value="<?php _e('Remove', 'megashop'); ?>">

                                </div>

                                    

                                <?php

                            }

                        }

                        ?>

                </div>

                <input type="button" class="addnew_div" value="<?php _e('Add New','megashop'); ?>">

                </div>

                 <script type="text/javascript">

            jQuery(document).ready(function(){

                var total = jQuery(".wrap_<?php echo esc_js($id); ?> .cat_block").length;

                    total = total + 1;

                jQuery(".wrap_<?php echo esc_js($id); ?> .addnew_div").on('click', function() {

                    var s_title = jQuery(this).parent().find('.cat_title').attr('name');

                    var s_link = jQuery(this).parent().find('.cat_link').attr('name');

                    var cat_image = jQuery(this).parent().find('.image_input').attr('name');

                    var textap = ' ';

                    textap +='<div class="cat_block"><div class="drag_icon"><div></div><div></div><div></div></div>';

                    textap +='<p class=""><label for=">"><?php _e( 'Cat Title:','megashop'); ?></label>'; 

                    textap +='<input class="widefat" id="" name="'+ s_title +'" type="text"></p>';

                    textap +='<p class=""><label for=">"><?php _e( 'Cat Link:','megashop'); ?></label>'; 

                    textap +='<input class="widefat" id="" name="'+ s_link +'" type="text"></p>';

                    textap +='<p class="image_div"><label for=""><?php _e( 'Cat image:' ,'megashop'); ?></label>'; 

                    textap +='<input class="widefat image_input" id="" name="'+cat_image+'" type="text" value="" /><input type="button" class="button secondary upload_image" value="upload"/><span class="image_wrap"></span></p>';

                    textap +='<input type="button" class="remove_div" value="<?php _e('Remove','megashop'); ?>"></div>';   

                    jQuery('.wrap_<?php echo esc_js($id); ?> .our_text').append(textap);   

                    total++;

                });

                jQuery( ".our_text" ).sortable({ handle: '.drag_icon' });

                

                jQuery(".wrap_<?php echo esc_js($id); ?> .remove_div").on('click', function() {

                  jQuery(this).parent().remove();                    

                });

                      

            });

        </script>		

<?php

	}

}

function register_Add_new_Block() {

    register_widget( 'Add_new_Block' );

}

add_action( 'widgets_init', 'register_Add_new_Block' );