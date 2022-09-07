<?php

/*
  Plugin Name: TemplateTrip Shortcode
  Plugin URI: http://www.templatetrip.com
  Description: templatetrip Custom Shortcodes for templatetrip wordpress themes.
  Version: 1.0
  Author: TemplateTrip
  Author URI: http://www.templatetrip.com
 * Text Domain: ttshortcode
 */

add_action('init', 'ttshortcode_load_textdomain');

/* register widget */
define('TTSHORTCODE_DIR', WP_PLUGIN_DIR . '/' . plugin_basename('TTCustomShortcode'));

    require TTSHORTCODE_DIR . '/widgets/widget-cat_widget.php';
    require_once TTSHORTCODE_DIR . '/widgets/widget-contactus.php';
    require_once TTSHORTCODE_DIR . '/widgets/widget-testimonial.php';
    require_once TTSHORTCODE_DIR . '/widgets/widget-ourbrand.php';
    require_once TTSHORTCODE_DIR . '/widgets/widget-latestblog.php';
    require_once TTSHORTCODE_DIR . '/widgets/widget-latestblog-list.php';
    if (class_exists('woocommerce')) {
        require_once TTSHORTCODE_DIR . '/widgets/widget-tt_woo_products.php';
        require_once TTSHORTCODE_DIR . '/widgets/widget-tt_productlist.php';
        require_once TTSHORTCODE_DIR . '/widgets/widget-product-sort-by.php';
        require_once TTSHORTCODE_DIR . '/widgets/widget-filter-price-list.php';
    }
    /**
     * 360 product view for this theme.
     */
    require_once TTSHORTCODE_DIR . '/product-360-view.php';


/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
function ttshortcode_load_textdomain() {
    load_plugin_textdomain('ttshortcode', false, dirname(plugin_basename(__FILE__)) . '/languages');
}

add_shortcode('map', 'mgms_map');

function mgms_map($args) {
    $args = shortcode_atts(array(
        'address' => 'india',
        'type' => 'ROADMAP',
        'map_icon' => '',
        'width' => '500px',
        'zoom' => '8',
        'height' => '300px'
            ), $args, 'map');

    $output = '';
    $id = substr(sha1("Google Map" . time()), rand(2, 10), rand(5, 8));

		$output = '<div class="map_canvas" style="height:' . $args["height"] . '; width:' . $args["width"] . '; margin-bottom: 1.6842em" id="map-' . $id . '"></div>';
		if(!empty(of_get_option('google_map_api_key'))){
			$output .= "<script type='text/javascript'>\n";
			$output .= "\t  function DisplayMapAddress(address) {\n";
			$output .= "\t var geocoder = new google.maps.Geocfoder();\n";
			$output .= "\t geocoder.geocode({address: address}, function (results, status) {\n";
			$output .= "\t if (status == google.maps.GeocoderStatus.OK) { \n";
			$output .= "\t var location = results[0].geometry.location; \n";
			$output .= "\t  var options = { \n";
			$output .= "\t zoom: " . $args['zoom'] . ", \n";
			$output .= "\t center: location, \n";
			$output .= "\t streetViewControl: true, \n";
			$output .= "\t mapTypeId: google.maps.MapTypeId." . $args['type'] . ", \n";
			$output .= "\t scrollwheel: false, \n";
			$output .= "\t draggable: true, \n";
			$output .= "\t panControl: true, \n";
			$output .= "\t zoomControl: true, \n";
			$output .= "\t zoomControlOptions: { \n";
			$output .= "\t style: google.maps.ZoomControlStyle.SMALL \n";
			$output .= "\t } }; \n";
			$output .= "\t var mymap = new google.maps.Map(document.getElementById('map-" . $id . "'), options); \n";
			$output .= "\t var marker = new google.maps.Marker({ \n";
			$output .= "\t map: mymap, \n";
			$output .= "\t flat: true, \n";
			$output .= "\t icon: '" . $args['map_icon'] . "', \n";
			$output .= "\t position: results[0].geometry.location }); \n";
			$output .= "\t var infowindow = new google.maps.InfoWindow({ \n";
			$output .= "\t content: 'india' }); \n";
			$output .= "\t google.maps.event.addListener(marker, 'click', function () { \n";
			$output .= "\t infowindow.open(mymap, marker); }); \n";
			$output .= "\t } }); \n";
			$output .= "\t } \n";
			$output .= "\t DisplayMapAddress('" . $args['address'] . "'); \n";
			$output .= "</script>\n\n";
		}
    return $output;
}

/* * *************** Services *************** */

function services_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
                "color" => '#cccccc',
                "icon_background_color" => '',
                "icon" => 'fa-arrows-alt',
                "title" => '',
                "link_text" => '',
                "link_url" => '',
                "style" => '1'
                    ), $atts));

    $style_css = 'color:' . $color . ';';
    if (!empty($icon_background_color)):
        $style_css .= 'background-color: ' . $icon_background_color . ';';
        $icon_class = '';
    else:
        $icon_class = ' no-background';
    endif;

    $output = '';
    $output .= '<div class="service style-' . $style . '">';
    $output .= '<div class="service-content style-' . $style . '">';

    if ($style == '1' || $style == '2'):
        if (!empty($icon))
            $output .= '<div class="icon"><i class="service-icon fa ' . $icon . $icon_class . '" style="' . $style_css . '"></i></div>';
        $output .= '<div class="service-content">';
        if (!empty($title))
            $output .= '<div class="title service-text">' . esc_html($title) . '</div>';
    endif;

    if ($style == '3'):
        $output .= '<div class="service-top">';
        if (!empty($icon))
            $output .= '<div class="icon"><i class="service-icon fa ' . $icon . $icon_class . '" style="' . $style_css . '"></i></div>';
        if (!empty($title))
            $output .= '<div class="title service-text">' . esc_html($title) . '</div>';
        $output .= '</div>';
        $output .= '<div class="service-content">';
    endif;

    if ($style == '4'):
        if (!empty($title))
            $output .= '<div class="title service-text">' . esc_html($title) . '</div>';
        if (!empty($icon))
            $output .= '<div class="icon"><i class="service-icon fa ' . $icon . $icon_class . '" style="color:' . $color . ';background-color: ' . $icon_background_color . ';"></i></div>';
        $output .= '<div class="service-content">';
    endif;

    if ($style == '5'):
        if (!empty($icon))
            $output .= '<div class="icon"><i class="service-icon fa ' . $icon . $icon_class . '" style="' . $style_css . '"></i></div>';
        $output .= '<div class="service-content">';
        if (!empty($title))
            $output .= '<div class="title service-text"><span class="text-first">' . esc_html($title) . '</span><span class="text-second">' . esc_html($title) . '</span></div>';
    endif;

    $output .= '<div class="description other-font">' . do_shortcode($content) . '</div>';

    if (!empty($link_text)):
        if (!empty($link_url)):
            $output .= '<div class="service-read-more other-font"><a href="' . esc_url($link_url) . '" class="other-read-more">' . esc_html($link_text) . '<i class="fa fa-arrow-right"></i></a></div>';
        else:
            $output .= '<div class="service-read-more other-font">' . esc_html($link_text) . '></div>';
        endif;
    endif;

    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode("tt_service", "services_shortcode");

/* * ***************************Counter**************** */

function shortcode_counter($atts, $content = null) {
    extract(shortcode_atts(array(
                'id' => '',
                'start' => 0,
                'icon' => '',
                'icon_color' => '#000',
                'image' => '',
                'type' => '',
                'color' => '#000',
                'end' => '154',
                'decimal' => '0',
                'duration' => '20',
                'title_color' => '#000',
                'title' => '',
                'separator' => ','
                    ), $atts));
    $output = '';
    $output .="<div class='counter " . $type . "'>";
    $output .="<div class='counter_wrap'>";
    if ($icon) {
        $output .="<div class='counter_icon icon_wrap'><i class='fa " . $icon . "' style='color:" . $icon_color . "'></i></div>";
    } elseif ($image) {
        $output .="<div class='counter_image icon_wrap'>";
        $output .= '<img src="' . $image . '" alt="' . tt_get_attachment_data($image, 'alt') . '" width="' . tt_get_attachment_data($image, 'width') . '" height="' . tt_get_attachment_data($image, 'height') . '"/></div>';
    }

    $output .="<div class='counter_desc'>";
    $output .="<div class='counter_number'>";
    $output .="<h1 class='count' id='" . $id . "' style='color:" . $color . "'>0</h1></div>";
    $output .="<div class='counter_title' style='color:" . $title_color . "'>" . $title . "</div>";
    $output .="</div></div></div>";

    $output .= "<script type='text/javascript'>\n";
    $output .= "\t var options = {\n";
    $output .= "\t useEasing : true,\n";
    $output .= "\t useGrouping : true,\n";
    $output .= "\t separator : ',', \n";
    $output .= "\t decimal : '.', \n";
    $output .= "\t }\n";
    $output .= "\t  jQuery.noConflict(); jQuery(document).ready(function() { \n";
    $output .= "\t var demo = new CountUp(" . $id . ", " . $start . ", " . $end . ", " . $decimal . ", " . $duration . ", options); \n";
    $output .="\t demo.start(); \n";
    $output .="\t }); \n";
    $output .= "</script>\n\n";

    return $output;
}

add_shortcode('tt_counter', 'shortcode_counter');

/* * *************** Code *************** */

function shortcode_code($atts, $content = null) {

    echo $atts;
    echo $content;

    extract(shortcode_atts(array(
                'style' => '1'
                    ), $atts));

    $output = '';
    $output .= '<div class="code">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    return $output;
}

add_shortcode('tt_code', 'shortcode_code');
/* shortcode for messagebox */

function message_box_func($args, $content = "") {
    $args = shortcode_atts(array(
        'type' => 'success'
            ), $args);
    //ob_start();
    $output = '';
    if ($args['type'] == 'success') {
        $output .= '<div class="alert alert-success alert-dismissible">';
        $output .= '<a class="close" data-dismiss="alert" aria-label="Close">x</a>';
        $output .= $content;
        $output .= '</div>';
    } elseif ($args['type'] == 'danger') {
        $output .= '<div class="alert alert-danger alert-dismissible">';
        $output .= '<a class="close" data-dismiss="alert" aria-label="Close">x</a>';
        $output .= $content;
        $output .= '</div>';
    } elseif ($args['type'] == 'warning') {
        $output .= '<div class="alert alert-warning alert-dismissible">';
        $output .= '<a class="close" data-dismiss="alert" aria-label="Close">x</a>';
        $output .= $content;
        $output .= '</div>';
    } elseif ($args['type'] == 'info') {
        $output .= '<div class="alert alert-info alert-dismissible">';
        $output .= '<a class="close" data-dismiss="alert" aria-label="Close">x</a>';
        $output .= $content;
        $output .= '</div>';
    }
    return $output;
}

add_shortcode('message_box', 'message_box_func');

/* * *************** Progress Bar  *************** */

function shortcode_progressbar_container($atts, $content = null, $code) {
    extract(shortcode_atts(array(
                'style' => '1',
                    ), $atts));
    $output = '';
    $output .= '<div class="progressbar-container">';
    $output .= '<div class="progressbar-content ' . $style . '">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('progressbar', 'shortcode_progressbar_container');

function shortcode_progressbar($atts, $content = null) {
    extract(shortcode_atts(array(
                'value' => '90',
                'color' => '#1f2022 ',
                'background_color' => '#87CFC5',
                'show_percentage' => 'yes',
                'style' => '1'
                    ), $atts));
    $output = '';
    $output .= '<div class="template_trip_progresbar style-' . $style . '">';

    if ($style == 4):
        $output .= '<small class="progress_detail">';
        $output .= do_shortcode($content);
        if ($show_percentage == 'yes') {
            $output .= '<span class="template_trip_progress_label">' . $value . '%</span>';
        }
        $output .= '</small>';
        $output .= '<div class="active_progresbar" style="color:' . $color . '" data-value="' . $value . '" data-percentage-value="' . $value . '">';
    else:
        $output .= '<div class="active_progresbar" style="color:' . $color . '" data-value="' . $value . '" data-percentage-value="' . $value . '">';
        $output .= '<small class="progress_detail" style="color:' . $color . '">';
        $output .= do_shortcode($content);
        if ($show_percentage == 'yes') {
            $output .= '<span class="template_trip_progress_label">' . $value . '%</span>';
        }
        $output .= '</small>';
    endif;


    $output .= '<span class="value animated" data-animated="fadeInLeft" style="width:' . $value . '%; background-color:' . $background_color . ';"></span>';
    $output .= '</div></div>';

    return $output;
}

add_shortcode('tt_progressbar', 'shortcode_progressbar');
/* * *************** PIE Chart *************** */

function shortcode_piechart($atts, $content = null) {
    extract(shortcode_atts(array(
                'percentage' => 20,
                'background_color' => '#87CFC5',
                'title' => '',
                'style' => '1',
                    ), $atts));

    $output = '';
    $randomdValue = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz123456789"), 0, 2);
    $output = '';

    $output .='<div class="template_trip_piechart column4">';
    $output .='<div class="chart_top">';
    $output .='<span class="chart_' . $randomdValue . ' tmchat_wrapper animated" data-percent="' . $percentage . '">';
    if ($style == 1) {
        $output .= '<span class="percent" style="color:' . $background_color . ';"></span>';
        $output .= '</span>';
    }
    $output .='</div>';
    $output .='<div class="chart_bottom">';
    if (!empty($title))
        $output .='<h2 class="chart_title">' . $title . '</h2>';
    $output .='<div class="chart_desc">' . do_shortcode($content) . '</div>';
    $output .='</div>';
    $output .='</div>';

    $output .= "<script type='text/javascript'>\n";
    $output .= "\t jQuery(function() {\n";
    $output .= "\t jQuery('.chart_" . $randomdValue . "').waypoint(function() {\n";
    $output .= "\t jQuery(this).easyPieChart({\n";
    $output .= "\t easing:'easeOutBounce',\n";
    $output .= "\t animate: {duration: 2000, enabled: true},\n";
    $output .= "\t barColor: '" . $background_color . "',\n";
    $output .= "\t trackColor: '#EAEAEB',\n";
    $output .= "\t scaleColor: '',\n";
    $output .= "\t lineWidth: 8,\n";
    $output .= "\t size: 130,\n";
    $output .= "\t onStep: function(from, to, percent) { {\n";
    $output .= "\t\t jQuery(this.el).find('.percent').text(Math.round(percent));\n";
    $output .= "\t } \n";
    $output .= "\t } }); \n";
    $output .= "\t }, {
			  triggerOnce: true,
			  offset: 'bottom-in-view'
			});\n";
    $output .= "\t}); \n";
    $output .= "</script>\n\n";

    return $output;
}

add_shortcode('tt_piechart', 'shortcode_piechart');
/* * *************** Blockquote  *************** */

