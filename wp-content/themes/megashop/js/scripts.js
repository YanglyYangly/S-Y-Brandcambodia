/*! Customized Jquery from Punit Korat.  punit@templatetrip.com  : www.templatetrip.com
Authors & copyright (c) 2016: TemplateTrip - Webzeel Services(addonScript). */
/*! NOTE: This Javascript is licensed under two options: a commercial license, a commercial OEM license and Copyright by Webzeel Services - For use Only with TemplateTrip Themes for our Customers*/
jQuery(window).load(function () {
    // animation
    jQuery('.animated').waypoint(function() {
        jQuery(this).toggleClass(jQuery(this).data('animated'));
    });        
    jQuery('.woocommerce-cart .cart-collaterals .cross-sells').insertAfter('.woocommerce-cart .cart-collaterals .cart_totals.calculated_shipping');
                
    jQuery('.toggles_wrap.style3 .toggle_heading,.toggles_wrap.style4 .toggle_heading').find('i').addClass('fa-hand-o-right');
    jQuery('.toggles_wrap.style3 .toggle_heading,.toggles_wrap.style4 .toggle_heading').click(function () {
        jQuery(this).next('.toggle-answer').slideToggle(500);
        jQuery(this).toggleClass('toggleclose');
        if (jQuery(this).hasClass("toggleclose")) {
            jQuery(this).find('i').removeClass('fa-hand-o-down');
            jQuery(this).find('i').addClass('fa-hand-o-right');
        } else {
            jQuery(this).find('i').addClass('fa-hand-o-down');
            jQuery(this).find('i').removeClass('fa-hand-o-right');
        }
    });
    jQuery('.toggles_wrap.style1 .toggle_heading,.toggles_wrap.style2 .toggle_heading').find('i').addClass('fa-plus');
    jQuery('.toggles_wrap.style1 .toggle_heading,.toggles_wrap.style2 .toggle_heading').click(function () {
        jQuery(this).next('.toggle-answer').slideToggle(500);
        jQuery(this).toggleClass('toggleclose');
        if (jQuery(this).hasClass("toggleclose")) {
            jQuery(this).find('i').removeClass('fa-minus');
            jQuery(this).find('i').addClass('fa-plus');
        } else {
            jQuery(this).find('i').addClass('fa-minus');
            jQuery(this).find('i').removeClass('fa-plus');
        }
    });


    jQuery('.accordians_wrap.style1 .accordion_heading,.accordians_wrap.style2 .accordion_heading').find('i').addClass('fa-plus');
    jQuery('.accordians_wrap.style1 .accordion_heading,.accordians_wrap.style2 .accordion_heading').click(function () {
        var selected = jQuery(this);
        jQuery('.accordians_wrap.style1 .accordion_heading,.accordians_wrap.style2 .accordion_heading').each(function () {
            var qhead = jQuery(this);
            if (!selected.is(qhead)) {
                if (!jQuery(this).hasClass('accoodionclose')) {
                    jQuery(this).next('.accordion-answer').slideUp(500);
                    jQuery(this).addClass('accoodionclose');
                    jQuery(this).find('i').removeClass('fa-minus');
                    jQuery(this).find('i').addClass('fa-plus');
                }
            }
        });
        jQuery(this).next('.accordion-answer').slideToggle(500);
        jQuery(this).toggleClass('accoodionclose');
        if (jQuery(this).find('i').hasClass('fa-minus')) {
            jQuery(this).find('i').removeClass('fa-minus');
            jQuery(this).find('i').addClass('fa-plus');
        } else {
            jQuery(this).find('i').addClass('fa-minus');
            jQuery(this).find('i').removeClass('fa-plus');
        }
    });
    jQuery('.accordians_wrap.style3 .accordion_heading,.accordians_wrap.style4 .accordion_heading').find('i').addClass(' fa-hand-o-right');
    jQuery('.accordians_wrap.style3 .accordion_heading,.accordians_wrap.style4 .accordion_heading').click(function () {
        var selected = jQuery(this);
        jQuery('.accordians_wrap.style3 .accordion_heading,.accordians_wrap.style4 .accordion_heading').each(function () {
            var qhead = jQuery(this);
            if (!selected.is(qhead)) {
                if (!jQuery(this).hasClass('accoodionclose')) {
                    jQuery(this).next('.accordion-answer').slideUp(500);
                    jQuery(this).addClass('accoodionclose');	
                    jQuery(this).find('i').removeClass('fa-hand-o-down');
                    jQuery(this).find('i').addClass('fa-hand-o-right');
                }
            }
        });
        jQuery(this).next('.accordion-answer').slideToggle(500);
        jQuery(this).toggleClass('accoodionclose');
        if (jQuery(this).find('i').hasClass('fa-hand-o-down')) {
            jQuery(this).find('i').removeClass('fa-hand-o-down');
            jQuery(this).find('i').addClass('fa-hand-o-right');
        } else {
            jQuery(this).find('i').addClass('fa-hand-o-down');
            jQuery(this).find('i').removeClass('fa-hand-o-right');
        }
    });
    
});
jQuery( window ).scroll(function() {  
    fixed_productblock();
});
function fixed_productblock(){
    if( jQuery(window).width() < 992 ) return;

    if ( jQuery( '.fixed-product-block' ).height() > jQuery( '.product-images' ).height() ) return;

    jQuery('.fixed-product-block').each(function() {
        var el = jQuery(this),
        parent = el.parent(),
        heightOffsetEl = jQuery('.product-images'),
        parentHeight = heightOffsetEl.outerHeight(),
        firstImg = heightOffsetEl.find('img').first(),
        firstImgHeight = firstImg.outerHeight();

        jQuery(window).resize(function() {
            parentHeight = heightOffsetEl.outerHeight();
            firstImgHeight = firstImg.outerHeight();
            el.css({
                'maxWidth': parent.width(),
                'minHeight': firstImgHeight
            });
            parent.height(parentHeight);
        });

        jQuery(window).resize();

        jQuery(this).stick_in_parent({
            offset_top: 150
        });

    });
}

