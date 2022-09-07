<?php
/**
 * Product loop sale flash
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/sale-flash.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.5.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;
$sale_value = of_get_option( 'sale_percentage' );
?>
<?php if ( $product->is_on_sale() ) : ?>

	<?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', 'megashop' ) . '</span>', $post, $product ); ?>
        <?php if ( $sale_value == 1 && $product->get_type() == 'simple' ): 
			$regular_price = $product->get_regular_price();
			$sale_price = $product->get_sale_price();
			$percentage = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
			
		    echo  '<div class="sale-back"><span class="sale-value">-'. $percentage . '%' .'</span></div>';
	   
                    endif ?>
<?php endif;

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
