<?php
/**
 * Single Product page Bundle products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

$woocommerce_loop['columns'] = apply_filters( 'megashop_bundle_product_loop_columns', 3 );

//$bundle_product = get_bundle_products( $product );
$current_product = get_the_ID();
$bundle_product = maybe_unserialize(get_post_meta($current_product,'_bundle_prduct_ids',true));
if ( !empty($bundle_product) ) {
	
//print_r($product);
$meta_query = WC()->query->get_meta_query();

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => 3,
	'orderby'             => 'post__in',
	'post__in'            => $bundle_product,
	'meta_query'          => $meta_query
);

unset( $args['meta_query'] );

$products = new WP_Query( $args );


$add_to_cart_checkbox 	= '';
$total_price = 0;
$count 	= 0;

if ( $products->have_posts() ) : ?>

	<div class="bundle_product col-xs-12">

		<div class="megashop-wc-message"></div>
		<div class="row">
			<div class="col-xs-12 col-left padding_0">

				<?php woocommerce_product_loop_start(); ?>

					<li class="post-<?php echo esc_attr( get_the_ID() ); ?> product first">
						<div class="product-container">
							<div class="product-inner">
								<a href="<?php echo esc_url( $product->get_permalink() );?>">
									<div class="product-thumbnail">
										<?php echo wp_kses_post( $product->get_image( 'shop_catalog' ) ); ?>
									</div>
								</a>
                                                            <div class="product-description">
                                                                <div class="caption">
                                                                <?php //echo $product->get_categories( ' ', '<span class="posted_in">' . _n( '', '', sizeof( get_the_terms( $product->ID, 'megashop' ) ), 'megashop' ) . ' ', '</span>' ); ?>
                                                                </div>
                                                                <h3><?php echo wp_kses_post( $product->get_title() ); ?></h3>
                                                                <?php if ($average = $product->get_average_rating()) : ?>
                                                                    <?php echo '<div class="star-rating" title="'.sprintf(__( 'Rated %s out of 5', 'megashop' ), $average).'"><span style="width:'.( ( $average / 5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">'.$average.'</strong> '.__( 'out of 5', 'megashop' ).'</span></div>'; ?>
                                                                <?php endif; ?>
                                                                <div class="price-add-to-cart"><p class="price"><?php echo wp_kses_post( $product->get_price_html() ); ?></p></div>
                                                            </div>
							</div>
						</div>					
					</li>

					<?php
						$count++;
						$price_html = '';

						if ( $price_html = $product->get_price_html() ) {
							$price_html = '<span class="bundleproduct-price">' . $price_html . '</span>';
						}

						$total_price += $product->get_price();
						
						$add_to_cart_checkbox = '<div class="checkbox bundleproduct-checkbox"><label><input checked="checked" disabled type="checkbox" class="product-check" data-price="'  . $product->get_price() . '" data-product-id="' . get_the_ID() . '" data-product-type="' . $product->get_type() . '" /> <span class="product-title"><strong>' . esc_html__( 'This product: ', 'megashop' ) . '</strong>' . get_the_title() . '</span> - ' . $price_html . '</label></div>';
                                                
                                                $add_to_cart_item = '<div class="total_item_price first post-'.esc_attr( $product->get_id() ).'" data="'.$product->get_price().'"><span>'.esc_html__('1 Item','megashop').'</span>'.$price_html.'</div>';
                                                
					?>

					<?php $woocommerce_loop['loop']    = 1; // Set to 1 because we have already displayed the single product just above ?>

					<?php while ( $products->have_posts() ) : $products->the_post(); ?>

						<?php wc_get_template_part( 'content', 'product' ); ?>

						<?php 
							global $product;
							
							$price_html = '';

							if ( $price_html = $product->get_price_html() ) {
								$price_html = '<span class="bundleproduct-price">' .$price_html. '</span>';
							}

							$total_price += $product->get_price();

							$prefix = '';

							$count++;

							$add_to_cart_checkbox .= '<div class="checkbox bundleproduct-checkbox"><label><input checked="checked" type="checkbox" class="product-check" data-price="'  . $product->get_price() . '" data-product-id="' . $product->get_id() . '" data-product-type="' . $product->get_type() . '" /> <span class="product-title">' . $prefix . get_the_title() . '</span> - ' . $price_html . '</label></div>';
                                                        $add_to_cart_item .= '<div class="total_item_price post-'.esc_attr( get_the_ID() ).'" data="'.$product->get_price().'"><span>'.esc_html__('1 Addon','megashop').'</span>'.$price_html.'</div>';
						?>

					<?php endwhile; // end of the loop. ?>

				<?php woocommerce_product_loop_end(); ?>
				
				<div class="check-products col-xs-12">
					<?php echo do_shortcode($add_to_cart_checkbox); ?>
                                    <div class="total_count"><?php echo do_shortcode($add_to_cart_item); ?>
                                        <div class="col-xs-12 col-sm-3 col-right">
                                    <div class="total-price">
					<?php   echo '<span class="total_title">'.esc_html__('Total','megashop').'</span>';
						$total_price_html = '<span class="total-price-html">' . wc_price( $total_price ) . $product->get_price_suffix() . '</span>';
						$total_products_html = '<span class="total-products">' . $count . '</span>';
						$total_price = sprintf( __( '%s for %s item(s)', 'megashop' ), $total_price_html, $total_products_html );
						echo wp_kses_post( $total_price );
					?>
				</div>
                                        
                                    </div>
                                        <div class="bundle_product-add-all-to-cart">
					<button type="button" class="button btn btn-primary add-all-to-cart"><?php echo esc_html__( 'Add all to cart', 'megashop' ); ?></button>
				</div>
				</div>

			</div>
				
				
			</div>
		</div>
		<?php
			$alert_message = apply_filters( 'megashop_bundle_product_product_cart_alert_message', array(
				'success'		=> sprintf( '<div class="woocommerce-message">%s <a class="button wc-forward" href="%s">%s</a></div>', esc_html__( 'Products was successfully added to your cart.', 'megashop' ), wc_get_cart_url(), esc_html__( 'View Cart', 'megashop' ) ),
				'empty'			=> sprintf( '<div class="woocommerce-error">%s</div>', esc_html__( 'No Products selected.', 'megashop' ) ),
				'no_variation'	=> sprintf( '<div class="woocommerce-error">%s</div>', esc_html__( 'Product Variation does not selected.', 'megashop' ) ),
			) );
		?>
		
               
<?php 
                $jquery_code = "";                
                $jquery_code .= "\n jQuery(document).ready(function () {\n";
                $jquery_code .= "\n jQuery('.bundle_product-add-all-to-cart .add-all-to-cart').click(function() {\n";
                $jquery_code .= "\n var bundle_product_all_product_ids = bundleproduct_checked_product_ids();\n";
                $jquery_code .= "\n var bundle_product_variable_product_ids = bundleproduct_checked_variable_product_ids();\n";
                $jquery_code .= "\n if( bundle_product_all_product_ids.length === 0 ) {\n";
                $jquery_code .= "\n var bundle_product_alert_msg = '". wp_kses_post( $alert_message['empty'] )."';\n";
                $jquery_code .= "\n } else if( bundle_product_variable_product_ids.length > 0 && bundleproduct_is_variation_selected() === false ) {\n";
                $jquery_code .= "\n var bundle_product_alert_msg = '". wp_kses_post( $alert_message['no_variation'] )."';\n";
                $jquery_code .= "\n } else {\n";
                $jquery_code .= "\n for (var i = 0; i < bundle_product_all_product_ids.length; i++ ) {\n";
                $jquery_code .= "\n if( ! jQuery.inArray( bundle_product_all_product_ids[i], bundle_product_variable_product_ids ) ) {\n";
                $jquery_code .= "\n var variation_id  = jQuery('.variations_form .variations_button').find('input[name^=variation_id]').val();\n";
                $jquery_code .= "\n var variation = {};\n";
                $jquery_code .= "\n if( jQuery( '.variations_form' ).find('select[name^=attribute]').length ) {\n";
                $jquery_code .= "\n jQuery( '.variations_form' ).find('select[name^=attribute]').each(function() {\n";
                $jquery_code .= "\n var attribute = jQuery(this).attr('name');var attributevalue = jQuery(this).val();\n";                
                $jquery_code .= "\n variation[attribute] = attributevalue; }); } else { \n";
                $jquery_code .= "\n jQuery( '.variations_form' ).find('.select').each(function() {\n";                
                $jquery_code .= "\n var attribute = jQuery(this).attr('data-attribute-name');\n";
                $jquery_code .= "\n var attributevalue = jQuery(this).find('.selected').attr('data-name');variation[attribute] = attributevalue;\n";
                $jquery_code .= "\n }); } jQuery.ajax({ type: 'POST',async: false,\n";
                $jquery_code .= "\n url: '".esc_js(admin_url( 'admin-ajax.php' ))."', \n";
                $jquery_code .= "\n data: { 'action': 'woocommerce_add_to_cart', 'product_id': bundle_product_all_product_ids[i]  },beforeSend: function() {
                    // setting a timeout
                    jQuery( '#loading' ).show();
                },  \n";
                $jquery_code .= "\n success : function( response ) {  jQuery( '#loading' ).fadeOut(400); \n";
                $jquery_code .= "\n bundleproduct_refresh_fragments( response ); } }); }else{ jQuery.ajax({ \n";
                $jquery_code .= "\n type: 'POST',async: false,url: '".esc_js(admin_url( 'admin-ajax.php' ))."', \n";
                $jquery_code .= "\n data: { 'action': 'woocommerce_add_to_cart', 'product_id': bundle_product_all_product_ids[i]  },beforeSend: function() {
                    // setting a timeout
                    jQuery( '#loading' ).show();
                }, \n";
                $jquery_code .= "\n success : function( response ) {jQuery('html, body').animate({scrollTop: 0}, 1000, function(){
                        jQuery( '.cart_contents' ).addClass('active');
                        jQuery( '.dropdowncartwidget' ).slideDown('slow');
                        setTimeout(function(){
                        jQuery( '.cart_contents' ).removeClass('active');
                       jQuery( '.dropdowncartwidget' ).slideUp('slow');
                        }, 3000);
                        }); jQuery( '#loading' ).fadeOut(400); \n";
                $jquery_code .= "\n bundleproduct_refresh_fragments( response ); } }); } } \n";
                $jquery_code .= "\n var bundle_product_alert_msg = '".(wp_kses_post($alert_message['success']))."'; } \n";
                $jquery_code .= "\n jQuery( '.megashop-wc-message' ).html(bundle_product_alert_msg); \n";
                $jquery_code .= "\n }); }); \n";
                wp_add_inline_script( 'bootstrapjs', $jquery_code );                
                ?>
	</div>

<?php endif;

wp_reset_postdata();
}