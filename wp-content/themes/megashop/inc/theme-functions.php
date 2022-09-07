<?php
/*
 *  Custom Theme Functions 
 */

/* ---------------------------------------------------------------------------
 * get template part 
 * --------------------------------------------------------------------------- */

function return_get_template_part($slug, $name = null) {
    ob_start();
    get_template_part($slug, $name);
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

/* ---------------------------------------------------------------------------
 * Attachment | GET attachment ID by URL
 * --------------------------------------------------------------------------- */
if (!function_exists('tt_get_attachment_id_url')) {

    function tt_get_attachment_id_url($image_url) {
        global $wpdb;

        $image_url = esc_url($image_url);
        $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url));

        if (isset($attachment[0])) {
            return $attachment[0];
        }
    }

}
/* ---------------------------------------------------------------------------
 * Get Menu location
 * --------------------------------------------------------------------------- */

function megashop_get_menu_by_location($location) {
    if (empty($location))
        return false;

    $locations = get_nav_menu_locations();
    if (!isset($locations[$location]))
        return false;

    $menu_obj = get_term($locations[$location], 'nav_menu');

    return $menu_obj;
}

/* ---------------------------------------------------------------------------
 * Attachment | GET attachment data
 * --------------------------------------------------------------------------- */
if (!function_exists('tt_get_attachment_data')) {

    function tt_get_attachment_data($image, $data, $with_key = false) {
        $size = $return = false;
        if (!is_numeric($image)) {
            // QUICK FIX https
            $image_ID = tt_get_attachment_id_url($image);

            if (!$image_ID) {
                $image = str_replace('https://', 'http://', $image);
                $image_ID = tt_get_attachment_id_url($image);
            }

            $image = $image_ID;
        }

        $meta = wp_prepare_attachment_for_js($image);
        if (is_array($meta) && isset($meta[$data])) {
            $return = $meta[$data];

            // if looking for alt and it isn't specified use image title
            if ($data == 'alt' && !$return) {
                $return = $meta['title'];
            }
        }

        if ($return && $with_key) {
            $return = $data . '="' . $return . '"';
        }

        return $return;
    }

}
/* ---------------------------------------------------------------------------
 * funtion for display pre-loader image
 * --------------------------------------------------------------------------- */
if (!function_exists('tt_pre_loader')) {

    function tt_pre_loader() {
        $pre_loader = of_get_option('pre_loader');
        $preloader_bg_color = of_get_option('preloader_bg_color');
        $display_preloader = of_get_option('display_preloader');
        if (!empty($pre_loader) && $display_preloader == 1 && is_front_page()) {

            $custom_css = ".ttloader {
                    background-color: " . esc_js($preloader_bg_color) . ";
                    height: 100%;
                    left: 0;
                    position: fixed;
                    top: 0;
                    width: 100%;
                    z-index: 999999;
                }.rotating {
                    background-image: url(" . esc_js($pre_loader) . ");
                }.rotating {
                    background-position: center center;
                    background-repeat: no-repeat;
                    bottom: 0;
                    height: auto;
                    left: 0;
                    margin: auto;
                    position: absolute;
                    right: 0;
                    top: 0;
                    width: 100%;
                }";

            wp_add_inline_script('bootstrapjs', 'jQuery(window).load(function() { jQuery(".ttloader").fadeOut("slow"); });');
            wp_add_inline_style('megashop-style', $custom_css);
        }
    }

}
add_action('wp_enqueue_scripts', 'tt_pre_loader');



if (!function_exists('megashop_masonry_init')) :

    function megashop_masonry_init() {
        if (isset($_GET['blog_layout']) && $_GET['blog_layout'] == 'masonry') {
            $blog_layout = 'masonry';
        } else {
            $blog_layout = of_get_option('select_blog_layout');
        }
        if ($blog_layout == 'masonry') {
            wp_add_inline_script('bootstrapjs', 'jQuery(window).load(function() { var $container = jQuery(".blog_wrap_div.masonry"); $container.imagesLoaded( function() {  $container.masonry({ itemSelector : ".ms-item"  }); }); });');
        }
    }

    add_action('wp_enqueue_scripts', 'megashop_masonry_init');

endif; // ! megashop_masonry_init exists


if (!function_exists('megashop_shop_masonry_init')) {

    function megashop_shop_masonry_init() {
        if (isset($_GET['shop_masonry']) && $_GET['shop_masonry'] == 1) {
            $shop_masonry = 1;
        } else {
            $shop_masonry = of_get_option('shop_masonry');
        }
        if ($shop_masonry == 1) {
            wp_add_inline_script('bootstrapjs', 'jQuery(window).load(function() { var $container = jQuery(".product_wrap.shop_masonry .products"); $container.imagesLoaded( function() {  $container.masonry({ itemSelector : ".ms-item"  }); }); });');
        }
    }

    add_action('wp_enqueue_scripts', 'megashop_shop_masonry_init');
} // ! megashop_masonry_init exists

/* ---------------------------------------------------------------------------
 * Woocommerce Functions
 * --------------------------------------------------------------------------- */
