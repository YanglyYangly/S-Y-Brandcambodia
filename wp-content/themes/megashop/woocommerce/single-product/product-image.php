<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product;

$single_image_slider = of_get_option('single_image_slider');

$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
$full_size_image   = $post_thumbnail_id ? wp_get_attachment_image_src( $post_thumbnail_id, 'full' ) : '';
$thumbnail_post    = $post_thumbnail_id ? get_post( $post_thumbnail_id ): '' ;
$image_title       = $thumbnail_post ? $thumbnail_post->post_content:'';
$placeholder       = has_post_thumbnail() ? 'with-images' : 'without-images';
$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
	'woocommerce-product-gallery',
	'woocommerce-product-gallery--' . $placeholder,
	'woocommerce-product-gallery--columns-' . absint( $columns ),
	'images',
) );
if($single_image_slider == 'left_verticle' || $single_image_slider == 'right_verticle'){
    $single_image_slider = $single_image_slider.' verticle';
}
if(isset($_GET['single_layout']) && $_GET['single_layout'] == 'fixed'){
        $single_layout = 'fixed';
    }elseif(isset($_GET['single_layout']) && $_GET['single_layout'] == 'image_center'){
        $single_layout = 'image_center';
    }else{
        $single_layout = of_get_option('single_layout');
    }
?>
<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) )." ".esc_attr($single_image_slider); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
    <?php if($single_layout == 'fixed'){ ?>
	<div class="woocommerce-product-gallery__wrapper zoom_wrap">
		<?php
        }else{ ?>
            <div class="woocommerce-product-gallery__wrapper slider-for zoom_wrap">
        <?php }
        if( !empty($full_size_image) ){
            $attributes = array(
                'title'                   => get_post_field( 'post_title', $post_thumbnail_id ),
                'data-caption'            => get_post_field( 'post_excerpt', $post_thumbnail_id ),
                'data-src'                => $full_size_image[0],
                'data-large_image'        => $full_size_image[0],
                'data-large_image_width'  => $full_size_image[1],
                'data-large_image_height' => $full_size_image[2],
                'data-zoom-image'         => $full_size_image[0],
            );
        

		if ( has_post_thumbnail() ) {
			$html  = '<div data-thumb="' . get_the_post_thumbnail_url( $post->ID, 'shop_thumbnail' ) . '" class="woocommerce-product-gallery__image easyzoom easyzoom--overlay">';
                        $html .= sprintf( '<a href="%s" class="nm-product-image-link zoom" data-size="%sx%s" itemprop="image">', esc_url( $full_size_image[0] ), intval( $full_size_image[1] ), intval( $full_size_image[2] ) );
			$html .= get_the_post_thumbnail( $post->ID, 'shop_single', $attributes );
			$html .= '<i class="product-image-icon fa fa-expand"></i></a></div>';
		} else {
			$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
			$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'megashop' ) );
			$html .= '</div>';
		}
    
		echo apply_filters( 'woocommerce_single_product_image_html', $html, get_post_thumbnail_id( $post->ID ) );
    }
		// Gallery images
            $attachment_ids = $product->get_gallery_image_ids();
            
            if ( $attachment_ids ) {
                foreach ( $attachment_ids as $attachment_id ) {
                    $image_link = wp_get_attachment_url( $attachment_id );
                    $full_size_image   = $post_thumbnail_id ? wp_get_attachment_image_src( $post_thumbnail_id, 'full' ):'';
                    if( !empty($full_size_image) ){
                        $attributes = array(
                                'title'                   => $image_title,
                                'data-src'                => $full_size_image[0],
                                'data-large_image'        => $full_size_image[0],
                                'data-large_image_width'  => $full_size_image[1],
                                'data-large_image_height' => $full_size_image[2],
                                'data-zoom-image' => $full_size_image[0],
                        );
                    
                        if ( ! $image_link ) {
                            continue;
                        }
                            $full_image = wp_get_attachment_image_src( $attachment_id, 'full' );
                            $html  = '<div data-thumb="' . wp_get_attachment_url($attachment_id, 'shop_thumbnail' ) . '" class="woocommerce-product-gallery__image easyzoom easyzoom--overlay">';
                                        $html .= sprintf( '<a href="%s" class="nm-product-image-link zoom" data-size="%sx%s" itemprop="image">', esc_url( $full_image[0] ), intval( $full_image[1] ), intval( $full_image[2] ) );
                            $html .= wp_get_attachment_image( $attachment_id, 'shop_single', $attributes );
                            $html .= '<i class="product-image-icon fa fa-expand"></i></a></div>';
                        

                        echo apply_filters( 'woocommerce_single_product_image_html', $html, get_post_thumbnail_id( $post->ID ) );
                    }
                }
                
            }
		?>
	</div> 
        <?php if($single_layout != 'fixed'){ ?>
            <div class="slider-nav">
                <?php 
                if( !empty($full_size_image) ){
                         $attributes = array(
                                'title'                   => $image_title,
                                'data-src'                => $full_size_image[0],
                                'data-large_image'        => $full_size_image[0],
                                'data-large_image_width'  => $full_size_image[1],
                                'data-large_image_height' => $full_size_image[2],
                        );
                    
                        if ( has_post_thumbnail() ) {
                                $html  = '<div data-thumb="' . get_the_post_thumbnail_url( $post->ID, 'shop_thumbnail' ) . '" class="woocommerce-product-gallery__image"><a href="' . esc_url( $full_size_image[0] ) . '">';
                                $html .= get_the_post_thumbnail( $post->ID, 'shop_thumbnail', $attributes );
                                $html .= '</a></div>';
                        } else {
                                $html  = '<div class="woocommerce-product-gallery__image--placeholder">';
                                $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'megashop' ) );
                                $html .= '</div>';
                        }

                        echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, get_post_thumbnail_id( $post->ID ) );
                    }
                ?>
            <?php do_action( 'woocommerce_product_thumbnails' ); ?>
            </div>
            <?php } ?>
</div>
