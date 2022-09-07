jQuery(document).ready(function(){    
    /* page templete and sidebar selection option */
    var theme_layout = js_strings.theme_layout;
    jQuery('.post-type-page #page_template').on('change', function() {
            var valueSelected = this.value;
            var theme_layout = js_strings.theme_layout;
            if((valueSelected == 'default' || valueSelected == 'page-templates/left_sidebar.php' || valueSelected == 'page-templates/home_page.php' || valueSelected == 'page-templates/right_sidebar.php') && theme_layout == 'left_sidebar_layout'){
                jQuery('#custom_sidebar').show();
                jQuery('#custom_sidebar_2').hide();
            }else if((valueSelected == 'page-templates/left_sidebar.php' || valueSelected == 'page-templates/right_sidebar.php' ) && (theme_layout == 'left_sidebar_layout' || theme_layout == 'full_width_layout' || theme_layout == 'both_sidebar_layout') ){
                jQuery('#custom_sidebar').show();
                jQuery('#custom_sidebar_2').hide();
            }else if((valueSelected == 'page-templates/both_sidebar.php' || valueSelected == 'default' || valueSelected == 'page-templates/home_page.php') && theme_layout == 'both_sidebar_layout' ){
                jQuery('#custom_sidebar').show();
                jQuery('#custom_sidebar_2').show();
            }else if((valueSelected == 'page-templates/both_sidebar.php' ) && (theme_layout == 'left_sidebar_layout' || theme_layout == 'full_width_layout' || theme_layout == 'both_sidebar_layout') ){
                jQuery('#custom_sidebar').show();
                jQuery('#custom_sidebar_2').show();
            }else{
                jQuery('#custom_sidebar').hide();
                jQuery('#custom_sidebar_2').hide();
            }
        
    });
    
    var valueSelected = jQuery( ".post-type-page #page_template" ).val();
    if((valueSelected == 'default' || valueSelected == 'page-templates/left_sidebar.php' || valueSelected == 'page-templates/home_page.php' || valueSelected == 'page-templates/right_sidebar.php') && theme_layout == 'left_sidebar_layout'){
        jQuery('#custom_sidebar').show();
        jQuery('#custom_sidebar_2').hide();
    }else if((valueSelected == 'page-templates/left_sidebar.php' || valueSelected == 'page-templates/right_sidebar.php' ) && (theme_layout == 'left_sidebar_layout' || theme_layout == 'full_width_layout' || theme_layout == 'both_sidebar_layout') ){
        jQuery('#custom_sidebar').show();
        jQuery('#custom_sidebar_2').hide();
    }else if((valueSelected == 'page-templates/both_sidebar.php' || valueSelected == 'default' || valueSelected == 'page-templates/home_page.php') && theme_layout == 'both_sidebar_layout' ){
        jQuery('#custom_sidebar').show();
        jQuery('#custom_sidebar_2').show();
    }else if((valueSelected == 'page-templates/both_sidebar.php' ) && (theme_layout == 'left_sidebar_layout' || theme_layout == 'full_width_layout' || theme_layout == 'both_sidebar_layout') ){
        jQuery('#custom_sidebar').show();
        jQuery('#custom_sidebar_2').show();
    }else{
        jQuery('#custom_sidebar').hide();
        jQuery('#custom_sidebar_2').hide();
    }
    /*********/
    jQuery( "#new_label_date_field" ).datepicker({minDate: 0,dateFormat: 'yy-mm-dd'});
    jQuery('#tt_end_sales_date').datepicker({
                        minDate: 0,
                        dateFormat : 'yy/mm/dd'
                    });
    /* script for auto install */
    jQuery('#auto-install').on('click',function(){
        jQuery('.auto-install-loader').show();
        var demo = jQuery('#auto-install').attr('data-href');
        var auto_update = 'auto_install_layout1';
            auto_update = demo; 
        jQuery.ajax({
            type: 'POST',
            url: js_strings.ajaxurl,
            data: {
                layout: auto_update,
                action: 'auto_install_layout'
            },
            success: function(data, textStatus, XMLHttpRequest){
                jQuery('.auto-install-loader').hide();
                location.reload();
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                jQuery('.auto-install-loader').hide();
                location.reload();
            }
        });
    });
    jQuery('#remove-auto-install').on('click',function(){
        if (confirm("Do you want to remove sample data?") == true) {
            jQuery('.auto-install-loader').show();
            jQuery.ajax({
                type: 'POST',
                url: js_strings.ajaxurl,
                data: {
                    action: 'remove_auto_update'
                },
                success: function(data, textStatus, XMLHttpRequest){
                    jQuery('.auto-install-loader').hide();
                    location.reload();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    jQuery('.auto-install-loader').hide();
                    location.reload();
                }
            });
            return true;
        } else {
            return false;
        }
    });
    
    /* jquery auto-install section */

    jQuery('.demo_layout_wrap.select_demo div.bgframe').on('click', function (e) {
        var tlayout = jQuery(this);
        jQuery('.demo_layout_wrap div.bgframe').each(function () {
            jQuery(this).find('.scroll_image').removeClass('selected');
            jQuery(this).removeClass('selected');
        });
        tlayout.find('.scroll_image').addClass('selected');
        tlayout.addClass('selected');
        var install_path = tlayout.find('.scroll_image').attr('demo-attr');
        jQuery('.demo_install_button').find('a.install_demo').removeClass('disabled');
        jQuery('.demo_install_button').find('.select_demo_msg').remove();
        jQuery('.demo_install_button').find('a.install_demo').attr('data-href', install_path);
    });
    if (jQuery('.demo_layout_wrap a.bgframe').hasClass('selected')) {
        jQuery('.demo_install_button').find('a.install_demo').removeClass('disabled');
    } else {
        jQuery('.demo_install_button').find('a.install_demo').addClass('disabled');
        jQuery('.demo_install_button').find('.start_install').append('<span class="select_demo_msg"> ' + js_strings.select_demo_notice + '</span>');
    }
    jQuery(window).load(function () {
        jQuery('.end_install').find('.select_demo_msg').remove();
    });
    
    
    /* UNLIMITED SIDEBARS */
	
	var delSidebar = '<div class="delete-sidebar">delete</div>';
	
	jQuery('.sidebar-template_trip_custom_sidebar').find('.sidebar-name-arrow').before(delSidebar);
	
	jQuery('.delete-sidebar').click(function(){
		
		var confirmIt = confirm('Are you sure?');
		
		if(!confirmIt) return;
		
		var widgetBlock = jQuery(this).parent().parent().parent();
	
		var data =  {
			'action':'template_trip_delete_sidebar',
			'template_trip_sidebar_name': jQuery(this).parent().find('h2').text()
		};
		
		widgetBlock.hide();
		
		jQuery.ajax({
			url: ajaxurl,
			data: data,
			success: function(response){
				console.log(response);
				widgetBlock.remove();
			},
			error: function(data) {
				alert('Error while deleting sidebar');
				widgetBlock.show();
			}
		});
	});

	
	/* end sidebars */
    
    
	 jQuery(document).on("click", ".upload_image", function (event) {
        event.preventDefault();
		var thisvar = jQuery(this);
        var frame;
        if (frame) {
            frame.open();
            return;
        }
        frame = wp.media({
            title: 'upload image',
            button: {
                text: 'select'
            },
            library: {type: 'image'},
            multiple: false
        });
        frame.on('select', function () {
            var attachment = frame.state().get('selection').first().toJSON();
            thisvar.next('.image_wrap').empty().hide().append('<img src="' + attachment.url + '" alt="" style="max-width:100%; float:left;"/><a class="remove-image" title="remove">remove</a>').slideDown('fast');
            thisvar.prev().val(attachment.url);
            thisvar.next('.image_wrap').parent().closest('.image_div').parent('div').find('.custom_image_position').show();
			jQuery(".image_wrap .remove-image").click(function () {
			jQuery(this).closest('.image_wrap').slideUp('fast');			
			jQuery(this).closest('.image_wrap').parent().closest('.image_div').find(".image_input").val('');
                        jQuery(this).closest('.image_wrap').parent().closest('.image_div').parent('div').find('.custom_image_position').hide();			
			jQuery(this).hide('slow');
			jQuery(this).closest('.image_wrap').empty();
			return false;
		});
        });
		
        frame.open();
    });
    /* product 360 */    
function product360ViewGallery() {

if(jQuery('body').hasClass('post-type-product')){
// Product gallery file uploads.
var product_gallery_frame;
var $image_gallery_ids = jQuery( '#product_360_image_gallery' );
var $product_images    = jQuery( '#product_360_images_container' ).find( 'ul.product_360_images' );

jQuery( '.add_product_360_images' ).on( 'click', 'a', function( event ) {
    var $el = jQuery( this );

    event.preventDefault();

    // If the media frame already exists, reopen it.
    if ( product_gallery_frame ) {
        product_gallery_frame.open();
        return;
    }

    // Create the media frame.
    product_gallery_frame = wp.media.frames.product_gallery = wp.media({
        // Set the title of the modal.
        title: $el.data( 'choose' ),
        button: {
            text: $el.data( 'update' )
        },
        states: [
            new wp.media.controller.Library({
                title: $el.data( 'choose' ),
                filterable: 'all',
                multiple: true
            })
        ]
    });

    // When an image is selected, run a callback.
    product_gallery_frame.on( 'select', function() {
        var selection = product_gallery_frame.state().get( 'selection' );
        var attachment_ids = $image_gallery_ids.val();

        selection.map( function( attachment ) {
            attachment = attachment.toJSON();

            if ( attachment.id ) {
                attachment_ids   = attachment_ids ? attachment_ids + ',' + attachment.id : attachment.id;
                var attachment_image = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;

                $product_images.append( '<li class="image" data-attachment_id="' + attachment.id + '"><img src="' + attachment_image + '" /><ul class="actions"><li><a href="#" class="delete" title="' + $el.data('delete') + '">' + $el.data('text') + '</a></li></ul></li>' );
            }
        });

        $image_gallery_ids.val( attachment_ids );
    });

    // Finally, open the modal.
    product_gallery_frame.open();
});

// Image ordering.
$product_images.sortable({
    items: 'li.image',
    cursor: 'move',
    scrollSensitivity: 40,
    forcePlaceholderSize: true,
    forceHelperSize: false,
    helper: 'clone',
    opacity: 0.65,
    placeholder: 'wc-metabox-sortable-placeholder',
    start: function( event, ui ) {
        ui.item.css( 'background-color', '#f6f6f6' );
    },
    stop: function( event, ui ) {
        ui.item.removeAttr( 'style' );
    },
    update: function() {
        var attachment_ids = '';

        $( '#product_360_images_container' ).find( 'ul li.image' ).css( 'cursor', 'default' ).each( function() {
            var attachment_id = $( this ).attr( 'data-attachment_id' );
            attachment_ids = attachment_ids + attachment_id + ',';
        });

        $image_gallery_ids.val( attachment_ids );
    }
});

// Remove images.
jQuery( '#product_360_images_container' ).on( 'click', 'a.delete', function() {
    jQuery( this ).closest( 'li.image' ).remove();

    var attachment_ids = '';

    jQuery( '#product_360_images_container' ).find( 'ul li.image' ).css( 'cursor', 'default' ).each( function() {
        var attachment_id = $( this ).attr( 'data-attachment_id' );
        attachment_ids = attachment_ids + attachment_id + ',';
    });

    $image_gallery_ids.val( attachment_ids );

    // Remove any lingering tooltips.
    jQuery( '#tiptip_holder' ).removeAttr( 'style' );
    jQuery( '#tiptip_arrow' ).removeAttr( 'style' );

    return false;
});
}
}
product360ViewGallery();
/* end 360 */
    jQuery(document).on("click", ".upload_image", function (event) {
        event.preventDefault();
        var thisvar = jQuery(this);
        var frame;
        if (frame) {
            frame.open();
            return;
        }
        frame = wp.media({
            title: 'upload image',
            button: {
                text: 'select'
            },
            library: {
                type: 'image'
            },
            multiple: false
        });
        frame.on('select', function () {
            var attachment = frame.state().get('selection').first().toJSON();
            thisvar.next('.image_wrap').empty().hide().append('<img src="' + attachment.url + '" alt="" style="max-width:100%; float:left;"/><a class="remove-image" title="remove">remove</a>').slideDown('fast');
            thisvar.prev().val(attachment.url);
            thisvar.next('.image_wrap').parent().closest('.image_div').show();
            jQuery(".image_wrap .remove-image").on('click',function () {
                jQuery(this).closest('.image_wrap').slideUp('fast');	
                jQuery(this).closest('.image_wrap').parent().closest('.image_div').find(".image_input").val('');
                jQuery(this).closest('.image_wrap').parent().hide();	
                jQuery(this).hide('slow');
                jQuery(this).closest('.image_wrap').empty();
                return false;
            });
        });

        frame.open();
    });
    /*-- Remove image --*/
        jQuery(".image_wrap .remove-image").click(function () {
                jQuery(this).closest('.image_wrap').slideUp('fast');			
                jQuery(this).closest('.image_wrap').parent().closest('.image_div').find(".image_input").val('');
                jQuery(this).closest('.image_wrap').parent().closest('.image_div').parent('div').find('.custom_image_position').hide();		
                jQuery(this).hide('slow');
                jQuery(this).closest('.image_wrap').empty();
                return false;
        });
	
	jQuery(document).on('widget-added', function(e, widget){
		jQuery(".image_wrap .remove-image").click(function () {
			jQuery(this).closest('.image_wrap').slideUp('fast');			
			jQuery(this).closest('.image_wrap').parent().closest('.image_div').find(".image_input").val('');			
			jQuery(this).hide('slow');
			jQuery(this).closest('.image_wrap').empty();
			return false;
		});
	});
	jQuery(document).on('widget-updated', function(e, widget){
		jQuery(".remove-image").click(function () {
			jQuery(this).closest('.image_wrap').slideUp('fast');			
			jQuery(this).closest('.image_wrap').parent().closest('.image_div').find(".image_input").val('');			
			jQuery(this).hide('slow');
			jQuery(this).closest('.image_wrap').empty();
			return false;
		});
	});

});

function ck_category_check(ob_check) {
		var is_checked_len = jQuery(ob_check).parent().parent().find('input:checked').length; 
		if( is_checked_len == 0 ) {
			ob_check.checked = true;
		} 
} 