jQuery(document).ready(function() {
    "use strict";	
    
    jQuery(".tt_category_tab").easyResponsiveTabs({
        type: "default",
        width: "auto",
        fit: true,
        closed: "accordion",
        activate: function(e) {
            var t = jQuery(this);
            var n = jQuery("#tabInfo");
            var r = jQuery("span", n);
            r.text(t.text());
            n.show()
        }
    });
	
	/* 360 product view */
        jQuery('.product-360-button a').magnificPopup({
            type: 'inline',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            disableOn: false,
            preloader: false,
            fixedContentPos: false,
            callbacks: {
                open: function() {
                    jQuery(window).resize()
                }
            }
        });
		
		/* pop video product */
        jQuery('.custom_product_video a').magnificPopup({
            disableOn: 700,
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,
            fixedContentPos: false
        });
        /**/
    
    jQuery('body').find('img.lazy').lazyload();
    

    // Add Parameters to YouTube Videos oEmbed
    jQuery('.video-embed iframe[src^="http://www.youtube.com"], .video-embed iframe[src^="https://www.youtube.com"], .entry-video iframe[src^="http://www.youtube.com"], .entry-video iframe[src^="https://www.youtube.com"]').each(function() {
        var url = jQuery(this).attr("src")
        jQuery(this).attr("src",url.substring(0,url.indexOf('?')) + '?autohide=1&modestbranding=1&rel=0&showinfo=0')
    });
    
    if(jQuery('body').hasClass('single-product')){
        jQuery(".variations select").select2();
    }
    
    fixed_productblock();
    
    var pro_thumb = screenReaderText.product_thumb;
    if(pro_thumb == 'col_3'){
        pro_thumb = 3;
    }else if(pro_thumb == 'col_4'){
        pro_thumb = 4;
    }else if(pro_thumb == 'col_5'){
        pro_thumb = 5
        
    }else{
        pro_thumb = 3;
    }
    jQuery('body:not(.rtl) .verticle .slider-nav').slick({
        slidesToShow: pro_thumb,
        slidesToScroll: 1,
        asNavFor: '.verticle .slider-for',
        dots: false,	
        arrows: true,
        fade: false,
        infinite: false,
        prevArrow:'<button class="slick-prev"><i class="fa fa-angle-up"></i></button>',
        nextArrow:'<button class="slick-next"><i class="fa fa-angle-down"></i></button>',
        touchDrag: true,
        focusOnSelect:true,
        responsive: [{
            breakpoint: 1200,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 1008,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }
        }],
        vertical:true
    });
    jQuery('.rtl .verticle .slider-nav').slick({
        slidesToShow: pro_thumb,
        slidesToScroll: 1,
        asNavFor: '.rtl .verticle .slider-for',
        dots: false,	
        rtl:true,
        arrows: true,
        fade: false,
        infinite: false,
        prevArrow:'<button class="slick-prev"><i class="fa fa-angle-up"></i></button>',
        nextArrow:'<button class="slick-next"><i class="fa fa-angle-down"></i></button>',
        touchDrag: true,
        focusOnSelect:true,
        responsive: [{
            breakpoint: 1200,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 1008,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }
        }],
        vertical:true
    });
    /*Product slide*/
    jQuery('body:not(.rtl) .verticle .slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        prevArrow:'<button class="slick-prev"><i class="fa fa-angle-left"></i></button>',
        nextArrow:'<button class="slick-next"><i class="fa fa-angle-right"></i></button>',
        fade: true,
        asNavFor: '.verticle .slider-nav',
        infinite: false,
        autoplay:false
    });
    jQuery('.rtl .verticle .slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        rtl:true,
        prevArrow:'<button class="slick-prev"><i class="fa fa-angle-left"></i></button>',
        nextArrow:'<button class="slick-next"><i class="fa fa-angle-right"></i></button>',
        fade: true,
        asNavFor: '.rtl .verticle .slider-nav',
        infinite: false,
        autoplay:false
    });
    jQuery('body:not(.rtl) .horizontal .slider-nav').not('.slick-initialized').slick({
        slidesToShow: pro_thumb,
        slidesToScroll: 1,
        asNavFor: '.slider-for',
        dots: false,	
        arrows: true,
        fade: false,
        infinite: false,
        prevArrow:'<button class="slick-prev"><i class="fa fa-angle-left"></i></button>',
        nextArrow:'<button class="slick-next"><i class="fa fa-angle-right"></i></button>',
        touchDrag: true,
        focusOnSelect:true,
        vertical:false,
        responsive: [{
            breakpoint: 1200,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 1008,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }
        }]
    });
    jQuery('.rtl .horizontal .slider-nav').not('.slick-initialized').slick({
        slidesToShow: pro_thumb,
        slidesToScroll: 1,
        asNavFor: '.slider-for',
        dots: false,	
        arrows: true,
        rtl:true,
        fade: false,
        infinite: false,
        prevArrow:'<button class="slick-prev"><i class="fa fa-angle-left"></i></button>',
        nextArrow:'<button class="slick-next"><i class="fa fa-angle-right"></i></button>',
        touchDrag: true,
        focusOnSelect:true,
        vertical:false,
        responsive: [{
            breakpoint: 1200,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 1008,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 2,

                slidesToScroll: 1
            }
        }]
    });
    /*Product slide*/
    jQuery('body:not(.rtl) .horizontal .slider-for').not('.slick-initialized').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: false,
        prevArrow:'<button class="slick-prev"><i class="fa fa-angle-left"></i></button>',
        nextArrow:'<button class="slick-next"><i class="fa fa-angle-right"></i></button>',
        fade: true,
        asNavFor: '.slider-nav',
        autoplay:false
    });
    jQuery('.rtl .horizontal .slider-for').not('.slick-initialized').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: false,
        rtl:true,
        prevArrow:'<button class="slick-prev"><i class="fa fa-angle-left"></i></button>',
        nextArrow:'<button class="slick-next"><i class="fa fa-angle-right"></i></button>',
        fade: true,
        asNavFor: '.slider-nav',
        autoplay:false
    });
    // Remove active class from all thumbnail slides
    jQuery('.slider-nav .slick-slide').removeClass('slick-active');

    // Set active class to first thumbnail slides
    jQuery('.slider-nav .slick-slide').eq(0).addClass('slick-active');
    // On before slide change match active thumbnail to current slide
    jQuery('.slider-for').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
        var mySlideNumber = nextSlide;
        jQuery('.slider-nav .slick-slide').removeClass('slick-active');
        jQuery('.slider-nav .slick-slide').eq(mySlideNumber).addClass('slick-active');
        elevatezoomproduct();
    });
    function elevatezoomproduct(){
        jQuery(".easyzoom.slick-current img").elevateZoom({
            zoomType: "inner",
            cursor: "crosshair",
            zoomWindowFadeIn: 500,
            zoomWindowFadeOut: 750
        });
    }
    jQuery('.slider-for .slick-next,.slider-for .slick-prev').click(function(){
        elevatezoomproduct();
    });
    jQuery('.slider-nav').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
        var mySlideNumber = nextSlide;
        jQuery('.slider-for .slick-slide').removeClass('slick-active');
        jQuery('.slider-for .slick-slide').eq(mySlideNumber).addClass('slick-active');
        //       
        elevatezoomproduct();
    });
    
    jQuery('.woocommerce-product-gallery__image.slick-slide a').click(function (e) {
        e.preventDefault();
        elevatezoomproduct();
    })
    
    var $productImageSlider =  jQuery('.slider-for');
    var animSpeed = 300;
    var $productThumbSlider = jQuery('.slider-nav');
    var $productImages = jQuery('.zoom_wrap').find('div.woocommerce-product-gallery__image');
    
    // Init hover zoom (EasyZoom plugin)
      
    jQuery(".easyzoom.slick-current img").elevateZoom({
        zoomType: "inner",
        cursor: "crosshair"
    });
    jQuery(".product-images-fixed .easyzoom img").elevateZoom({
        zoomType: "inner",
        cursor: "crosshair"
    });
          
            
    $productImages.bind('click', function(e) {
        e.preventDefault();
        var index = jQuery(this).index(); // Clicked image-container index
        elevatezoomproduct();
        // Open fullscreen gallery
        _openPhotoSwipe(this, index);
    });
   
    /* Product fullscreen gallery (PhotoSwipe) */
    var _openPhotoSwipe = function(imageWrap, index) {
        // Create gallery images array
        var $this, $a, $img, items = [], size, item;
        $productImages.each(function() {
            $this = jQuery(this);
            $a = $this.children('a');
            $img = $a.children('img');
            size = $img.attr('src');
                                                
            size = $a.attr('data-size').split('x');
            // Create slide object
            item = {
                src: $a.attr('href'),
                w: parseInt(size[0], 10),
                h: parseInt(size[1], 10),
                msrc: $img.attr('src'),
                el: $a[0] // Save image link for use in 'getThumbBoundsFn()' below
            };

            items.push(item);
        });

        // Gallery options
        var options = {
            index: index,
            showHideOpacity: true,
            bgOpacity: 1, // Note: Setting this below "1" makes slide transition slow in Chrome (using "rgba" background instead)
            loop: false,
            closeOnVerticalDrag: false,
            mainClass: ($productImages.length > 1) ? 'pswp--minimal--dark' : 'pswp--minimal--dark pswp--single--image',
            // PhotoSwipeUI_Default:
            barsSize: {
                top: 0, 
                bottom: 0
            },
            captionEl: false,
            fullscreenEl: true,
            zoomEl: true,
            shareE1: true,
            counterEl: true,
            tapToClose: true,
            clickToCloseNonZoomable: true,
            tapToToggleControls: false
        };

        var pswpElement = jQuery('#pswp')[0];

        // Initialize and open gallery (PhotoSwipe)
        var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
        gallery.init();
        // Event: Opening zoom animation
        gallery.listen('initialZoomIn', function() {
            $productThumbSlider.slick('slickSetOption', 'speed', 0);
        });
        // Event: Before slides change
        var slide = index;
        gallery.listen('beforeChange', function(dirVal) {
            slide = slide + dirVal;
            $productImageSlider.slick('slickGoTo', slide, true); // Change active image in slider (event, slideIndex, skipAnimation)
            elevatezoomproduct();
        });
        // Event: Gallery starts closing
        gallery.listen('close', function() {
            $productThumbSlider.slick('slickSetOption', 'speed', animSpeed);
            elevatezoomproduct();
        });
    };
    /***/
    // animation
    jQuery('.animated').waypoint(function() {
        jQuery(this).toggleClass(jQuery(this).data('animated'));
    });        
    jQuery('.woocommerce-cart .cart-collaterals .cross-sells').insertAfter('.woocommerce-cart .cart-collaterals .cart_totals.calculated_shipping');
                
    /* when product quantity changes, update quantity attribute on add-to-cart button */
    jQuery("form.cart").on("change", "input.qty", function() {
        if (this.value === "0")
            this.value = "1";

        jQuery(this.form).find("button[data-quantity]").data("quantity", this.value);
    });

    /* remove old "view cart" text, only need latest one thanks! */
    jQuery(document.body).on("adding_to_cart", function() {
        jQuery("a.added_to_cart").remove();
    });
    jQuery(".products .product .add_to_cart_button.product_type_simple").on('click', function() {

        var $button = jQuery(this);

        $button.data('quantity', $button.parent('.product').find('input.quantity').val());
    });
    /* Quntity input increase decrease */
    jQuery( document.body ).on( 'click', '.quantity .increase, .quantity .decrease', function ( e ) {
        e.preventDefault();

        var $this = jQuery( this ),
        $qty = $this.siblings( '.qty' ),
        current = parseInt( $qty.val(), 10 ),
        min = parseInt( $qty.attr( 'min' ), 10 ),
        max = parseInt( $qty.attr( 'max' ), 10 );

        min = min ? min : 1;
        max = max ? max : current + 1;

        if ( $this.hasClass( 'decrease' ) && current > min ) {
            $qty.val( current - 1 );
            $qty.trigger( 'change' );
        }
        if ( $this.hasClass( 'increase' ) && current < max ) {
            $qty.val( current + 1 );
            $qty.trigger( 'change' );
        }
    } );
    /* review add click to slidedown */
    jQuery(".woocommerce-review-link").click(function(e) {
        e.preventDefault();
        jQuery(".woocommerce-Reviews").show();
        jQuery('html, body').animate({
            scrollTop: jQuery(".woocommerce-tabs.wc-tabs-wrapper").offset().top-150
        }, 1000);
    });
    /*Scroll to top js*/
    jQuery(".scroll-up").click(function () {
        jQuery("html, body").animate({
            scrollTop: 0
        }, '1000');
        return false;
    });
    /* filter position change */
    jQuery('<div class="filter_wrapper"></div>').insertBefore('.filter-grid-list');
    jQuery( ".sidebar .widget.woocommerce.widget_price_filter" ).wrap( "<div class='options_filter'></div>" );
    jQuery( ".sidebar .widget.widget_layered_nav" ).each(function() {
        var nav_l_id = jQuery( this ).attr('id');
        var a = jQuery( this );
        jQuery( this ).wrap( "<div class='widget_layered_nav_filter "+nav_l_id+"'></div>" )
    })
    jQuery( ".site-content .testimonial_slider_wrap li" ).wrap( "<div class='testimo_li_wrap'></div>" );
    
    if(jQuery( window ).width() <= 768) {
        jQuery('.shop_table.wishlist_table').addClass('shop_table_responsive');	
        var product_name = jQuery('.shop_table.wishlist_table th.product-name span').html();	
        var product_price = jQuery('.shop_table.wishlist_table th.product-price span').html();
        var product_status = jQuery('.shop_table.wishlist_table th.product-stock-stauts span').html();
        jQuery('.shop_table.wishlist_table tbody td.product-name').attr('data-title', product_name);
        jQuery('.shop_table.wishlist_table tbody td.product-price').attr('data-title', product_price);
        jQuery('.shop_table.wishlist_table tbody td.product-stock-status').attr('data-title', product_status);
    }
           
    /* added wishlist update count in header menu */
    var update_wishlist_count = function() {
        jQuery.ajax({
            beforeSend: function () {
            },
            complete : function () {
            },
            data : {
                action: 'megashop_update_wishlist_count'
            },
            success : function (data) {
                jQuery('.wishlistbtn a span').html( data );
            },
            url: screenReaderText.ajaxurl
        });
    };
    jQuery('body').on( 'added_to_wishlist removed_from_wishlist added_to_cart', update_wishlist_count );
    /**************************/
    /* header title move on title wrapper */
    jQuery(".site-main > header h1.page-title").detach().prependTo('.page-title-wrapper');
    jQuery('body').not( ".search" ).find(".site-main > article > header > h1.page-title").detach().prependTo('.page-title-wrapper');
    jQuery(".category-description-wrap h1.page-title").detach().prependTo('.page-title-wrapper');
    jQuery(".woo_page h1.page-title").detach().prependTo('.page-title-wrapper');
    jQuery(".site-content article.page.type-page .entry-header h1.page-title").detach().prependTo('.page-title-wrapper');
    
    /***************************/
 
    jQuery(".error404 .site-content .not-found h1.page-title").detach().prependTo('.page-title-wrapper');
    var $pro_title = jQuery('.product-block .summary.entry-summary h1.product_title').clone();
    jQuery($pro_title).prependTo('.page-title-wrapper');

    jQuery('.thumbnails.slider .yith_magnifier_gallery').each(function() {
        var children = jQuery(this).children('li');
        var count = children.length;
        if(count <= 3){
            jQuery(this).parent().addClass('slider_cnt');
        }
    });

    jQuery(".dropdown.myaccount-menu .dropdown-toggle.myaccount").click(function(){
        jQuery( ".account-link-toggle.dropdown-menu" ).slideToggle( "2000" );
        jQuery(this).parent('div.dropdown').toggleClass('openclose closelink');
        jQuery( ".dropdowncartwidget" ).slideUp('slow');
    }); 
    
    jQuery(".header_cart .cart_contents").click(function(){
        jQuery( ".dropdowncartwidget" ).slideToggle( "2000" );
        if(jQuery('.dropdown-toggle.myaccount').parent().hasClass('closelink')){
            jQuery('.dropdown-toggle.myaccount').parent().addClass('openclose');
            jQuery('.dropdown-toggle.myaccount').parent().removeClass('closelink');
        }      
        jQuery( ".account-link-toggle.dropdown-menu" ).slideUp('slow');
    });
    jQuery(".language-selector .language_toggle").click(function(){
        jQuery( ".wpml-ls-legacy-list-horizontal" ).slideToggle( "2000" );
    });
    jQuery(".wcml_currency_switcher .wcml-cs-active-currency").click(function(){
        jQuery( ".wcml-cs-submenu" ).slideToggle( "2000" );
    });
    jQuery('.products li .caption .description p').each(function() {
        var title = jQuery.trim(jQuery(this).text());
        var max = 160;

        if (title.length > max) {
            var shortText = jQuery.trim(title).substring(0, max - 3) + '...';
            jQuery(this).html('<span class="product-shorten-desc">' + shortText + '</span>');
        }
    });
    
    /*related Products slider*/
    jQuery('.related.products ul.products').owlCarousel({
        items : 4, //4 items above 1000px browser width
        itemsDesktop : [1200,3], 
        itemsDesktopSmall : [991,3], 
        itemsTablet: [767,2], 
        itemsMobile : [480,1] ,
        slideSpeed : 1000,
        autoPlay : false,
        navigation:true,
        pagination:false,
        stopOnHover:true
    });
    jQuery('.both_sidebar_layout .related.products ul.products').owlCarousel({
        items : 4, //4 items above 1000px browser width
        itemsDesktop : [1200,3], 
        itemsDesktopSmall : [1024,2], 
        itemsTablet: [767,2], 
        itemsMobile : [480,1] ,
        slideSpeed : 1000,
        autoPlay : false,
        navigation:true,
        pagination:false,
        stopOnHover:true
    });

    // Custom Navigation Events
    if(jQuery('.related.products ul.products .owl-controls.clickable').css('display') == 'none'){                                            
        jQuery('.related.products .customNavigation').hide();
    }else{
        jQuery('.related.products .customNavigation').show();
        jQuery(".related_next").click(function(){
            jQuery('.related.products ul.products').trigger('owl.next');
        });

        jQuery(".related_prev").click(function(){
            jQuery('.related.products ul.products').trigger('owl.prev');
        });
    }
    /*upsell Products slider*/
    jQuery('.upsells.products ul.products').owlCarousel({
        items : 4, //4 items above 1000px browser width
        itemsDesktop : [1200,3], 
        itemsDesktopSmall : [1024,2], 
        itemsTablet: [767,2], 
        itemsMobile : [480,1] ,
        slideSpeed : 1000,
        pagination:false,
        navigation:true,
        autoPlay : false,
        stopOnHover:true
    });

    /*upsell Products slider*/
    jQuery('.both_sidebar_layout .upsells.products ul.products').owlCarousel({
        items : 4, //4 items above 1000px browser width
        itemsDesktop : [1200,3], 
        itemsDesktopSmall : [1024,3], 
        itemsTablet: [767,2], 
        itemsMobile : [480,1] ,
        slideSpeed : 1000,
        pagination:false,
        navigation:true,
        autoPlay : false,
        stopOnHover:true
    });

    // Custom Navigation Events
    if(jQuery('.upsells.products ul.products .owl-controls.clickable').css('display') == 'none'){                                            
        jQuery('.upsells.products .customNavigation').hide();
    }else{
        jQuery('.upsells.products .customNavigation').show();
        jQuery(".upsells_next").click(function(){
            jQuery('.upsells.products ul.products').trigger('owl.next');
        });

        jQuery(".upsells_prev").click(function(){
            jQuery('.upsells.products ul.products').trigger('owl.prev');
        });
    }
    /*upsell Products slider*/
    jQuery('.cross-sells ul.products').owlCarousel({
        items : 4, //4 items above 1000px browser width
        itemsDesktop : [1200,3], 
        itemsDesktopSmall : [991,3], 
        itemsTablet: [767,2], 
        itemsMobile : [480,1] ,
        slideSpeed : 1000,
        pagination:false,
        navigation:true,
        autoPlay : false,
        stopOnHover:true
    });
    /*upsell Products slider*/
    jQuery('.both_sidebar_layout .cross-sells ul.products').owlCarousel({
        items : 4, //4 items above 1000px browser width
        itemsDesktop : [1200,3], 
        itemsDesktopSmall : [991,2], 
        itemsTablet: [767,2], 
        itemsMobile : [480,1] ,
        slideSpeed : 1000,
        pagination:false,
        navigation:true,
        autoPlay : false,
        stopOnHover:true
    });

    // Custom Navigation Events
    if(jQuery('.cross-sells.products ul.products .owl-controls.clickable').css('display') == 'none'){                                            
        jQuery('.cross-sells.products .customNavigation').hide();
    }else{
        jQuery('.cross-sells.products .customNavigation').show();
        jQuery(".cross-sells_next").click(function(){
            jQuery('.cross-sells.products ul.products').trigger('owl.next');
        });

        jQuery(".cross-sells_prev").click(function(){
            jQuery('.cross-sells.products ul.products').trigger('owl.prev');
        });
    }
  
    (function(e) {
        "use strict";
        e(".active_progresbar > span").each(function() {
            e(this).data("origWidth", e(this).width()).width(0).animate({
                width: e(this).data("origWidth")
            }, 1200)
        })
    })(jQuery);
    	
    (function(e) {
        "use strict";
        e(".tab ul.tabs li:first-child a").addClass("current");
        e(".tab .tab_groupcontent div.tabs_tab").hide();
        e(".tab .tab_groupcontent div.tabs_tab:first-child").css("display", "block");
        e(".tab ul.tabs li a").click(function(t) {
            var n = e(this).parent().parent().parent(),
            r = e(this).parent().index();
            n.find("ul.tabs").find("a").removeClass("current");
            e(this).addClass("current");
            n.find(".tab_groupcontent").find("div.tabs_tab").not("div.tabs_tab:eq(" + r + ")").slideUp();
            n.find(".tab_groupcontent").find("div.tabs_tab:eq(" + r + ")").slideDown();
            t.preventDefault();
        })
    })(jQuery);
    
    // tooltips on hover
    jQuery('[data-toggle=\'tooltip\']').tooltip({
        container: 'body'
    });

    // Makes tooltips work on ajax generated content
    jQuery(document).ajaxStop(function() {
        jQuery('[data-toggle=\'tooltip\']').tooltip({
            container: 'body'
        });
    });
        
    jQuery('.product_wrap .products > .product-list .product-thumb').attr('class', 'product-thumb col-xs-5 col-sm-5 col-md-3 padding_left_0');
    jQuery('.product_wrap .products > .product-list .product-description').attr('class', 'product-description col-xs-7 col-sm-7 col-md-9');
    
    
    jQuery('.product_wrap .products > .product-grid .product-thumb').attr('class', 'product-thumb col-xs-12 padding_0');
    jQuery('.product_wrap .products > .product-grid .product-description').attr('class', 'product-description col-xs-12');
    jQuery('select.form-control').wrap("<div class='select-wrapper'></div>");
    /* Active class in Product List Grid START */
    jQuery('.product_wrap ul.products > li').addClass('product-grid');
    jQuery('#list-view').click(function() {
        jQuery('.product_wrap ul.products > li').removeClass('product-grid');
        jQuery('.product_wrap ul.products > li').addClass('product-list');
        jQuery('#grid-view').removeClass('active');
        jQuery('#list-view').addClass('active');
        jQuery('.product_wrap .products > .product-list .product-thumb').attr('class', 'product-thumb col-xs-5 col-sm-5 col-md-3 padding_left_0');
        jQuery('.product_wrap .products > .product-list .product-description').attr('class', 'product-description col-xs-7 col-sm-7 col-md-9');
        
        localStorage.setItem('display', 'list');
    });
    jQuery('#grid-view').click(function() {
        jQuery('#list-view').removeClass('active');
        jQuery('#grid-view').addClass('active');
        jQuery('.product_wrap ul.products > li').removeClass('product-list');
        jQuery('.product_wrap ul.products > li').addClass('product-grid');
        jQuery('.product_wrap .products > .product-grid .product-thumb').attr('class', 'product-thumb col-xs-12 padding_0');
        jQuery('.product_wrap .products > .product-grid .product-description').attr('class', 'product-description col-xs-12');	
        localStorage.setItem('display', 'grid');
    });
    /* Active class in Product List Grid END */
    if(jQuery('.filter-grid-list').find('.btn-group').hasClass('grid_list')){
        if (localStorage.getItem('display') == 'list') {
            jQuery('#list-view').trigger('click');
        }else{
            jQuery('#grid-view').trigger('click');
        }               
    }
    if(jQuery('.filter-grid-list').find('.btn-group').hasClass('list_grid')){
        if (localStorage.getItem('display') == 'grid') {
            jQuery('#grid-view').trigger('click');
        }else{
            jQuery('#list-view').trigger('click');
        }               
    }
    if(jQuery('.filter-grid-list').find('.btn-group').hasClass('grid_only')){
        jQuery('#grid-view').trigger('click');
    }else if(jQuery('.filter-grid-list').find('.btn-group').hasClass('list_only')){
        jQuery('#list-view').trigger('click');
    }
    /**
    * Gallery post format slideshow
    */
    jQuery('.format-gallery .enable-slider').slick({
        prevArrow: '<button type="button" data-role="none" class="slick-prev" aria-label="Previous" tabindex="0" role="button"><i class="fa fa-angle-left"></i></button>',
        nextArrow: '<button type="button" data-role="none" class="slick-next" aria-label="Next" tabindex="0" role="button"><i class="fa fa-angle-right"></i></button>'
    });
    jQuery('#stoggle').click(function () {
        if (jQuery(this).hasClass('open')) {
            jQuery(this).removeClass('open');
            jQuery(this).find('i').removeClass('fa-spin');
            jQuery('.theme_customize').css('right', '-300px');
        } else {
            jQuery(this).addClass('open');
            jQuery(this).find('i').addClass('fa-spin');
            jQuery('.theme_customize').css('right', '0');
        }
    });


    jQuery( 'body' ).on( 'found_variation', function( event, variation ) {
        jQuery('.bundleproduct-checkbox .product-check').each(function() {
            if( jQuery(this).is(':checked') && $(this).data( 'product-type' ) == 'variable' ) {
                jQuery(this).data( 'price', variation.display_price );
                jQuery(this).siblings( 'span.bundleproduct-price' ).html( $(variation.price_html).html() );
            }
        });
    });

    jQuery( 'body' ).on( 'woocommerce_variation_has_changed', function( event ) {
        var total_price = bundleproduct_checked_total_price();
        jQuery.ajax({
            type: "POST",
            async: false,
            url: screenReaderText.ajaxurl,
            data: {
                'action': "megashop_bundle_products_total_price", 
                'price': total_price
            },
            success : function( response ) {
                jQuery( 'span.total-price-html .amount' ).html( response );
            }
        })
    });

    jQuery( '.bundleproduct-checkbox .product-check' ).on( "click", function() {
        var total_price = bundleproduct_checked_total_price();
        jQuery.ajax({
            type: "POST",
            async: false,
            url: screenReaderText.ajaxurl,
            data: {
                'action': "megashop_bundle_products_total_price", 
                'price': total_price
            },
            success : function( response ) {
                jQuery( 'span.total-price-html .amount' ).html( response );
                jQuery( 'span.total-products' ).html( bundleproduct_checked_count() );

                var unchecked_product_ids = bundleproduct_unchecked_product_ids();
                jQuery( '.bundle_product ul.products > li' ).each(function() {
                    jQuery(this).show();
                    for (var i = 0; i < unchecked_product_ids.length; i++ ) {
                        if( jQuery(this).hasClass( 'post-'+unchecked_product_ids[i] ) ) {
                            jQuery(this).hide();
                        }
                    }
                });
                jQuery( '.bundle_product .total_count > .total_item_price' ).each(function() {
                    jQuery(this).show();
                    for (var i = 0; i < unchecked_product_ids.length; i++ ) {
                        if( jQuery(this).hasClass( 'post-'+unchecked_product_ids[i] ) ) {
                            jQuery(this).hide();
                        }
                    }
                });
            }
        })
    });
    jQuery('.bundleproduct-checkbox .product-check').each(function() {
        jQuery(this).prop( "checked", true );
    });
        
});
/* ---------------- End Templatetrip more menu ----------------------*/
function moremenu() {    
    var max_elem = 4;
    var items = jQuery('.site-header-menu .main-navigation > div > ul > li');
    var surplus = items.slice(max_elem, items.length);
    surplus.wrapAll('<li class="more_menu menu-item-flyout tttoplink mega-menu-item"><ul class="top-link sub-menu clearfix">');
    jQuery('.more_menu').prepend('<a href="#" class="level-top mega-menu-link">More</a>');
    jQuery('.more_menu').mouseover(function(){
        jQuery(this).children('ul').addClass('shown-link');
    })
    jQuery('.more_menu').mouseout(function(){
        jQuery(this).children('ul').removeClass('shown-link');
    });
}