if (class_exists('woocommerce')) {
    /* related post filter */
    add_filter('woocommerce_output_related_products_args', 'tt_related_products_args');

    function tt_related_products_args($args) {
        $args['posts_per_page'] = 8; // 4 related products
        return $args;
    }

    /* add wishlist in shop page */
    if (defined('YITH_WCWL') && !function_exists('yith_wcwl_add_wishlist_on_loop')) {

        function megashop_yith_wcwl_add_wishlist_on_loop() {
            ?><div class="button wishlist"><?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?></div> <?php
        }

        add_action('woocommerce_after_shop_loop_item', 'megashop_yith_wcwl_add_wishlist_on_loop', 15);
    }

    add_filter('woocommerce_add_to_cart_fragments', 'megashop_woocommerce_header_add_to_cart_fragment');

    function megashop_woocommerce_header_add_to_cart_fragment($fragments) {
        global $woocommerce;
        ob_start();
        ?>
        <button class="btn btn-inverse btn-block btn-lg dropdown-toggle" type="button" data-toggle="dropdown" data-loading-text="Loading...">
        <?php $cart_cnt = $woocommerce->cart->cart_contents_count; ?>
            <i class="cart-contents" id="headercarttrigger" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_html_e('View your shopping cart', 'megashop'); ?>"><span><?php echo esc_attr($cart_cnt); ?></span>
            </i>	
        </button>
        <?php
        $fragments['i.cart-contents'] = ob_get_clean();
        return $fragments;
    }

    function megashop_add_productthumb_div() {
        $product_rollover = of_get_option('product_rollover');
        ?>
        <div class="product-thumb ">
            <div class="<?php echo esc_attr($product_rollover); ?>">
                <?php
            }

            add_action('woocommerce_before_shop_loop_item', 'megashop_add_productthumb_div', 5);

            function megashop_close_productthumb_div() {
                woo_custom_lable();
                tt_add_pack_label();
                woocommerce_show_product_loop_sale_flash();
                woocommerce_template_loop_product_link_close();
                ?>
            </div>
        </div>
        <?php
    }

    add_action('woocommerce_before_shop_loop_item_title', 'megashop_close_productthumb_div', 15);

    add_action('woocommerce_before_single_product_summary', 'megashop_add_sproductthumb_div', 9);

    function megashop_add_sproductthumb_div() {
        ?>
        <div class="product-img">
        <?php
    }

    add_action('woocommerce_before_single_product_summary', 'close_sproductthumb_div', 25);

    function close_sproductthumb_div() {
        ?>
        </div>
                <?php
            }

            function add_productdesc_div() {
                ?>
        <div class="product-description"><div class="caption">
                <?php
            }

            add_action('woocommerce_before_shop_loop_item_title', 'add_productdesc_div', 20);

            function add_product_description_div() {
                global $post;
                ?><div class="description">
                    <?php echo apply_filters('woocommerce_short_description', $post->post_excerpt); ?>
                </div>
            </div><div class="button-wrapper">
                    <?php woocommerce_template_loop_price(); ?>
                <div class="button-group">
                <?php
            }

            add_action('woocommerce_after_shop_loop_item', 'add_product_description_div', 1);

            function close_productdesc_div() {
                ?><div class="button-quickview button"><a class="detail-link trquickview" data-quick-id="<?php echo get_the_ID(); ?>" href=""><?php _e('Quick View', 'megashop'); ?></a></div>
                </div>
                <?php
            }

            add_action('woocommerce_after_shop_loop_item', 'close_productdesc_div', 20);

            /** add product sold out label * */
            add_action('woocommerce_before_shop_loop_item', 'product_outof_stock', 1);

            function product_outof_stock() {
                global $product;

                if (!$product->is_in_stock()) {
                    echo '<div class="soldout_wrap"><span class="soldout">' . esc_html__('SOLD OUT', 'megashop') . '</span></div>';
                }
            }

            /* cross cell products display in cart totlas */
            remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
            add_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display', 15);
            /*             * ******** */
            /* search products for ajax saerch */
            add_action('wp_ajax_nopriv_megashop_tt_ajax_pro_search', 'megashop_tt_ajax_pro_search');

            add_action('wp_ajax_megashop_tt_ajax_pro_search', 'megashop_tt_ajax_pro_search');

            function megashop_tt_ajax_pro_search() {
                global $woocommerce;
                $search_keyword = $_POST['keyword'];
                $ordering_args = $woocommerce->query->get_catalog_ordering_args('title', 'asc');
                $search_results = array();
                $args = apply_filters('tt_live_search_query_args', array(
                   // 'posts_per_page' => 10,
                    'no_found_rows' => true,
                    'post_type' => 'product',
                    'tax_query' => WC()->query->get_tax_query(),
                    'meta_query' => WC()->query->get_meta_query(),
                    'post_status' => 'publish',
                    'orderby' => $ordering_args['orderby'],
                    'order' => $ordering_args['order']
                ));
				
				
				
                if (isset($search_keyword)) {
                    $args['s'] = $search_keyword;
                }

                if (isset($_POST['category']) && !empty($_POST['category'])) {
                    $args['tax_query'] = array(
                        'relation' => 'AND',
                        array(
                            'taxonomy' => 'product_cat',
                            'field' => 'slug',
                            'terms' => $_POST['category']
                            ));
                }
                $products = get_posts($args);
                if (!empty($products)) {
                   foreach ($products as $post) {
                        $product = wc_get_product($post);
                        if(has_post_thumbnail($product->id)){
                            $img=get_the_post_thumbnail_url($product->id, 'shop_thumbnail');
                            }else{
                             $img =wc_placeholder_img_src();
                            }
                        $search_results[] = array(
                            'image' => $img,
                            'id' => $product->id,
                            'value' => strip_tags($product->get_title()),
                            'url' => $product->get_permalink()
                        );
                    }
                } else {
                    $search_results[] = array(
                        'id' => 0,
                        'value' => esc_html__('No results', 'megashop'),
                        'url' => '#',
                    );
                }
                wp_reset_postdata();

                $search_results = array(
                    'search_results' => $search_results
                );
                echo json_encode($search_results);
                die();
            }

            /**/
            /*********** add product category image and subcategory *********** */
            add_action('woocommerce_archive_description', 'megashop_woocommerce_category_image', 2);

            function megashop_woocommerce_category_image() {
                if (is_product_category()) {
                    global $wp_query;
                    $cat = $wp_query->get_queried_object();
                    $IDbySlug = get_term_by('slug', $cat->slug, 'product_cat');
                    $product_cat_ID = $IDbySlug->term_id;
                    $args = array(
                        'hierarchical' => 1,
                        'show_option_none' => '',
                        'hide_empty' => 0,
                        'parent' => $product_cat_ID,
                        'taxonomy' => 'product_cat'
                    );
                    $subcats = get_categories($args);
                    $desc = $IDbySlug->description;
                    $thumbnail_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
                    $image = wp_get_attachment_url($thumbnail_id);
                    $subcats = array_filter($subcats);
                    if (!empty($subcats) || !empty($desc) || !empty($image)) {
                        ?><div class="category-description-wrap"><?php if (apply_filters('woocommerce_show_page_title', true)) { ?>
                                <h1 class="page-title"><?php woocommerce_page_title(); ?></h1>
                                <?php
                            }
                            if ($image) {
                                echo '<img src="' . esc_url($image) . '" alt="cat-image" />';
                            }
                        }
                    }
                }

                add_action('woocommerce_archive_description', 'megashop_woocommerce_category_image_end', 11);

                function megashop_woocommerce_category_image_end() {
                    if (is_product_category()) {
                        global $wp_query;
                        $cat = $wp_query->get_queried_object();
                        megashop_woocommerce_subcats_from_parentcat_by_Id($cat->slug);
                        $IDbySlug = get_term_by('slug', $cat->slug, 'product_cat');
                        $product_cat_ID = $IDbySlug->term_id;
                        $args = array(
                            'hierarchical' => 1,
                            'show_option_none' => '',
                            'hide_empty' => 0,
                            'parent' => $product_cat_ID,
                            'taxonomy' => 'product_cat'
                        );
                        $subcats = get_categories($args);
                        $desc = $IDbySlug->description;
                        $thumbnail_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
                        $image = wp_get_attachment_url($thumbnail_id);
                        $subcats = array_filter($subcats);
                        if (!empty($subcats) || !empty($desc) || !empty($image)) {
                            ?></div><?php
            }
        }
    }

    function megashop_woocommerce_subcats_from_parentcat_by_Id($parent_cat_slug) {
        $IDbySlug = get_term_by('slug', $parent_cat_slug, 'product_cat');
        $product_cat_ID = $IDbySlug->term_id;
        $args = array(
            'hierarchical' => 1,
            'show_option_none' => '',
            'hide_empty' => 0,
            'parent' => $product_cat_ID,
            'taxonomy' => 'product_cat'
        );
        $subcats = get_categories($args);
        if (!empty($subcats)) {
            echo '<div class="category-list"><h3>' . esc_html__('Refine Search', 'megashop') . '</h3><div class="row"><div class="col-sm-12"><ul class="wooc_sclist unstyle-list">';
            foreach ($subcats as $sc) {
                $link = get_term_link($sc->slug, $sc->taxonomy);
                echo '<li><a href="' . esc_url($link) . '">' . $sc->name . '</a></li>';
            }
            echo '</ul></div></div></div>';
        }
    }

    /*     * ***************** */

    function megashop_wooc_extra_register_fields() {
        ?> 
                <p class="form-row form-row-first"> 
                    <label for="reg_billing_first_name"><?php esc_html_e('First name', 'megashop'); ?><span class="required">*</span></label> 
                    <input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if (!empty($_POST['billing_first_name'])) echo esc_html($_POST['billing_first_name']); ?>" /> 
                </p> 
                <p class="form-row form-row-last"> 
                    <label for="reg_billing_last_name"><?php esc_html_e('Last name', 'megashop'); ?><span class="required">*</span></label> 
                    <input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if (!empty($_POST['billing_last_name'])) echo esc_html($_POST['billing_last_name']); ?>" /> 
                </p> 
                <div class="clear"></div> 
                <p class="form-row form-row-wide"> 
                    <label for="reg_billing_phone"><?php esc_html_e('Phone', 'megashop'); ?><span class="required">*</span></label> 
                    <input type="text" class="input-text" name="billing_phone" id="reg_billing_phone" value="<?php if (!empty($_POST['billing_phone'])) echo esc_html($_POST['billing_phone']); ?>" /> 
                </p> 

               

                <?php
            }

            add_action('woocommerce_register_form_start', 'megashop_wooc_extra_register_fields');

            // Woocommerce rating stars always
            add_filter('woocommerce_product_get_rating_html', 'tt_get_rating_html', 10, 2);

            function tt_get_rating_html($rating_html, $rating) {
                if ($rating > 0) {
                    $title = sprintf(__('Rated %s out of 5', 'megashop'), $rating);
                } else {
                    $title = esc_html__('Not yet rated', 'megashop');
                    $rating = 0;
                }

                $rating_html = '<div class="star-rating" title="' . $title . '">';
                $rating_html .= '<span style="width:' . ( ( $rating / 5 ) * 100 ) . '%"><strong class="rating">' . $rating . '</strong> ' . esc_html__('out of 5', 'megashop') . '</span>';
                $rating_html .= '</div>';
                return $rating_html;
            }

            function wooc_validate_extra_register_fields($username, $email, $validation_errors) {
                if (isset($_POST['billing_first_name']) && empty($_POST['billing_first_name'])) {
                    $validation_errors->add('billing_first_name_error', __('<strong>Error</strong>: First name is required!', 'megashop'));
                }
                if (isset($_POST['billing_last_name']) && empty($_POST['billing_last_name'])) {
                    $validation_errors->add('billing_last_name_error', __('<strong>Error</strong>: Last name is required!.', 'megashop'));
                }
                if (isset($_POST['billing_phone']) && empty($_POST['billing_phone'])) {
                    $validation_errors->add('billing_phone_error', __('<strong>Error</strong>: Phone is required!.', 'megashop'));
                }
            }

            add_action('woocommerce_register_post', 'wooc_validate_extra_register_fields', 10, 3);
            add_action('woocommerce_product_options_general_product_data', 'woo_add_custom_general_fields');

            function woo_add_custom_general_fields() {
                echo '<div class="options_group">';
                woocommerce_wp_text_input(
                        array(
                            'id' => 'new_label_text_field',
                            'label' => esc_html__('Product Custom Label', 'megashop'),
                            'placeholder' => esc_html__('New', 'megashop'),
                            'desc_tip' => 'true',
                            'description' => esc_html__('Enter the custom value here.', 'megashop')
                        )
                );
                woocommerce_wp_text_input(
                        array(
                            'id' => 'new_label_date_field',
                            'label' => esc_html__('Custom Label Last Date', 'megashop'),
                            'placeholder' => esc_html__('To  YYYY-MM-DD', 'megashop'),
                            'desc_tip' => 'true',
                            'description' => esc_html__('Select Date For Display Lable.', 'megashop')
                        )
                );
                echo '</div>';
            }

            add_action('woocommerce_process_product_meta', 'woo_add_custom_general_fields_save');

            function woo_add_custom_general_fields_save($post_id) {
                $new_label_text_field = $_POST['new_label_text_field'];
                if (!empty($new_label_text_field))
                    update_post_meta($post_id, 'new_label_text_field', esc_attr($new_label_text_field));
                $new_label_date_field = $_POST['new_label_date_field'];
                if (!empty($new_label_date_field))
                    update_post_meta($post_id, 'new_label_date_field', esc_attr($new_label_date_field));
            }

            function woo_custom_lable() {
                global $post;
                $date2 = date("Y-m-d");
                $custom_lable = get_post_meta($post->ID, 'new_label_text_field', true);
                $date1 = get_post_meta($post->ID, 'new_label_date_field', true);
                if (!empty($custom_lable) && strtotime($date2) <= strtotime($date1)) {
                    ?><div class="custom_lable"><?php echo esc_attr($custom_lable); ?></div><?php
        }
    }

}
/* ---------------------------------------------------------------------------
 * yith wishlist ajax update count
 * --------------------------------------------------------------------------- */