function shortcode_quote($atts, $content = null) {
    extract(shortcode_atts(array(
                'style' => '1',
                'author' => '',
                'link' => ''
                    ), $atts));

    $output = '';
    $output .= '<div class="blockquote-container">';
    $output .= '<div class="blockquote-inner style-' . $style . '">';
    if ($style == '3' || $style == '4')
        $output .= '<blockquote class="blockquote"><i class="fa fa-quote-left"></i>' . do_shortcode($content) . '<i class="fa fa-quote-right"></i>';
    else
        $output .= '<blockquote class="blockquote">' . do_shortcode($content);
    if ($author != "") {
        $output .='<p class="author"><cite><a href="' . esc_url($link) . '" target="_blanck"><i class="fa fa-user"></i> ' . esc_html($author) . '</a></cite></p>';
    }
    $output .= '</blockquote></div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('tt_blockquote', 'shortcode_quote');
/* * *************** Horizontal Tab *************** */
$maintab_div = '';

function tabs_group($atts, $content = null) {
    global $maintab_div;
    extract(shortcode_atts(array(
                'tab_type' => 'horizontal',
                'style' => '1'
                    ), $atts));

    switch ($tab_type) {
        case 'vertical' :
            $element_class = 'vertical_tab';
            break;
        default :
            $element_class = 'horizontal_tab';
            break;
            break;
    }


    $maintab_div = '';
    $output = '<div id="' . $element_class . '" class="' . $element_class . ' style' . $style . '"><div id="tab" class="tab"><ul class="tabs">';
    $output.= do_shortcode($content) . '</ul>';
    $output.= '<div class="tab_groupcontent">' . $maintab_div . '</div></div></div>';
    return $output;
}

add_shortcode('tt_tabs', 'tabs_group');

function tab($atts, $content = null) {
    global $maintab_div;

    static $oddeven_class = 0;
    $oddeven_class++;
    $newclass = '';
    $output = '';
    if ($oddeven_class % 2 == 0) {
        $newclass .= "even";
    } else {
        $newclass .= "odd";
    }

    extract(shortcode_atts(array(
                'title' => '',
                    ), $atts));
    $dummy_title = __('Tab', 'ttshortcode');

    if ($title != NULL) {
        $output .= '<li class="' . $newclass . '"><a href="#">' . $title . '<span class="leftarrow"></span></a></li>';
    } else {
        $output .= '<li class="' . $newclass . '"><a href="#">' . $dummy_title . '<span class="leftarrow"></span></a></li>';
    }
    $maintab_div.= '<div class="tabs_tab">' . $content . '</div>';
    return $output;
}

add_shortcode('tt_tab', 'tab');
/* * *************** Pricing Table *************** */

function shortcode_pricingtable($atts, $content = null) {
    extract(shortcode_atts(array(
                "style" => '1',
                "image" => '',
                "heading" => '',
                "button_text" => '',
                "button_link" => '#',
                "currency" => '$',
                "price" => '',
                "subtitle" => '',
                "price_per" => '',
                "selected" => 'no',
                    ), $atts));

    if ($selected == 'yes') {
        $selected = 'selected';
    }
    $output = '';
    $output .='<div class="pricing_wrapper">';
    $output .='<div class="pricing_wrapper_inner style-' . $style . ' ' . $selected . '"><div class="pricing_inner">';

    if ($style == '1') {
        if ($heading != '' && $price_per != '' && $price != '') {
            if ($image) {
                $output .= '<div class="image">';
                $output .= '<img src="' . esc_url($image) . '" alt="' . tt_get_attachment_data($image, 'alt') . '" width="' . tt_get_attachment_data($image, 'width') . '" height="' . tt_get_attachment_data($image, 'height') . '"/>';
                $output .= '</div>';
            }
            $output .='<div class="pricing_heading">' . $heading . '</div>';
            $output .='<div class="pricing_top"><div class="pricing_top_inner">';
            $output .= '<sup class="currency">' . $currency . '</sup>';
            $output .= '<span class="pricing_price">' . $price . '</span>';
            $output .= '<sup class="pricing_per"> / ' . $price_per . '</sup></div></div>';
        } else {
            $output .='<div class="nopricing_heading"></div>';
            $output .='<div class="nopricing_top"><div class="pricing_per"></div><div class="pricing_price"></div></div>';
        }
    } elseif ($style == '2') {
        if ($heading != '' && $price_per != '' && $price != '') {
            $output .='<div class="pricing_heading">' . $heading . '</div>';
            $output .='<div class="pricing_top"><div class="pricing_top_inner">';
            $output .= '<sup class="currency">' . $currency . '</sup>';
            $output .='<span class="pricing_price">' . $price . '</span>';
            $output .='<sup class="pricing_per"> / ' . $price_per . '</sup></div></div>';
        } else {
            $output .='<div class="nopricing_top"><div class="nopricing_heading"></div>';
            $output .='<div class="pricing_per"></div><div class="pricing_price"></div></div>';
        }
    }
    if ($subtitle)
        $output .= '<p class="subtitle"><big>' . $subtitle . '</big></p>';
    $output .='<div class="pricing_bottom">';
    $output .='<ul>';
    $output .= do_shortcode($content);
    $output .='</ul>';
    $output .='<div class="pricing_button">';
    if ($button_text != '') {
        $output .='<a href="' . esc_url($button_link) . '" target="_blank" class="button" id="pricing-btn">' . esc_html($button_text) . '</a>';
    }
    $output .='</div></div>';
    $output .='</div></div></div>';
    return $output;
}

add_shortcode("tt_pricingtable", "shortcode_pricingtable");

function shortcode_pricingtable_row($atts, $content = null) {
    extract(shortcode_atts(array(
                "symbol" => '',
                    ), $atts));
    $output = '';
    if (!empty($symbol))
        $output .= '<li><i class="fa ' . $symbol . '"></i> ' . $content . '</li>';
    else
        $output .= '<li>' . $content . '</li>';
    return $output;
}

add_shortcode('price_row', 'shortcode_pricingtable_row');

/* ============ accordions style shortcode =========== */

function accordions_func($args, $content = "") {
    $args = shortcode_atts(array(
        'style' => '1'
            ), $args);
    if ($args['style'] == '1') {
        $class = 'style1';
    } elseif ($args['style'] == '2') {
        $class = 'style2';
    } elseif ($args['style'] == '3') {
        $class = 'style3';
    } elseif ($args['style'] == '4') {
        $class = 'style4';
    }
    $output = '';
    $output .= '<div class="accordians_wrap ' . $class . '">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    return $output;
}

add_shortcode('accordions', 'accordions_func');

function accordion_func($args, $content = "") {
    $args = shortcode_atts(array(
        'title' => ''
            ), $args);
    $output = '';
    $output .= '<div class="accordion-single">';
    $output .= '<div class="accordion_heading accoodionclose">';
    $output .= '<i class="fa"></i>';
    $output .= '<span>' . $args["title"] . '</span>';
    $output .= '</div>';
    $output .= '<div class="accordion-answer"  style="display: none;">';
    $output .= '<p>' . $content . '</p>';
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('accordion', 'accordion_func');

function toggles_func($args, $content = "") {
    $args = shortcode_atts(array(
        'style' => '1'
            ), $args);
    $output = '';
    if ($args['style'] == '1') {
        $class = 'style1';
    } elseif ($args['style'] == '2') {
        $class = 'style2';
    } elseif ($args['style'] == '3') {
        $class = 'style3';
    } elseif ($args['style'] == '4') {
        $class = 'style4';
    }
    $output .= '<div class="toggles_wrap ' . $class . '">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    return $output;
}

add_shortcode('toggles', 'toggles_func');

/* ============ Toggle style shortcode =========== */

function toggle_func($args, $content = "") {
    $args = shortcode_atts(array(
        'title' => ''
            ), $args);
    $output = '';
    $output .= '<div class="toggle-single">';
    $output .= '<div class="toggle_heading toggleclose">';
    $output .= '<i class="fa"></i>';
    $output .= '<span>' . $args['title'] . '</span>';
    $output .= '</div>';
    $output .= '<div class="toggle-answer"  style="display: none;">';
    $output .= '<p>' . $content . '</p>';
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('toggle', 'toggle_func');


/* ============ list style shortcode =========== */

function tt_list_shortcode($atts, $content = null) {

    return '<ul class="tt_list">' . do_shortcode($content) . '</ul>';
}

add_shortcode('tt_list', 'tt_list_shortcode');

function list_item_func($args, $content = "") {
    $args = shortcode_atts(array(
        'list_icon' => 'fa-square'
            ), $args);
    $output = '';
    $output .= '<li>';
    $output .= '<i class="fa ' . $args['list_icon'] . '"></i>';
    $output .= $content;
    $output .= '</li>';
    return $output;
}

add_shortcode('list_item', 'list_item_func');

/* ============ divider shortcode =========== */

function divider_shortcode($args, $content = "") {
    $args = shortcode_atts(array(
        'type' => 'solid',
        'space' => '10'
            ), $args);
    $output = '';
    $output .= '<div class="divider_content">';
    $output .= '<div class="divider_content_inner">';
    $output .= '<p>' . $content . '</p>';
    $output .= '<div class="' . $args['type'] . '" style="height:' . $args['space'] . 'px"></div>';
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('tt_divider', 'divider_shortcode');
/* * *************** Addess *************** */

function shortcode_address($atts, $content = null) {
    extract(shortcode_atts(array(
                'title' => '',
                'description' => '',
                'address_label' => 'Address:',
                'phone_label' => 'Phone numbers:',
                'phone' => '',
                'fax_label' => 'Fax numbers:',
                'fax' => '123456789',
                'email_label' => 'Email:',
                'email' => '',
				'other' => '',
                'email_link' => '',
                    ), $atts));
    $output = '';
    $output .= '<div class="address-container right-to-left">';
    if (!empty($title))
        $output .= '<h1 class="small-title"><span>' . esc_html($title) . '</span></h1>';
    if (!empty($description))
        $output .= '<div class="address-description description">' . esc_html($description) . '</div>';


    $output .= '<div class="address-text first"><div class="icon"><i class="fa fa-map-marker"></i></div> <div class="content"><div class="address-label">' . $address_label . '</div>' . do_shortcode($content) . '</div> </div>';

    if (!empty($phone)):
        $output .= '<div class="address-text second"><div class="icon"><i class="fa fa-phone"></i></div> <div class="content"><div class="address-label">' . $phone_label . '</div>' . $phone . '</div> </div>';
    endif;

    if (!empty($fax)):
        $output .= '<div class="address-text second"><div class="icon"><i class="fa fa-fax"></i></div> <div class="content"><div class="address-label">' . $fax_label . '</div>' . $fax . '</div> </div>';
    endif;

    if (!empty($email)):
        if (!empty($email_link)):
            $output .= '<div class="address-text third"><div class="icon"><i class="fa fa-envelope "></i></div> <div class="content"><div class="address-label">' . $email_label . '</div><a href="' . $email_link . '">' . $email . '</a><p>' . $other . '</p></div></div>';
        else:
            $output .= '<div class="address-text><div class="icon"><i class="fa fa-envelope "></i></div>  <div class="content"><div class="address-label">' . $email_label . '</div>' . $email . '></div></div>';
        endif;
    endif;
    $output .= '</div>';
    return $output;
}

add_shortcode('tt_address', 'shortcode_address');

/* ============ Container =========== */

function shortcode_container($atts, $content = null) {
    extract(shortcode_atts(array(
                'background_color' => '',
                'background_image' => '',
                'background_repeat' => '',
                'background_attachment' => '',
                'background_position' => '',
                'background_size' => '',
                'padding' => '0',
                'margin' => '0',
                'align' => '',
                'color' => '',
                'border_color' => '',
                'classname' => '',
                    ), $atts));
    $variables = '';
    $datasource = '';
    if (!empty($background_color))
        $variables .= 'background-color: ' . $background_color . ';';
    $variables .= 'padding:' . $padding . ';';
    $variables .= 'margin:' . $margin . ';';
    if (!empty($color))
        $variables .= 'color:' . $color . ';';
    $variables .= 'overflow: hidden;';

    if (!empty($background_image)):
        $variables .= 'background-image: url(' . $background_image . ');';
        if (!empty($background_repeat)) :
            $variables .= 'background-repeat:' . $background_repeat . ';';
        endif;
        if (!empty($background_size)) :
            $variables .= 'background-size:' . $background_size . ';';
        endif;
        if (!empty($background_attachment)) :
            $variables .= 'background-attachment:' . $background_attachment . ';';
        endif;
        if (!empty($background_position)) :
            $variables .= 'background-position:' . $background_position . ';';
        endif;
    endif;

    $output = '';
    $output .= '<div class="main-container ' . $align . ' ' . $classname . '" style="' . $variables . ';">';
    $output .= '<div class="inner-container">';
    $output .= do_shortcode($content);
    $output .= '</div></div>';
    return $output;
}

add_shortcode('container', 'shortcode_container');

/* ============ One half =========== */

function shortcode_one($atts, $content = null) {
    extract(shortcode_atts(array(
                'content_width' => '100%',
                'margin' => '0',
                'padding' => '0',
                'align' => 'left',
                'classname' => '',
                'background_color' => '',
                'background_image' => '',
                'background_repeat' => 'no-repeat',
                'background_attachment' => '',
                'background_size' => ''
                    ), $atts));

    $variables = '';
    if (!empty($background_color))
        $variables .= 'background-color: #' . $background_color . ';';
    if (!empty($color))
        $variables .= 'color:#' . $color . ';';
    if (!empty($background_image)):
        $variables .= 'background-image: url(' . $background_image . ');';
        $variables .= 'background-repeat:' . $background_repeat . ';';
        $variables .= 'background-size:' . $background_size . ';';
        $variables .= 'background-attachment:' . $background_attachment . ';';
    endif;
    $output = '';
    $output .= '<div class="one ' . $classname . '" style="' . $variables . '">';
    $output .= '<div class="one_inner content_inner ' . $align . '" style="margin:' . $margin . ';width:' . $content_width . ';padding:' . $padding . '">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('one', 'shortcode_one');

/* ============ One half =========== */

function shortcode_one_half($atts, $content = null) {
    extract(shortcode_atts(array(
                'content_width' => '100%',
                'margin' => '0',
                'padding' => '0',
                'align' => 'left',
                'classname' => '',
                'background_color' => '',
                'background_image' => '',
                'background_repeat' => 'no-repeat',
                'background_attachment' => '',
                'background_size' => ''
                    ), $atts));

    $variables = '';
    if (!empty($background_color))
        $variables .= 'background-color: #' . $background_color . ';';
    if (!empty($color))
        $variables .= 'color:#' . $color . ';';
    if (!empty($background_image)):
        $variables .= 'background-image: url(' . esc_url($background_image) . ');';
        $variables .= 'background-repeat:' . $background_repeat . ';';
        $variables .= 'background-size:' . $background_size . ';';
        $variables .= 'background-attachment:' . $background_attachment . ';';
    endif;
    $output = '';
    $output .= '<div class="one_half ' . $classname . '" style="' . $variables . '">';
    $output .= '<div class="one_half_inner content_inner ' . $align . '" style="margin:' . $margin . ';width:' . $content_width . ';padding:' . $padding . '">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('one_half', 'shortcode_one_half');
/* ============ Inner One half =========== */

function shortcode_inner_one_half($atts, $content = null) {
    extract(shortcode_atts(array(
                'classname' => '',
                'padding' => '0',
                'content_width' => '100%',
                'margin' => '0',
                'align' => 'left'
                    ), $atts));

    $output = '';
    $output .= '<div class="one_half ' . $classname . '">';
    $output .= '<div class="one_half_inner content_inner ' . $align . '" style="margin:' . $margin . ';padding:' . $padding . ';width:' . $content_width . ';">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('inner_one_half', 'shortcode_inner_one_half');
/* ============ One third =========== */

function shortcode_one_third($atts, $content = null) {
    extract(shortcode_atts(array(
                'classname' => '',
                'content_width' => '100%',
                'margin' => '0',
                'padding' => '0',
                'align' => ''
                    ), $atts));

    $output = '';
    $output .= '<div class="one_third ' . $classname . '">';
    $output .= '<div class="one_third_inner content_inner ' . $align . '" style="margin:' . $margin . ';padding:' . $padding . ';width:' . $content_width . ';">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('one_third', 'shortcode_one_third');
/* ============ One fourth =========== */

function shortcode_one_fourth($atts, $content = null) {
    extract(shortcode_atts(array(
                'classname' => '',
                'padding' => '0',
                'content_width' => '100%',
                'margin' => '0',
                'align' => 'left'
                    ), $atts));

    $output = '';
    $output .= '<div class="one_fourth">';
    $output .= '<div class="one_fourth_inner content_inner ' . $align . '" style="margin:' . $margin . ';padding:' . $padding . ';width:' . $content_width . ';">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('one_fourth', 'shortcode_one_fourth');
/* ============ One Fifth =========== */

function shortcode_one_fifth($atts, $content = null) {
    extract(shortcode_atts(array(
                'content_width' => '100%',
                'classname' => '',
                'padding' => '0',
                'margin' => '0',
                'align' => 'left'
                    ), $atts));

    $output = '';
    $output .= '<div class="one_fifth">';
    $output .= '<div class="one_fifth_inner content_inner ' . $align . '" style="margin:' . $margin . ';padding:' . $padding . ';width:' . $content_width . ';">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('one_fifth', 'shortcode_one_fifth');
/* ============ One sixth =========== */

function shortcode_one_sixth($atts, $content = null) {
    extract(shortcode_atts(array(
                'content_width' => '100%',
                'margin' => '0',
				'padding' => '0',
                'align' => 'left'
                    ), $atts));

    $output = '';
    $output .= '<div class="one_sixth">';
    $output .= '<div class="one_sixth_inner content_inner ' . $align . '" style="margin:' . $margin . ';padding:' . $padding . ';width:' . $content_width . ';">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('one_sixth', 'shortcode_one_sixth');
/* ============ Two third =========== */

function shortcode_two_third($atts, $content = null) {
    extract(shortcode_atts(array(
                'content_width' => '100%',
                'classname' => '',
                'padding' => '0',
                'margin' => '0',
                'align' => 'left',
                'classname' => ''
                    ), $atts));

    $output = '';
    $output .= '<div class="two_third ' . $classname . '">';
    $output .= '<div class="two_third_inner content_inner ' . $align . '" style="margin:' . $margin . ';padding:' . $padding . ';width:' . $content_width . ';">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('two_third', 'shortcode_two_third');

/* ============ Two Fourth =========== */

function shortcode_two_fourth($atts, $content = null) {
    extract(shortcode_atts(array(
                'content_width' => '100%',
                'margin' => '0',
                'classname' => '',
                'padding' => '0',
                'align' => 'left'
                    ), $atts));

    $output = '';
    $output .= '<div class="two_fourth ' . $classname . '">';
    $output .= '<div class="two_fourth_inner content_inner ' . $align . '" style="margin:' . $margin . ';padding:' . $padding . ';width:' . $content_width . ';">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('two_fourth', 'shortcode_three_fourth');
/* ============ Three Fourth =========== */

function shortcode_three_fourth($atts, $content = null) {
    extract(shortcode_atts(array(
                'content_width' => '100%',
                'margin' => '0',
                'classname' => '',
                'padding' => '0',
                'align' => 'left'
                    ), $atts));

    $output = '';
    $output .= '<div class="three_fourth ' . $classname . '">';
    $output .= '<div class="three_fourth_inner content_inner ' . $align . '" style="margin:' . $margin . ';padding:' . $padding . ';width:' . $content_width . ';">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('three_fourth', 'shortcode_three_fourth');

/* ============ Two Fifth =========== */

function shortcode_two_fifth($atts, $content = null) {
    extract(shortcode_atts(array(
                'content_width' => '100%',
                'classname' => '',
                'padding' => '0',
                'margin' => '0',
                'align' => 'left'
                    ), $atts));

    $output = '';
    $output .= '<div class="two_fifth ' . $classname . '">';
    $output .= '<div class="two_fifth_inner content_inner ' . $align . '" style="margin:' . $margin . ';padding:' . $padding . ';width:' . $content_width . ';">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('two_fifth', 'shortcode_two_fifth');
/* ============ Three Fifth =========== */

function shortcode_three_fifth($atts, $content = null) {
    extract(shortcode_atts(array(
                'content_width' => '100%',
                'margin' => '0',
                'classname' => '',
                'padding' => '0',
                'align' => 'left'
                    ), $atts));

    $output = '';
    $output .= '<div class="three_fifth ' . $classname . '">';
    $output .= '<div class="three_fifth_inner content_inner ' . $align . '" style="margin:' . $margin . ';padding:' . $padding . ';width:' . $content_width . ';">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('three_fifth', 'shortcode_three_fifth');
/* ============ Four Fifth =========== */

function shortcode_four_fifth($atts, $content = null) {
    extract(shortcode_atts(array(
                'content_width' => '100%',
                'margin' => '0',
                'classname' => '',
                'padding' => '0',
                'align' => 'left'
                    ), $atts));

    $output = '';
    $output .= '<div class="four_fifth ' . $classname . '">';
    $output .= '<div class="four_fifth_inner content_inner ' . $align . '" style="margin:' . $margin . ';padding:' . $padding . ';width:' . $content_width . ';">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('four_fifth', 'shortcode_four_fifth');

/* ============ Two Sixth =========== */

function shortcode_two_sixth($atts, $content = null) {
    extract(shortcode_atts(array(
                'content_width' => '100%',
                'margin' => '0',
                'classname' => '',
                'padding' => '0',
                'align' => 'left'
                    ), $atts));

    $output = '';
    $output .= '<div class="two_sixth ' . $classname . '">';
    $output .= '<div class="two_sixth_inner content_inner ' . $align . '" style="margin:' . $margin . ';padding:' . $padding . ';width:' . $content_width . ';">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('two_sixth', 'shortcode_two_sixth');

/* ============ Three Sixth =========== */

function shortcode_three_sixth($atts, $content = null) {
    extract(shortcode_atts(array(
                'content_width' => '100%',
                'margin' => '0',
                'classname' => '',
                'padding' => '0',
                'align' => 'left'
                    ), $atts));

    $output = '';
    $output .= '<div class="three_sixth ' . $classname . '">';
    $output .= '<div class="three_sixth_inner content_inner ' . $align . '" style="margin:' . $margin . ';padding:' . $padding . ';width:' . $content_width . ';">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('three_sixth', 'shortcode_three_sixth');
/* ============ Four Sixth =========== */

function shortcode_four_sixth($atts, $content = null) {
    extract(shortcode_atts(array(
                'content_width' => '100%',
                'margin' => '0',
                'classname' => '',
                'padding' => '0',
                'align' => 'left'
                    ), $atts));

    $output = '';
    $output .= '<div class="four_sixth ' . $classname . '">';
    $output .= '<div class="four_sixth_inner content_inner ' . $align . '" style="margin:' . $margin . ';padding:' . $padding . ';width:' . $content_width . ';">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('four_sixth', 'shortcode_four_sixth');
/* ============ five Sixth =========== */

function shortcode_five_sixth($atts, $content = null) {
    extract(shortcode_atts(array(
                'content_width' => '100%',
                'margin' => '0',
                'classname' => '',
                'padding' => '0',
                'align' => 'left'
                    ), $atts));

    $output = '';
    $output .= '<div class="five_sixth ' . $classname . '">';
    $output .= '<div class="five_sixth_inner content_inner ' . $align . '" style="margin:' . $margin . ';padding:' . $padding . ';width:' . $content_width . ';">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('five_sixth', 'shortcode_five_sixth');
/* ============ Static Text =========== */

function shortcode_static_text($atts, $content = null) {
    extract(shortcode_atts(array(
                'align' => 'left'
                    ), $atts));

    $output = '';
    $output .= '<div class="static-text-container ' . $align . '">';
    $output .= '<div class="text">' . do_shortcode($content) . '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('text', 'shortcode_static_text');
/* ============ Button shortcode =========== */

function tt_button_shortcode($args, $content = "") {
    $args = shortcode_atts(array(
        'size' => 'small',
        'type' => '',
        'icon' => '',
        'target' => '_blank',
        'link' => '#',
        'icon_align' => ''
            ), $args);
    $class = "";
	$target= "";
    if (!empty($args['target'])) {
        $target .= $args['target'];
    }else{
        $target ="";
    }
    if ($args['size'] == 'small') {
        $class .= "btn-small";
    } elseif ($args['size'] == 'medium') {
        $class .= "";
    } elseif ($args['size'] == 'large') {
        $class .= "btn-large";
    } elseif ($args['size'] == 'mini') {
        $class .= "btn-mini";
    }
    if ($args['type'] == 'basic') {
        $class .= "";
    } elseif ($args['type'] == 'primary') {
        $class .= " btn-primary";
    } elseif ($args['type'] == 'info') {
        $class .= " btn-info";
    } elseif ($args['type'] == 'success') {
        $class .= " btn-success";
    } elseif ($args['type'] == 'warning') {
        $class .= " btn-warning";
    } elseif ($args['type'] == 'danger') {
        $class .= " btn-danger";
    } elseif ($args['type'] == 'inverse') {
        $class .= " btn-inverse";
    }
    $output = '';
    $output .= '<div class="button_content_inner">';
    $output .= '<a class="tt_btn  ' . $class . '" target="'.$target.'"  href="' . esc_url($args['link']) . '" style="">';
    if ($args['icon_align'] == 'left') {
        $output .= '<i class="fa ' . $args['icon'] . '"></i>';
    } $output .= $content;
    if ($args['icon_align'] == 'right') {
        $output .= '<i class="fa ' . $args['icon'] . '"></i>';
    }
    $output .= '</a>';
    $output .= '</div>';
    return $output;
}

add_shortcode('tt_button', 'tt_button_shortcode');
/* ============ Shareicon shortcode =========== */

function tt_shareicon_shortcode($args, $content = "") {
    $args = shortcode_atts(array(
        'size' => 'small',
        'shape' => 'circle'
            ), $args);
    $class = "";
    if ($args['size'] == 'small') {
        $class .= "small";
    } elseif ($args['size'] == 'large') {
        $class .= "large";
    }
    if ($args['shape'] == 'circle') {
        $class .= " circle";
    } elseif ($args['shape'] == 'square') {
        $class .= " square";
    }
    $output = '';
    $output .= '<div class="tt_shareicon_div ' . $class . '">';
    $output .= '<a class="tt_shareicon facebook" href="https://www.facebook.com/sharer/sharer.php?u=' . get_permalink() . '" target="_blank">';
    $output .= '<i class="fa fa-facebook"></i>';
    $output .= '</a>';
    $output .= '<a class="tt_shareicon twitter" href="https://twitter.com/share?url=' . get_permalink() . '" target="_blank">';
    $output .= '<i class="fa fa-twitter"></i>';
    $output .= '</a>';
    $output .= '<a class="tt_shareicon mail" href="mailto:emailid@gmail.com?subject=Checkout this awesome website&body=Hi%20emaild%40gmail.com,%0A%0AI%20found%20this%20interesting%20article%20or%20topics%20and%20thought%20of%20sharing%20it%20with%20you.%20%0A%0ACheck%20it%20out%3A%20' . get_permalink() . '%0A%0AThanks,%0AFrom%20Email%20Address%20Name">';
    $output .= '<i class="fa fa-envelope-o"></i>';
    $output .= '</a>';
    $output .= '<a class="tt_shareicon pinterest" href="https://pinterest.com/pin/create/button/?url=' . get_permalink() . '" target="_blank">';
    $output .= '<i class="fa fa-pinterest"></i>';
    $output .= '</a>';
    $output .= '<a class="tt_shareicon google-plus" href="https://plus.google.com/share?url=' . get_permalink() . '" target="_blank">';
    $output .= '<i class="fa fa-google-plus"></i>';
    $output .= '</a>';
    $output .= '</div>';
    return $output;
}

add_shortcode('tt_shareicon', 'tt_shareicon_shortcode');
/* ============ Followicon shortcode =========== */

function tt_followicon_shortcode($args, $content = "") {
    $args = shortcode_atts(array(
        'size' => 'small',
        'shape' => 'circle',
        'facebook' => '',
        'twitter' => '',
        'pinterest' => '',
        'google-plus' => '',
        'rss' => '',
        'instagram' => '',
        'linkedin' => '',
        'youtube' => '',
        'flickr' => ''
            ), $args);
    $output = '';
    $class = "";
    if ($args['size'] == 'small') {
        $class .= "small";
    } elseif ($args['size'] == 'large') {
        $class .= "large";
    }
    if ($args['shape'] == 'circle') {
        $class .= " circle";
    } elseif ($args['shape'] == 'square') {
        $class .= " square";
    }
    $output .= '<div class="tt_followicon_div ' . $class . '">';
    if ($args['facebook'] != '') {
        $output .= '<a class="tt_followicon facebook" href="' . esc_url($args['facebook']) . '" target="_blank">';
        $output .= '<i class="fa fa-facebook"></i>';
        $output .= '</a>';
    }
    if ($args['twitter'] != '') {
        $output .= '<a class="tt_followicon twitter" href="' . esc_url($args['twitter']) . '" target="_blank">';
        $output .= '<i class="fa fa-twitter"></i>';
        $output .= '</a>';
    }
    if ($args['pinterest'] != '') {
        $output .= '<a class="tt_followicon pinterest" href="' . esc_url($args['pinterest']) . '" target="_blank">';
        $output .= '<i class="fa fa-pinterest"></i>';
        $output .= '</a>';
    }
    if ($args['google-plus'] != '') {
        $output .= '<a class="tt_followicon google-plus" href="' . esc_url($args['google-plus']) . '" target="_blank">';
        $output .= '<i class="fa fa-google-plus"></i>';
        $output .= '</a>';
    }
    if ($args['rss'] != '') {
        $output .= '<a class="tt_followicon rss" href="' . esc_url($args['rss']) . '" target="_blank">';
        $output .= '<i class="fa fa-rss"></i>';
        $output .= '</a>';
    }
    if ($args['instagram'] != '') {
        $output .= '<a class="tt_followicon instagram" href="' . esc_url($args['instagram']) . '" target="_blank">';
        $output .= '<i class="fa fa-instagram"></i>';
        $output .= '</a>';
    }
    if ($args['linkedin'] != '') {
        $output .= '<a class="tt_followicon linkedin" href="' . esc_url($args['linkedin']) . '" target="_blank">';
        $output .= '<i class="fa fa-linkedin"></i>';
        $output .= '</a>';
    }
    if ($args['youtube'] != '') {
        $output .= '<a class="tt_followicon youtube" href="' . esc_url($args['youtube']) . '" target="_blank">';
        $output .= '<i class="fa fa-youtube"></i>';
        $output .= '</a>';
    }
    if ($args['flickr'] != '') {
        $output .= '<a class="tt_followicon flickr" href="' . esc_url($args['flickr']) . '" target="_blank">';
        $output .= '<i class="fa fa-flickr"></i>';
        $output .= '</a>';
    }
    $output .= '</div>';

    return $output;
}

add_shortcode('tt_followicon', 'tt_followicon_shortcode');

function tt_product_tab_shortcode($args, $content = "") {
    $args = shortcode_atts(array(
        'title' => '',
        'subtitle' => '',
        'no_of_product' => '-1',
        'product_tabs' => '',
        'lazyLoad' => 'true',
        'product_tabs_title' => '',
        'products_columns' => '4',
        'auto_slide' => 'true',
        'slide_speed' => '1000'
            ), $args);
    global $woocommerce;
    $lazyLoad = $args['lazyLoad'];
    $subtitle = $args['subtitle'];
    $product_tabs_title = explode(",", $args['product_tabs_title']);
    $Products_type = explode(",", $args['product_tabs']);
    $Products_columns = $args['products_columns'];
    $title = $args['title'];
    $no_of_product = $args['no_of_product'];
    $auto_slide = $args['auto_slide'];
    $slide_speed = $args['slide_speed'];
    $id = rand();
    $output = '';

    $output .= '<div class="woocommerce padding_0 TTProduct-Tab woo_product">';
    $output .= '<div class="col-xs-12 padding_0">';

    $output .= '<div class="tab-box-heading">';
    if (!empty($title)) {
        $output .= '<div class="box-heading tthometab-title">';
        $output .= '<h3>' . esc_html($title) . '</h3>';
        $output .= '<div class="ttdesc">' . esc_html($subtitle) . '</div>';
        $output .= '</div>';
    }
    $output .= '<ul id="home-page-tabs" class="nav nav-tabs clearfix">';
    for ($i = 0; $i < count($Products_type); $i++) {
        if ($i == 0) {
            $clas = 'active';
        } else {
            $clas = '';
        }
        $output .= '<li class="' . $clas . '">';
         if(!empty($args['product_tabs_title'])){
            $output .= '<a class="tt' . $Products_type[$i] . ' text-capitalize" data-toggle="tab" href="#' . $Products_type[$i] . '">' . $product_tabs_title[$i] . '</a>';
        }else{
            $output .= '<a class="tt' . $Products_type[$i] . ' text-capitalize" data-toggle="tab" href="#' . $Products_type[$i] . '">' . strtr($Products_type[$i], array('_' => ' ', 'products' => '')) . '</a>';
        }
        $output .= '</li>';
    }
    $output .= '</ul>';
    $output .= '</div>';
    $output .= '<div class="tttab-content col-xs-12">';
    $output .= '<div class="tab-content">';
    for ($i = 0; $i < count($Products_type); $i++) {
        $output .= "<script type='text/javascript'>\n";
        $output .= "\t jQuery(document).ready(function () {\n";
        $output .= "\t var ttfeature = jQuery('.tt" . $Products_type[$i] . "_" . $id . "');\n";
        $output .= "\t ttfeature.owlCarousel({\n";
        $output .= "\t items : " . $Products_columns . ",\n";
        $output .= "\t itemsDesktop : [1200,3],\n";
        $output .= "\t itemsDesktopSmall : [1024,3],\n";
        $output .= "\t itemsTablet: [767,2],\n";
        $output .= "\t lazyLoad : " . $lazyLoad . ",\n";
        $output .= "\t itemsMobile : [480,1],\n";
        $output .= "\t slideSpeed : " . $slide_speed . ",\n";
        $output .= "\t autoPlay : " . $auto_slide . ",stopOnHover:true\n";
        $output .= "\t });\n";
        $output .= "\t if(jQuery('.tt" . $Products_type[$i] . "_" . $id . " .owl-controls.clickable').css('display') == 'none'){ \n";
        $output .= "\t jQuery('." . $Products_type[$i] . "_" . $id . " .customNavigation').hide();\n";
        $output .= "\t }else{ \n";
        $output .= "\t jQuery('." . $Products_type[$i] . "_" . $id . " .customNavigation').show(); \n";
        $output .= "\t jQuery('.tt" . $Products_type[$i] . '_' . $id . "_next').click(function(){ \n";
        $output .= "\t ttfeature.trigger('owl.next');\n";
        $output .= "\t });\n";
        $output .= "\t jQuery('.tt" . $Products_type[$i] . '_' . $id . "_prev').click(function(){ \n";
        $output .= "\t ttfeature.trigger('owl.prev');\n";
        $output .= "\t }); } });\n";
        $output .= "</script>\n\n";
        if ($i == 0) {
            $act = 'active';
        } else {
            $act = '';
        } $output .= '<div id="' . $Products_type[$i] . '" class="' . $Products_type[$i] . '_' . $id . ' product-carousel tab-pane block products_block clearfix  ' . $act . '">';
        $output .= '<div class="customNavigation">';
        $output .= '<a class="btn prev tt' . $Products_type[$i] . '_' . $id . '_prev">' . __('Prev', 'ttshortcode') . '</a>';
        $output .= '<a class="btn next tt' . $Products_type[$i] . '_' . $id . '_next"> ' . __('Next', 'ttshortcode') . '</a>';
        $output .= '</div>';
        $output .= '<div class="block_content">';
        $output .= '<ul class="tt' . $Products_type[$i] . '_' . $id . '">';
        if ($Products_type[$i] == 'featured_products') {
            $meta_query = WC()->query->get_meta_query();
                    $tax_query[] = array(
                            'taxonomy' => 'product_visibility',
                            'field'    => 'name',
                            'terms'    => 'featured',
                            'operator' => 'IN',
                    );
                    $args = array(
                        'post_type' => 'product',
                        'post_status' => 'publish',
                        'posts_per_page' => $no_of_product,
                        'meta_query'  =>  $meta_query,
                        'tax_query'           => $tax_query,
                    );
        } elseif ($Products_type[$i] == 'best_selling_products') {
            $meta_query = WC()->query->get_meta_query();
            $args = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'posts_per_page' => $no_of_product,
                'meta_key' => 'total_sales',
                'orderby' => 'meta_value_num',
                'meta_query' => $meta_query
            );
        } elseif ($Products_type[$i] == 'top_rated_products') {

            $args = array(
                'posts_per_page' => $no_of_product,
                'post_status' => 'publish',
                'post_type' => 'product',
                'meta_key' => '_wc_average_rating',
                'orderby' => 'meta_value_num',
            );
        } elseif ($Products_type[$i] == 'sale_products') {
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => $no_of_product,
                'post_status' => 'publish',
                'meta_query' => array(
                    'relation' => 'OR',
                    array(// Simple products type
                        'key' => '_sale_price',
                        'value' => 0,
                        'compare' => '>',
                        'type' => 'numeric'
                    ),
                    array(// Variable products type
                        'key' => '_min_variation_sale_price',
                        'value' => 0,
                        'compare' => '>',
                        'type' => 'numeric'
                    )
                )
            );
        } elseif ($Products_type[$i] == 'recent_products' || $Products_type[$i] == 'all') {
            $args = array(
                'post_type' => 'product',
                'orderby' => 'date',
                'post_status' => 'publish',
                'posts_per_page' => $no_of_product
            );
        }
        $cnt = 1;
        $loop1 = new WP_Query($args);
        $found_posts = $loop1->found_posts;
        while ($loop1->have_posts()) : $loop1->the_post();
            if (($found_posts >= $Products_columns * 2) && ($no_of_product >= ($Products_columns * 2))) {
                if ($cnt % 2 != 0) {
                    $output .= "<li class='li_single'><ul class='single-column'>";
                }
            }
            $content = return_get_template_part('woocommerce/content-product', 'product');
            $output .=$content;
            if (($found_posts >= $Products_columns * 2) && ($no_of_product >= ($Products_columns * 2))) {
                if ($cnt % 2 == 0) {
                    $output .= '</ul></li>';
                }
            }
            $cnt++;
        endwhile;
        if(($found_posts > $Products_columns * 2) && ($no_of_product > ($Products_columns * 2))) { if($cnt % 2 == 0) { $output.= '</li></ul>'; } }
        if ($Products_type[$i] != 'top_rated_products') {
            remove_filter('posts_clauses', array(WC()->query, 'order_by_rating_post_clauses'));
        }
        $output .= '</ul>';
        $output .= '</div>';
        $output .= '</div>';
        wp_reset_postdata();
    }
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('tt_product_tab', 'tt_product_tab_shortcode');

function tt_product_type_shortcode($args, $content = "") {
    $args = shortcode_atts(array(
        'title' => '',
        'subtitle' => '',
        'no_of_product' => '-1',
        'product_type' => '',
        'products_columns' => '4',
        'auto_slide' => 'true',
        'lazyLoad' => 'true',
        'slide_speed' => '1000'
            ), $args);
    $output = "";
    global $woocommerce;
    $lazyLoad = $args['lazyLoad'];
    $Products_type = $args['product_type'];
    $Products_columns = $args['products_columns'];
    $title = $args['title'];
    $subtitle = $args['subtitle'];
    $no_of_product = $args['no_of_product'];
    $auto_slide = $args['auto_slide'];
    $slide_speed = $args['slide_speed'];
    $id = rand();
    if ($Products_type == 'featured_products') {

            $meta_query = WC()->query->get_meta_query();
                    $tax_query[] = array(
                            'taxonomy' => 'product_visibility',
                            'field'    => 'name',
                            'terms'    => 'featured',
                            'operator' => 'IN',
                    );
                    $args = array(
                        'post_type' => 'product',
                        'post_status' => 'publish',
                        'posts_per_page' => $no_of_product,
                        'meta_query'  =>  $meta_query,
                        'tax_query'           => $tax_query,
                    );
    } elseif ($Products_type == 'best_selling_products') {
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => $no_of_product,
            'meta_key' => 'total_sales',
            'orderby' => 'meta_value_num',
        );
    } elseif ($Products_type == 'top_rated_products') {
        $args = array(
            'posts_per_page' => $no_of_product,
            'post_status' => 'publish',
            'post_type' => 'product',
            'meta_key' => '_wc_average_rating',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
        );
    } elseif ($Products_type == 'sale_products') {
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => $no_of_product,
            'meta_query' => array(
                'relation' => 'OR',
                array(// Simple products type
                    'key' => '_sale_price',
                    'value' => 0,
                    'compare' => '>',
                    'type' => 'numeric'
                ),
                array(// Variable products type
                    'key' => '_min_variation_sale_price',
                    'value' => 0,
                    'compare' => '>',
                    'type' => 'numeric'
                )
            )
        );
    } elseif ($Products_type == 'recent_products') {
        $args = array(
            'post_type' => 'product',
            'orderby' => 'date',
            'post_status' => 'publish',
            'posts_per_page' => $no_of_product
        );
    }
    $output .='<div class="col-xs-12 padding_0">';
    if (!empty($title)) {
        $output .='<div class="box-heading">';
        $output .='<h3>' . $title . '</h3>';
        $output .= '<div class="ttdesc">' . esc_html($subtitle) . '</div>';
        $output .='</div>';
    }
    $output .= "<script type='text/javascript'>\n";
    $output .= "\t jQuery(document).ready(function () {\n";
    $output .= "\t var ttfeature = jQuery('.Products_wrap_" . $id . "');\n";
    $output .= "\t jQuery('.Products_wrap_" . $id . "').owlCarousel({\n";
    $output .= "\t items : " . $Products_columns . ",\n";
    $output .= "\t itemsDesktop : [1200,3],\n";
    $output .= "\t itemsDesktopSmall : [1024,3],\n";
    $output .= "\t itemsTablet: [767,2],\n";
    $output .= "\t itemsMobile : [480,1],\n";
    $output .= "\t lazyLoad : " . $lazyLoad . ",\n";
    $output .= "\t slideSpeed : " . $slide_speed . ",\n";
    $output .= "\t navigation:true,\n";
    $output .= "\t autoPlay : " . $auto_slide . ",pagination: false,stopOnHover:true\n";
    $output .= "\t });\n";
    $output .= "\t if(jQuery('.Products_wrap_" . $id . " .owl-controls.clickable').css('display') == 'none'){ \n";
    $output .= "\t jQuery('.products_wrap_" . $id . " .customNavigation').hide();\n";
    $output .= "\t }else{ \n";
    $output .= "\t jQuery('.products_wrap_" . $id . " .customNavigation').show(); \n";
    $output .= "\t jQuery('.tt" . $Products_type . '_' . $id . "_next').click(function(){ \n";
    $output .= "\t ttfeature.trigger('owl.next');\n";
    $output .= "\t });\n";
    $output .= "\t jQuery('.tt" . $Products_type . '_' . $id . "_prev').click(function(){ \n";
    $output .= "\t ttfeature.trigger('owl.prev');\n";
    $output .= "\t }); } });\n";
    $output .= "</script>\n\n";
     $output .= "<div class='block_content'>";
    $output .='<div class="woocommerce products_block products_wrap_' . $id . ' woo_product col-xs-12 padding_0">';
    $output .='<div class="customNavigation">';
    $output .= '<a class="btn prev tt' . $Products_type . '_' . $id . '_prev">' . __('Prev', 'ttshortcode') . '</a>';
    $output .= '<a class="btn next tt' . $Products_type . '_' . $id . '_next"> ' . __('Next', 'ttshortcode') . '</a>';
    $output .= '</div>';
    $output .= '<ul class="tt-carousel Products_wrap_' . $id . ' product-carousel">';
    $cnt = 1;
        $loop1 = new WP_Query($args);
        $found_posts = $loop1->found_posts;
        while ($loop1->have_posts()) : $loop1->the_post();
            if (($found_posts >= $Products_columns * 2) && ($no_of_product >= ($Products_columns * 2))) {
                if ($cnt % 2 != 0) {
                    $output .= "<li class='li_single'><ul class='single-column'>";
                }
            }
            $content = return_get_template_part('woocommerce/content-product', 'product');
            $output .=$content;
            if (($found_posts >= $Products_columns * 2) && ($no_of_product >= ($Products_columns * 2))) {
                if ($cnt % 2 == 0) {
                    $output .= '</ul></li>';
                }
            }
            $cnt++;
        endwhile;
        if(($found_posts > $Products_columns * 2) && ($no_of_product > ($Products_columns * 2))) { if($cnt % 2 == 0) { $output.= '</li></ul>'; } }
    if ($Products_type == 'top_rated_products') {
        add_filter('posts_clauses', array(WC()->query, 'order_by_rating_post_clauses'));
    }
    wp_reset_postdata();
    $output .= '</ul>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('tt_product_type', 'tt_product_type_shortcode');

function tt_testimonial_shortcode($args, $content = "") {
    $args = shortcode_atts(array(
        'title' => '',
        'subtitle' => '',
        'no_of_testimonial' => '5',
        'testimonial_columns' => '1',
        'show_thumbnail' => 'true',
        'show_designation' => 'true'
            ), $args);
    $output = "";
    $show_designation = $args['show_designation'];
    $show_thumbnail = $args['show_thumbnail'];
    $testimonial_columns = $args['testimonial_columns'];
    $title = $args['title'];
    $subtitle = $args['subtitle'];
    $no_of_testimonial = $args['no_of_testimonial'];
    $id = rand();
    $r = new WP_Query(apply_filters('widget_posts_args', array(
                        'posts_per_page' => $no_of_testimonial,
                        'no_found_rows' => true,
                        'post_status' => 'publish',
                        'post_type' => 'testimonial',
                        'ignore_sticky_posts' => true
                    )));

    if ($r->have_posts()) :
        $output .= "<script type='text/javascript'>\n";
        $output .= "\t jQuery(document).ready(function () {\n";
        $output .= "\t jQuery('.testimonial_wrap_" . $id . "').owlCarousel({\n";
        $output .= "\t items : " . $testimonial_columns . ",\n";
        $output .= "\t itemsDesktop : [1200," . $testimonial_columns . "],\n";
        $output .= "\t itemsDesktopSmall : [991,1],\n";
        $output .= "\t itemsTablet: [767,1],\n";
        $output .= "\t itemsMobile : [480,1],\n";
        $output .= "\t autoPlay : true,\n";
        $output .= "\t navigation: true,\n";
        $output .= "\t pagination: false,stopOnHover:true }); });\n";
        $output .= "</script>\n\n";
        if (!empty($title)) {
            $output .='<div class="box-heading">';
            $output .='<h3>' . esc_html($title) . '</h3>';
            $output .= '<div class="ttdesc">' . esc_html($subtitle) . '</div>';
            $output .='</div>';
        }
        $output .='<div class="testimonial_slider_wrap">';
        $output .='<ul class="padding_0 testimonial_slider testimonial_wrap_' . $id . '">';
        while ($r->have_posts()) : $r->the_post();
            $output .='<li><div class="testimonial-image">';
            if ($show_thumbnail == 'true') :
                if (has_post_thumbnail()) {
                    $output .='<img src="' . get_the_post_thumbnail_url() . '" alt="' . get_the_title() . '"/>';
                }
            endif;
            $output .='</div>';
            $output .='<div class="testimonial-user-title"><h3>' . get_the_title() . '</h3>';
            if ($show_designation == 'true') :
                $output .='<span class="tttestimonial-subtitle">';
                $output .= get_post_meta(get_the_ID(), 'testimonial_designation', true);
                $output .='</span>';
            endif;
            $output .='</div>';
            $output .='<div class="testimonial-content">';
            $output .='<div class="testimonial-desc">';
            $output .= get_the_content();
            $output .='</div>';
            $output .='</div>';
            $output .='</li>';
        endwhile;
        wp_reset_postdata();

        $output .='</ul>';
        $output .='</div>';
    endif;
    return $output;
}

add_shortcode('tt_testimonial', 'tt_testimonial_shortcode');

function tt_ourbrand_shortcode($args, $content = "") {
    $args = shortcode_atts(array(
        'title' => '',
        'subtitle' => '',
        'no_of_ourbrand' => '-1',
        'ourbrand_columns' => '5',
        'show_newtab' => 'true'
            ), $args);
    //ob_start();
    $show_newtab = $args['show_newtab'];
    $ourbrand_columns = $args['ourbrand_columns'];
    $title = $args['title'];
    $subtitle = $args['subtitle'];
    $no_of_ourbrand = $args['no_of_ourbrand'];
    $id = rand();
    $output = '';
    $r = new WP_Query(apply_filters('widget_posts_args', array(
                        'posts_per_page' => $no_of_ourbrand,
                        'no_found_rows' => true,
                        'post_status' => 'publish',
                        'post_type' => 'ourbrand',
                        'ignore_sticky_posts' => true
                    )));

    if ($r->have_posts()) :
        $output .='<div class="our_brand col-xs-12 padding_0">';
        $output .= "<script type='text/javascript'>\n";
        $output .= "\t jQuery(document).ready(function () {\n";
        $output .= "\t jQuery('.ourbrand_wrap_" . $id . "').owlCarousel({\n";
        $output .= "\t items : " . $ourbrand_columns . ",\n";
        $output .= "\t itemsDesktop : [1200,5],\n";
        $output .= "\t itemsDesktopSmall : [1024,4],\n";
        $output .= "\t itemsTablet: [767,3],\n";
        $output .= "\t itemsMobile : [480,2],\n";
        $output .= "\t autoPlay : true,\n";
        $output .= "\t navigation:true,stopOnHover:true,\n";
        $output .= "\t pagination: false });\n";
        $output .= "\t if(jQuery('.our_brand_" . $id . " .owl-controls.clickable').css('display') == 'none'){\n";
        $output .= "\t jQuery('.our_brand_" . $id . " .customNavigation').hide(); }else{\n";
        $output .= "\t  jQuery('.our_brand_" . $id . " .customNavigation').show();\n";
        $output .= "\t jQuery('.our_brand_" . $id . " .ttmanufacturer_next').click(function(){\n";
        $output .= "\t jQuery('.ourbrand_wrap_" . $id . "').trigger('owl.next'); });\n";
        $output .= "\t jQuery('.our_brand_" . $id . " .ttmanufacturer_prev').click(function(){ jQuery('.ourbrand_wrap_" . $id . "').trigger('owl.prev');\n";
        $output .= "\t  }); } });\n";
        $output .= "</script>\n\n";
        $output .='<div id="ttbrandlogo" class="brand-carousel our_brand_' . $id . '">';
        if (!empty($title)) {
            $output .='<div class="box-heading">';
            $output .='<h3>' . $title . '</h3>';
            $output .= '<div class="ttdesc">' . esc_html($subtitle) . '</div>';
            $output .='</div>';
        }
        $output .='<div class="customNavigation">';
        $output .='<a class="btn prev ttmanufacturer_prev"></a>';
        $output .='<a class="btn next ttmanufacturer_next"></a>';
        $output .='</div>';
        $output .='<div class="ourbrand_wrap_' . $id . ' brand-carousel-wrap">';
        while ($r->have_posts()) : $r->the_post();
            if (has_post_thumbnail()) {
                $brand_url = get_post_meta(get_the_ID(), 'brand_url', true);
                $output .='<div class="item">';
                if (!empty($brand_url)) {
                    $url = $brand_url;
                } else {
                    $url = '#';
                }
                if ($show_newtab == 'true' && !empty($brand_url)) {
                    $target = 'target="_blank"';
                } else {
                    $target = '';
                }
                $output .='<a href="' . $url . '" ' . $target . '>';
                $output .='<img src="' . get_the_post_thumbnail_url() . '" alt="' . get_the_title() . '"/>';
                $output .='</a>';
                $output .='</div>';
            }
        endwhile;
        wp_reset_postdata();
        $output .='</div>';
        $output .='</div>';
        $output .='</div>';
    endif;
    return $output;
}

add_shortcode('tt_ourbrand', 'tt_ourbrand_shortcode');

function tt_latestblog_shortcode($args, $content = "") {
    $args = shortcode_atts(array(
        'title' => '',
        'subtitle' => '',
        'no_of_post' => '-1',
        'no_of_column' => '3',
        'lazyLoad' => 'true',
        'show_date' => 'true',
        'show_comment' => 'true'
            ), $args);
    //ob_start();
    $lazyLoad = $args['lazyLoad'];
    $show_date = $args['show_date'];
    $title = $args['title'];
    $subtitle = $args['subtitle'];
    $no_of_post = $args['no_of_post'];
    $no_of_column = $args['no_of_column'];
    $show_comment = $args['show_comment'];
    if ($no_of_column == '1') {
        $no_of_column = 1;
        $class = '';
    } elseif ($no_of_column == '2') {
        $no_of_column = 2;
    } elseif ($no_of_column == '3') {
        $no_of_column = 3;
    }elseif ($no_of_column == '4') {
        $no_of_column = 4;
    } else {
        $no_of_column = 3;
    }
    $output = '';
    $id = rand();
    $r = new WP_Query(apply_filters('widget_posts_args', array(
        'posts_per_page' => $no_of_post,
        'no_found_rows' => true,
        'post_status' => 'publish',
        'post_type' => 'post',
        'ignore_sticky_posts' => true
    )));

    if ($r->have_posts()) :
        $output .='<div id="latest_blog_' . $id . '" class="latest_blog_' . $id . ' latest_blog_wrap col-xs-12 padding_0">';
        $output .= "<script type='text/javascript'>\n";
        $output .= "\t jQuery(document).ready(function () {\n";
        $output .= "\t jQuery('.latestblog_wrap_" . $id . "').owlCarousel({\n";
        $output .= "\t items : " . $no_of_column . ",\n";
        if ($no_of_column > 2) {
            $no_of_column1 = $no_of_column - 1;
        } elseif ($no_of_column >= 2) {
            $no_of_column1 = $no_of_column;
        } elseif ($no_of_column == 1) {
            $no_of_column1 = $no_of_column;
        }
        $output .= "\t itemsDesktop : [1200," . $no_of_column . "],\n";
        $output .= "\t itemsDesktopSmall : [991," . $no_of_column1 . "],\n";
        $output .= "\t itemsTablet: [767,2],\n";
        $output .= "\t itemsMobile : [480,1],\n";
        $output .= "\t navigation:true,\n";
        $output .= "\t lazyLoad : " . $lazyLoad . ",\n";
        $output .= "\t autoPlay : true,stopOnHover:true,\n";
        $output .= "\t pagination: false });\n";
        $output .= "\t if(jQuery('.latest_blog_" . $id . " .owl-controls.clickable').css('display') == 'none'){\n";
        $output .= "\t jQuery('.latest_blog_" . $id . " .customNavigation').hide(); }else{\n";
        $output .= "\t  jQuery('.latest_blog_" . $id . " .customNavigation').show();\n";
        $output .= "\t jQuery('.latest_blog_" . $id . " .ttblog_next').click(function(){\n";
        $output .= "\t jQuery('.latestblog_wrap_" . $id . "').trigger('owl.next'); });\n";
        $output .= "\t jQuery('.latest_blog_" . $id . " .ttblog_prev').click(function(){ jQuery('.latestblog_wrap_" . $id . "').trigger('owl.prev');\n";
        $output .= "\t  }); } });\n";
        $output .= "</script>\n\n";
        if (!empty($title)) {
            $output .='<div class="box-heading">';
            $output .='<h3>' . $title . '</h3>';
            $output .= '<div class="ttdesc">' . esc_html($subtitle) . '</div>';
            $output .='</div>';
        }
        $output .='<div class="row">';
        $output .='<div class="customNavigation">';
        $output .='<a class="btn prev ttblog_prev"></a>';
        $output .='<a class="btn next ttblog_next"></a>';
        $output .='</div>';
        $output .='<ul class="latestblog_wrap_' . $id . ' latestblog-carousel latestblog-wrap list-unstyled">';
        while ($r->have_posts()) : $r->the_post();
            $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'latest-blog');
            $full = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');

            if (isset($thumb[0])) {
                $url = $thumb[0];
            }else{
                $url = '';
            }
            $output .='<li>';
            $output .='<div class="blog-content">';
            $content = get_the_content();
            $post_media = TT_get_post_format_media();
            if (get_post_format() == 'video') {
                $is_shortcode = ( 0 === strpos($post_media, '[') );
                if ($post_media) {
                    $content = str_replace($post_media, '', $content);
                }
                if ($post_media) {
                    if ($is_shortcode) {
                        $post_media = do_shortcode($post_media);
                    } else {
                        $post_media = '<div class="video-container">' . wp_oembed_get($post_media) . '</div>';
                    }
                    $output .= $post_media;
                }
            } elseif (get_post_format() == 'audio') {
                $is_shortcode = ( 0 === strpos($post_media, '[') );
                $display_image = true;
                //Disable featured image display when using [playlist] shortcode
                if (0 === strpos($post_media, '[playlist') || !$is_shortcode) {
                    $display_image = false;
                }
                if ($post_media && $is_shortcode) {
                    $content = str_replace($post_media, '', $content);
                }
                if (has_post_thumbnail(get_the_ID())) {
                    $output .= get_the_post_thumbnail(get_the_ID());
                }
                if ($post_media && (!is_single() || $is_shortcode )) {
                    if ($is_shortcode) {
                        $post_media = do_shortcode($post_media);
                    } else {
                        $post_media = wp_oembed_get($post_media);
                    }
                    $output .= $post_media;
                }
            } elseif (get_post_format() == 'gallery') {
                if (!is_array($post_media)) {
                    $post_media = explode(',', $post_media);
                }
                if (is_array($post_media) && !empty($post_media)) {
                    $output .='<div class="format-gallery"><div class="entry-media enable-slider">';
                    foreach ($post_media as $image_id) {
                        $output .='<a href="' . esc_url(get_permalink()) . '" class="slide">' . wp_get_attachment_image(absint($image_id), 'full') . '</a>';
                    }
                    $output .='</div></div>';
                }
            } elseif (get_post_format() == 'quote') {
                $content = preg_replace('/<(\/?)blockquote(.*?)>/', '', get_the_content());
                $quote_source = trim(get_post_meta(get_the_ID(), 'quote_source', true));
                if (empty($quote_source)) {
                    $quote_source = strip_tags(get_the_title());
                }
                if (false === stristr($content, '<cite') && $quote_source) {
                    $content .= '<cite class="quote-source">' . $quote_source . '</cite>';
                }
                $content = explode('<cite', $content);
                $output .='<blockquote class="quote-content">' . $content[0] . '</blockquote>';
                if (isset($content[1]) && $content[1]) {
                    $output .= '<cite' . $content[1];
                }
            } elseif (has_post_thumbnail()) {
                $output .='<div class="ttblog_image_holder blog_image_holder col-xs-12 col-sm-12 padding_0">';
                $output .='<a href="' . get_the_permalink() . '">';
                $output .='<img class="image_thumb" src="' . $url . '" alt="' . __('Latest Blog', 'ttshortcode') . '" title="' . __('Latest Blog', 'ttshortcode') . '">';
                $output .='<div class="blog-hover"></div>';
                $output .='</a><span class="bloglinks">';
                if( ! empty($full) ){
                    $output .='<a class="icon zoom" data-lightbox="example-set" href="' . $full[0] . '" title="' . get_the_title() . '">';
                }
                $output .='<i class="fa fa-search"></i>';
                $output .='</a>';
                $output .='</span>';
                $output .='</div>';
            }
            $output .='<div class="blog-caption blog-sub-content col-xs-12 col-sm-12 padding_0">';
            if ($show_comment == 'true' || $show_date == 'true') {
                $output .='<div class="col-xs-12 padding_0">';
                if ($show_date == 'true') {
                    $output .='<span class="blog-date" style="display: block">';
                    $output .='<i class="fa fa-calendar"></i>';
                    $output .='<span class="date">' . get_the_date(' M') . '</span>';
                    $output .='<span class="month">' . get_the_date(' d, Y') . '</span>';
                    $output .='</span>';
                } $num_comments = get_comments_number(get_the_ID()); // get_comments_number returns only a numeric value
                if ($show_comment == 'true') {
                    $output .='<div class="comment" style="display: block">';
                    if (comments_open()) {
                        if ($num_comments == 0) {
                            $comments = __('0 Comments', 'ttshortcode');
                        } elseif ($num_comments > 1) {
                            $comments = $num_comments . __(' Comments', 'ttshortcode');
                        } else {
                            $comments = __('1 Comment', 'ttshortcode');
                        }
                        $output .= $write_comments = '<a href="' . get_comments_link() . '"><i class="fa fa-comments-o"></i> ' . $comments . '</a>';
                    } else {
                        $output .= $write_comments = __('Comments are off for this post.', 'ttshortcode');
                    }
                    $output .='</div>';
                }
                $output .='</div>';
            }
            $output .='<div class="col-xs-12 padding_0">';
            $output .='<h5 class="post_title">';
            $output .='<a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h5>';
            if (get_post_format() != 'quote') {
                $output .='<div class="blog-description">';
                $content_legth = 12;
                $trimexcerpt = wp_trim_excerpt();
                $shortexcerpt = wp_trim_words($trimexcerpt, $content_legth, '..<div class="continue_read"><a href="' . get_the_permalink() . '" class="read-more">' . __('Read More', 'ttshortcode') . '</a></div>');
                $output .= $shortexcerpt;
                $output .='</div>';
            } elseif (get_post_format() == 'quote') {
                $output .='<div class="continue_read"><a href="' . get_the_permalink() . '" class="read-more">' . __('Read More', 'ttshortcode') . '</a></div>';
            }
            $output .='</div>';
            $output .='</div>';
            $output .='</div>';
            $output .='</li>';
        endwhile;
        wp_reset_postdata();
        $output .='</ul>';
        $output .='</div>';
        $output .='</div>';
    endif;
    return $output;
}

add_shortcode('tt_latestblog', 'tt_latestblog_shortcode');

function tt_banner_shortcode($args, $content = "") {
    $args = shortcode_atts(array(
        'hover_style' => 'style1',
        'background_color' => '',
        'layout' => 'layout1',
        'img_src_1' => '',
        'img_link_1' => '#',
        'img_src_2' => '',
        'img_link_2' => '#',
        'img_src_3' => '',
        'img_link_3' => '#',
        'img_src_4' => '',
        'img_link_4' => '#'
            ), $args);
    $layout = $args['layout'];
    $hover_style = $args['hover_style'];
    $img_link_1 = esc_url($args['img_link_1']);
    $img_link_2 = esc_url($args['img_link_2']);
    $img_link_3 = esc_url($args['img_link_3']);
    $img_link_4 = esc_url($args['img_link_4']);
    $img_src_1 = esc_url($args['img_src_1']);
    $img_src_2 = esc_url($args['img_src_2']);
    $img_src_3 = esc_url($args['img_src_3']);
    $img_src_4 = esc_url($args['img_src_4']);
    $background_color = $args['background_color'];
    if (!empty($background_color)) {
        $back_color = 'background-color:' . $background_color . ';';
        $class_back = "pad_class";
    } else {
        $back_color = '';
        $class_back = "";
    }
    $output = '';
    if ($layout == 'layout1') {
        if ($img_src_1 != "" && $img_src_2 == '' && $img_src_3 == '') {
            $class = 'col-xs-12';
            $col = 1;
        }
        if ($img_src_1 != "" && $img_src_2 != "") {
            $class = 'col-sm-6 col-xs-6';
            $col = 2;
        }
        if ($img_src_1 != "" && $img_src_2 != "" && $img_src_3 != "" ) {
            $col = 3;
        }
        $output .='<div class="ttbannerblock layout1 ' . $hover_style . ' ' . $class_back .'" style="' . $back_color . '">';
        if ($img_src_1 != "") {
            if(empty($background_color) && $col == 1){
                $output .='<div class="ttbanner1 padding_right_0 padding_left_0 ttbanner ' . $class . '" style="' . $back_color . '">';
            }elseif(empty($background_color) && $col != 1){
                $output .='<div class="ttbanner1 ttbanner padding_left_0 ' . $class . '" style="' . $back_color . '">';
            }else{
                $output .='<div class="ttbanner1 ttbanner ' . $class . '" style="' . $back_color . '">';
            }
            $output .=' <div class="ttbanner-img">';
            $output .='<a href="' . $img_link_1 . '">';
            $output .='<img src="' . $img_src_1 . '" alt="banner-01">';
            if ($hover_style == 'style1') {
                $output .='<span class="hover hover1">test</span>';
                $output .='<span class="hover hover2">test</span>';
                $output .='<span class="hover hover3">test</span>';
                $output .='<span class="hover hover4">test</span>';
            }
            $output .='</a>';
            $output .='</div>';
            $output .='</div>';
        }if ($img_src_1 != "" && $img_src_2 != "") {
            if($background_color == "" && $col != 1){
                $output .='<div class="ttbanner2 padding_right_0 ttbanner ' . $class . '" style="' . $back_color . '">';
            }else{
                $output .='<div class="ttbanner2 ttbanner ' . $class . '" style="' . $back_color . '">';
            }
            $output .='<div class="ttbanner-row1">';
            $output .='<div class="ttbanner-img">';
            $output .='<a href="' . $img_link_2 . '">';
            $output .='<img src="' . $img_src_2 . '" alt="banner-02">';
            if ($hover_style == 'style1') {
                $output .='<span class="hover hover1">test</span>';
                $output .='<span class="hover hover2">test</span>';
                $output .='<span class="hover hover3">test</span>';
                $output .='<span class="hover hover4">test</span>';
            }
            $output .='</a>';
            $output .='</div>';
            $output .='</div>';
            if ($img_src_1 != "" && $img_src_2 != "" && $img_src_3 != "") {
                $output .='<div class="ttbanner-row2">';
                $output .='<div class="ttbanner-img">';
                $output .='<a href="' . $img_link_3 . '">';
                $output .='<img src="' . $img_src_3 . '" alt="banner-03">';
                if ($hover_style == 'style1') {
                    $output .='<span class="hover hover1">test</span>';
                    $output .='<span class="hover hover2">test</span>';
                    $output .='<span class="hover hover3">test</span>';
                    $output .='<span class="hover hover4">test</span>';
                }
                $output .='</a>';
                $output .='</div>';
                $output .='</div>';
            }
            $output .='</div>';
        }
        $output .=' </div>';
    } elseif ($layout == 'layout2') {
        if ($img_src_1 != "" && $img_src_2 == '' && $img_src_3 == '' && $img_src_4 == '') {
            $col = 1;
            if (!empty($background_color)) {
                $class = 'col-xs-12 padding_0';
            }else{
                $class = 'col-xs-12';
            }
        }if ($img_src_1 != "" && $img_src_2 != "" && $img_src_3 == '' && $img_src_4 == '') {
            $class = 'col-sm-6 col-xs-6';
            $col = 2;
        }
        if ($img_src_1 != "" && $img_src_2 != "" && $img_src_3 != '' && $img_src_4 == '') {
            $class = 'col-sm-4 col-xs-4';
            $col = 3;
        }
        if ($img_src_1 != "" && $img_src_2 != "" && $img_src_3 != '' && $img_src_4 != '') {
            $class = 'col-sm-3 col-xs-3';
            $col = 4;
        }
        $output .='<div class="ttbannerblock layout2  ' . $hover_style . ' ' . $class_back .'" style="' . $back_color . '">';
        if ($img_src_1 != "") {
            if(empty($background_color) && $col == 1){
                $output .='<div class="ttbanner1 padding_left_0 padding_right_0 ttbanner ' . $class . '" style="' . $back_color . '">';
            }elseif(empty($background_color) && $col != 1){
                $output .='<div class="ttbanner1 ttbanner padding_left_0 ' . $class . '" style="' . $back_color . '">';
            }else{
                $output .='<div class="ttbanner1 ttbanner ' . $class . '" style="' . $back_color . '">';
            }
            $output .='<div class="ttbanner-img">';
            $output .='<a href="' . $img_link_1 . '">';
            $output .='<img src="' . $img_src_1 . '" alt="banner-01">';
            if ($hover_style == 'style1') {
                $output .='<span class="hover hover1">test</span>';
                $output .='<span class="hover hover2">test</span>';
                $output .='<span class="hover hover3">test</span>';
                $output .='<span class="hover hover4">test</span>';
            }
            $output .='</a>';
            $output .='</div>';
            $output .='</div>';
        }
        if ($img_src_1 != "" && $img_src_2 != "") {
            if(empty($background_color) && $col == 2){
                $output .='<div class="ttbanner2 padding_right_0 ttbanner ' . $class . '" style="' . $back_color . '">';
            }else{
                $output .='<div class="ttbanner2 ttbanner ' . $class . '" style="' . $back_color . '">';
            }
            $output .='<div class="ttbanner-row1">';
            $output .='<div class="ttbanner-img">';
            $output .='<a href="' . $img_link_2 . '">';
            $output .='<img src="' . $img_src_2 . '" alt="banner-02">';
            if ($hover_style == 'style1') {
                $output .='<span class="hover hover1">test</span>';
                $output .='<span class="hover hover2">test</span>';
                $output .='<span class="hover hover3">test</span>';
                $output .='<span class="hover hover4">test</span>';
            }
            $output .='</a>';
            $output .='</div>';
            $output .='</div>';
            $output .='</div>';
        }
        if ($img_src_1 != "" && $img_src_2 != "" && $img_src_3 != "") {
            if(empty($background_color) && $col == 3){
                $output .='<div class="ttbanner3 padding_right_0 ttbanner ' . $class . '" style="' . $back_color . '">';
            }else{
                $output .='<div class="ttbanner3 ttbanner ' . $class . '" style="' . $back_color . '">';
            }
            $output .='<div class="ttbanner-row2">';
            $output .='<div class="ttbanner-img">';
            $output .='<a href="' . $img_link_3 . '">';
            $output .='<img src="' . $img_src_3 . '" alt="banner-03">';
            if ($hover_style == 'style1') {
                $output .='<span class="hover hover1">test</span>';
                $output .='<span class="hover hover2">test</span>';
                $output .='<span class="hover hover3">test</span>';
                $output .='<span class="hover hover4">test</span>';
            }
            $output .='</a>';
            $output .='</div>';
            $output .='</div>';
            $output .='</div>';
        }
        if ($img_src_1 != "" && $img_src_2 != "" && $img_src_3 != "" && $img_src_4 != "") {
            if(empty($background_color) && $col == 4){
                $output .='<div class="ttbanner4 padding_right_0 ttbanner ' . $class . '" style="' . $back_color . '">';
            }else{
                $output .='<div class="ttbanner4 ttbanner ' . $class . '" style="' . $back_color . '">';
            }
            $output .='<div class="ttbanner-row2">';
            $output .='<div class="ttbanner-img">';
            $output .='<a href="' . $img_link_4 . '">';
            $output .='<img src="' . $img_src_4 . '" alt="banner-04">';
            if ($hover_style == 'style1') {
                $output .='<span class="hover hover1">test</span>';
                $output .='<span class="hover hover2">test</span>';
                $output .='<span class="hover hover3">test</span>';
                $output .='<span class="hover hover4">test</span>';
            }
            $output .='</a>';
            $output .='</div>';
            $output .='</div>';
            $output .='</div>';
        }
        $output .='</div>';
    } elseif ($layout == 'layout3') {
        if ($img_src_1 != "" && $img_src_2 == '' && $img_src_3 == '') {
            $class = 'col-xs-12';
            $col = 1;
        }if ($img_src_1 != "" && $img_src_2 != "") {
            $class = 'col-sm-6 col-xs-6';
            $col = 2;
        }
        if ($img_src_1 != "" && $img_src_2 != "" && $img_src_3 != "") {
            $class1 = 'col-xs-12';
            $col = 3;
        }
        $output .='<div class="ttbannerblock layout3  ' . $hover_style . ' ' . $class_back .'" style="' . $back_color . '">';
        if ($img_src_1 != "" && $img_src_2 == "") {
            if(empty($background_color) && $col == 1){
                $output .='<div class="ttbanner1 padding_left_0 padding_right_0 ttbanner ' . $class . '" style="' . $back_color . '">';
            }else{
                $output .='<div class="ttbanner1 ttbanner ' . $class . '" style="' . $back_color . '">';
            }
            $output .=' <div class="ttbanner-img">';
            $output .='<a href="' . $img_link_1 . '">';
            $output .='<img src="' . $img_src_1 . '" alt="banner-01">';
            if ($hover_style == 'style1') {
                $output .='<span class="hover hover1">test</span>';
                $output .='<span class="hover hover2">test</span>';
                $output .='<span class="hover hover3">test</span>';
                $output .='<span class="hover hover4">test</span>';
            }
            $output .='</a>';
            $output .='</div>';
            $output .='</div>';
        }
         $output .='<div class="ttbanner1 ttbanner col-xs-12 padding_left_0 padding_right_0" style="' . $back_color . '">';
        if ($img_src_1 != "" && $img_src_2 != "") {

            if(empty($background_color) && $col != 1){
                  $output .='<div class="ttbanner-row1 padding_left_0 ' . $class . '">';
            }else{
                  $output .='<div class="ttbanner-row1 ' . $class . '">';
            }
            $output .='<div class="ttbanner-img">';
            $output .='<a href="' . $img_link_1 . '">';
            $output .='<img src="' . $img_src_1 . '" alt="banner-02">';
            if ($hover_style == 'style1') {
                $output .='<span class="hover hover1">test</span>';
                $output .='<span class="hover hover2">test</span>';
                $output .='<span class="hover hover3">test</span>';
                $output .='<span class="hover hover4">test</span>';
            }
            $output .='</a>';
            $output .='</div>';
            $output .='</div>';
            if(empty($background_color) && $col != 1){
                  $output .='<div class="ttbanner-row1 padding_right_0 ' . $class . '">';
            }else{
                  $output .='<div class="ttbanner-row1 ' . $class . '">';
            }
            $output .='<div class="ttbanner-img">';
            $output .='<a href="' . $img_link_2 . '">';
            $output .='<img src="' . $img_src_2 . '" alt="banner-02">';
            if ($hover_style == 'style1') {
                $output .='<span class="hover hover1">test</span>';
                $output .='<span class="hover hover2">test</span>';
                $output .='<span class="hover hover3">test</span>';
                $output .='<span class="hover hover4">test</span>';
            }
            $output .='</a>';
            $output .='</div>';
            $output .='</div>';
            $output .='</div>';
            if ($img_src_1 != "" && $img_src_2 != "" && $img_src_3 != "") {
                if(empty($background_color) && $col != 1){
                    $output .='<div class="ttbanner2 ttbanner padding_left_0 padding_right_0 ' . $class1 . '" style="' . $back_color . '">';
                }else{
                    $output .='<div class="ttbanner2 ttbanner ' . $class1 . '" style="' . $back_color . '">';
                }
                $output .='<div class="ttbanner-row2">';
                $output .='<div class="ttbanner-img">';
                $output .='<a href="' . $img_link_3 . '">';
                $output .='<img src="' . $img_src_3 . '" alt="banner-03">';
                if ($hover_style == 'style1') {
                    $output .='<span class="hover hover1">test</span>';
                    $output .='<span class="hover hover2">test</span>';
                    $output .='<span class="hover hover3">test</span>';
                    $output .='<span class="hover hover4">test</span>';
                }
                $output .='</a>';
                $output .='</div>';
                $output .='</div>';

                $output .='</div>';
            }
        }
        $output .=' </div>';
    }
    return $output;
}

add_shortcode('tt_banner', 'tt_banner_shortcode');


/* text widget add filter */
add_filter('widget_text', 'do_shortcode');

// Add Shortcode function for  latest product carousel
function tt_sales_countdown_shortcode($atts) {
    // Attributes
    extract(shortcode_atts(
                    array(
                'posts' => "-1",
                'order' => '',
                'column' => '1',
                'title' => '',
                'subtitle' => '',
                'orderby' => '',
                'slider_type' => '',
                    ), $atts)
    );
    global $post;
    $now_time = time();
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $posts,
        'meta_query' => array(
            array(
                'key' => 'tt_sales_countdown',
                'value' => 'sales_yes',
                'compare' => '=',
            ),
            array(
                'key' => 'tt_end_sales_date',
                'value' => $now_time,
                'compare' => '>',
            )
        )
    );
    $output = '';

    $thePosts = query_posts($args);
    if (have_posts()) :
        $id = rand();
        $output .= "<script type='text/javascript'>\n";
        $output .= "\t jQuery(document).ready(function () {\n";
        $output .= "\t jQuery('.tt_latest_product_slider" . $id . "').owlCarousel({\n";
        $output .= "\t items : " . $column . ",\n";
        $output .= "\t itemsDesktop : [1200,1],\n";
        $output .= "\t itemsDesktopSmall : [991,1],\n";
        $output .= "\t itemsTablet: [767,1],\n";
        $output .= "\t itemsMobile : [480,1],\n";
        $output .= "\t autoPlay : false,\n";
        $output .= "\t navigation:true,stopOnHover:true,\n";
        $output .= "\t pagination: false });\n";
        $output .= "\t });\n";
        $output .= "</script>\n\n";
        $output .= '<div id="tt_latest_product_slider" class="">';
         if(!empty($title))
        {
        $output .= '<div class="box-heading"><h3>' . $title . '</h3> <div class="ttdesc">' . esc_html($subtitle) . '</div></div>';
        }
        $output .= '<div id="" class="row">';
        $output .= '<div id="" class="tt_latest_product_slider' . $id . ' sales_' . $slider_type . '">';
        while (have_posts()) : the_post();
            $post_id = get_the_ID();
            $product_id = get_post_thumbnail_id();
            $product_url = wp_get_attachment_image_src($product_id, 'shop_single', true);
            $product_mata = get_post_meta($product_id, '_wp_attachment_image_alt', true);
            $product_link = get_permalink();
            global $product;
            $attachment_ids = $product->get_gallery_image_ids();

            $output .= '<div class="tt_product_item">';
            if ($product_link) :
                $output .= '<div class="product-img-div col-xs-12 col-sm-6 padding_0"><span class="countdown onsale">' . __('on Sale!', 'eletronics') . '</span><div class="product-item' . $id . ' product-item-div"><div class="pro-item"><a href="' . $product_link . '">';
            endif;
            if (!empty($product_url[0])) {
                $output .= '<img  src="' . $product_url[0] . '" alt="' . $product_mata . '" /></a></div>';
                foreach ($attachment_ids as $attachment_id) {
                    $im = wp_get_attachment_image_src($attachment_id, 'shop_single');
                    $output .= '<div class="pro-item"><a href="' . $product_link . '"><img src="' . $im[0] . '"></a></div>';
                }
            }
            if ($product_link) :
                $output .= '</div>';
                if ($attachment_ids):
                    if ($slider_type == 'vertical') {
                        $left = '"fa fa-angle-up"';
                        $right = '"fa fa-angle-down"';
                    } elseif ($slider_type == 'horizontal') {
                        $left = '"fa fa-angle-left"';
                        $right = '"fa fa-angle-right"';
                    }
                    $slickleft = '"slick-prev"';
                    $slickright = '"slick-next"';
                    $output .= "<script type='text/javascript'>\n";
                    $output .= "\t jQuery(document).ready(function () {\n";
                    $output .= "\t jQuery('.product-thumb" . $id . "').not('.slick-initialized').slick({\n";
                    $output .= "\t slidesToShow: 3,\n";
                    $output .= "\t slidesToScroll: 1,\n";
                    $output .= "\t asNavFor: '.product-item" . $id . "',\n";
                    $output .= "\t prevArrow:'<button class=" . $slickleft . "><i class=" . $left . "></i></button>',\n";
                    $output .= "\t nextArrow:'<button class=" . $slickright . "><i class=" . $right . "></i></button>',\n";
                    $output .= "\t dots: false,centerMode: true,\n";
                    if ($slider_type == 'vertical') {
                        $left = '"fa fa-arrow-left"';
                        $right = '"fa fa-arrow-right"';

                        $output .= "\t vertical:true,\n";
                        $output .= "\t slidesToShow: 3,\n";
                    } elseif ($slider_type == 'horizontal') {
                        $output .= "\t vertical:false,\n";
                    }
                    $output .= "\t arrows: true,\n";
                    $output .= "\t focusOnSelect: true\n";
                    $output .= "\t });\n";
                    $output .= "\t jQuery('.product-item" . $id . "').not('.slick-initialized').slick({\n";
                    $output .= "\t slidesToShow: 1,\n";
                    $output .= "\t slidesToScroll: 1,\n";
                    $output .= "\t prevArrow:'<button class=" . $slickleft . "><i class=" . $left . "></i></button>',\n";
                    $output .= "\t nextArrow:'<button class=" . $slickright . "><i class=" . $right . "></i></button>',\n";
                    $output .= "\t asNavFor: '.product-thumb" . $id . "',\n";
                    $output .= "\t arrows: true,\n";
                    $output .= "\t });\n";
                    $output .= "\t });\n";
                    $output .= "</script>\n\n";
                    if ($slider_type == 'horizontal') {
                        $class = 'slick-horizontal';
                    } elseif ($slider_type == 'vertical') {
                        $class = 'slick-vertical';
                    }
                    $output .= '<div class="product-thumb' . $id . ' product-thumbdiv">';
                    $product_img = wp_get_attachment_image_src($product_id, 'shop_thumbnail');
                    if (!empty($product_url[0])) {
                        $output .= '<div class=""><img  src="' . $product_img[0] . '" alt="' . $product_mata . '" /></div>';
                        foreach ($attachment_ids as $attachment_id) {
                            $thumb_img = wp_get_attachment_image_src($attachment_id, 'shop_thumbnail');
                            $output .= '<div class=""><img src="' . $thumb_img[0] . '"></div>';
                        }
                    }
                    $output .= '</div>';
                endif;
                $output .= '</div>';
            endif;

            $output .='<div class="col-sm-6 col-xs-12 sales_product_sontent"><h3 class="tt_pro_title">';
            if (strlen(get_the_title()) > 20) {
                $output .= substr(get_the_title(), 0, 20) . '...';
            } else {
                $output .= get_the_title();
            }
            $output .='</h3>';
            $output .='<div class="product_desc">';
            $output .= wp_trim_words(get_the_excerpt(),20,'...');;
            $output .='</div>';
            $sales_date = get_post_meta($post_id, 'tt_end_sales_date', true);
            if ($sales_date >= $now_time) {
                $sales_date = date('Y/m/d', $sales_date);
            }

            $output .= '<div class="count-down tt_time_wrap"><div class="countbox hastime" data-time="' . $sales_date . '"></div></div>';
            $output .= '<div class="tt_price_area_fix">' . do_shortcode('[add_to_cart id="' . get_the_ID() . '"]');
            $output .= '<a class="detail-link trquickview" data-quick-id="'. get_the_ID().'" href=""> '. __('Quick View','modernshop').'</a></div>';

            $output .= '</div></div>';

        endwhile;
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';
    endif;


    wp_reset_query();
    if (empty($thePosts)) {
        $output .= '<div class="no-data"><strong>No Product Yet.</strong></div>';
    }
    return $output;
}

add_shortcode('tt_sales_countdown_product', 'tt_sales_countdown_shortcode'); // add shortcode
/* * *************** Photo Shortcode *************** */

function shortcode_flickrphoto($atts, $content = null) {
    extract(shortcode_atts(array(
                'id' => '',
                'type' => 'user',
                'count_no' => '',
                    ), $atts));
    if ($type == 'user') {
        $flickr_data = '<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=' . $count_no . '&amp;display=latest;size=s&amp;layout=x&amp;source=user&amp;user==' . $id . '"></script> ';
    } else {
        $flickr_data = '<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=' . $count_no . '&amp;display=latest;size=s&amp;layout=x&amp;source=group&amp;group=' . $id . '"></script> ';
    }
    return $flickr_data;
}

function tt_product_category_tab_shortcode($args) {
    $args = shortcode_atts(array(
        'title' => '',
        'subtitle' => '',
        'category_banner' => '',
        'no_of_product' => '-1',
        'category_ids' => '14,16,19',
        'product_type' => 'all',
        'products_columns' => '4',
        'auto_slide' => 'true',
        'slide_speed' => '1000'
            ), $args);
    global $woocommerce;
    $category_banner = $args['category_banner'];
    $Products_columns = $args['products_columns'];
    $title = $args['title'];
    $subtitle = $args['subtitle'];
    $no_of_product = $args['no_of_product'];
    $Products_type = $args['product_type'];
    $auto_slide = $args['auto_slide'];
    $slide_speed = $args['slide_speed'];
    $id = rand();
    $output = '';
    $category_ids_array = explode(",", $args['category_ids']);

    $output = '';
    if (class_exists('WooCommerce')) {
        $output .= '<div class="woocommerce padding_0 TTProduct-Tab woo_product">';
        $output .= '<div class="col-xs-12 padding_0">';
        $category_ids = '';
        $term_category_id = '';
        $term_category_name = '';
        $term_categroy_slug = '';
        $term_thumbnai_id = '';
        $term_image = '';
        $output .= '<div class="tt_category_tab"  id="categorytab">';
        $output .= '<div class="tab-box-heading"  id="categorytab">';

        if (!empty($title)) {
            $output .= '<div class="box-heading tthometab-title">';
            $output .= '<h3>' . $title . '</h3>';
            $output .= '<div class="ttdesc">' . esc_html($subtitle) . '</div>';
            $output .= '</div>';
        }
        $output .= '<ul class="resp-tabs-list"><div class="product_type box-heading"><h3>' . $Products_type . '</h3></div>';
        foreach ($category_ids_array as $key) {
            $category_ids = get_term($key, 'product_cat');
            if ($category_ids) {
                $term_category_id = $category_ids->term_id;
                $term_category_name = $category_ids->name;
                $term_category_slug = $category_ids->slug;
                $term_thumbnail_id = get_woocommerce_term_meta($term_category_id, 'thumbnail_id', true);
                $term_image = wp_get_attachment_url($term_thumbnail_id);  // get the image URL
                $output .= '<li>';
                $output .= $term_category_name;
                $output .= '</li>';
            }
        }
        $output .= '</ul>';
        $output .= '</div>';
        $output .= '<div class="resp-tabs-container ttcategory col-xs-12">';
        foreach ($category_ids_array as $key) {
            $category_ids = get_term($key, 'product_cat');
            if ($category_ids) {
                $term_category_id = $category_ids->term_id;
                $term_category_name = $category_ids->name;
                $term_category_slug = $category_ids->slug;

                $output .= "<div class='$term_category_slug'><script type='text/javascript'>\n";
                $output .= "\t jQuery(document).ready(function () {\n";
                $output .= "\t var ttfeature = jQuery('.tt" . $term_category_slug . "_" . $id . "');\n";
                $output .= "\t ttfeature.owlCarousel({\n";
                $output .= "\t items : " . $Products_columns . ",\n";
                $output .= "\t itemsDesktop : [1200,3],\n";
                $output .= "\t itemsDesktopSmall : [1024,2],\n";
                $output .= "\t itemsTablet: [767,1],\n";
                $output .= "\t itemsMobile : [480,1],\n";
                $output .= "\t slideSpeed : " . $slide_speed . ",navigation:true,pagination: false,\n";
                $output .= "\t autoPlay : " . $auto_slide . ",stopOnHover:true\n";
                $output .= "\t });\n";
                $output .= "\t if(jQuery('." . $term_category_slug . "_" . $id . " .owl-controls.clickable').css('display') == 'none'){ \n";
                $output .= "\t jQuery('." . $term_category_slug . "_" . $id . " .customNavigation').hide();\n";
                $output .= "\t }else{ \n";
                $output .= "\t jQuery('." . $term_category_slug . "_" . $id . " .customNavigation').show(); \n";
                $output .= "\t jQuery('.tt" . $term_category_slug . '_' . $id . "_next').click(function(){ \n";
                $output .= "\t ttfeature.trigger('owl.next');\n";
                $output .= "\t });\n";
                $output .= "\t jQuery('.tt" . $term_category_slug . '_' . $id . "_prev').click(function(){ \n";
                $output .= "\t ttfeature.trigger('owl.prev');\n";
                $output .= "\t }); } });\n";
                $output .= "</script>\n\n";

                $output .= '<div id="' . $term_category_slug . '" class="' . $term_category_slug . '_' . $id . ' product-carousel tab-pane block products_block clearfix">';
                $output .= '<div class="block_content">';

                if (!empty($category_banner)) {
                    $output .= '<div class="categoryimage col-sm-2 col-xs-12">';
                    $output .= '<img src="'.$category_banner.'" atl=""/>';
                    $output .= '</div>';
                }
                $output .= '<div class="categoryul col-sm-10 col-xs-12">';
                $output .= '<ul class="tt' . $term_category_slug . '_' . $id . '">';
                if ($Products_type == 'featured') {
                     $meta_query = WC()->query->get_meta_query();
                    $tax_query[] = array(
                            'taxonomy' => 'product_visibility',
                            'field'    => 'name',
                            'terms'    => 'featured',
                            'operator' => 'IN',
                    );
                    $tax_query[] = array(
                                'taxonomy' => 'product_cat',
                                'field' => 'id',
                                'terms' => $term_category_id,
                                'include_children' => false
                            );
                    $args = array(
                        'post_type' => 'product',
                        'post_status' => 'publish',
                        'posts_per_page' => $no_of_product,
                        'meta_query'  =>  $meta_query,
                        'tax_query'   => $tax_query,
                    );
                } elseif ($Products_type == 'best-selling') {
                    $meta_query = WC()->query->get_meta_query();
                    $args = array(
                        'post_type' => 'product',
                        'post_status' => 'publish',
                        'posts_per_page' => $no_of_product,
                        'meta_key' => 'total_sales',
                        'orderby' => 'meta_value_num',
                        'meta_query' => $meta_query,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field' => 'id',
                                'terms' => $term_category_id,
                                'include_children' => false
                            )
                        )
                    );
                } elseif ($Products_type == 'top-rated') {

                    $args = array(
                        'posts_per_page' => $no_of_product,
                        'post_status' => 'publish',
                        'post_type' => 'product',
                        'meta_key' => '_wc_average_rating',
                        'orderby' => 'meta_value_num',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field' => 'id',
                                'terms' => $term_category_id,
                                'include_children' => false
                            )
                        )
                    );
                } elseif ($Products_type == 'sale') {
                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => $no_of_product,
                        'post_status' => 'publish',
                        'meta_query' => array(
                            'relation' => 'OR',
                            array(// Simple products type
                                'key' => '_sale_price',
                                'value' => 0,
                                'compare' => '>',
                                'type' => 'numeric'
                            ),
                            array(// Variable products type
                                'key' => '_min_variation_sale_price',
                                'value' => 0,
                                'compare' => '>',
                                'type' => 'numeric'
                            )
                        ),
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field' => 'id',
                                'terms' => $term_category_id,
                                'include_children' => false
                            )
                        )
                    );
                } elseif ($Products_type == 'recent' || $Products_type == 'all') {
                    $args = array(
                        'post_type' => 'product',
                        'orderby' => 'date',
                        'post_status' => 'publish',
                        'posts_per_page' => $no_of_product,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field' => 'id',
                                'terms' => $term_category_id,
                                'include_children' => false
                            )
                        )
                    );
                }
               $cnt = 1;
        $loop1 = new WP_Query($args);
        $found_posts = $loop1->found_posts;
        while ($loop1->have_posts()) : $loop1->the_post();
            if (($found_posts >= $Products_columns * 2) && ($no_of_product >= ($Products_columns * 2))) {
                if ($cnt % 2 != 0) {
                    $output .= "<li class='li_single'><ul class='single-column'>";
                }
            }
            $content = return_get_template_part('woocommerce/content-product', 'product');
            $output .=$content;
            if (($found_posts >= $Products_columns * 2) && ($no_of_product >= ($Products_columns * 2))) {
                if ($cnt % 2 == 0) {
                    $output .= '</ul></li>';
                }
            }
            $cnt++;
        endwhile;
        if(($found_posts > $Products_columns * 2) && ($no_of_product > ($Products_columns * 2))) { if($cnt % 2 == 0) { $output.= '</li></ul>'; } }
                if ($Products_type != 'top_rated_products') {
                    remove_filter('posts_clauses', array(WC()->query, 'order_by_rating_post_clauses'));
                }
                $output .= '</ul>';
                $output .= '</div>';
                $output .='<div class="customNavigation">';
                $output .= '<a class="btn prev tt' . $term_category_slug . '_' . $id . '_prev">' . __('Prev', 'ttshortcode') . '</a>';
                $output .= '<a class="btn next tt' . $term_category_slug . '_' . $id . '_next"> ' . __('Next', 'ttshortcode') . '</a>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div></div>';
                wp_reset_postdata();
            }
        }
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div></div>';
    }
    return $output;
}

add_shortcode('tt_product_cat_tab', 'tt_product_category_tab_shortcode');

function tt_shortcode_woo_sub_categories($atts, $content = null) {
    extract(shortcode_atts(array(
                'category_ids' => '19',
                'title' => '',
                'subtitle' => ''
                    ), $atts));
    $category_ids_array = explode(",", $category_ids);
    $output = '';
    if (!empty($title)) {
        $output .='<div class="box-heading">';
        $output .='<h3>' . $title . '</h3>';
        $output .= '<div class="ttdesc">' . esc_html($subtitle) . '</div>';
        $output .='</div>';
    }
    $output .= '<div class="category_link">';
    $output .= '<ul class="category">';
    foreach ($category_ids_array as $key) {
        $category_ids = get_term($key, 'product_cat');
        $thumbnail_id = get_woocommerce_term_meta($category_ids->term_id, 'thumbnail_id', true);
        $output .= '<li class="block"><div class="cat_wrap">';
        $image = wp_get_attachment_url($thumbnail_id);
        $cat_thumb = tt_print_images_thumb($image, $product_category->name, 250, 250, 'c');
        $output .= '<div class="cat-img col-sm-4"><a href="' . get_category_link($product_category) . '">' . $cat_thumb . '</a></div>';
        $output .= '<div class="ttcat-content col-sm-8"><a class="cat-name" href="' . get_category_link($category_ids) . '">' . $category_ids->name . '</a>';
        $args = array(
            'parent' => $category_ids->term_id,
            'hide_empty' => 0,
            'taxonomy' => 'product_cat',
        );
        $categories = get_categories($args);
        if (!empty($categories)) {
            $output .= '<ul>';
            foreach ($categories as $subkey) {
                $output .= '<li><a class="sub-name" href="' . get_category_link($subkey->term_id) . '">' . $subkey->name . '</a></li>';
            }
            $output .= '</ul>';
        }
        $output .= '</div>';
        $output .='</div></li>';
    }
    $output .= '</ul>';
    $output .= '</div>';
    return $output;
}

if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) :
    add_shortcode("tt_woo_sub_categories", "tt_shortcode_woo_sub_categories");
endif;

function tt_shortcode_woo_categories_slider($atts, $content = null) {
    extract(shortcode_atts(array(
                'title' => '',
                'subtitle' => '',
                'number_of_category' => '5',
                'category_columns' => '4',
                'category_ids' => '',
                'lazyLoad' => 'true',
                'hide_empty' => '0'
                    ), $atts));
    $args = array(
        'number' => $number_of_category,
        'orderby' => 'title',
        'order' => 'ASC',
        'hide_empty' => $hide_empty,
        'include' => $category_ids
    );
    $product_categories = get_terms('product_cat', $args);
    $count = count($product_categories);
    if ($count > 0) {
        $output = '';
        $id = rand();
        $output .= "<script type='text/javascript'>\n";
        $output .= "\t jQuery(document).ready(function () {\n";
        $output .= "\t jQuery('.tt_category_" . $id . "').owlCarousel({\n";
        $output .= "\t items : ".$category_columns.",\n";
        $output .= "\t itemsDesktop : [1200,3],\n";
        $output .= "\t lazyLoad : " . $lazyLoad . ",\n";
        $output .= "\t itemsDesktopSmall : [991,2],\n";
        $output .= "\t itemsTablet: [767,1],\n";
        $output .= "\t itemsMobile : [480,1],\n";
        $output .= "\t autoPlay : true,\n";
        $output .= "\t navigation:true,stopOnHover:true,\n";
        $output .= "\t pagination: false });\n";

        $output .= "\t if(jQuery('.tt_category_" . $id . " .owl-controls.clickable').css('display') == 'none'){ \n";
        $output .= "\t jQuery('.tt_category_wrap" . $id . ".customNavigation').hide();\n";
        $output .= "\t }else{ \n";
        $output .= "\t jQuery('.tt_category_wrap" . $id . ".customNavigation').show(); \n";
        $output .= "\t jQuery('.tt_category_wrap" . $id . " .tt_next').click(function(){ \n";
        $output .= "\t jQuery('.tt_category_" . $id . "').trigger('owl.next');\n";
        $output .= "\t });\n";
        $output .= "\t jQuery('.tt_category_wrap" . $id . " .tt_prev').click(function(){ \n";
        $output .= "\t jQuery('.tt_category_" . $id . "').trigger('owl.prev');\n";
        $output .= "\t }); } \n";
        $output .= "\t });\n";
        $output .= "</script>\n\n";

        $output .='<div class="woocommerce category_slider_wrap col-xs-12 padding_0">';
        if (!empty($title)) {
            $output .='<div class="box-heading">';
            $output .='<h3>' . $title . '</h3>';
            $output .= '<div class="ttdesc">' . esc_html($subtitle) . '</div>';
            $output .='</div>';
        }
        $output .='<div class="customNavigation tt_category_wrap' . $id . '">';
        $output .='<a class="btn prev tt_prev"></a>';
        $output .='<a class="btn next tt_next"></a>';
        $output .='</div>';
        $output .= '<div class="category_link tt_category_wrap">';
        $output .= '<ul class="tt_category_' . $id . '">';
        foreach ($product_categories as $product_category) {
            $thumbnail_id = get_woocommerce_term_meta($product_category->term_id, 'thumbnail_id', true);
            $image = wp_get_attachment_image_src($thumbnail_id, 'tt-product-category-slider');
            $output .= '<li class="block">';
            $image = wp_get_attachment_url($thumbnail_id);
            $cat_thumb = tt_print_images_thumb($image, $product_category->name, 140,180, 'c');
            $output .= '<div class="ttcat-content col-sm-8 col-xs-8"><a class="cat-name" href="' . get_category_link($product_category) . '">' . $product_category->name . '</a>';
            $args = array(
                'parent' => $product_category->term_id,
                'hide_empty' => 0,
                'taxonomy' => 'product_cat',
            );
            $categories = get_categories($args);
            if (!empty($categories)) {
                $output .= '<ul>';
                foreach ($categories as $subkey) {
                    $output .= '<li><a class="sub-name" href="' . get_category_link($subkey->term_id) . '">' . $subkey->name . '</a></li>';
                }
                $output .= '</ul>';
            }
            $output .= '</div>';
             $output .= '<div class="cat-img col-sm-4 col-xs-4"><a href="' . get_category_link($product_category) . '">' . $cat_thumb . '</a></div>';
            $output .='</li>';
        }
        $output .= '</ul>';
        $output .= '</div></div>';
        return $output;
    }
}

if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) :
    add_shortcode("tt_woo_categories_slider", "tt_shortcode_woo_categories_slider");
endif;

function tt_product_type_shortcode_horizontal($args) {
    $args = shortcode_atts(array(
        'title' => '',
        'subtitle' => '',
        'no_of_product' => '-1',
        'product_type' => '',
        'products_columns' => '3',
        'auto_slide' => 'true',
        'lazyLoad' => 'true',
        'slide_speed' => '1000'
            ), $args);
    $output = "";
    global $woocommerce;
    $lazyLoad = $args['lazyLoad'];
    $Products_type = $args['product_type'];
    $Products_columns = $args['products_columns'];
    $title = $args['title'];
    $subtitle = $args['subtitle'];
    $no_of_product = $args['no_of_product'];
    $auto_slide = $args['auto_slide'];
    $slide_speed = $args['slide_speed'];
    $id = rand();
    if ($Products_type == 'featured_products') {
         $meta_query = WC()->query->get_meta_query();
                    $tax_query[] = array(
                            'taxonomy' => 'product_visibility',
                            'field'    => 'name',
                            'terms'    => 'featured',
                            'operator' => 'IN',
                    );
                    $args = array(
                        'post_type' => 'product',
                        'post_status' => 'publish',
                        'posts_per_page' => $no_of_product,
                        'meta_query'  =>  $meta_query,
                        'tax_query'           => $tax_query,
                    );
    } elseif ($Products_type == 'best_selling_products') {
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => $no_of_product,
            'meta_key' => 'total_sales',
            'orderby' => 'meta_value_num',
        );
    } elseif ($Products_type == 'top_rated_products') {
        $args = array(
            'posts_per_page' => $no_of_product,
            'post_status' => 'publish',
            'post_type' => 'product',
            'meta_key' => '_wc_average_rating',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
        );
    } elseif ($Products_type == 'sale_products') {
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => $no_of_product,
            'meta_query' => array(
                'relation' => 'OR',
                array(// Simple products type
                    'key' => '_sale_price',
                    'value' => 0,
                    'compare' => '>',
                    'type' => 'numeric'
                ),
                array(// Variable products type
                    'key' => '_min_variation_sale_price',
                    'value' => 0,
                    'compare' => '>',
                    'type' => 'numeric'
                )
            )
        );
    } elseif ($Products_type == 'recent_products') {
        $args = array(
            'post_type' => 'product',
            'orderby' => 'date',
            'post_status' => 'publish',
            'posts_per_page' => $no_of_product
        );
    }
    $output .='<div class="col-xs-12 padding_0">';
    if (!empty($title)) {
        $output .='<div class="box-heading">';
        $output .='<h3>' . $title . '</h3>';
        $output .= '<div class="ttdesc">' . esc_html($subtitle) . '</div>';
        $output .='</div>';
    }
    $theme_layout = of_get_option('theme_layout');

    $output .= "<script type='text/javascript'>\n";
    $output .= "\t jQuery(document).ready(function () {\n";
    $output .= "\t var ttfeature = jQuery('.Products_wrap_horizontal_" . $id . "');\n";
    $output .= "\t jQuery('.Products_wrap_horizontal_" . $id . "').owlCarousel({\n";
    $output .= "\t items : " . $Products_columns . ",\n";
    $output .= "\t itemsDesktop : [1200,2],\n";
    $output .= "\t itemsDesktopSmall : [991,2],\n";
    $output .= "\t itemsTablet: [767,1],\n";
    $output .= "\t itemsMobile : [640,1],\n";
    $output .= "\t slideSpeed : " . $slide_speed . ",\n";
    $output .= "\t lazyLoad : " . $lazyLoad . ",\n";
    $output .= "\t navigation:true,pagination: false,\n";
    $output .= "\t autoPlay : " . $auto_slide . ",pagination: false,stopOnHover:true\n";
    $output .= "\t });\n";
    $output .= "\t if(jQuery('.Products_wrap_horizontal_" . $id . " .owl-controls.clickable').css('display') == 'none'){ \n";
    $output .= "\t jQuery('.products_wrap_" . $id . " .customNavigation').hide();\n";
    $output .= "\t }else{ \n";
    $output .= "\t jQuery('.products_wrap_" . $id . " .customNavigation').show(); \n";
    $output .= "\t jQuery('.tt" . $Products_type . '_' . $id . "_next').click(function(){ \n";
    $output .= "\t ttfeature.trigger('owl.next');\n";
    $output .= "\t });\n";
    $output .= "\t jQuery('.tt" . $Products_type . '_' . $id . "_prev').click(function(){ \n";
    $output .= "\t ttfeature.trigger('owl.prev');\n";
    $output .= "\t }); } });\n";
    $output .= "</script>\n\n";
    $output .='<div class="block_content">';
    $output .='<div class="woocommerce products_block_horizontal products_block products_wrap_' . $id . ' woo_product col-xs-12">';
    $output .='<div class="customNavigation">';
    $output .= '<a class="btn prev tt' . $Products_type . '_' . $id . '_prev">' . __('Prev', 'ttshortcode') . '</a>';
    $output .= '<a class="btn next tt' . $Products_type . '_' . $id . '_next"> ' . __('Next', 'ttshortcode') . '</a>';
    $output .= '</div>';
    $output .= '<ul class="tt-carousel Products_wrap_horizontal_' . $id . ' product-carousel">';
    $cnt = 1;
    $loop1 = new WP_Query($args);
    $found_posts = $loop1->found_posts;
    while ($loop1->have_posts()) : $loop1->the_post();
        $content = return_get_template_part('woocommerce/content', 'product');
        $output .=$content;
    endwhile;
    if ($Products_type == 'top_rated_products') {
        add_filter('posts_clauses', array(WC()->query, 'order_by_rating_post_clauses'));
    }
    wp_reset_postdata();
    $output .= '</ul>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('tt_product_type_horizontal', 'tt_product_type_shortcode_horizontal');

/* * *************** Services *************** */

function services_home_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
                "image" => '',
                "title" => '',
                "background_color" => '',
                "link_text" => '',
                "link_url" => '',
                "style" => 'vertical'
                    ), $atts));

    if (!empty($background_color)):
        $style_css .= 'style="background-color: ' . $background_color . ';"';
    else:
        $style_css = '';
    endif;

    $output = '';
    $output .= '<div class="service style-' . $style . '" '.$style_css.'>';
    $output .= '<div class="service-content-wrap style-' . $style . '">';

        if (!empty($image))
            $output .= '<div class="service-icon"><img src="'.$image.'" alt=""/></div>';
        $output .= '<div class="service-content">';
        if (!empty($title))
            $output .= '<div class="title service-text">' . $title . '</div>';

    $output .= '<div class="description other-font">' . do_shortcode($content) . '</div>';

    if (!empty($link_text)):
        if (!empty($link_url)):
            $output .= '<div class="service-read-more other-font"><a href="' . $link_url . '" class="other-read-more">' . $link_text . '<i class="fa fa-arrow-right"></i></a></div>';
        else:
            $output .= '<div class="service-read-more other-font">' . $link_text . '></div>';
        endif;
    endif;

    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode("tt_home_service", "services_home_shortcode");

/* * *************** Tt offer shortcode *************** */

function offers_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
                "image" => '',
                "title" => '',
                "subtitle" => '',
                "background_color" => '',
                "link_url" => ''
                    ), $atts));

    if (!empty($background_color)):
        $style_css .= 'style="background-color: ' . $background_color . ';"';
    else:
        $style_css = '';
    endif;

    $output = '';
     if (!empty($link_url)):
            $output .= '<a href="'.$link_url.'">';
        endif;
    $output .= '<div class="ttoffer ttoffers">';
    $output .= '<div class="ttoffer-image col-sm-5">';

        if (!empty($image))
            $output .= '<div class="ttoffer-image"><img src="'.$image.'" alt=""/></div>';
         $output .= '</div>';
        if (!empty($title))
            $output .= '<div class="ttoffer-content col-sm-7"><div class="title ttoffer-heading">' . $title . '</div>';
        if (!empty($subtitle))
            $output .= '<div class="ttoffer-subheading">' . $subtitle . '</div>';

    $output .= '<div class="description other-font ttoffer-desc">' . do_shortcode($content) . '</div>';

        if (!empty($link_url)):
            $output .= '</a>';
        endif;

    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode("tt_offers", "offers_shortcode");