jQuery(document).ready(function(){
    moremenu();
});
/* Start Homepage Stickyheader JS */

/* Start Homepage Stickyheader JS */	

function header() {    
    if (jQuery(window).width() > 1200){
        if(jQuery('.full-header').hasClass("active")){
            if (jQuery(this).scrollTop() > 100)
            {    
                jQuery('.full-header').addClass("fixed");
 
            }else{
                jQuery('.full-header').removeClass("fixed");
            }
        } else {
            jQuery('.full-header').removeClass("fixed");
        }
    }else{
        jQuery('.full-header').removeClass('fixed');
    }    
}
jQuery(window).scroll(function () {
    var scroll = jQuery(window).scrollTop();
    if (scroll > 100) {
        jQuery(".scroll-up").fadeIn();
    } else {
        jQuery(".scroll-up").fadeOut();
    }
});
 
function menuToggle() {
    if(jQuery( window ).width() < 992) {
        if(jQuery('.sidebar .widget_maxmegamenu').length > 0){
            jQuery('.sidebar .widget_maxmegamenu .mega-menu-wrap').appendTo('.responsivemenu');	
        }else{
            jQuery('.header-bottom-menu .site-navigation').appendTo('.responsivemenu');	
        }
        jQuery('.sidebar .widget_maxmegamenu .mega-menu-wrap').appendTo('.responsivemenu');	
    }
    else if(jQuery( window ).width() >= 992){
        jQuery('.responsivemenu .mega-menu-wrap').insertAfter('.sidebar .widget_maxmegamenu h2');
    }
}
jQuery(document).ready(function() {
    menuToggle();
	if(jQuery('body').hasClass('single-product') && jQuery('body').hasClass('both_sidebar_layout') && jQuery( window ).width() <= 1199) {
		jQuery('.product-block').addClass('productblock_full');
    }else{
		jQuery('.product-block').removeClass('productblock_full');
	}
    
});
jQuery( window ).resize(function(){
    menuToggle();
    if(jQuery( window ).width() > 991) {
        sfMenu();
    }
    if(jQuery( window ).width() <= 991) {
        jQuery('.mega-menu-wrap').hide();
    }
	if(jQuery('body').hasClass('single-product') && jQuery('body').hasClass('both_sidebar_layout') && jQuery( window ).width() <= 1199) {
		jQuery('.product-block').addClass('productblock_full');
    }else{
		jQuery('.product-block').removeClass('productblock_full');
	}
});