if (function_exists('YITH_WCWL')) {

    function megashop_update_wishlist_count() {
        wp_send_json(YITH_WCWL()->count_products());
    }

}
add_action('wp_ajax_megashop_update_wishlist_count', 'megashop_update_wishlist_count');
add_action('wp_ajax_nopriv_megashop_update_wishlist_count', 'megashop_update_wishlist_count');

/* ---------------------------------------------------------------------------
 * Get Parent Terms
 * --------------------------------------------------------------------------- */

function get_parent_terms($term) {
    if ($term->parent > 0) {
        $term = get_term_by("id", $term->parent, "product_cat");
        if ($term->parent > 0) {
            get_parent_terms($term);
        } else
            return $term;
    }
}

/* ---------------------------------------------------------------------------
 * Admin Footer Text 
 * --------------------------------------------------------------------------- */
if (isset($_GET['page']) && ($_GET['page'] == 'megashop' || $_GET['page'] == 'options-framework' || $_GET['page'] == 'support_megashop_submenu' || $_GET['page'] == 'shortcode_submenu')) {
    add_filter('admin_footer_text', 'megashop_remove_footer_admin'); //change admin footer text
    if (!function_exists('megashop_remove_footer_admin')) {

        function megashop_remove_footer_admin() {
                    ?>
                    <p id="footer-left" class="alignleft">
                    <?php esc_html_e('If you like ', 'megashop') ?>
                        <a href="#" target="_blank"><strong><?php esc_html_e('Megashop WooCommerce Responsive Theme ', 'megashop') ?></strong></a>
                    <?php esc_html_e('please leave us a ', 'megashop') ?>
                        <a class="as-review-link" data-rated="Thanks :)" target="_blank" href="https://themeforest.net/item/mega-shop-woocommerce-multipurpose-responsive-theme/reviews/19403919">&#x2605;&#x2605;&#x2605;&#x2605;&#x2605;</a>
                    <?php esc_html_e(' rating. A huge thank you from TemplateTrip in advance!', 'megashop') ?>
                    </p>
                    <?php
                }

            }
        }
        /* ---------------------------------------------------------------------------
         * Add Theme Panel 
         * --------------------------------------------------------------------------- */
        if (current_user_can('manage_options')) {
            get_template_part('admin/megashop_menu', 'panel');
        }

        /* ---------------------------------------------------------------------------
         * Redirect on theme activation
         * --------------------------------------------------------------------------- */
        add_action('admin_init', 'megashop_theme_setup_options');

        function megashop_theme_setup_options() {
            global $pagenow;
            if (is_admin() && isset($_GET['activated']) && $pagenow == 'themes.php') {
                wp_redirect(admin_url('admin.php?page=megashop'));
                exit;
            }
        }

        /* ---------------------------------------------------------------------------
         * post classes
         * --------------------------------------------------------------------------- */
        add_filter('post_class', 'megashop_prefix_post_class', 21);

        function megashop_prefix_post_class($classes) {
            if ('product' == get_post_type()) {
                $classes = array_diff($classes, array('first', 'last'));
            }
            return $classes;
        }

        /* ---------------------------------------------------------------------------
         * advanced search functionality for product search
         * --------------------------------------------------------------------------- */

        function megashop_advanced_search_query($query) {

            if ($query->is_search()) {
                // category terms search.
                if (isset($_GET['category']) && !empty($_GET['category'])) {
                    $query->set('tax_query', array(array(
                            'taxonomy' => 'product_cat',
                            'field' => 'slug',
                            'terms' => array($_GET['category']))
                    ));
                }
                return $query;
            }
        }

        add_action('pre_get_posts', 'megashop_advanced_search_query', 1000);