function tt_product_type_shortcode_special($args) {
    $args = shortcode_atts(array(
        'title' => '',
        'subtitle' => '',
        'no_of_product' => '-1',
        'product_type' => '',
        'products_columns' => '1',
        'auto_slide' => 'true',
        'slide_speed' => '1000'
            ), $args);
    $output = "";
    global $woocommerce;
    $Products_type = $args['product_type'];
    $Products_columns = $args['products_columns'];
    $title = $args['title'];
    $subtitle = $args['subtitle'];
    $no_of_product = $args['no_of_product'];
    $auto_slide = $args['auto_slide'];
    $slide_speed = $args['slide_speed'];
    $id = rand();
    if ($Products_type == 'featured_products') {
         $meta_query = WC()->query->get_meta_query();
                    $tax_query[] = array(
                            'taxonomy' => 'product_visibility',
                            'field'    => 'name',
                            'terms'    => 'featured',
                            'operator' => 'IN',
                    );
                    $args = array(
                        'post_type' => 'product',
                        'post_status' => 'publish',
                        'posts_per_page' => $no_of_product,
                        'meta_query'  =>  $meta_query,
                        'tax_query'           => $tax_query,
                    );
    } elseif ($Products_type == 'best_selling_products') {
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => $no_of_product,
            'meta_key' => 'total_sales',
            'orderby' => 'meta_value_num',
        );
    } elseif ($Products_type == 'top_rated_products') {
        $args = array(
            'posts_per_page' => $no_of_product,
            'post_status' => 'publish',
            'post_type' => 'product',
            'meta_key' => '_wc_average_rating',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
        );
    } elseif ($Products_type == 'sale_products') {
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => $no_of_product,
            'meta_query' => array(
                'relation' => 'OR',
                array(// Simple products type
                    'key' => '_sale_price',
                    'value' => 0,
                    'compare' => '>',
                    'type' => 'numeric'
                ),
                array(// Variable products type
                    'key' => '_min_variation_sale_price',
                    'value' => 0,
                    'compare' => '>',
                    'type' => 'numeric'
                )
            )
        );
    } elseif ($Products_type == 'recent_products') {
        $args = array(
            'post_type' => 'product',
            'orderby' => 'date',
            'post_status' => 'publish',
            'posts_per_page' => $no_of_product
        );
    }
    $output .='<div class="col-xs-12 products_block_special_wrap">';
     $output .='<div class="row">';
    if (!empty($title)) {
        $output .='<div class="box-heading">';
        $output .='<h3>' . $title . '</h3>';
        $output .= '<div class="ttdesc">' . esc_html($subtitle) . '</div>';
        $output .='</div>';
    }
    $theme_layout = of_get_option('theme_layout');

    $output .= "<script type='text/javascript'>\n";
    $output .= "\t jQuery(document).ready(function () {\n";
    $output .= "\t var ttfeature = jQuery('.Products_wrap_special_" . $id . "');\n";
    $output .= "\t jQuery('.Products_wrap_special_" . $id . "').owlCarousel({\n";
    $output .= "\t items : ".$Products_columns.",\n";
    $output .= "\t itemsDesktop : [1200,".$Products_columns."],\n";
    $output .= "\t itemsDesktopSmall : [991,".$Products_columns."],\n";
    $output .= "\t itemsTablet: [767,1],\n";
    $output .= "\t itemsMobile : [640,1],\n";
    $output .= "\t slideSpeed : " . $slide_speed . ",\n";
    $output .= "\t navigation:true,pagination: false,\n";
    $output .= "\t autoPlay : " . $auto_slide . ",pagination: false,stopOnHover:true\n";
    $output .= "\t });\n";
    $output .= "\t if(jQuery('.Products_wrap_special_" . $id . " .owl-controls.clickable').css('display') == 'none'){ \n";
    $output .= "\t jQuery('.products_wrap_" . $id . " .customNavigation').hide();\n";
    $output .= "\t }else{ \n";
    $output .= "\t jQuery('.products_wrap_" . $id . " .customNavigation').show(); \n";
    $output .= "\t jQuery('.tt" . $Products_type . '_' . $id . "_next').click(function(){ \n";
    $output .= "\t ttfeature.trigger('owl.next');\n";
    $output .= "\t });\n";
    $output .= "\t jQuery('.tt" . $Products_type . '_' . $id . "_prev').click(function(){ \n";
    $output .= "\t ttfeature.trigger('owl.prev');\n";
    $output .= "\t }); } });\n";
    $output .= "</script>\n\n";
    $output .='<div class="block_content">';
    $output .='<div class="woocommerce products_block_special products_block products_wrap_' . $id . ' woo_product col-xs-12">';
    $output .='<div class="customNavigation">';
    $output .= '<a class="btn prev tt' . $Products_type . '_' . $id . '_prev">' . __('Prev', 'ttshortcode') . '</a>';
    $output .= '<a class="btn next tt' . $Products_type . '_' . $id . '_next"> ' . __('Next', 'ttshortcode') . '</a>';
    $output .= '</div>';
    $output .= '<ul class="tt-carousel Products_wrap_special_' . $id . ' product-carousel">';
    $cnt = 1;
    $loop1 = new WP_Query($args);
    $found_posts = $loop1->found_posts;
    while ($loop1->have_posts()) : $loop1->the_post();
        $content = return_get_template_part('woocommerce/content', 'product');
        $output .=$content;
    endwhile;
    if ($Products_type == 'top_rated_products') {
        add_filter('posts_clauses', array(WC()->query, 'order_by_rating_post_clauses'));
    }
    wp_reset_postdata();
    $output .= '</ul>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('tt_product_type_special', 'tt_product_type_shortcode_special');

