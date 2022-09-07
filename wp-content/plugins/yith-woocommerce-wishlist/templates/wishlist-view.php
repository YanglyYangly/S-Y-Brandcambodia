<?php
/**
 * Wishlist page template - Standard Layout
 *
 * @author YITH
 * @package YITH\Wishlist\Templates\Wishlist\View
 * @version 3.0.0
 */

/**
 * Template variables:
 *
 * @var $wishlist                      \YITH_WCWL_Wishlist Current wishlist
 * @var $wishlist_items                array Array of items to show for current page
 * @var $wishlist_token                string Current wishlist token
 * @var $wishlist_id                   int Current wishlist id
 * @var $users_wishlists               array Array of current user wishlists
 * @var $pagination                    string yes/no
 * @var $per_page                      int Items per page
 * @var $current_page                  int Current page
 * @var $page_links                    array Array of page links
 * @var $is_user_owner                 bool Whether current user is wishlist owner
 * @var $show_price                    bool Whether to show price column
 * @var $show_dateadded                bool Whether to show item date of addition
 * @var $show_stock_status             bool Whether to show product stock status
 * @var $show_add_to_cart              bool Whether to show Add to Cart button
 * @var $show_remove_product           bool Whether to show Remove button
 * @var $show_price_variations         bool Whether to show price variation over time
 * @var $show_variation                bool Whether to show variation attributes when possible
 * @var $show_cb                       bool Whether to show checkbox column
 * @var $show_quantity                 bool Whether to show input quantity or not
 * @var $show_ask_estimate_button      bool Whether to show Ask an Estimate form
 * @var $show_last_column              bool Whether to show last column (calculated basing on previous flags)
 * @var $move_to_another_wishlist      bool Whether to show Move to another wishlist select
 * @var $move_to_another_wishlist_type string Whether to show a select or a popup for wishlist change
 * @var $additional_info               bool Whether to show Additional info textarea in Ask an estimate form
 * @var $price_excl_tax                bool Whether to show price excluding taxes
 * @var $enable_drag_n_drop            bool Whether to enable drag n drop feature
 * @var $repeat_remove_button          bool Whether to repeat remove button in last column
 * @var $available_multi_wishlist      bool Whether multi wishlist is enabled and available
 * @var $no_interactions               bool
 */

if ( ! defined( 'YITH_WCWL' ) ) {
	exit;
} // Exit if accessed directly
?>

<!-- WISHLIST TABLE -->