jQuery(document).ready(function(){
    header();
});
jQuery(window).resize(function() {
    header();
    if(jQuery( window ).width() <= 768) {
        jQuery('.shop_table.wishlist_table').addClass('shop_table_responsive');	
        var product_name = jQuery('.shop_table.wishlist_table th.product-name span').html();	
        var product_price = jQuery('.shop_table.wishlist_table th.product-price span').html();
        var product_status = jQuery('.shop_table.wishlist_table th.product-stock-stauts span').html();
        jQuery('.shop_table.wishlist_table tbody td.product-name').attr('data-title', product_name);
        jQuery('.shop_table.wishlist_table tbody td.product-price').attr('data-title', product_price);
        jQuery('.shop_table.wishlist_table tbody td.product-stock-status').attr('data-title', product_status);
    }
});
jQuery(window).scroll(function() {
    header();
});

// Countdown
function timecounter() {
    jQuery('.countbox.hastime').each(function() {
        var countTime = jQuery(this).attr('data-time');

        jQuery(this).countdown(countTime, function(event) {
            jQuery(this).html(
                    '<span class="timebox day"><span class="timebox-inner"><strong>' + event.strftime('%D') + '<i>:</i></strong></span></span><span class="timebox hour"><span class="timebox-inner"><strong>' + event.strftime('%H') + '<i>:</i></strong></span></span><span class="timebox minute"><span class="timebox-inner"><strong>' + event.strftime('%M') + '<i>:</i></strong></span></span><span class="timebox second"><span class="timebox-inner"><strong>' + event.strftime('%S') +
                    '</strong></span></span>'
                    );
        });
    });
}