// Add meta box for Sales Countdown
        function tt_get_meta($meta_name, $post) {
            if (!empty($meta_data)) {
                $meta_data = get_post_meta($post->ID, $meta_name, true);
            }
            if (!empty($meta_data))
                $save_meta = $meta_data;
            else
                $save_meta = '';
            return $save_meta;
        }
/* Add Metabox for products */
add_action('add_meta_boxes', 'tt_sales_countdown_box');

function tt_sales_countdown_box() {
    add_meta_box(
            'tt_sales_countdown_box', __('Sales Countdown Box', 'megashop'), 'tt_sales_countdown_box_content', 'product', 'side', 'default'
    );
}

function tt_sales_countdown_box_content($post) {
    //checkbox
    $tt_sales_yes = get_post_meta($post->ID, 'tt_sales_countdown', true);
    $checked = '';
    if ($tt_sales_yes == 'sales_yes') {
        $checked = 'checked';
    }
    echo '<input type="checkbox" id="tt_sales_countdown" name="tt_sales_countdown" ' . $checked . '  value="sales_yes"/>&nbsp;';
    echo '<label for="tt_sales_countdown">' . __('Add Product in Sales Countdown', 'megashop') . '</label>';

    // date
    $tt_sales_date = get_post_meta($post->ID, 'tt_end_sales_date', true);
    if (!empty($tt_sales_date)) {
        $tt_sales_date = date('Y/m/d', $tt_sales_date);
    } else {
        $tt_sales_date = '';
    }
    echo '<div class="label-wrap"><label for="tt_sales_countdown_date">' . __('End Date:', 'megashop') . '</label>';
    echo '<input type="text" id="tt_end_sales_date" name="tt_end_sales_date" value="' . $tt_sales_date . '"></div>';
}

