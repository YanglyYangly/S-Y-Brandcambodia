<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.1
 */
defined('ABSPATH') || exit; 

/**
 * woocommerce_before_main_content hook.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
do_action('woocommerce_before_main_content');
?>

<header class="woocommerce-products-header">


    <?php
    if (!is_product_category()) {
        if (apply_filters('woocommerce_show_page_title', true)) :
            ?>

            <h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>

        <?php endif;
    }
    ?>

    <?php
    /**
     * woocommerce_archive_description hook.
     *
     * @hooked woocommerce_taxonomy_archive_description - 10
     * @hooked woocommerce_product_archive_description - 10
     */
    do_action('woocommerce_archive_description');
    ?>

</header>
    <?php if (woocommerce_product_loop()) { ?>
    <div id="shop_product_wrapper" class="product_wrapper">
        <?php
        if (isset($_GET['ajax_filter']) && $_GET['ajax_filter'] == 1) {
            $ajax_filter = 1;
        } else {
            $ajax_filter = of_get_option('ajax_filter');
        }
        /* if ($ajax_filter == 1) {
            remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
        } */
        /**
         * woocommerce_before_shop_loop hook.
         *
         * @hooked woocommerce_result_count - 20
         * @hooked woocommerce_catalog_ordering - 30
         */
        do_action('woocommerce_before_shop_loop');
        if (isset($_GET['shop_masonry']) && $_GET['shop_masonry'] == 1) {
            $shop_masonry = 1;
        } else {
            $shop_masonry = of_get_option('shop_masonry');
        }
        if ($shop_masonry == 1) {
            $class = 'shop_masonry';
        } else {
            $class = 'shop_normal';
        }
        ?>
        <div id="shop_product_wrap" class="product_wrap <?php echo esc_attr($class); ?>">                        
            <div id="shop-loading" class="shop-loading"><div class="shop-loader"></div></div>
            <div class="row">
                <?php
                woocommerce_product_loop_start();
                if (wc_get_loop_prop('total')) {
                    woocommerce_product_subcategories();
                    while (have_posts()) {
                        the_post();

                        /**
                         * woocommerce_shop_loop hook.
                         *
                         * @hooked WC_Structured_Data::generate_product_data() - 10
                         */
                        do_action('woocommerce_shop_loop');
                        wc_get_template_part('content', 'product');
                    }  // end of the loop
                }
                woocommerce_product_loop_end();
                ?>

                <?php
                /**
                 * woocommerce_after_shop_loop hook.
                 *
                 * @hooked woocommerce_pagination - 10
                 */
                do_action('woocommerce_after_shop_loop');
                ?>
            </div>
        <?php
        } else {


            /**
             * woocommerce_no_products_found hook.
             *
             * @hooked wc_no_products_found - 10
             */
            do_action('woocommerce_no_products_found');
            ?>
        </div>
    </div>
<?php } ?>

<?php
/**
 * woocommerce_after_main_content hook.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('woocommerce_after_main_content');