jQuery(document).ready(function() {
    timecounter();
});
jQuery(window).resize(function() {
    timecounter();
});

function footerToggle() {
    if(jQuery( window ).width() < 992) {   
        jQuery('.sidebar .yith-woocommerce-ajax-product-filter.widget').appendTo('.filter_wrapper')
        jQuery(".sidebar .widget h2").addClass( "toggle" );
        jQuery(".sidebar .widget").children(':nth-child(2)').css( 'display', 'none' );
        jQuery(".sidebar .widget.active").children(':nth-child(2)').css( 'display', 'block' );
        jQuery(".sidebar .widget h2.toggle").unbind("click");
        jQuery(".sidebar .widget h2.toggle").click(function() {
            jQuery(this).parent().toggleClass('active').children(':nth-child(2)').slideToggle( "fast" );
        });
        jQuery(".site-footer  .widget:not(.widget_mailpoet_form,.widget_accepted_payment_methods) h2").addClass( "toggle" );
        jQuery(".site-footer .widget:not(.widget_mailpoet_form,.widget_accepted_payment_methods)").children(':nth-child(2)').css( 'display', 'none' );
        jQuery(".site-footer .widget.active:not(.widget_mailpoet_form,.widget_accepted_payment_methods)").children(':nth-child(2)').css( 'display', 'block' );
        jQuery(".site-footer .widget:not(.widget_mailpoet_form,.widget_accepted_payment_methods) h2.toggle").unbind("click");
        jQuery(".site-footer .widget:not(.widget_mailpoet_form,.widget_accepted_payment_methods) h2.toggle").click(function() {
            jQuery(this).parent().toggleClass('active').children(':nth-child(2)').slideToggle( "fast" );
        });
        jQuery('.sidebar .widget_price_filter.widget').detach().appendTo('.filter_wrapper');
        jQuery('.sidebar .yith-woocommerce-ajax-product-filter.widget').detach().appendTo('.filter_wrapper');        
        
        jQuery('.widget_price_filter.widget > form').css( 'display', 'block' );
        jQuery('.yith-woocommerce-ajax-product-filter.widget').css( 'display', 'block' );
        
        jQuery( ".sidebar .widget.widget_layered_nav" ).each(function() {
            var nav_l_id = jQuery( this ).attr('id');
            jQuery('.widget_layered_nav.widget#'+nav_l_id).detach().appendTo('.filter_wrapper');
        });       
        
        jQuery("#content .filter_wrapper .widget.woocommerce").children(':nth-child(2)').css( 'display', 'block' );
        jQuery("#content .filter_wrapper .widget.woocommerce").addClass('active');
        jQuery('.widget_layered_nav.widget > form').css( 'display', 'block' );
    }else{
        jQuery( ".filter_wrapper .widget.widget_layered_nav" ).each(function() {
            var nav_l_id = jQuery( this ).attr('id');
            jQuery('.filter_wrapper .widget_layered_nav.widget#'+nav_l_id).detach().appendTo('.sidebar .widget_layered_nav_filter.'+nav_l_id);
        });
        jQuery("#content .filter_wrapper .widget.woocommerce").removeClass('active');
        jQuery('.filter_wrapper .widget_price_filter.widget').detach().appendTo('.sidebar .options_filter');
        jQuery(".sidebar .widget h2").unbind("click");
        jQuery(".sidebar .widget h2").removeClass( "toggle" );
        jQuery(".sidebar .widget").children(':nth-child(2)').css( 'display', 'block' );
        jQuery(".site-footer .widget h2").unbind("click");
        jQuery(".site-footer .widget h2").removeClass( "toggle" );
        jQuery(".site-footer .widget").children(':nth-child(2)').css( 'display', 'block' );
                
    }
}
jQuery(document).ready(function() {
    footerToggle();
});
jQuery(window).resize(function() {
    footerToggle();
});


