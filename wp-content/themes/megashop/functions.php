<?php
/**
 * megashop functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage megashop
 * @since megashop 1.1.1
 */
/**
 * megashop only works in WordPress 4.4 or later.
 */
if (version_compare($GLOBALS['wp_version'], '4.4-alpha', '<')) {
    require get_template_directory() . '/inc/back-compat.php';
}

if (!function_exists('megashop_setup')) :

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     *
     * Create your own megashop_setup() function to override in a child theme.
     *
     * @since megashop 1.0
     */
    function megashop_setup() {
        /*
         * Make theme available for translation.
         * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/megashop
         * If you're building a theme based on megashop, use a find and replace
         * to change 'megashop' to the name of your theme in all the template files
         */
        load_theme_textdomain('megashop');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');


        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(1200, 9999);

        // This theme uses wp_nav_menu() in two locations.
        register_nav_menus(array(
            'primary' => esc_html__('Primary Menu', 'megashop'),
            'left_menu' => esc_html__('Left Menu', 'megashop'),
            'top_menu' => esc_html__('Top Menu', 'megashop')
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));
        add_theme_support('custom-background');
        add_theme_support('custom-header');
        remove_theme_support('custom-background');
        remove_theme_support('custom-header');
        /*
         * Enable support for Post Formats.
         *
         * See: https://codex.wordpress.org/Post_Formats
         */
        add_theme_support('post-formats', array(
            'aside',
            'image',
            'video',
            'quote',
            'link',
            'gallery',
            'status',
            'audio',
            'chat',
        ));


        add_theme_support('woocommerce');

        /*
         * This theme styles the visual editor to resemble the theme style,
         * specifically font, colors, icons, and column width.
         */
        add_editor_style(array('css/editor-style.css', megashop_fonts_url()));

        // Indicate widget sidebars can use selective refresh in the Customizer.
        add_theme_support('customize-selective-refresh-widgets');
    }

endif; // megashop_setup
add_action('after_setup_theme', 'megashop_setup');

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 * @since megashop 1.0
 */
if (!function_exists('megashop_content_width')) {

    function megashop_content_width() {
        $GLOBALS['content_width'] = apply_filters('megashop_content_width', 840);
    }

}
add_action('after_setup_theme', 'megashop_content_width', 0);

/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @since megashop 1.0
 */