add_action('save_post', 'tt_sales_countdown_box_save', 10, 3);

function tt_sales_countdown_box_save($post_id, $post, $update) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    if ("product" != $post->post_type)
        return $post_id;

    if (isset($_POST['tt_sales_countdown'])) {
        $tt_sales_countdown = $_POST['tt_sales_countdown'];
        update_post_meta($post_id, 'tt_sales_countdown', $tt_sales_countdown);
    } else {
        $tt_sales_countdown = tt_get_meta('tt_sales_countdown', $post_id);
        update_post_meta($post_id, 'tt_sales_countdown', $tt_sales_countdown);
    }
    if (isset($_POST['tt_sales_countdown'])) {
        $tt_sales_date = $_POST['tt_end_sales_date'];
        $tt_sales_date = strtotime($tt_sales_date);
        update_post_meta($post_id, 'tt_end_sales_date', $tt_sales_date);
    } else {
        $tt_sales_date = tt_get_meta('tt_end_sales_date', $post_id);
        update_post_meta($post_id, 'tt_end_sales_date', $tt_sales_date);
    }
}

add_action('woocommerce_single_product_summary', 'tt_sale_product', 30);
add_action('woocommerce_before_shop_loop_item', 'tt_sale_product', 15);
if (!function_exists('tt_sale_product')) {

    function tt_sale_product() {
        global $post;
        $post_id = $post->ID;
        $output = '';
        $now_time = time();
        $tt_sales_countdown = get_post_meta($post_id, 'tt_sales_countdown', true);
        $str_time = get_post_meta($post_id, 'tt_end_sales_date', true);
        if (!empty($tt_sales_countdown) && $tt_sales_countdown == "sales_yes" && !empty($str_time)) {
            $now_time = time();
            $sales_date = date('Y/m/d', $str_time);
            $id = rand();
            if ($str_time >= $now_time) {
                $output .= '<div class="count-down tt_time_wrap"><div class="countbox hastime" data-time="' . $sales_date . '"></div></div>';
                echo do_shortcode($output);
            }
        }
    }

}