//Include menu
        function tt_product_menu() {
            add_submenu_page("woocommerce", __("Countdown Products", 'megashop'), __("Countdown Products", 'megashop'), "administrator", "countdown-products", "tt_product_pages");
        }

//menu pages
        add_action("admin_menu", "tt_product_menu");

        function tt_product_pages() {
            include get_template_directory() . '/admin/includes/countdown-products.php';
        }


        if (class_exists('WooCommerce')) {
            /* Ajax Quick Viewl ================================================================================================== */
            add_action('wp_ajax_tt_quickview', 'tt_quickview');
            add_action('wp_ajax_nopriv_tt_quickview', 'tt_quickview');

            /* The Quickview Ajax Output */

            function tt_quickview() {

                global $post, $product, $woocommerce, $sitepress;
                $product_id = intval($_REQUEST['productID']);
                $product_id = $_POST['productID'];

                if (isset($sitepress)) {
                    $post_id = $product_id; // Your original product ID
                    $trid = $sitepress->get_element_trid($post_id, 'post_product');
                    $translations = $sitepress->get_element_translations($trid, 'product');
                    wp('p=' . $product_id . '&post_type=product');
                    wp('p=' . $product_id . '&post_type=product');
                } else {
                    wp('p=' . $product_id . '&post_type=product');
                }

                ob_start();

                while (have_posts()) : the_post();
                    ?>     
                    <div class="product quick_product woocommerce">
                        <div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class('product'); ?>>
                            <div class="images">
                                <?php
                                global $product;
                                woocommerce_show_product_sale_flash();
                                $product_thum_id = get_post_thumbnail_id();
                                $attachment_ids = $product->get_gallery_image_ids();
                                $product_mata = get_post_meta($product_thum_id, '_wp_attachment_image_alt', true);
                                $product_url = wp_get_attachment_image_src($product_thum_id, 'shop_single', true);
                                echo '<div class="popup_product_slider">';
                                echo '<div class="pro-item"><a href="' . $product_url[0] . '"><img src="' . $product_url[0] . '"></a></div>';
                                foreach ($attachment_ids as $attachment_id) {
                                    $im = wp_get_attachment_image_src($attachment_id, 'shop_single');
                                    echo '<div class="pro-item"><a href="' . $im[0] . '"><img src="' . $im[0] . '"></a></div>';
                                }
                                echo '</div>';
                                echo '<div class="popup_product_thumb_slider">';
                                $product_img = wp_get_attachment_image_src($product_thum_id, 'shop_thumbnail');
                                echo '<div class=""><img  src="' . $product_img[0] . '" alt="' . $product_mata . '" /></div>';
                                foreach ($attachment_ids as $attachment_id) {
                                    $thumb_img = wp_get_attachment_image_src($attachment_id, 'shop_thumbnail');
                                    echo '<div class=""><img src="' . $thumb_img[0] . '"></div>';
                                }
                                echo '</div>';
                                ?>
                            </div>
                            <div class="summary entry-summary">
                                <div class="summary-content">
                    <?php
                    //do_action('woocommerce_single_product_summary');
                    add_action('woocommerce_quickveiw_product_summary', 'woocommerce_template_single_title', 5);
                    add_action('woocommerce_quickveiw_product_summary', 'woocommerce_template_single_rating', 10);
                    add_action('woocommerce_quickveiw_product_summary', 'woocommerce_template_single_price', 10);
                    add_action('woocommerce_quickveiw_product_summary', 'woocommerce_template_single_excerpt', 20);
                    add_action('woocommerce_quickveiw_product_summary', 'woocommerce_template_single_add_to_cart', 30);
                    add_action('woocommerce_quickveiw_product_summary', 'woocommerce_template_single_meta', 40);
                    add_action('woocommerce_quickveiw_product_summary', 'woocommerce_template_single_sharing', 50);
                    do_action('woocommerce_quickveiw_product_summary');
                    ?>
                                </div>
                            </div>
                        </div>  
                    </div>

                    <?php
                endwhile; // end of the loop.
                //$product = wc_get_template( 'yith-quick-view-content.php', array(), '', get_template_directory() . '/woocommerce/' );

                echo ob_get_clean();
                die();
            }

            add_action('wp_footer', 'quickview');
            add_action('woocommerce_quickveiw_product_summary', 'add_product_detail_link', 15);

            function add_product_detail_link() {
                echo '<a class="veiw_all" href="' . get_the_permalink() . '" alt="' . get_the_title() . '">' . __('Veiw all Features ', 'megashop') . ' <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
</a>';
            }

            function quickview() {
                ?>
                <div class="tt-quickview-wrap">
                    <div class="overlay-bg" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; z-index: 10; cursor: pointer;" onclick="RemoveQuickView()"></div>
                    <div id="product-modal" class="quick-modal">
                        <span class="QVloading"></span>
                        <span class="CloseQV">
                            <i class="fa fa-times"></i>
                        </span>
                        <div class="modal-body" id="quickview-content">

                        </div>
                    </div>
                </div>
                <?php
            }

        }

        function tt_print_images_thumb($src, $alttext, $width = 200, $height = 200, $align = 'left') {
            $src = mr_image_resize($src, $width, $height, true, $align, false);
            if (empty($src) || $src == 'image_not_specified'):
                $src = get_template_directory_uri() . "/images/placeholder.png";
                $src = mr_image_resize($src, $width, $height, true, $align, false);
            endif;
            $return = '';
            $return .= '<img src="' . $src . '"';
            $return .= " title='$alttext' alt='$alttext' width='$width' height='$height' />";
            return do_shortcode($return);
        }