if (!function_exists('megashop_widgets_init')) {

    function megashop_widgets_init() {

        register_sidebar(array(
            'name' => esc_html__('Left Sidebar', 'megashop'),
            'id' => 'sidebar-1',
            'description' => esc_html__('Add widgets here to appear in your sidebar.', 'megashop'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        ));

        register_sidebar(array(
            'name' => esc_html__('Right Sidebar', 'megashop'),
            'id' => 'right-sidebar',
            'description' => esc_html__('Appears at the right sidebar.', 'megashop'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Shop Page TopBar Filter Widget', 'megashop'),
            'id' => 'shop-filter',
            'description' => esc_html__('Add widgets here to appear in your Shop page Filter.', 'megashop'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        ));

        register_sidebar(array(
            'name' => esc_html__('Footer Column 1', 'megashop'),
            'id' => 'footer_column_1',
            'description' => esc_html__('Appears at the bottom of the footer column 1.', 'megashop'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Footer Column 2', 'megashop'),
            'id' => 'footer_column_2',
            'description' => esc_html__('Appears at the bottom of the footer column 2.', 'megashop'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Footer Column 3', 'megashop'),
            'id' => 'footer_column_3',
            'description' => esc_html__('Appears at the bottom of the footer column 3.', 'megashop'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Footer Column 4', 'megashop'),
            'id' => 'footer_column_4',
            'description' => esc_html__('Appears at the bottom of the footer column 4.', 'megashop'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Footer Column 5', 'megashop'),
            'id' => 'footer_column_5',
            'description' => esc_html__('Appears at the bottom of the footer column 5.', 'megashop'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Footer Column 6', 'megashop'),
            'id' => 'footer_column_6',
            'description' => esc_html__('Appears at the bottom of the footer column 6.', 'megashop'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Footer Widget For Payment Icon Display', 'megashop'),
            'id' => 'footer_payment_icon',
            'description' => esc_html__('Appears at the bottom of the footer Accepted Payment Method Display.', 'megashop'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        ));
    }

}
add_action('widgets_init', 'megashop_widgets_init');

if (!function_exists('megashop_fonts_url')) :

    /**
     * Register Google fonts for megashop.
     *
     * Create your own megashop_fonts_url() function to override in a child theme.
     *
     * @since megashop 1.0
     *
     * @return string Google fonts URL for the theme.
     */
    function megashop_fonts_url() {
        $fonts_url = '';
        $fonts = array();
        if ('off' !== _x('on', 'Poppins: on or off', 'megashop')) {
            $fonts[] = 'Poppins:400,500,600,700,400italic,700italic,900italic';
        }
        if ($fonts) {
            $fonts_url = add_query_arg(array(
                'family' => urlencode(implode('|', $fonts)),
                    ), 'https://fonts.googleapis.com/css');
        }
        return $fonts_url;
    }

endif;

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since megashop 1.0
 */
function megashop_javascript_detection() {
    echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}

add_action('wp_head', 'megashop_javascript_detection', 0);

if (!function_exists('megashop_scripts')) {

    /**
     * Enqueues scripts and styles.
     *
     * @since megashop 1.0
     */
    function megashop_scripts() {
        // Add custom fonts, used in the main stylesheet.
        wp_enqueue_style('megashop-fonts', megashop_fonts_url(), array(), null);

        // Add Genericons, used in the main stylesheet.
        wp_enqueue_style('genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.4.1');

        // Load the Internet Explorer specific stylesheet.
        wp_enqueue_style('megashop-ie', get_template_directory_uri() . '/css/ie.css', array('megashop-style'), '20160816');
        wp_style_add_data('megashop-ie', 'conditional', 'lt IE 10');

        // Load the html5 shiv.
        wp_enqueue_script('megashop-html5', get_template_directory_uri() . '/js/html5.js', array(), '3.7.3');
        wp_script_add_data('megashop-html5', 'conditional', 'lt IE 9');
        // Load the Internet Explorer 8 specific stylesheet.
        wp_enqueue_style('megashop-ie8', get_template_directory_uri() . '/css/ie8.css', array('megashop-style'), '20160816');
        wp_style_add_data('megashop-ie8', 'conditional', 'lt IE 9');

        // Load the Internet Explorer 7 specific stylesheet.
        wp_enqueue_style('megashop-ie7', get_template_directory_uri() . '/css/ie7.css', array('megashop-style'), '20160816');
        wp_style_add_data('megashop-ie7', 'conditional', 'lt IE 8');

        wp_enqueue_script('megashop-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20160816', true);



        wp_enqueue_script('masonry');
        wp_enqueue_script('jquery-form');
        if (class_exists('woocommerce')) {
            wp_enqueue_script('wc-add-to-cart-variation');
            if (is_shop() || is_product_taxonomy() || is_product() || is_account_page()) {
                $assets_path = str_replace(array('http:', 'https:'), '', WC()->plugin_url()) . '/assets/';
                wp_enqueue_style('select2', $assets_path . 'css/select2.css');
                wp_enqueue_script('select2', $assets_path . 'js/select2/select2.js');
            }
        }
        wp_enqueue_style('owl.carouselcss', get_template_directory_uri() . '/css/owl.carousel.css', '3.3.0');
        wp_enqueue_style('font-awesomecss', get_template_directory_uri() . '/css/font-awesome.min.css', '4.6.3');
        wp_enqueue_style('slickcss', get_template_directory_uri() . '/css/slick.css', '3.3.0');
        wp_enqueue_style('bootstrapcss', get_template_directory_uri() . '/css/bootstrap.css', '1.6.0');
        wp_enqueue_style('shortcodecss', get_template_directory_uri() . '/shortcode.css');
        wp_enqueue_style('woocommrcecss', get_template_directory_uri() . '/woocommerce.css');
        wp_enqueue_style('photoswipe-skin', get_template_directory_uri() . '/css/photoswipe/photoswipe-skin.css');
        wp_enqueue_style('photoswipe', get_template_directory_uri() . '/css/photoswipe/photoswipe.css');
        wp_enqueue_style('jquery.qtip', get_template_directory_uri() . '/css/jquery.qtip.css');
        wp_enqueue_style('lightboxcss', get_template_directory_uri() . '/css/lightbox.css');
        wp_enqueue_style('magnific-popup', get_template_directory_uri() . '/css/magnific-popup.css');

        // Theme stylesheet.
        wp_enqueue_style('megashop-style', get_stylesheet_uri());

        wp_enqueue_style('jquery.countdowncss', get_template_directory_uri() . '/css/jquery.countdown.css', array(), '3.3.0');
        wp_register_script('owl.carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', '', '3.3.0', true);
        wp_enqueue_script('owl.carousel');
        wp_register_script('easyResponsiveTabs', get_template_directory_uri() . '/js/easyResponsiveTabs.min.js', '', '3.3.0', true);
        wp_enqueue_script('easyResponsiveTabs');
        wp_register_script('jquery.lazyload.min', get_template_directory_uri() . '/js/jquery.lazyload.min.js', '', '1.0.0', true);
        wp_enqueue_script('jquery.lazyload.min');
        wp_register_script('tt-jquery-magnific-popup', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', '', '', true);
        wp_enqueue_script('tt-jquery-magnific-popup');
		
        wp_register_script('slick.minjs', get_template_directory_uri() . '/js/slick.min.js', '', '3.3.0', true);
        wp_enqueue_script('slick.minjs');
        wp_register_script('bootstrapjs', get_template_directory_uri() . '/js/bootstrap.min.js', '', '1.6.0', true);
        wp_enqueue_script('bootstrapjs');
        wp_register_script('jquery.elevatezoom.min', get_template_directory_uri() . '/js/jquery.elevatezoom.min.js', '', '', true);
        wp_enqueue_script('jquery.elevatezoom.min');
        wp_register_script('photoswipe.min.js', get_template_directory_uri() . '/js/photoswipe.min.js', '', '', true);
        wp_enqueue_script('photoswipe.min.js');
        wp_register_script('photoswipe-ui-default.min', get_template_directory_uri() . '/js/photoswipe-ui-default.min.js', '', '', true);
        wp_enqueue_script('photoswipe-ui-default.min');
        wp_register_script('tt-threesixty', get_template_directory_uri() . '/js/threesixty.min.js', '', '', true);
        wp_enqueue_script('tt-threesixty');
        wp_register_script('jquery.sticky-kit', get_template_directory_uri() . '/js/jquery.sticky-kit.min.js', '', '', true);
        wp_enqueue_script('jquery.sticky-kit');
        wp_register_script('isotope', get_template_directory_uri() . '/js/isotope.pkgd.min.js', '', '3.0.1', true);
        wp_enqueue_script('isotope');
        wp_register_script('easypiechart', get_template_directory_uri() . '/js/jquery.easypiechart.min.js', '', '', true);
        wp_enqueue_script('easypiechart');
        wp_register_script('waypoints', get_template_directory_uri() . '/js/waypoints.min.js', '', '', true);
        wp_enqueue_script('waypoints');
        wp_register_script('countUp', get_template_directory_uri() . '/js/countUp.min.js', '', '', true);
        wp_enqueue_script('countUp');
        wp_register_script('ttsearch', get_template_directory_uri() . '/js/ttsearch.min.js', array('jquery'), '', true);
        wp_enqueue_script('ttsearch');
        wp_enqueue_script('jquery.countdown', get_template_directory_uri() . '/js/jquery.countdown.min.js', '', '', true);
        wp_enqueue_script('quickview', get_template_directory_uri() . '/js/quickview.min.js', array('jquery'), '', true);
        wp_register_script('lightboxjs', get_template_directory_uri() . '/js/lightbox-2.6.min.js', array('jquery'), '', true);
        wp_enqueue_script('lightboxjs');
        wp_enqueue_script('scripts', get_template_directory_uri() . '/js/scripts.min.js', array('jquery'), '1.0', true);


        $layout = get_option('layout');
        if ($layout != '') {
            wp_enqueue_style($layout, get_template_directory_uri() . '/css/layouts/' . $layout . '.css', '', true);
        }

        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }

        if (is_singular() && wp_attachment_is_image()) {
            wp_enqueue_script('megashop-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.min.js', array('jquery'), '20160816');
        }

        wp_enqueue_script('megashop-script', get_template_directory_uri() . '/js/functions.min.js', array('jquery'), '20170416', true);
        $product_thumb_col = of_get_option('product_thumb_col');
        wp_localize_script('megashop-script', 'screenReaderText', array(
            'expand' => __('expand child menu', 'megashop'),
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('_tt_nonce'),
            'collapse' => __('collapse child menu', 'megashop'),
            'product_thumb' => esc_attr($product_thumb_col),
        ));
        $load_more_button = get_load_more_button();
        $image = '<div class="tt_products_loading">';
        $ajax_loader = of_get_option('ajax_loader');
        if (!empty($ajax_loader)) {
            $image .= '<img src="' . $ajax_loader . '"/>';
        } else {
            $image .= '<i class="fa fa-spinner"></i>';
        }
        $image .= '</div>';
        $load_more_end_text = of_get_option('load_more_end_text');
        $load_more_text = '<div class="tt_products"><div class="no_products">';
        if (!empty($load_more_end_text)) {
            $load_more_text .= $load_more_end_text;
        } else {
            $load_more_text .= __('No More Products', 'megashop');
        }
        $load_more_text .= '</div></div>';

        if (isset($_GET['shop_infinite_load']) && $_GET['shop_infinite_load'] == 'infinity_scroll') {
            $infinte_load = 'infinity_scroll';
        } elseif (isset($_GET['shop_infinite_load']) && $_GET['shop_infinite_load'] == 'more_button') {
            $infinte_load = 'more_button';
        } else {
            $infinte_load = of_get_option('shop_infinite_load');
        }
        if ($infinte_load != 'disable') {
            wp_register_script('tt-shop-infload', get_template_directory_uri() . '/js/tt-shop-infload.min.js', array('jquery'), '', true);
            wp_enqueue_script('tt-shop-infload');

            wp_localize_script('scripts', 'the_tt_js_data', array(
                'type' => esc_attr($infinte_load),
                'use_mobile' => '',
                'mobile_type' => 'more_button',
                'mobile_width' => '767',
                'load_image' => $image,
                'buffer' => '30',
                'load_img_class' => '.tt_products_loading',
                'load_more' => $load_more_button,
                'lazy_load' => false,
                'javascript' => '',
                'end_text' => $load_more_text,
                'products' => '#shop_product_wrap ul.products.tt-products',
                'item' => 'li.product',
                'pagination' => '.woocommerce-pagination',
                'next_page' => '.woocommerce-pagination .next.page-numbers',
            ));
        }
    }

}
add_action('wp_enqueue_scripts', 'megashop_scripts');

if (!function_exists('megashop_adminscripts')) {

    function megashop_adminscripts() {
        wp_enqueue_script('adminjs', get_template_directory_uri() . '/admin/js/admin_script.js', array('jquery'), '');
        wp_enqueue_style('admincss', get_template_directory_uri() . '/admin/css/admin_css.css', '', '');
        $theme_layout = get_option('theme_layout');

        wp_localize_script('adminjs', 'js_strings', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'select_demo_notice' => __('select demo', 'megashop'),
            'theme_layout' => esc_attr($theme_layout),
        ));
        wp_enqueue_script('jquery-ui-datepicker', array('jquery'));

        wp_enqueue_style('jquery-ui-datepicker');

        wp_enqueue_script('jquery-ui-dialog');
        wp_enqueue_style('font-awesomecss', get_template_directory_uri() . '/css/font-awesome.min.css', '', '4.6.3');
    }

}
add_action('admin_enqueue_scripts', 'megashop_adminscripts');

/*
 * @desc For auto install
 */
if (is_admin()) {
    load_template(get_template_directory() . '/inc/auto-install/auto_install_data.php');
    add_action('wp_ajax_auto_install_layout', 'auto_install_layout');
    add_action('wp_ajax_nopriv_auto_install_layout', 'auto_install_layout');
    add_action('wp_ajax_remove_auto_update', 'remove_auto_update');
    add_action('wp_ajax_nopriv_remove_auto_update', 'remove_auto_update');
}

function megashop_theme_layout() {
    $theme_layout = of_get_option('theme_layout');
    if (get_option('theme_layout') !== false) {
        // The option already exists, so we just update it.
        update_option('theme_layout', $theme_layout);
    } else {

        // The option hasn't been added yet. We'll add it with $autoload set to 'no'.
        $deprecated = null;
        $autoload = 'no';
        add_option('theme_layout', $theme_layout, $deprecated, $autoload);
    }
}

add_action('init', 'megashop_theme_layout');
update_option('default_comment_status', 'closed');

/**
 * Adds custom classes to the array of body classes.
 *
 * @since megashop 1.0
 *
 * @param array $classes Classes for the body element.
 * @return array (Maybe) filtered body classes.
 */
function megashop_body_classes($classes) {
    // Adds a class of group-blog to sites with more than 1 published author.
    if (is_multi_author()) {
        $classes[] = 'group-blog';
    }
    $theme_layout = of_get_option('theme_layout');
    $shoppage_column = of_get_option('shoppage_column');
    $box_layout = of_get_option('box_layout');
    $classes[] = $theme_layout;
    $classes[] = $shoppage_column;
    $classes[] = of_get_option('single_image_slider');
    $layout = get_option('layout');
    $classes[] = $layout;
    $shop_infinite_load = of_get_option('shop_infinite_load');
    if ($shop_infinite_load != 'disable') {
        $classes[] = 'infinite_load';
    }
    if ($box_layout == 1) {
        $class = "box_layout_wrap";
    } else {
        $class = "";
    }
    $classes[] = $class;
    // Adds a class of no-sidebar to sites without active sidebar.
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }

    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    return $classes;
}

add_filter('body_class', 'megashop_body_classes');

/**
 * Converts a HEX value to RGB.
 *
 * @since megashop 1.0
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 *               HEX code, empty array otherwise.
 */
function megashop_hex2rgb($color) {
    $color = trim($color, '#');

    if (strlen($color) === 3) {
        $r = hexdec(substr($color, 0, 1) . substr($color, 0, 1));
        $g = hexdec(substr($color, 1, 1) . substr($color, 1, 1));
        $b = hexdec(substr($color, 2, 1) . substr($color, 2, 1));
    } else if (strlen($color) === 6) {
        $r = hexdec(substr($color, 0, 2));
        $g = hexdec(substr($color, 2, 2));
        $b = hexdec(substr($color, 4, 2));
    } else {
        return array();
    }

    return array('red' => $r, 'green' => $g, 'blue' => $b);
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images
 *
 * @since megashop 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function megashop_content_image_sizes_attr($sizes, $size) {
    $width = $size[0];

    840 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';

    if ('page' === get_post_type()) {
        840 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
    } else {
        840 > $width && 600 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
        600 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
    }

    return $sizes;
}

add_filter('wp_calculate_image_sizes', 'megashop_content_image_sizes_attr', 10, 2);

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails
 *
 * @since megashop 1.0
 *
 * @param array $attr Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function megashop_post_thumbnail_sizes_attr($attr, $attachment, $size) {
    if ('post-thumbnail' === $size) {
        is_active_sidebar('sidebar-1') && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 60vw, (max-width: 1362px) 62vw, 840px';
        !is_active_sidebar('sidebar-1') && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px';
    }
    return $attr;
}

add_filter('wp_get_attachment_image_attributes', 'megashop_post_thumbnail_sizes_attr', 10, 3);

/**
 * Modifies tag cloud widget arguments to have all tags in the widget same font size.
 *
 * @since megashop 1.1
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array A new modified arguments.
 */
function megashop_widget_tag_cloud_args($args) {
    $args['largest'] = 1;
    $args['smallest'] = 1;
    $args['unit'] = 'em';
    return $args;
}

add_filter('widget_tag_cloud_args', 'megashop_widget_tag_cloud_args');

if (!function_exists('megashop_allowed_html')) :

    function megashop_allowed_html() {
        $allowed_html = array(
            'span' => array(
                'class' => array(),
                'style' => array(),
            ),
            'div' => array(
                'class' => array(),
                'style' => array(),
            ),
            'a' => array(
                'href' => array(),
            ),
            'i' => array(
                'class' => array(),
            ),
        );
        return $allowed_html;
    }

endif;

// Changing excerpt more
function new_excerpt_more($more) {
    global $post;
    $more = esc_html__('Read More', 'megashop');
    return '...<div class="continue_read"><a class="read-more" href="' . get_permalink($post->ID) . '">' . $more . '</a></div>';
}

add_filter('excerpt_more', 'new_excerpt_more');

/* ------------------------------------------------------------------------ */
/* Misc
  /* ------------------------------------------------------------------------ */
// Post Thumbnail Sizes
if (function_exists('add_image_size'))
    add_theme_support('post-thumbnails');


if (class_exists('woocommerce')) {
    $size = wc_get_image_size('shop_catalog');
    $placeholder_width = $size['width'];
    add_image_size('shop-masonry', $placeholder_width);
}
add_image_size('blog', 1000, 563, true);    // Standard Blog Image
add_image_size('latest-blog', 370, 240, true);
add_image_size('mini', 80, 80, true);     // used for widget thumbnail
add_image_size('portfolio', 600, 400, true);   // also for blog-medium
add_image_size('regular', 500, 500, true);
add_image_size('wide', 1000, 500, true);
add_image_size('tall', 500, 1000, true);
add_image_size('widetall', 1000, 1000, true);
add_image_size('tt-latest-blog', 870, 564);
add_image_size('tt-latest-blog-list', 200, 180);
add_image_size('tt-latest-blog-masonry', 300);


/* portfolio files */
require_once get_template_directory() . '/inc/meta-boxes.php';
require get_template_directory() . '/inc/meta-box-tabs.php'; // Include Tabs Extension




/* Add Breadcrumb file code */
get_template_part('inc/tt', 'breadcrumb');

function wpse_129259_enqueue_dynamic_css() {
    // Include dynamic CSS file
    require get_template_directory() . '/inc/style.php';
    ?>
    <script>
        var ajax_search_loader = '<?php echo esc_url(get_template_directory_uri()); ?>/images/ajax-loader.gif';
    </script>
    <?php
}

add_action('wp_head', 'wpse_129259_enqueue_dynamic_css');

/* add shortcode in admin side file */
get_template_part('admin/includes/admin', 'shortcode');

/* add New Widget area file */
get_template_part('inc/tt', 'newaddwidgetarea');

/* post formats file */
get_template_part('inc/post', 'formats');

/* add theme Function file */
get_template_part('inc/theme', 'functions');


define('TT_FRAMEWORK_TGMPA_DIRECTORY', get_template_directory() . '/inc/tgmpa/');
require_once TT_FRAMEWORK_TGMPA_DIRECTORY . 'register-plugins.php';

/*
 * Loads the Options Panel
 *
 */
define('OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/admin/');
require_once get_template_directory() . '/admin/options-framework.php';
// Loads options.php from child or parent theme
$optionsfile = locate_template('options.php');
load_template($optionsfile);

/* mega menu theme settings */

require get_template_directory() . '/inc/mega-menu/nav-menus.php';
require get_template_directory() . '/inc/menus.php';

/**
 * Initialize instances
 *
 * Priority 20 to make sure it run after plugin's callback, such as register custom post types...
 */
function templatetrip_init() {
    if (is_admin()) {
        new TT_Mega_Menu_Edit();
    }
}

add_action('init', 'templatetrip_init', 50);

if (!function_exists('TT_parse_args')) :

    /**
     * Recursive merge user defined arguments into defaults array.
     *
     * @param array $args
     * @param array $default
     *
     * @return array
     */
    function TT_parse_args($args, $default = array()) {
        $args = (array) $args;
        $result = $default;

        foreach ($args as $key => $value) {
            if (is_array($value) && isset($result[$key])) {
                $result[$key] = TT_parse_args($value, $result[$key]);
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }

endif;

if (!function_exists('TT_get_mega_menu_setting_default')) {

    /**
     * Get the default mega menu settings of a menu item
     *
     * @return array
     */
    function TT_get_mega_menu_setting_default() {
        return apply_filters(
                'TT_mega_menu_setting_default', array(
            'mega' => false,
            'megaColumn' => '4',
            'menuColumn' => '',
            'icon' => '',
            'iconimage' => '',
            'hide_text' => false,
            'disable_link' => false,
            'content' => '',
            'width' => '',
            'border' => array(
                'left' => 0,
            ),
            'background' => array(
                'image' => '',
                'color' => '',
                'attachment' => 'scroll',
                'size' => '',
                'repeat' => 'no-repeat',
                'position' => array(
                    'x' => 'left',
                    'y' => 'top',
                    'custom' => array(
                        'x' => '',
                        'y' => '',
                    ),
                ),
            ),
                )
        );
    }

}


add_action('wp', 'tt_template_hooks', 60);
if (!function_exists('tt_template_hooks')) {

    function tt_template_hooks() {
        if (of_get_option('single_layout') == 'fixed' || of_get_option('single_layout') == 'image_center') {
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
        } else {
            add_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
            add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
            add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
        }
    }

}
if (!function_exists('tt_product_bundle_tab')) {

    function tt_product_bundle_tab() {
        get_template_part('inc/tt', 'bundle_product');
    }

}

/* Check if current request is made via AJAX */

function get_load_more_button() {
    $load_more = of_get_option('load_more');
    if (empty($load_more)) {
        $load_more = esc_html__('Load More', 'megashop');
    }
    $button = '<div class="tt_load_more_button">';
    $button .= '<a class="tt_button" href="#load_next_page">' . esc_attr($load_more) . '</a>';
    $button .= '</div>';
    return $button;
}

add_filter( 'woocommerce_post_class', 'remove_post_class', 21, 3 ); //woocommerce use priority 20, so if you want to do something after they finish be more lazy
function remove_post_class( $classes ) {
    if ( 'product' == get_post_type() ) {
        $classes = array_diff( $classes, array( 'last','first' ) );
    }
    return $classes;
}