function tt_ourteam_shortcode($args, $content = "") {
    $args = shortcode_atts(array(
        'title' => '',
        'subtitle' => '',
        'no_of_ourbrand' => '-1',
        'ourteam_columns' => '5',
		'no_of_post' => '10',
            ), $args);
    //ob_start();
    $ourteam_columns = $args['ourteam_columns'];
    $title = $args['title'];
    $subtitle = $args['subtitle'];
    $no_of_ourteam = $args['no_of_post'];
    $id = rand();
    $output = '';
    $r = new WP_Query(apply_filters('widget_posts_args', array(
                        'posts_per_page' => $no_of_ourteam,
                        'no_found_rows' => true,
                        'post_status' => 'publish',
                        'post_type' => 'ourteam',
                        'ignore_sticky_posts' => true
                    )));

    if ($r->have_posts()) :
        $output .='<div class="our_team col-xs-12 padding_0">';
        $output .= "<script type='text/javascript'>\n";
        $output .= "\t jQuery(document).ready(function () {\n";
        $output .= "\t jQuery('.ourteam_wrap_" . $id . "').owlCarousel({\n";
        $output .= "\t items : " . $ourteam_columns . ",\n";
        $output .= "\t itemsDesktop : [1200,5],\n";
        $output .= "\t itemsDesktopSmall : [1024,4],\n";
        $output .= "\t itemsTablet: [767,2],\n";
        $output .= "\t itemsMobile : [480,1],\n";
        $output .= "\t autoPlay : true,\n";
        $output .= "\t navigation:true,stopOnHover:true,\n";
        $output .= "\t pagination: false });\n";
        $output .= "\t if(jQuery('.our_team_" . $id . " .owl-controls.clickable').css('display') == 'none'){\n";
        $output .= "\t jQuery('.our_team_" . $id . " .customNavigation').hide(); }else{\n";
        $output .= "\t  jQuery('.our_team_" . $id . " .customNavigation').show();\n";
        $output .= "\t jQuery('.our_team_" . $id . " .ttteam_next').click(function(){\n";
        $output .= "\t jQuery('.ourteam_wrap_" . $id . "').trigger('owl.next'); });\n";
        $output .= "\t jQuery('.our_team_" . $id . " .ttteam_prev').click(function(){ jQuery('.ourteam_wrap_" . $id . "').trigger('owl.prev');\n";
        $output .= "\t  }); } });\n";
        $output .= "</script>\n\n";
        $output .='<div id="ttteamlogo" class="team-carousel our_team_' . $id . '">';
        if (!empty($title)) {
            $output .='<div class="box-heading">';
            $output .='<h3>' . $title . '</h3>';
            $output .= '<div class="ttdesc">' . esc_html($subtitle) . '</div>';
            $output .='</div>';
        }
        $output .='<div class="customNavigation">';
        $output .='<a class="btn prev ttteam_prev"></a>';
        $output .='<a class="btn next ttteam_next"></a>';
        $output .='</div>';
        $output .='<div class="ourteam_wrap_' . $id . ' team-carousel-wrap">';
        while ($r->have_posts()) : $r->the_post();
            if (has_post_thumbnail()) {
				$img = '<img src="' . get_the_post_thumbnail_url() . '" alt="' . get_the_title() . '"/>';
			}
			else{
				$img = '<i class="fa fa-user"></i>';
			}
                $ourteam_designation = get_post_meta(get_the_ID(), 'ourteam_designation', true);
				$facebook_link = get_post_meta(get_the_ID(), 'facebook_link', true);
				$twitter_link = get_post_meta(get_the_ID(), 'twitter_link', true);
				$Gplus_link = get_post_meta(get_the_ID(), 'Gplus_link', true);
				$instagram_link = get_post_meta(get_the_ID(), 'instagram_link', true);
                $output .='<div class="item">';

                $output .='<div class="ourteam_img_wrap">';
                $output .= $img;
				$output .='</div>';
				$output .= '<p class="ourteam_name">'.get_the_title().'</p>';
              	$output .= '<p>'.$ourteam_designation.'</p>';
			    $output .= '<div class="tt_shareicon_div small circle">';
			    if (!empty($facebook_link)) {
                    $output .= '<a class="tt_shareicon facebook" href="'.$facebook_link.'" target="_blank"><i class="fa fa-facebook"></i></a>';
                }
			   if (!empty($twitter_link)) {
                   $output .= '<a class="tt_shareicon twitter" href="'.$twitter_link.'" target="_blank"><i class="fa fa-twitter"></i></a>';
                }
				if (!empty($Gplus_link)) {
                   $output .= '<a class="tt_shareicon google-plus" href="'.$Gplus_link.'" target="_blank"><i class="fa fa-google-plus"></i></a>';
                }
				if (!empty($instagram_link)) {
                   $output .= '<a class="tt_shareicon instagram" href="'.$instagram_link.'" target="_blank"><i class="fa fa-instagram"></i></a>';
                }
				$output .= '</div>';

                $output .='</div>';

        endwhile;
        wp_reset_postdata();
        $output .='</div>';
        $output .='</div>';
        $output .='</div>';
    endif;
    return $output;
}

