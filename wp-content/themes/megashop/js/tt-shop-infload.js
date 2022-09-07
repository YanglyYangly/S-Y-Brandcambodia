(function ($){
    $(document).ready( function () {
        var tt_is_loading = false,
            tt_loading_style;
        if ( $( the_tt_js_data.products ).length > 0 ) {
            
            $( the_tt_js_data.products ).after( $( the_tt_js_data.load_more ) );
            current_style();
            $(window).resize( function () {
                current_style();
            });
            $(window).scroll ( function () {
                if ( tt_loading_style == 'infinity_scroll' ) {
                    if(the_tt_js_data.products.length){
                    var products_bottom = $( the_tt_js_data.products ).offset().top + $( the_tt_js_data.products ).height() - the_tt_js_data.buffer;
                    var bottom_position = $(window).scrollTop() + $(window).height();
                    if ( products_bottom < bottom_position && ! tt_is_loading ) {
                        load_next_page();
                    }
                }
                }
            });
            $(document).on( 'click', '.tt_button', function (event) {
                event.preventDefault();
                load_next_page();
            });
            
        }
        function load_next_page( replace, user_next_page ) {
            if ( typeof( replace ) == 'undefined' ) {
                user_next_page = false;
            }
            if ( typeof( user_next_page ) == 'undefined' ) {
                user_next_page = false;
            }
            var $next_page = $( the_tt_js_data.next_page );
            if ( $next_page.length > 0 || user_next_page !== false ) {
                start_ajax_loading()
                var next_page;
                if( user_next_page !== false ) {
                    next_page = user_next_page;
                } else {
                    next_page = $next_page.attr('href');
                }
                $.get( next_page, function( data ) {
                    var $data = $(data);
                    if( the_tt_js_data.lazy_load_m && $(window).width() <= the_tt_js_data.mobile_width || the_tt_js_data.lazy_load && $(window).width() > the_tt_js_data.mobile_width ) {
                        $data.find(the_tt_js_data.item+', .berocket_lgv_additional_data').find( 'img' ).each( function ( i, o ) {
                            $(o).attr( 'data-src', $(o).attr( 'src' ) ).removeAttr( 'src' );
                        });
                        $data.find(the_tt_js_data.item+', .berocket_lgv_additional_data').addClass('lazy');
                    }
                    var $products = $data.find( the_tt_js_data.products ).html();
                    if ( replace ) {
                        $( the_tt_js_data.products ).html( $products );
                    } else {
                        var $container = jQuery(".product_wrap.shop_masonry .tt-products.products");
                        $( the_tt_js_data.products ).append( $products ).each(function(){
                        $('.tt-products').masonry('reloadItems');
                            });
                            if($( the_tt_js_data.products ).find('li').hasClass('product-grid')){
                                jQuery('#grid-view').trigger('click');
                                jQuery('li.product').addClass('product-grid');
                            }
                            if($( the_tt_js_data.products ).find('li').hasClass('product-list')){
                                jQuery('#list-view').trigger('click');
                                jQuery('li.product').addClass('product-list');
                            }
                             $container.imagesLoaded( function() {
                                $container.masonry();
                             });
                    }
                    
                    $( the_tt_js_data.products ).find('img.lazy').lazyload({
                                threshold: 1000
                        });
//                    
                    
                    if( the_tt_js_data.lazy_load_m && $(window).width() <= the_tt_js_data.mobile_width || the_tt_js_data.lazy_load && $(window).width() > the_tt_js_data.mobile_width ) {
                        $( the_tt_js_data.products+' .lazy' ).find( 'img' ).lazyLoadXT();
                        $( the_tt_js_data.products ).find('.lazy').on( 'lazyshow', function () {
                            $(this).removeClass('lazy').addClass('animated').addClass(the_tt_js_data.LLanimation);
                            if( ! $(this).is('.berocket_lgv_additional_data') ) {
                                $(this).next( '.berocket_lgv_additional_data' ).removeClass('lazy').addClass('animated').addClass(the_tt_js_data.LLanimation);
                            }
                        });
                    }
                    var $pagination = $data.find( the_tt_js_data.pagination );
                    $( the_tt_js_data.pagination ).html( $pagination.html() );
                    current_style();
                    end_ajax_loading();
                });
            }
        }
        function start_ajax_loading() {
            tt_is_loading = true;
            if($( the_tt_js_data.products ).find('li').hasClass('product-grid')){
                jQuery('#grid-view').trigger('click');
                jQuery('li.product').addClass('product-grid');
            }
            if($( the_tt_js_data.products ).find('li').hasClass('product-list')){
                jQuery('#list-view').trigger('click');
                jQuery('li.product').addClass('product-list');
            }
            tt_execute_func( the_tt_js_data.javascript.before_update );
            $( the_tt_js_data.products ).append( $( the_tt_js_data.load_image ) );
        }
        function end_ajax_loading() {
            $( the_tt_js_data.load_img_class ).remove();
            tt_execute_func( the_tt_js_data.javascript.after_update );
            tt_is_loading = false;
            if($( the_tt_js_data.products ).find('li').hasClass('product-grid')){
                jQuery('#grid-view').trigger('click');
            }
            if($( the_tt_js_data.products ).find('li').hasClass('product-list')){
                jQuery('#list-view').trigger('click');
            }
            var $next_page = $( the_tt_js_data.next_page );
            if( ( tt_loading_style == 'infinity_scroll' || tt_loading_style == 'more_button' ) && $next_page.length <= 0 ) {
                $( the_tt_js_data.products ).append( $( the_tt_js_data.end_text ) );
            }
        }
        function current_style() {
            if( $( the_tt_js_data.next_page ).length > 0 ) {
                $('.tt_button').attr('href', $( the_tt_js_data.next_page ).attr('href'));
            }
            if ( the_tt_js_data.use_mobile && $(window).width() <= the_tt_js_data.mobile_width ) {
                set_style( the_tt_js_data.mobile_type );
            } else {
                set_style( the_tt_js_data.type );
            }
        }
        function set_style( style ) {
            var $next_page = $( the_tt_js_data.next_page );
            $( the_tt_js_data.pagination ).hide();
            $( '.tt_load_more_button' ).hide();
            if ( style == 'more_button' ) {
                if ( $next_page.length > 0 ) {
                    $( '.tt_load_more_button' ).show();
                } else {
                    setTimeout( test_next_page, 2000 );
                }
            } else if ( style == 'pagination' ) {
                $( the_tt_js_data.pagination ).show();
            }
            tt_loading_style = style;
        }
        function test_next_page() {
            var $next_page = $( the_tt_js_data.next_page );
            if ( $next_page.length > 0 ) {
                current_style();
            } else {
                setTimeout( test_next_page, 2000 );
            }
        }
        tt_update_state = function() {
            current_style();
        }
    });
})(jQuery);


function tt_execute_func ( func ) {
    if( the_tt_js_data.javascript != 'undefined'
        && the_tt_js_data.javascript != null
        && typeof func != 'undefined' 
        && func.length > 0 ) {
        try{
            eval( func );
        } catch(err){
            alert('You have some incorrect JavaScript code (Load More Products)');
        }
    }
}
