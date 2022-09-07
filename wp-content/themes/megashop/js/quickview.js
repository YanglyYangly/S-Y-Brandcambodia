jQuery(document).ready(function(){
	
//quickview button

	jQuery(document).on('click', 'a.trquickview', function(event){											   
		event.preventDefault();
		var productID = jQuery(this).attr('data-quick-id');
		DisplayQuickView(productID);
	});

	jQuery(document).on('click', '.CloseQV', function(){
		RemoveQuickView();
	}); 
	//loading when add to cart
	/*jQuery('body').append('<div id="loading"></div>');
	jQuery( document ).ajaxComplete(function( event, request, options ){
		if(options.url.indexOf('wc-ajax=add_to_cart') != -1){
			var title = jQuery('a.added_to_cart').attr('title');
			jQuery('a.added_to_cart').removeAttr('title').closest('p.add_to_cart_inline').attr('data-original-title', title);
			jQuery('html, body').animate({scrollTop: 0}, 1000, function(){
				jQuery('.cart_contents .dropdowncartwidget ').slideDown(500);
			});
		}
		jQuery( "#loading" ).fadeOut(400);
	});
	jQuery( document ).ajaxSend(function(event, xhr, options){
		if(options.url.indexOf('wc-ajax=add_to_cart') != -1){
			jQuery( "#loading" ).show();
		}
		if(options.url.indexOf('wc-ajax=get_refreshed_fragments') != -1){
			if(jQuery('body').hasClass('fragments_refreshed')){
				xhr.abort();
			}else{
				jQuery('body').addClass('fragments_refreshed');
			}
		}
	});*/
});
function DisplayQuickView(productID){
	jQuery('#quickview-content').html('');
	window.setTimeout(function(){
		jQuery('.tt-quickview-wrap').addClass('open in');
		jQuery.ajax({
                url : screenReaderText.ajaxurl,
                type : 'post',
                data : {
                    action : 'tt_quickview',
                    productID : productID
                },
                success : function( response ) 
                {
                    jQuery('#quickview-content').html(response);
                    jQuery('.overlay-bg').addClass('loader_remove');
				jQuery('.tt-quickview-wrap .quick-modal').addClass('show');
                                /* variable product form */
				if(jQuery('#quickview-content .variations_form').length){
					jQuery( '#quickview-content .variations_form' ).wc_variation_form();
					jQuery( '#quickview-content .variations_form .variations select' ).change();
				}
				
				/*thumbnails carousel*/
                                if(jQuery('body').hasClass('rtl')){
				jQuery('.popup_product_thumb_slider').not('.slick-initialized').slick({
                                    slidesToShow: 3,
                                    slidesToScroll: 1,
                                    asNavFor: '.popup_product_slider',
                                    dots: false,
                                    rtl: true,
                                    centerMode: true,
                                    prevArrow:'<button class="slick-prev"><i class="fa fa-arrow-left"></i></button>',
                                    nextArrow:'<button class="slick-next"><i class="fa fa-arrow-right"></i></button>',
                                    touchDrag: true,
                                    focusOnSelect:true,
                                    vertical:false
                                });
                                /*Product slide*/
                                jQuery('.popup_product_slider').not('.slick-initialized').slick({
                                    slidesToShow: 1,
                                    slidesToScroll: 1,
                                    arrows: false,
                                    rtl: true,
                                    fade: true,
                                    asNavFor: '.popup_product_thumb_slider',
                                    autoplay:false,
                                    autoplaySpeed: 3000
                                });
                                }else{
                                    jQuery('.popup_product_thumb_slider').not('.slick-initialized').slick({
                                    slidesToShow: 3,
                                    slidesToScroll: 1,
                                    asNavFor: '.popup_product_slider',
                                    dots: false,
                                    centerMode: true,
                                    prevArrow:'<button class="slick-prev"><i class="fa fa-arrow-left"></i></button>',
                                    nextArrow:'<button class="slick-next"><i class="fa fa-arrow-right"></i></button>',
                                    touchDrag: true,
                                    focusOnSelect:true,
                                    vertical:false
                                });
                                /*Product slide*/
                                jQuery('.popup_product_slider').not('.slick-initialized').slick({
                                    slidesToShow: 1,
                                    slidesToScroll: 1,
                                    arrows: false,
                                    fade: true,
                                    asNavFor: '.popup_product_thumb_slider',
                                    autoplay:false,
                                    autoplaySpeed: 3000
                                });
                                }
				
				
				/*review link click*/				
				jQuery('.woocommerce-review-link').on('click', function(event){
					event.preventDefault();
					var reviewLink = jQuery('.veiw_all').attr('href');
					
					window.location.href = reviewLink + '#reviews';
				});
                }				
            });	
	}, 300);
}
function RemoveQuickView(){
	jQuery('.tt-quickview-wrap #product-modal').removeClass('show');
	jQuery('.tt-quickview-wrap').removeClass('open');
        jQuery('.overlay-bg').removeClass('loader_remove');
        jQuery('#quickview-content').html('');
}