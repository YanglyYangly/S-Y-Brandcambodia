<?php 
    global $product;
?>
<div class="product-fixed-wrapper">
<div class="col-md-3 product-summary-fixed product-summary">
    <div class="fixed-product-block summary entry-summary">
        <div class="fixed-content">
                <?php
                woocommerce_template_single_title();
                woocommerce_template_single_rating();
                echo '<hr class="divider short">';
                woocommerce_template_single_excerpt();
                ?>
         </div>
     </div>
</div>

<div class="product-images col-md-6 product-images-fixed">
    <div class="product-block"> 
    <?php
        /**
         * woocommerce_before_single_product_summary hook
         *
         * @hooked woocommerce_show_product_sale_flash - 10
         * @hooked woocommerce_show_product_images - 20
         */
        do_action( 'woocommerce_before_single_product_summary' );
    ?>
    </div>
</div><!-- Product images/ END -->

<div class="col-md-3 product-information">
    <div class="product-information-inner summary entry-summary product-block fixed-product-block">
        <div class="fixed-content">
            <?php
                /**
                 * woocommerce_single_product_summary hook
                 *
                 * @hooked woocommerce_template_single_title - 5 
                 * @hooked woocommerce_template_single_rating - 10
                 * @hooked woocommerce_template_single_price - 10
                 * @hooked woocommerce_template_single_excerpt - 20
                 * @hooked woocommerce_template_single_add_to_cart - 30
                 * @hooked woocommerce_template_single_meta - 40
                 * @hooked woocommerce_template_single_sharing - 50
                 */
                do_action( 'woocommerce_single_product_summary' );
            $video_link = get_post_meta($post->ID, '_custom_product_video_field', true);
            if ($video_link != "") {
                ?>
                <div class="custom_product_video">
                    <a href="<?php echo esc_url($video_link); ?>" class="custom_product_video_field"><?php _e('Launch video player', 'megashop'); ?></a>
                </div>
<?php } ?>
           </div>
    </div>
</div><!-- Product information/ END -->
</div>
 <?php tt_product_bundle_tab(); ?>