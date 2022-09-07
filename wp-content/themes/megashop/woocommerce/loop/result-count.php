<?php
/**
 * Result Count
 *
 * Shows text: Showing x - x of x results.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/result-count.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $wp_query;

/* if ( ! woocommerce_products_will_display() )
	return;
if(isset($_GET['shop_masonry']) && $_GET['shop_masonry'] == 1){
    $shop_masonry = 1;
}else{
    $shop_masonry = of_get_option('shop_masonry');
} */
$class = '';
/* if($shop_masonry == 1){
    $class = 'pull-left';
} */
if(isset($_GET['shop_infinite_load']) && $_GET['shop_infinite_load'] == 'infinity_scroll'){
    $shop_infinite_load = 'infinity_scroll';
}elseif(isset($_GET['shop_infinite_load']) && $_GET['shop_infinite_load'] == 'more_button'){
    $shop_infinite_load = 'more_button';
}else{
    $shop_infinite_load = of_get_option('shop_infinite_load');
}

$product_veiwmode  = of_get_option('product_veiwmode');
// if($shop_masonry != 1){
    if($product_veiwmode == 'gird_only' || $product_veiwmode == 'list_only'){
        $class = "hide";
    }
?>
<div class="col-md-2 filter-grid-list padding_left_0 <?php echo esc_attr($class); ?>">
    <?php if($product_veiwmode == 'grid_list'){ ?>
    <div class="btn-group grid_list">
        <button id="grid-view" class="btn btn-default active" type="button" data-toggle="tooltip" title="<?php _e('Grid','megashop'); ?>" ><i class="fa fa-th"></i></button>
        <button id="list-view" class="btn btn-default" type="button" data-toggle="tooltip" title="<?php _e('List','megashop'); ?>"><i class="fa fa-th-list"></i></button>
    </div>
    <?php }
    if($product_veiwmode == 'list_grid'){ ?>
        <div class="btn-group list_grid">            
        <button id="list-view" class="btn btn-default active" type="button" data-toggle="tooltip" title="<?php _e('List','megashop'); ?>"><i class="fa fa-th-list"></i></button>
        <button id="grid-view" class="btn btn-default" type="button" data-toggle="tooltip" title="<?php _e('Grid','megashop'); ?>" ><i class="fa fa-th"></i></button>
    </div>
   <?php }elseif($product_veiwmode == 'gird_only'){
       $class = 'pull-left';
       ?>
        <div class="btn-group grid_only hide">            
        <button id="grid-view" class="btn btn-default active" type="button" data-toggle="tooltip" title="<?php _e('Grid','megashop'); ?>" ><i class="fa fa-th"></i></button>
    </div>
   <?php }elseif($product_veiwmode == 'list_only'){
       $class = 'pull-left';
       ?>
        <div class="btn-group list_only hide">            
        <button id="list-view" class="btn btn-default active" type="button" data-toggle="tooltip" title="<?php _e('List','megashop'); ?>"><i class="fa fa-th-list"></i></button>
    </div>
   <?php } ?>
</div>
<?php //}
if(isset($_GET['ajax_filter']) && $_GET['ajax_filter'] == 1){
    $ajax_filter = 1;
}elseif(isset($_GET['ajax_filter']) && $_GET['ajax_filter'] == 0){
    $ajax_filter = 0;
}else{
    $ajax_filter = of_get_option('ajax_filter');
}
/* if(($ajax_filter == 1)){
  echo get_categories_filter();
} */
 if(($shop_infinite_load != 'infinity_scroll' && $shop_infinite_load != 'more_button') ){
?>
<p class="woocommerce-result-count <?php echo esc_attr($class); ?>">
	<?php
	if ( 1 === $total ) {
		_e( 'Showing the single result', 'megashop' );
	} elseif ( $total <= $per_page || -1 === $per_page ) {
		/* translators: %d: total results */
		printf( _n( 'Showing all %d result', 'Showing all %d results', $total, 'megashop' ), $total );
	} else {
		$first = ( $per_page * $current ) - $per_page + 1;
		$last  = min( $total, $per_page * $current );
		/* translators: 1: first result 2: last result 3: total results */
		printf( _nx( 'Showing %1$d&ndash;%2$d of %3$d result', 'Showing %1$d&ndash;%2$d of %3$d results', $total, 'with first and last result', 'megashop' ), $first, $last, $total );
	}
	?>
</p>
<?php } ?>