// **********************************************************************// 
// ! Display all images in popup for product page
// **********************************************************************// 

        add_action('woocommerce_after_single_product', 'pro_image_photoswiper', 2);

        function pro_image_photoswiper() {
            ?>
            <div id="pswp" class="pswp photoswipe-wrap" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="pswp__bg"></div>

                <div class="pswp__scroll-wrap">
                    <div class="pswp__container">
                        <div class="pswp__item"></div><div class="pswp__item"></div><div class="pswp__item"></div>
                    </div>

                    <div class="pswp__ui pswp__ui--hidden">
                        <div class="pswp__top-bar">
                            <div class="pswp__counter"></div>
                            <button class="pswp__button pswp__button--close nm-font-close2" title="Close (Esc)"></button>
                            <button class="pswp__button pswp__button--share nm-font-plus" title="Share"></button>
                            <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                            <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                            <div class="pswp__preloader nm-loader"></div>
                        </div>

                        <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                            <div class="pswp__share-tooltip"></div> 
                        </div>

                        <button class="pswp__button pswp__button--arrow--left nm-font-angle-thin-left" title="Previous (arrow left)"></button>
                        <button class="pswp__button pswp__button--arrow--right nm-font-angle-thin-right" title="Next (arrow right)"></button>
                    </div>
                </div>
            </div>
            <?php
        }