function responsivemenu()
{
    if (jQuery(document).width() <= 991)
    {
        jQuery('.main-navigation ul.primary-menu').appendTo('.responsivemenu .mega-menu-wrap > ul');	
        jQuery('.main-navigation ul.mega-menu').appendTo('.responsivemenu .mega-menu-wrap > ul');	
        jQuery('.top-navigation ul.Top-menu').appendTo('.responsivemenu .mega-menu-wrap > ul');
        if(jQuery('.sidebar .widget_maxmegamenu').length > 0){
            jQuery('.sidebar .widget_maxmegamenu .mega-menu-wrap').appendTo('.responsivemenu');	
        }else{
            jQuery('.header-bottom-menu .site-navigation').appendTo('.responsivemenu');	
        }
    }
    else 

    {	
        jQuery('.primary-menu.nav-menu.main-menu').prependTo('.site-inner .main-navigation > div');
        jQuery('.Top-menu.main-menu').prependTo('.site-inner .top-navigation > div');
        jQuery('ul.mega-menu > ul.mega-menu#mega-menu-primary').prependTo('.main-navigation .mega-menu-wrap');	
    }
}
jQuery(document).ready(function() {
    responsivemenu();
});
jQuery( window ).resize(function(){
    responsivemenu();
});

  
function bundleproduct_checked_count(){
    var product_count = 0;
    jQuery('.bundleproduct-checkbox .product-check').each(function() {
        if( jQuery(this).is(':checked') ) {
            product_count++;
        }
    });
    return product_count;
}

function bundleproduct_checked_total_price(){
    var total_price = 0;
    jQuery('.bundleproduct-checkbox .product-check').each(function() {
        if( jQuery(this).is(':checked') ) {
            total_price += parseFloat( jQuery(this).data( 'price' ) );
        }
    });
    return total_price;
}

function bundleproduct_checked_product_ids(){
    var product_ids = [];
    jQuery('.bundleproduct-checkbox .product-check').each(function() {
        if( jQuery(this).is(':checked') ) {
            product_ids.push( jQuery(this).data( 'product-id' ) );
        }
    });
    return product_ids;
}

function bundleproduct_unchecked_product_ids(){
    var product_ids = [];
    jQuery('.bundleproduct-checkbox .product-check').each(function() {
        if( ! jQuery(this).is(':checked') ) {
            product_ids.push( jQuery(this).data( 'product-id' ) );
        }
    });
    return product_ids;
}

function bundleproduct_checked_variable_product_ids(){
    var variable_product_ids = [];
    jQuery('.bundleproduct-checkbox .product-check').each(function() {
        if( jQuery(this).is(':checked') && jQuery(this).data( 'product-type' ) == 'variable' ) {
            variable_product_ids.push( jQuery(this).data( 'product-id' ) );
        }
    });
    return variable_product_ids;
}

function bundleproduct_is_variation_selected(){
    if( jQuery(".single_add_to_cart_button").is(":disabled") ) {
        return false;
    }
    return true;
}

function bundleproduct_refresh_fragments( response ){
    var this_page = window.location.toString();
    var fragments = response.fragments;
    var cart_hash = response.cart_hash;

    // Block fragments class
    if ( fragments ) {
        jQuery.each( fragments, function( key ) {
            jQuery( key ).addClass( 'updating' );
        });
    }

    // Replace fragments
    if ( fragments ) {
        jQuery.each( fragments, function( key, value ) {
            jQuery( key ).replaceWith( value );
        });
    }

    // Cart page elements
    jQuery( '.shop_table.cart' ).load( this_page + ' .shop_table.cart:eq(0) > *', function() {

        jQuery( '.shop_table.cart' ).stop( true ).css( 'opacity', '1' ).unblock();

        jQuery( document.body ).trigger( 'cart_page_refreshed' );
    });

    jQuery( '.cart_totals' ).load( this_page + ' .cart_totals:eq(0) > *', function() {
        jQuery( '.cart_totals' ).stop( true ).css( 'opacity', '1' ).unblock();
    });
}