add_shortcode('tt_ourteam', 'tt_ourteam_shortcode');


function tt_portfolio_shortcode($args, $content = "") {
    $args = shortcode_atts(array(
        'title' => '',
        'subtitle' => '',
        'no_of_product' => '-1',
        'filters' => '',
        'portfolio_tabs_title' => '',
        'portfolios_columns' => '4',
		'projects' => '',
            ), $args);

    $subtitle = $args['subtitle'];
    $portfolio_tabs_title = explode(",", $args['portfolio_tabs_title']);
    $Portfolios_type = explode(",", $args['filters']);
    $portfolios_columns = $args['portfolios_columns'];
    $title = $args['title'];
    $no_of_portfolio = $args['projects'];
    $id = rand();
    $output = '';

    $output .= '<div class="TTPortfolio-Tab col-xs-12 padding_0">';
    $output .= '<div class="">';

    $output .= '<div class="">';
    if (!empty($title)) {
        $output .= '<div class="box-heading">';
        $output .= '<h3>' . esc_html($title) . '</h3>';
        $output .= '<div class="ttdesc">' . esc_html($subtitle) . '</div>';
        $output .= '</div>';
    }
    $output .= '<ul id="home-page-tabs" class="nav nav-tabs clearfix">';

    for ($i = 0; $i < count($Portfolios_type); $i++) {
	$portfolio_filter = get_term_by('id', $Portfolios_type[$i], 'portfolio_filter');
        if ($i == 0) {
            $clas = 'active';
        } else {
            $clas = '';
        }
        $output .= '<li class="' . $clas . '">';
         if(!empty($portfolio_filter)){
            $output .= '<a class="tt' . $portfolio_filter->slug . ' text-capitalize" data-toggle="tab" href="#' . $portfolio_filter->slug . '">' . $portfolio_filter->name . '</a>';
        }else{
            $output .= '<a class="tt' . $Portfolios_type[$i] . ' text-capitalize" data-toggle="tab" href="#' . $Portfolios_type[$i] . '">' . strtr($Portfolios_type[$i], array('_' => ' ', 'products' => '')) . '</a>';
        }
        $output .= '</li>';
    }
    $output .= '</ul>';
    $output .= '</div>';
    $output .= '<div class="tttab-content col-xs-12 padding_0">';
    $output .= '<div class="tab-content">';
    for ($i = 0; $i < count($Portfolios_type); $i++) {
	$portfolio_filter = get_term_by('id', $Portfolios_type[$i], 'portfolio_filter');
	if(!empty($portfolio_filter)){
		$Portfolios_type[$i] = $portfolio_filter->slug;
	}
        $output .= "<script type='text/javascript'>\n";
        $output .= "\t jQuery(document).ready(function () {\n";
        $output .= "\t var ttfeature = jQuery('.tt" . $Portfolios_type[$i] . "_" . $id . "');\n";
        $output .= "\t ttfeature.owlCarousel({\n";
        $output .= "\t items : " . $portfolios_columns . ",\n";
        $output .= "\t itemsDesktop : [1200,3],\n";
        $output .= "\t itemsDesktopSmall : [1024,3],\n";
        $output .= "\t itemsTablet: [767,2],\n";
		$output .= "\t pagination:false,\n";
        $output .= "\t itemsMobile : [480,1],stopOnHover:true\n";
        $output .= "\t });\n";
        $output .= "\t if(jQuery('.tt" . $Portfolios_type[$i] . "_" . $id . " .owl-controls.clickable').css('display') == 'none'){ \n";
        $output .= "\t jQuery('." . $Portfolios_type[$i] . "_" . $id . " .customNavigation').hide();\n";
        $output .= "\t }else{ \n";
        $output .= "\t jQuery('." . $Portfolios_type[$i] . "_" . $id . " .customNavigation').show(); \n";
        $output .= "\t jQuery('.tt" . $Portfolios_type[$i] . '_' . $id . "_next').click(function(){ \n";
        $output .= "\t ttfeature.trigger('owl.next');\n";
        $output .= "\t });\n";
        $output .= "\t jQuery('.tt" . $Portfolios_type[$i] . '_' . $id . "_prev').click(function(){ \n";
        $output .= "\t ttfeature.trigger('owl.prev');\n";
        $output .= "\t }); } });\n";
        $output .= "</script>\n\n";
        if ($i == 0) {
            $act = 'active';
        } else {
            $act = '';
        } $output .= '<div id="' . $Portfolios_type[$i] . '" class="' . $Portfolios_type[$i] . '_' . $id . ' portfolios-carousel tab-pane block portfolios_block clearfix  ' . $act . '">';
        $output .= '<div class="customNavigation">';
        $output .= '<a class="btn prev tt' . $Portfolios_type[$i] . '_' . $id . '_prev">' . __('Prev', 'ttshortcode') . '</a>';
        $output .= '<a class="btn next tt' . $Portfolios_type[$i] . '_' . $id . '_next"> ' . __('Next', 'ttshortcode') . '</a>';
        $output .= '</div>';
        $output .= '<div class="block_content">';
        $output .= '<ul class="tt' . $Portfolios_type[$i] . '_' . $id . '">';
        if ($Portfolios_type[$i] == 'all') {
            $args = array(
                'post_type' => 'portfolio',
                'orderby' => 'date',
				'no_found_rows' => true,
                'post_status' => 'publish',
                'posts_per_page' => $no_of_portfolio
            );
        }else{
			$args = array(
                'post_type' => 'portfolio',
				 'no_found_rows' => true,
                'orderby' => 'date',
                'post_status' => 'publish',
                'posts_per_page' => $no_of_portfolio,
				'tax_query'             => array(
					array(
						'taxonomy'      => 'portfolio_filter',
						'field' => 'slug',
						'terms'         => $Portfolios_type[$i],
						'operator'      => 'AND'
					)
					)
            );
		}

        $cnt = 1;
        $loop1 = new WP_Query($args);

        $found_posts = $loop1->found_posts;

        while ($loop1->have_posts()) : $loop1->the_post();

           $output .='<div class="item">';

                $output .='<div class="portfolio_img_wrap">';
                $output .= '<img src="' . get_the_post_thumbnail_url() . '" alt="' . get_the_title() . '"/>';;
				$output .='</div>';
				$output .= '<p class="portfolio_name">'.get_the_title().'</p>';

                $output .='</div>';
            $cnt++;
        endwhile;
        if(($found_posts > $portfolios_columns * 2) && ($no_of_portfolio > ($portfolios_columns * 2))) { if($cnt % 2 == 0) { $output.= '</li></ul>'; } }
        if ($Portfolios_type[$i] != 'top_rated_products') {
            remove_filter('posts_clauses', array(WC()->query, 'order_by_rating_post_clauses'));
        }
        $output .= '</ul>';
        $output .= '</div>';
        $output .= '</div>';
        wp_reset_postdata();
    }
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('tt_portfolio', 'tt_portfolio_shortcode');