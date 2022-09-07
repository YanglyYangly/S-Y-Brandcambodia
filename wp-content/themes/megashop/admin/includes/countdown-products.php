<?php

//function for pagination
function tt_admin_pagination($pages = '', $range = 4) {
    $showitems = ($range * 2) + 1;
    //global $paged;
    $paged = (sanitize_text_field($_GET['paged'])) ? sanitize_text_field($_GET['paged']) : 1;
    if (empty($paged))
        $paged = 1;
    if ($pages == '') {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if (!$pages) {
            $pages = 1;
        }
    }
    if (1 != $pages) {
        echo "<div class=\"pagination\"><span>Page " . $paged . " of " . $pages . "</span>";
        if ($paged > 2 && $paged > $range + 1 && $showitems < $pages)
            echo "<a href='" . get_pagenum_link(1) . "'>&laquo; First</a>";
        if ($paged > 1 && $showitems < $pages)
            echo "<a href='" . get_pagenum_link($paged - 1) . "'>&lsaquo;&lsaquo;</a>"; //previous
        for ($i = 1; $i <= $pages; $i++) {
            if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems )) {
                if($paged == $i) {
                    echo "<span class=\"current\">" . $i . "</span>";
                } else {
                     echo "<a href='" . get_pagenum_link($i) . "' class=\"inactive\">" . $i . "</a>";
                }
            }
        }
        if ($paged < $pages && $showitems < $pages)
            echo "<a href=\"" . get_pagenum_link($paged + 1) . "\">&rsaquo;&rsaquo;</a>"; //next
        if ($paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages)
            echo "<a href='" . get_pagenum_link($pages) . "'>Last &raquo;</a>";
        echo "</div>\n";
    }
}
?>


<div class="wrap">
    <h2>Countdown Products <a href="<?php echo site_url(); ?>/wp-admin/post-new.php?post_type=product" class="add-new-h2"><?php _e('Add Countdown Product', 'megashop'); ?></a></h2>
    <table class="wp-list-table widefat fixed striped posts tt-admin-table">
        <thead>
            <tr>
                <th scope="col" id="thumb" class="manage-column column-thumb" style=""><span><?php _e('Product Image', 'megashop'); ?></span></th>
                <th scope="col" id="name" class="manage-column column-name" style=""><span><?php _e('Product Name', 'megashop'); ?></span></th>     
                <th scope="col" id="name" class="manage-column column-sku" style=""><span><?php _e('SKU', 'megashop'); ?></span></th>     
                <th scope="col" id="name" class="manage-column column-Stcok" style=""><span><?php _e('Stcok', 'megashop'); ?></span></a></th>                
                <th scope="col" id="date" class="manage-column column-price" style=""><span><?php _e('Price', 'megashop'); ?></span></th>
                <th scope="col" id="date" class="manage-column column-date" style=""><span><?php _e('Offer Ends', 'megashop'); ?></span></th>
                <th scope="col" class="manage-action" style=""><span>Action</span></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $paged = (isset($_GET['paged'])) ? sanitize_text_field($_GET['paged']) : 1;
            $post_per_page = 20;
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => $post_per_page,
                'paged' => $paged,
                'meta_query' => array(
                    array(
                        'key' => 'tt_sales_countdown',
                        'value' => 'sales_yes',
                        'compare' => '=',
                    )
                )
            );


            $the_query = new WP_Query($args);

            if ($the_query->have_posts()) :
                while ($the_query->have_posts()) : $the_query->the_post();
                    $post_id = get_the_ID();
                    $_product = wc_get_product( $post_id );
                    $product_id = get_post_thumbnail_id();
                    $product_url = wp_get_attachment_image_src($product_id, 'full', true);
                    $product_mata = get_post_meta($product_id, '_wp_attachment_image_alt', true);
                    $product_link = get_permalink() . '<br>';
                    ?>
            <tr id="post-<?php echo esc_attr($post_id); ?>">
                        <td class="thumb column-thumb">
                            <a href="<?php echo get_edit_post_link($post_id); ?>">
                                <?php echo the_post_thumbnail('thumbnail'); ?>
                            </a>
                        </td>
                        <td class="name column-name">
                            <strong>
                                <a class="row-title" href="<?php echo get_edit_post_link($post_id); ?>"><?php the_title(); ?></a>
                            </strong>
                        </td>
                        <td class="name column-name">
                            <span class="na">
                                <?php  $sku = $_product->get_sku();
                                if(!empty($sku)){
                                    echo esc_attr($sku);
                                }else{
                                    echo '_';
                                }
                                ?>
                            </span>
                        </td>
                        <td class="name column-stock">
                                <?php if ( $_product->is_in_stock() ){
                                     echo __('In Stock', 'megashop');
                                }else{
                                      echo __('Out Of Stock', 'megashop');
                                }
                                ?>
                        </td>                        
                        <td class="name column-price">
                                <?php echo do_shortcode($_product->get_price_html()); ?>
                        </td>
                        <td class="date column-date">
                            <?php $offer_ends = get_post_meta($post_id, 'tt_end_sales_date', true); ?>
                            <?php  $str_time = date('Y/m/d', $offer_ends); ?>
                            <?php $now_time = time(); ?>

                            <?php if ($offer_ends > $now_time) { ?>
                                <abbr title="<?php echo date('Y/m/d', $offer_ends); ?>"><?php echo date('Y/m/d', $offer_ends); ?></abbr>
                            <?php } else { ?>
                                <abbr title="<?php echo date('Y/m/d', $offer_ends); ?>"><?php _e('Timeout!','megashop'); ?></abbr>
                            <?php } ?>

                        </td>
                        <td class="name column-name">
                            <strong>
                                <a class="row-title" href="<?php echo get_edit_post_link($post_id); ?>"><div class="dashicons-edit dashicons"></div></a>
                            </strong>
                        </td>
                    </tr>
                    <?php
                endwhile;
                else: ?>
                   <tr class="no-record"><td colspan="7"><?php _e('No products Found..','megashop'); ?></td></tr><?php
            endif;
            ?>
            <?php
            
            
            //pagination 
            if (function_exists("tt_admin_pagination") and $the_query->found_posts > 20) {
                ?>
                <tr>
                    <td colspan="7">
                        <div  style="float:right;"><?php tt_admin_pagination($the_query->max_num_pages); ?></div>
                    </td> 
                </tr>
    <?php
}
?>
        </tbody>
    </table>
</div>