// **********************************************************************// 
// ! Display second image in the gallery
// **********************************************************************// 

        if (!function_exists('tt_get_second_image')) {

            function tt_get_second_image($size = 'shop_catalog') {
                global $post, $product, $woocommerce_loop;
                $attachment_ids = $product->get_gallery_image_ids();


                if (!empty($attachment_ids[0])) {
                    ?> 
                    <?php
                    echo tt_get_image_html($attachment_ids[0], 'shop_catalog', 'fade tt_img_hover replace-2x');
                }
            }

        }
        /*         * */

        function action_woocommerce_product_write_panel_tabs() {
            ?>
            <li class="bundle_products_options bundle_products_tab show_if_simple show_if_variable">
                <a href="#bundle_products_product_data"><?php echo esc_html__(' Bundle Products', 'megashop'); ?></a>
            </li>
                            <?php
                        }

// add the action 
                        add_action('woocommerce_product_write_panel_tabs', 'action_woocommerce_product_write_panel_tabs');

                        add_action('woocommerce_product_data_panels', 'add_product_bundle_products_panel_data');

                        function add_product_bundle_products_panel_data() {
                            global $post;
                            ?>
            <div id="bundle_products_product_data" class="panel woocommerce_options_panel">
                <div class="options_group">
                    <p class="form-field">
                        <label for="bundle_prduct_ids"><?php _e('Bundle product', 'megashop'); ?></label>
                        <select class="wc-product-search" multiple="multiple" style="width: 50%;" id="bundle_prduct_ids" name="bundle_prduct_ids[]" data-placeholder="<?php esc_attr_e('Search for a product&hellip;', 'megashop'); ?>" data-action="woocommerce_json_search_products_and_variations" data-exclude="<?php echo intval($post->ID); ?>">
            <?php
            $product_ids = array_filter(array_map('absint', (array) get_post_meta($post->ID, '_bundle_prduct_ids', true)));

            foreach ($product_ids as $product_id) {
                $product = wc_get_product($product_id);
                if (is_object($product)) {
                    echo '<option value="' . esc_attr($product_id) . '"' . selected(true, true, false) . '>' . wp_kses_post($product->get_formatted_name()) . '</option>';
                }
            }
            ?>
                        </select> <?php echo wc_help_tip(__('add Bundle products.', 'megashop')); ?>
                    </p>
                </div>
            </div>
            <?php
        }

       function get_bundle_products( $product ) {
    global $product;
   $current_product = get_the_ID();
$bundle_product = maybe_unserialize(get_post_meta($current_product,'_bundle_prduct_ids',true));
        return $bundle_product;
}
function tt_add_pack_label() {
$bundle_product = get_bundle_products(get_the_ID() );
if ( !empty($bundle_product) ) {
    $lable = __( 'pack', 'megashop' );
   ?>
     <div class="pack_lable custom_lable"><?php echo esc_attr($lable); ?></div>
  <?php
}
}

        function save_product_bundle_products_panel_data($post_id) {
            if (isset($_POST['bundle_prduct_ids']) && !empty($_POST['bundle_prduct_ids'])) {
                $bundle_products = isset($_POST['bundle_prduct_ids']) ? array_map('intval', (array) $_POST['bundle_prduct_ids']) : array();
            } else {
                $bundle_products = "";
            }
            update_post_meta($post_id, '_bundle_prduct_ids', $bundle_products);
        }