(function ($) {
    'use strict';
    jQuery(document).ready(function() {
        "use strict";
        /* ------------------------------------------------------------------------ */
        /* Menu
            /* ------------------------------------------------------------------------ */	
            jQuery('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
				jQuery(e.target.hash).find('.lazy').each(function(){
				var imageSrc = jQuery(this).attr("data-original");
				jQuery(this).attr("src", imageSrc).removeAttr("data-original");
			 });
		});

        sfMenu();

        /* Open Submenu on left side when Screen is too small */
        var wapoMainWindowWidth;
        var subMenuExist;
        var subMenuWidth;
        var subMenuOffset;
        var newSubMenuPosition;

        function sfSubmenuPosition() {
            wapoMainWindowWidth = $(window).width();
            $('#site-navigation ul.primary-menu li ul').mouseover(function(){     
                subMenuExist = $(this).find('.sub-menu').length;            
                if( subMenuExist > 0){
                    subMenuWidth = $(this).find('.sub-menu').width();
                    subMenuOffset = $(this).find('.sub-menu').parent().offset().left + subMenuWidth;

                    // if sub menu is off screen, give new position
                    if((subMenuOffset + subMenuWidth) > wapoMainWindowWidth){                  
                        newSubMenuPosition = subMenuWidth + 3;
                        $(this).find('.sub-menu').css({
                            left: -newSubMenuPosition,
                            top: '0'
                        });
                    } else {
                        $(this).find('.sub-menu').css({
                            left: newSubMenuPosition,
                            top: '0'
                        });
                    }
                }
            });
        }

        sfSubmenuPosition();
        /* ------------------------------------------------------------------------ */
        /* Portfolio
    /* ------------------------------------------------------------------------ */

        // FitVids
        function fitvidsLoad(){
            $("#portfolio-embed, .format-video, .format-audio, .video-embed").fitVids();
        }

        fitvidsLoad();

        // Portfolio Hover
        $('.widget_portfolio .portfolio-widget-item').hover(function() {
            $(this).find('.portfolio-overlay').stop().animate({
                'opacity' : 0.7
            }, 180);
        }, function(){
            $(this).find('.portfolio-overlay').stop().animate({
                'opacity' : 0
            }, 180);
        });

        // Overlay-Effect
        $('.portfolio-overlay-effect .portfolio-item .portfolio-image').hover(function() {
            $(this).find('.portfolio-overlay').stop().animate({
                'bottom' : 0
            }, 200,'easeOutCubic');
            $(this).find('.portfolio-image-img').stop().animate({
                'top' : '-60px'
            }, 440,'easeOutCubic');
            $(this).find('.overlay.overlay-effect').stop().animate({
                'margin-top' : '-30px'
            }, 160);
        }, function(){
            $(this).find('.portfolio-overlay').stop().animate({
                'bottom' : '-72px'
            }, 440,'easeOutCubic');
            $(this).find('.portfolio-image-img').stop().animate({
                'top' : '0px'
            }, 200,'easeOutCubic');
            $(this).find('.overlay.overlay-effect').stop().animate({
                'margin-top' : '-30px'
            }, 160);
        });

        // Overlay-Name
        $('.portfolio-overlay-name .portfolio-item .portfolio-image').hover(function() {
            $(this).find('.portfolio-overlay').stop().animate({
                'opacity' : 0.7
            }, 160);
        }, function(){
            $(this).find('.portfolio-overlay').stop().animate({
                'opacity' : 0
            }, 160);
        });
            
        // Portfolio Isotope
        function portfolioIsotope(){
    	
            var $portfoliocontainer = $('.portfolio-items');
            $('.portfolio-item').css({
                visibility: "visible", 
                opacity: "0"
            });

            $portfoliocontainer.imagesLoaded( function() {
                $portfoliocontainer.fadeIn(1000).isotope({
                    transitionDuration: '0.6s',
                    itemSelector: '.portfolio-item',
                    resizable: true,
                    layoutMode: 'packery',
                    sortBy: 'origorder'
                });

                // Fade In
                $('.portfolio-item').each(function(index){
                    $(this).delay(80*index).animate({
                        opacity: 1
                    }, 200);
                });
            });

            $('.portfolio-filters a').click(function(){
                $('.portfolio-items').addClass('animatedcontainer');
                $(this).closest('.portfolio-filters').find('a').removeClass('active');
                $(this).addClass('active');
                var selector = $(this).attr('data-filter');
                var portfolioID = $(this).closest('.portfolio-filters').attr("data-id");
                $('.portfolio-items[data-id=' + portfolioID + ']').isotope({
                    filter: selector
                });
                return false;
            });

        }

        portfolioIsotope();
            
            
        var ajaxXHR = null;
        filter_product_Ajax();
    });
    function filter_product_Ajax() {
        var ajaxXHR = null;
            
        var $shopTopbar = $('.archive_filter .archive_filter_wrap');
        $(document.body).find('.archive_filter .pro_filter').click(function (e) {
            e.preventDefault();
                              
            $shopTopbar.slideToggle();

            $shopTopbar.toggleClass('active');
            $(this).toggleClass('active');
            $('#tt-filter-overlay').toggleClass('show');
            if($('.pro_filter').hasClass('active')){                                    
                $('.pro_filter .genericon').addClass('genericon-minus');
                $('.pro_filter .genericon').removeClass('genericon-plus');
            }else{
                $('.pro_filter .genericon').addClass('genericon-plus');
                $('.pro_filter .genericon').removeClass('genericon-minus');
            }                                
        });
                        
        $(document.body).find('#tt-categories-filter').on('click', 'a', function (e) {
            e.preventDefault();
            $(this).addClass('selected');
            var url = $(this).attr('href');
            $(document.body).trigger('tt_catelog_filter_ajax', url, $(this));
        });         
                        
                        
        $(document.body).on('price_slider_change', function (event, ui) {
            var form = $('.price_slider').closest('form').get(0),
            $form = $(form),
            url = $form.attr('action') + '?' + $form.serialize();

            $(document.body).trigger('tt_catelog_filter_ajax', url, $(this));
        });


        $(document.body).on('click', ' #remove-filter-actived', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $(document.body).trigger('tt_catelog_filter_ajax', url, $(this));
        });

        $(document.body).find('.archive_filter ').find('.woocommerce-ordering').on('click', 'a', function (e) {
            e.preventDefault();
            $(this).addClass('active');
            var url = $(this).attr('href');
            $(document.body).trigger('tt_catelog_filter_ajax', url, $(this));
        });


        $(document.body).find('.archive_filter').on('click', 'a', function (e) {
            var $widget = $(this).closest('.widget');
            if ($widget.hasClass('widget_product_tag_cloud') ||
                $widget.hasClass('widget_product_categories') ||
                $widget.hasClass('widget_layered_nav_filters') ||
                $widget.hasClass('widget_layered_nav') ||
                $widget.hasClass('product-sort-by') ||
                $widget.hasClass('tt-price-filter-list')) {
                e.preventDefault();
                if($(this).closest('li').hasClass('chosen')){
                    $(this).closest('li').removeClass('chosen');
                }else{
                    $(this).closest('li').addClass('chosen');
                }
                $(this).closest('li').addClass('chosen');
                var url = $(this).attr('href');
                $(document.body).trigger('tt_catelog_filter_ajax', url, $(this));
            }

            if ($widget.hasClass('widget_product_tag_cloud')) {
                $(this).addClass('selected');
            }

            if ($widget.hasClass('product-sort-by')) {
                $(this).addClass('active');
            }
        });

        $(document.body).on('tt_catelog_filter_ajax', function (e, url, element) {

            var $container = $('#shop_product_wrap'),
            $container_nav = $('#primary-sidebar'),
            $categories = $('#tt-categories-filter'),
            $shopTopbar = $('.archive_filter_div'),
            $ordering = $('.archive_filter .woocommerce-ordering');

            if ($('.filter-toolbar').length > 0) {
                var position = $('.filter-toolbar').offset().top - 200;
                $('html, body').stop().animate({
                    scrollTop: position
                },
                1200
                );
            }

            $('#shop-loading').addClass('show');
            if ('?' == url.slice(-1)) {
                url = url.slice(0, -1);
            }
            url = url.replace(/%2C/g, ',');
                        
            history.pushState(null, null, url);
            //
            $(document.body).trigger('tt_ajax_filter_before_send_request', [url, element]);

            if (ajaxXHR) {
                ajaxXHR.abort();
            }

            ajaxXHR = $.get(url, function (res) {
                if($(res).find('#shop_product_wrap').length){
                    $container.replaceWith($(res).find('#shop_product_wrap'));
                    $container_nav.html($(res).find('.catalog-sidebar').html());
                    $categories.html($(res).find('#tt-categories-filter').html());
                    $shopTopbar.html($(res).find('.archive_filter_div').html());
                    $ordering.html($(res).find('.archive_filter .woocommerce-ordering').html());
                }else{
                    $container.addClass('no_products_wrap');
                    $container.find('.tt-products').replaceWith($( the_tt_js_data.end_text ));
                }
                priceSlider_filter();
                $('#shop-loading').removeClass('show');
                jQuery('.archive_filter').addClass('active');
                jQuery('.archive_filter_wrap').addClass('active');
                var $container_wrap = jQuery(".product_wrap.shop_masonry .tt-products.products");
                if($('.product_wrap').hasClass('shop_masonry')){
                    jQuery('li.product').addClass('product-grid');
                    $container_wrap.imagesLoaded( function() {
                        $container_wrap.masonry();
                    });
                }
                $container_wrap.find('img.lazy').lazyload({
                    threshold: 1000
                });
                if (jQuery( window ).width() > 991) {
                                
                    if($('.archive_filter').hasClass('active')){                                    
                        $('.pro_filter .genericon').addClass('genericon-minus');
                        $('.pro_filter .genericon').removeClass('genericon-plus');
                    }else{
                        $('.pro_filter .genericon').addClass('genericon-plus');
                        $('.pro_filter .genericon').removeClass('genericon-minus');
                    }
                }

                if(jQuery('.product_wrap').hasClass('shop_masonry')){
                    jQuery('li.product').addClass('product-grid');
                    jQuery('#grid-view').trigger('click');
                }else{
                    if (localStorage.getItem('display') == 'list') {
                        jQuery('li.product').addClass('product-list');
                        jQuery('#list-view').trigger('click');
                    }else{
                        jQuery('li.product').addClass('product-grid');
                        jQuery('#grid-view').trigger('click');
                    }
                }
                                 
                $(document.body).trigger('tt_ajax_filter_request_success', [res, url]);

            }, 'html');


        });
        $(document.body).on('unero_ajax_search_request_success', function (e, $results) {
            $results.find('img.lazy').lazyload({
                threshold: 1000
            });
        });
        //                $(document.body).find('.archive_filter').on('click', '.widget-title', function (e) {
        //	 if ($(this).closest('.archive_filter ').hasClass('on-mobile')) {
        //	 e.preventDefault();
        //
        //	 $(this).closest('.widget').siblings().find('.widget-title').next().slideUp(200);
        //	 $(this).closest('.widget').siblings().removeClass('active');
        //                                $(this).toggleClass('active');
        //
        //	 $(this).next().slideToggle(200);
        //	 $(this).closest('.widget').toggleClass('active');
        //
        //	 }
        //	 });

        $(document.body).on('tt_ajax_filter_before_send_request', function () {
            if ($('.archive_filter').hasClass('on-mobile')) {
                $('.archive_filter_wrap').slideUp();
                $('#tt-toggle-cats-filter').removeClass('active');
                $('.pro_filter').removeClass('active');
                $('.archive_filter').removeClass('active');
                $('.archive_filter_wrap').removeClass('active');
                $('.pro_filter .genericon').removeClass('genericon-minus');
                $('.pro_filter .genericon').addClass('genericon-plus');
                $('.archive_filter.on-mobile #tt-categories-filter').slideUp();
            }
        });
                

    }
        
        
    function priceSlider_filter() {	 // woocommerce_price_slider_params is required to continue, ensure the object exists
        if (typeof woocommerce_price_slider_params === 'undefined') {
            return false;
        }

        if ($('.catalog-sidebar').find('.widget_price_filter').length <= 0 && $('.archive_filter_wrap').find('.widget_price_filter').length <= 0) {
            return false;
        }

        // Get markup ready for slider
        $('input#min_price, input#max_price').hide();
        $('.price_slider, .price_label').show();

        // Price slider uses jquery ui
        var min_price = $('.price_slider_amount #min_price').data('min'),
        max_price = $('.price_slider_amount #max_price').data('max'),
        current_min_price = parseInt(min_price, 10),
        current_max_price = parseInt(max_price, 10);

        if ($('.price_slider_amount #min_price').val() != '') {
            current_min_price = parseInt($('.price_slider_amount #min_price').val(), 10);
        }
        if ($('.price_slider_amount #max_price').val() != '') {
            current_max_price = parseInt($('.price_slider_amount #max_price').val(), 10);
        }

        $(document.body).bind('price_slider_create price_slider_slide', function (event, min, max) {
            if (woocommerce_price_slider_params.currency_pos === 'left') {

                $('.price_slider_amount span.from').html(woocommerce_price_slider_params.currency_symbol + min);
                $('.price_slider_amount span.to').html(woocommerce_price_slider_params.currency_symbol + max);

            } else if (woocommerce_price_slider_params.currency_pos === 'left_space') {

                $('.price_slider_amount span.from').html(woocommerce_price_slider_params.currency_symbol + ' ' + min);
                $('.price_slider_amount span.to').html(woocommerce_price_slider_params.currency_symbol + ' ' + max);

            } else if (woocommerce_price_slider_params.currency_pos === 'right') {

                $('.price_slider_amount span.from').html(min + woocommerce_price_slider_params.currency_symbol);
                $('.price_slider_amount span.to').html(max + woocommerce_price_slider_params.currency_symbol);

            } else if (woocommerce_price_slider_params.currency_pos === 'right_space') {

                $('.price_slider_amount span.from').html(min + ' ' + woocommerce_price_slider_params.currency_symbol);
                $('.price_slider_amount span.to').html(max + ' ' + woocommerce_price_slider_params.currency_symbol);

            }

            $(document.body).trigger('price_slider_updated', [min, max]);
        });
        if (typeof $.fn.slider !== 'undefined') {
            $('.price_slider').slider({
                range  : true,
                animate: true,
                min    : min_price,
                max    : max_price,
                values : [current_min_price, current_max_price],
                create : function () {

                    $('.price_slider_amount #min_price').val(current_min_price);
                    $('.price_slider_amount #max_price').val(current_max_price);

                    $(document.body).trigger('price_slider_create', [current_min_price, current_max_price]);
                },
                slide  : function (event, ui) {

                    $('input#min_price').val(ui.values[0]);
                    $('input#max_price').val(ui.values[1]);

                    $(document.body).trigger('price_slider_slide', [ui.values[0], ui.values[1]]);
                },
                change : function (event, ui) {
                    $(document.body).trigger('price_slider_change', [ui.values[0], ui.values[1]]);
                }
            });
        }
    }
})(jQuery);
function sfMenu() {

    jQuery("#site-navigation ul.primary-menu").superfish({
        delay:       	300,
        hoverClass:    	'sfHover',
        animation:     {
            opacity: "show"
        },   // an object equivalent to first parameter of jQuery’s .animate() method. Used to animate the submenu open
        speed:       	200,
        speedOut: 	 	0,
        cssArrows:   	true
    });

}