<div style="background: white; border-radius: 10px; padding-left: 15px;">
<?php if ( $wishlist && $wishlist->has_items() ):;?>
	<ul style="list-style-type: none; display: contents; "class="wishlist">
	<?php foreach ( $wishlist_items as $item ): ?>
	<?php 
		global $product;
		$product = $item->get_product();

	?>
	<li class="cus-wishlist-item" style="position: relative;">
		<div class="product-container">
			<div class="product-thumb  ">
				<div class="pro_fade">
					<?php do_action( 'yith_wcwl_table_before_product_thumbnail', $item, $wishlist ); ?>

					<a class="woocommerce-LoopProduct-link woocommerce-loop-product__link"href="<?php echo esc_url( get_permalink( apply_filters( 'woocommerce_in_cart_product', $item->get_product_id() ) ) ); ?>">
						<?php echo wp_kses_post( $product->get_image() ); ?>
					</a>

					<?php do_action( 'yith_wcwl_table_after_product_thumbnail', $item, $wishlist ); ?>
				</div>
				
			</div>
			<div class="product-decription">
				<div class="cus-decription">
					<a href="<?php echo esc_url( get_permalink( apply_filters( 'woocommerce_in_cart_product', $item->get_product_id() ) ) ); ?>">
					<?php echo wp_kses_post( apply_filters( 'woocommerce_in_cartproduct_obj_title', $product->get_title(), $product ) ); ?>
				</a>
				<div class="product-price">
					<strong>
					<?php do_action( 'yith_wcwl_table_before_product_price', $item, $wishlist ); ?>

					<?php
					if ( $show_price ) {
						echo wp_kses_post( $item->get_formatted_product_price() );
					}

					if ( $show_price_variations ) {
						echo wp_kses_post( $item->get_price_variation() );
					}
					?>

					<?php do_action( 'yith_wcwl_table_after_product_price', $item, $wishlist ); ?>
					</strong>
				</div>
			
					<div style="position: absolute; left: 120px;">
								<a style="width: 29px; height: 29px;" href="<?php echo esc_url( $item->get_remove_url() ); ?>" class="remove remove_from_wishlist" title="<?php echo esc_html( apply_filters( 'yith_wcwl_remove_product_wishlist_message_title', __( 'Remove this product', 'yith-woocommerce-wishlist' ) ) ); ?>"><img src="http://themesy.test/wp-content/uploads/2022/09/x-button2.png" width="30px" height="30px" style="display: inherit;"></a>
					</div>

					<?php if ( $show_last_column ) : ?>
						<td class="product-add-to-cart">
							<?php do_action( 'yith_wcwl_table_before_product_cart', $item, $wishlist ); ?>

							<!-- Date added -->
							<?php
							if ( $show_dateadded && $item->get_date_added() ) :
								// translators: date added label: 1 date added.
								echo '<span class="dateadded">' . esc_html( sprintf( __( 'Added on: %s', 'yith-woocommerce-wishlist' ), $item->get_date_added_formatted() ) ) . '</span>';
							endif;
							?>

							<?php do_action( 'yith_wcwl_table_product_before_add_to_cart', $item, $wishlist ); ?>

							<!-- Add to cart button -->
							<div class="add_wishlist">	
							
							<?php $show_add_to_cart = apply_filters( 'yith_wcwl_table_product_show_add_to_cart', $show_add_to_cart, $item, $wishlist ); ?>
							<?php if ( $show_add_to_cart && $item->is_purchasable() && 'out-of-stock' !== $item->get_stock_status() ) : ?>
								<?php woocommerce_template_loop_add_to_cart( array( 'quantity' => $show_quantity ? $item->get_quantity() : 1 ) ); ?>

							<?php endif ?>
							</div>
							<?php do_action( 'yith_wcwl_table_product_after_add_to_cart', $item, $wishlist ); ?>

							<!-- Change wishlist -->
							<?php $move_to_another_wishlist = apply_filters( 'yith_wcwl_table_product_move_to_another_wishlist', $move_to_another_wishlist, $item, $wishlist ); ?>
							<?php if ( $move_to_another_wishlist && $available_multi_wishlist && count( $users_wishlists ) > 1 ) : ?>
								<?php if ( 'select' === $move_to_another_wishlist_type ) : ?>
									<select class="change-wishlist selectBox">
										<option value=""><?php esc_html_e( 'Move', 'yith-woocommerce-wishlist' ); ?></option>
										<?php
										foreach ( $users_wishlists as $wl ) :
											/**
											 * Each of customer's wishlists
											 *
											 * @var $wl \YITH_WCWL_Wishlist
											 */
											if ( $wl->get_token() === $wishlist_token ) {
												continue;
											}
											?>
											<option value="<?php echo esc_attr( $wl->get_token() ); ?>">
												<?php echo sprintf( '%s - %s', esc_html( $wl->get_formatted_name() ), esc_html( $wl->get_formatted_privacy() ) ); ?>
											</option>
											<?php
										endforeach;
										?>
									</select>
								<?php else : ?>

									<a href="#move_to_another_wishlist" class="move-to-another-wishlist-button" data-rel="prettyPhoto[move_to_another_wishlist]">
										<?php echo esc_html( apply_filters( 'yith_wcwl_move_to_another_list_label', __( 'Move to another list &rsaquo;', 'yith-woocommerce-wishlist' ) ) ); ?>

									</a>
								<?php endif; ?>

								<?php do_action( 'yith_wcwl_table_product_after_move_to_another_wishlist', $item, $wishlist ); ?>

							<?php endif; ?>

							<!-- Remove from wishlist -->
							<?php if ( $repeat_remove_button ) : ?>
								<a href="<?php echo esc_url( $item->get_remove_url() ); ?>" class="remove_from_wishlist button" title="<?php echo esc_html( apply_filters( 'yith_wcwl_remove_product_wishlist_message_title', __( 'Remove this product', 'yith-woocommerce-wishlist' ) ) ); ?>"><?php esc_html_e( 'Remove', 'yith-woocommerce-wishlist' ); ?></a>
							<?php endif; ?>

							<?php do_action( 'yith_wcwl_table_after_product_cart', $item, $wishlist ); ?>
						</td>
					<?php endif; ?>
				</div>
				
			</div>
		</div>
	</li>
	
	<?php endforeach ?>

	<?php endif ?>
	</ul>		
</div>