// Save Accessories Tab
        add_action('woocommerce_process_product_meta_simple', 'save_product_bundle_products_panel_data');
        add_action('woocommerce_process_product_meta_variable', 'save_product_bundle_products_panel_data');
        add_action('woocommerce_process_product_meta_grouped', 'save_product_bundle_products_panel_data');
        add_action('woocommerce_process_product_meta_external', 'save_product_bundle_products_panel_data');

        function megashop_bundle_products_total_price() {
            global $woocommerce;
            $price = empty($_POST['price']) ? 0 : $_POST['price'];

            if ($price) {
                $price_html = wc_price($price);
                echo wp_kses_post($price_html);
            }

            die();
        }

        add_action('wp_ajax_nopriv_megashop_bundle_products_total_price', 'megashop_bundle_products_total_price');
        add_action('wp_ajax_megashop_bundle_products_total_price', 'megashop_bundle_products_total_price');

        /**
         * AJAX add to cart.
         */
        function add_to_cart() {
            $product_id = apply_filters('megashop_add_to_cart_product_id', absint($_POST['product_id']));
            $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
            $variation_id = empty($_POST['variation_id']) ? 0 : $_POST['variation_id'];
            $variation = empty($_POST['variation']) ? 0 : $_POST['variation'];
            $passed_validation = apply_filters('megashop_add_to_cart_validation', true, $product_id, $quantity);
            $product_status = get_post_status($product_id);

            if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variation) && 'publish' === $product_status) {

                do_action('woocommerce_ajax_added_to_cart', $product_id);

                if (get_option('woocommerce_cart_redirect_after_add') == 'yes') {
                    wc_add_to_cart_message($product_id);
                }

                // Return fragments
                WC_AJAX::get_refreshed_fragments();
            } else {

                // If there was an error adding to the cart, redirect to the product page to show any errors
                $data = array(
                    'error' => true,
                    'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id)
                );

                wp_send_json($data);
            }

            die();
        }

        add_action('wp_ajax_nopriv_megashop_variable_add_to_cart', 'add_to_cart');
        add_action('wp_ajax_megashop_variable_add_to_cart', 'add_to_cart');

        /**
         * Remove mini cart item
         *
         * @since 1.0
         */
        function remove_mini_cart_item() {
            global $woocommerce;
            $nonce = isset($_POST['nonce']) ? $_POST['nonce'] : '';
            $remove_item = isset($_POST['item']) ? $_POST['item'] : '';
            $response = 0;
            if (wp_verify_nonce($nonce, '_tt_nonce') && !empty($remove_item)) {
                $woocommerce->cart->remove_cart_item($remove_item);
                $response = 1;
            }
            // Send the comment data back to Javascript.
            wp_send_json_success($response);
            die();
        }

        add_action('wp_ajax_tt_remove_mini_cart_item', 'remove_mini_cart_item');
        add_action('wp_ajax_nopriv_tt_remove_mini_cart_item', 'remove_mini_cart_item');

        /**
         * Display products link
         *
         * @since 1.0
         */
        function tt_prev_next_product() {

            if (!function_exists('is_product')) {
                return;
            }

            if (!is_product()) {
                return;
            }

            $prev_link = '<i class="fa fa-angle-left"></i>';
            $next_link = '<i class="fa fa-angle-right"></i>';
            ?>
            <div class="prev_next_buttons woo_product">
            <?php
            previous_post_link('<div class="nav-previous">%link</div>', $prev_link);
            next_post_link('<div class="nav-next">%link</div>', $next_link);
            ?>
            </div>
            <?php
        }

        add_action('woocommerce_single_product_summary', 'tt_prev_next_product', 1);

        add_filter('next_post_link', 'post_link_attributes');
        add_filter('previous_post_link', 'post_link_attributes');

        function post_link_attributes($output) {
            $code = 'class="woo-button"';
            return str_replace('<a href=', '<a ' . $code . ' href=', $output);
        }

        /**
         * Get current page URL for layered nav items.
         * @return string
         */
        function tt_get_page_base_url() {
            if (defined('SHOP_IS_ON_FRONT')) {
                $link = home_url();
            } elseif (is_post_type_archive('product') || is_page(wc_get_page_id('shop'))) {
                $link = get_post_type_archive_link('product');
            } elseif (is_product_category()) {
                $link = get_term_link(get_query_var('product_cat'), 'product_cat');
            } elseif (is_product_tag()) {
                $link = get_term_link(get_query_var('product_tag'), 'product_tag');
            } else {
                $queried_object = get_queried_object();
                $link = get_term_link($queried_object->slug, $queried_object->taxonomy);
            }

            return $link;
        }

        /**
         * show categories filter
         *
         * @return string
         */
        function get_categories_filter() {

            $filters = '';
            $output = array();
            $number = apply_filters('tt_product_cats_filter_number', 4);

            $term_id = 0;
            $args = array(
                'parent' => $term_id,
                'number' => $number,
                'orderby' => 'count',
                'order' => 'desc'
            );
            $categories = get_terms('product_cat', $args);

            $current_id = '';
            if (is_tax('product_cat')) {
                $queried_object = get_queried_object();
                if ($queried_object) {
                    $current_id = $queried_object->term_id;
                }
            }

            $found = false;

            if (!is_wp_error($categories) && $categories) {
                foreach ($categories as $cat) {

                    $css_class = '';
                    if ($cat->term_id == $current_id) {
                        $css_class = 'selected';
                        $found = true;
                    }
                    $filters .= sprintf('<li><a class="%s" href="%s">%s</a></li>', esc_attr($css_class), esc_url(get_term_link($cat)), esc_html($cat->name));
                }
            }

            $css_class = $found ? '' : 'selected';

            if ($filters) {
                $output[] = sprintf(
                        '<ul class="option-set" data-option-key="filter">
                        <li><a href="%s" class="%s">%s</a></li>
                            %s
                </ul>', esc_url(get_permalink(get_option('woocommerce_shop_page_id'))), esc_attr($css_class), esc_html__('All', 'megashop'), $filters
                );
            }


            return '<div class="tt-toggle-cats-filter widget-title" id="tt-toggle-cats-filter">' . esc_html__('Categories', 'megashop') . '</div> <div id="tt-categories-filter" class="tt-categories-filter">' . implode("\n", $output) . '</div>';
        }

        /* ------------------------------------------------------------------------ */
        /* Helper - expand allowed tags()
          /* Source: https://gist.github.com/adamsilverstein/10783774
          /* ------------------------------------------------------------------------ */

        function tt_expand_allowed_tags() {
            $my_allowed = wp_kses_allowed_html('post');
            // iframe
            $my_allowed['iframe'] = array(
                'src' => array(),
                'height' => array(),
                'width' => array(),
                'frameborder' => array(),
                'allowfullscreen' => array(),
            );
            return $my_allowed;
        }

        /* ------------------------------------------------------------------------ */
        /* EOF
          /* ------------------------------------------------------------------------ */

        /**
         * Get product image use lazyload
         *
         * @since  1.0
         *
         * @return string
         */
        function tt_get_image_html($post_thumbnail_id, $image_size, $css_class = '', $attributes = false) {
            global $post;
            $output = '';
            $props = wc_get_product_attachment_props($post_thumbnail_id, $post);
            $image = wp_get_attachment_image_src($post_thumbnail_id, $image_size);

            if ($image) {
                $image_trans = get_template_directory_uri() . '/images/lazyload.png';

                if ($attributes) {
                    $output = sprintf(
                            '<img src="%s" data-original="%s" data-lazy="%s" alt="%s" class="lazy %s" width="%s" height="%s" data-large_image_width="%s" data-large_image_height="%s">', esc_url($image_trans), esc_url($image[0]), esc_url($image[0]), esc_attr($props['alt']), esc_attr($css_class), esc_attr($image[1]), esc_attr($image[2]), esc_attr($attributes['data-large_image_width']), esc_attr($attributes['data-large_image_height'])
                    );
                } else {
                    $output = sprintf(
                            '<img src="%s" data-original="%s" data-lazy="%s" alt="%s" class="lazy %s" width="%s" height="%s">', esc_url($image_trans), esc_url($image[0]), esc_url($image[0]), esc_attr($props['alt']), esc_attr($css_class), esc_attr($image[1]), esc_attr($image[2])
                    );
                }
            }
            return $output;
        }
        add_filter( 'loop_shop_per_page', 'new_loop_shop_per_page', 20 );
        function new_loop_shop_per_page($cols) {
            // $cols contains the current number of products per page based on the value stored on Options -> Reading
            // Return the number of products you wanna show per page.
            $number_product = of_get_option('number_product');
            if (!empty($number_product)) {
                $cols = $number_product;
            } else {
                $cols = 10;
            }

            return $cols;
        }

        function bundle_leble() {
            $bundle_product = get_bundle_products($product);
            if (sizeof($bundle_product) === 0 && !array_filter($bundle_product) && empty($bundle_product)) {
                return;
            } else {
                ?>
                <span class="packed_lable"> <?php esc_html_e('Pack', 'megashop'); ?></span>
                <?php
            }
        }

//add_action('woocommerce_before_shop_loop_item_title','bundle_leble',11);

/* custom video field product */
// Display Fields
add_action('woocommerce_product_options_general_product_data', 'tt_product_video_custom_fields');

// Save Fields
add_action('woocommerce_process_product_meta', 'tt_product_custom_video_fields_save');

function tt_product_video_custom_fields() {
    global $woocommerce, $post;
    echo '<div class="product_video_field">';
    // Custom Product Text Field
    woocommerce_wp_text_input(
            array(
                'id' => '_custom_product_video_field',
                'placeholder' => 'Custom Product Video Link',
                'label' => __('TT Custom Product video Field', 'megashop'),
                'desc_tip' => 'true'
            )
    );
    echo '</div>';
}

function tt_product_custom_video_fields_save($post_id) {
    // Custom Product Text Field
    $woocommerce_custom_product_text_field = $_POST['_custom_product_video_field'];
    update_post_meta($post_id, '_custom_product_video_field', esc_attr($woocommerce_custom_product_text_field));
}

function tt_custom_video_product() {
    $video_link = get_post_meta($post->ID, '_custom_product_video_field', true);
    if ($video_link != "") {
        ?>
        <div class="custom_product_video">
            <a href="<?php echo esc_url($video_link); ?>" class="custom_product_video_field"><?php _e('Launch video player', 'megashop'); ?></a>
        </div>
        <?php
    }
}

if (class_exists('WooCommerce') && is_plugin_active('TTCustomShortcode/TTCustomShortcode.php')) {
    add_action('woocommerce_single_product_summary', 'tt_product_360_view', 60);
    if (!function_exists('tt_product_360_view')) {

        function tt_product_360_view() {
            $images = tt_get_360_gallery_attachment_ids();
            if (empty($images))
                return;

            $id = rand(100, 999);

            $title = '';

            $frames_count = count($images);

            $images_js_string = '';
            ?>

            <div class="product-360-button">
                <a href="#product-360-view"><span><?php _e('360 product view', 'megashop'); ?></span></a>
            </div>

            <div id="product-360-view" class="product-360-view-wrapper mfp-hide">
                <div class="tt-360-veiw threed-id-<?php echo esc_attr($id); ?>">
                    <?php if (!empty($title)): ?>
                        <h3 class="threed-title"><span><?php echo esc_html($title); ?></span></h3>
                    <?php endif ?>
                    <ul class="threed-view-images">
                        <?php if (count($images) > 0): ?>
                            <?php
                            $i = 0;
                            foreach ($images as $img_id): $i++;
                                ?>
                                <?php
                                $img = wp_get_attachment_image_src($img_id, 'full');
                                $width = $img[1];	
                                $height = $img[2];
                                $images_js_string .= "'" . $img[0] . "'";
                                if ($i < $frames_count) {
                                    $images_js_string .= ",";
                                }
                                ?>
                            <?php endforeach ?>
                        <?php endif ?>
                    </ul>
                    <div class="spinner">
                        <span>0%</span>
                    </div>
                </div>
                <script type="text/javascript">
                    jQuery(document).ready(function() {
                        jQuery('.threed-id-<?php echo esc_attr($id); ?>').ThreeSixty({
                            totalFrames: <?php echo count($images); ?>,
                            endFrame: <?php echo count($images); ?>,
                            currentFrame: 1,
                            imgList: '.threed-view-images',
                            progress: '.spinner',
                            imgArray: [<?php echo $images_js_string; ?>],
                            height: <?php echo $height ?>,
                            width: <?php echo $width ?>,
                            responsive: true,
                            navigation: true
                        });
                    });
                </script>
            </div>
            <?php
        }

    }
}