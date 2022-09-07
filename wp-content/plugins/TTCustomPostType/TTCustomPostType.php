<?php
/*
  Plugin Name: TemplateTrip Custom Post Type
  Plugin URI: http://www.templatetrip.com
  Description: TemplateTrip Custom Taxonomy(Testimonials,OurBrand) for templatetrip wordpress themes.
  Version: 1.0
  Author: TemplateTrip
  Author URI: http://www.templatetrip.com
* Text Domain: ttposttype
 */

add_action( 'init', 'ttposttype_load_textdomain' );
/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
function ttposttype_load_textdomain() {
  load_plugin_textdomain( 'ttposttype', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}

add_filter( 'init', 'testimonial_init' );
/**
 * Register a Testimonial post type.
 *
 */
function testimonial_init() {
	$labels = array(
		'name'               => _x( 'Testimonials', 'post type general name', 'ttposttype' ),
		'singular_name'      => _x( 'Testimonial', 'post type singular name', 'ttposttype' ),
		'menu_name'          => _x( 'Testimonials', 'admin menu', 'ttposttype' ),
		'name_admin_bar'     => _x( 'Testimonial', 'add new on admin bar', 'ttposttype' ),
		'add_new'            => _x( 'Add New', 'testimonial', 'ttposttype' ),
		'add_new_item'       => __( 'Add New Testimonial', 'ttposttype' ),
		'new_item'           => __( 'New Testimonial', 'ttposttype' ),
		'edit_item'          => __( 'Edit Testimonial', 'ttposttype' ),
		'view_item'          => __( 'View Testimonial', 'ttposttype' ),
		'all_items'          => __( 'All Testimonials', 'ttposttype' ),
		'search_items'       => __( 'Search Testimonials', 'ttposttype' ),
		'parent_item_colon'  => __( 'Parent Testimonials:', 'ttposttype' ),
		'not_found'          => __( 'No testimonials found.', 'ttposttype' ),
		'not_found_in_trash' => __( 'No testimonials found in Trash.', 'ttposttype' )
	);

	$args = array(
		'labels'             => $labels,
                'description'        => __( 'Description.', 'ttposttype' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'testimonial' ),
		'capability_type'    => 'post',
		'menu_icon'          =>'dashicons-format-status',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail' )
	);

	register_post_type( 'testimonial', $args );
}
function add_testimonial_meta_box()
{
    add_meta_box("testimonial-meta-box", esc_html__( "Testimonial designation" , 'ttposttype' ), "testimonial_meta_box_markup", "testimonial", "side", "high", null);
}

add_action("add_meta_boxes", "add_testimonial_meta_box");
function testimonial_meta_box_markup($object)
{
    wp_nonce_field(basename(__FILE__), "testimonial-meta-box-nonce");
    $test_designition = get_post_meta($object->ID, "testimonial_designation", true);
    ?>
        <div>
            <label for="meta-box-text"><?php esc_html_e('designation','ttposttype') ?></label>
			<br>
            <input name="testimonial_designation" type="text" value="<?php echo esc_html($test_designition); ?>">

            
        </div>
    <?php  
}
function save_testimoinal_meta_box($post_id, $post, $update)
{
    if (!isset($_POST["testimonial-meta-box-nonce"]) || !wp_verify_nonce($_POST["testimonial-meta-box-nonce"], basename(__FILE__)))
        return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $slug = "testimonial";
    if($slug != $post->post_type)
        return $post_id;

    $meta_box_text_value = "";

    if(isset($_POST["testimonial_designation"]))
    {
        $meta_box_text_value = esc_html($_POST["testimonial_designation"]);
    }   
    update_post_meta($post_id, "testimonial_designation", $meta_box_text_value);
    
}

add_action("save_post", "save_testimoinal_meta_box", 10, 3);

add_filter( 'manage_testimonial_posts_columns', 'set_custom_edit_testimonial_columns' );
add_action( 'manage_testimonial_posts_custom_column' , 'custom_testimonial_column', 10, 2 );

function set_custom_edit_testimonial_columns($columns) {
$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => esc_html__( 'Title', 'ttposttype' ),
		'thumbnail' => esc_html__( 'Thumbnail', 'ttposttype' ),
		'designation' => esc_html__( 'designation', 'ttposttype' ),
		'author' => esc_html__( 'Author', 'ttposttype' ),
		'date' => esc_html__( 'Date', 'ttposttype' )
	);
    return $columns;
}

function custom_testimonial_column( $column, $post_id ) {
    switch ( $column ) {

        /*case 'thumbnail' :
            if ( has_post_thumbnail() )
                echo get_the_post_thumbnail($post_id);
            break;*/

        case 'designation' :
            echo get_post_meta( $post_id , 'testimonial_designation' , true ); 
            break;
			/* Just break out of the switch statement for everything else. */
		default :
			break;

    }
}

add_filter( 'init', 'ourbrand_init' );
/**
 * Register a our brand post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function ourbrand_init() {
	$labels = array(
		'name'               => _x( 'Our Brands', 'post type general name', 'ttposttype' ),
		'singular_name'      => _x( 'Our Brand', 'post type singular name', 'ttposttype' ),
		'menu_name'          => _x( 'Our Brands', 'admin menu', 'ttposttype' ),
		'name_admin_bar'     => _x( 'Our Brand', 'add new on admin bar', 'ttposttype' ),
		'add_new'            => _x( 'Add New', 'Brand', 'ttposttype' ),
		'add_new_item'       => __( 'Add New Brand', 'ttposttype' ),
		'new_item'           => __( 'New Brand', 'ttposttype' ),
		'edit_item'          => __( 'Edit Brand', 'ttposttype' ),
		'view_item'          => __( 'View Brand', 'ttposttype' ),
		'all_items'          => __( 'All Our Brands', 'ttposttype' ),
		'search_items'       => __( 'Search Our Brands', 'ttposttype' ),
		'parent_item_colon'  => __( 'Parent Our Brands:', 'ttposttype' ),
		'not_found'          => __( 'No Our Brands found.', 'ttposttype' ),
		'not_found_in_trash' => __( 'No Our Brands found in Trash.', 'ttposttype' )
	);

	$args = array(
		'labels'             => $labels,
                'description'        => __( 'Description.', 'ttposttype' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'ourbrand' ),
		'capability_type'    => 'post',
		'menu_icon'          =>'dashicons-groups',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title','thumbnail','author')
	);

	register_post_type( 'ourbrand', $args );
}

add_action('do_meta_boxes', 'modernshop_move_meta_box');

function modernshop_move_meta_box(){
    remove_meta_box( 'postimagediv', 'ourbrand', 'side' );
    add_meta_box('postimagediv', esc_html__('Featured Image','ttposttype'), 'post_thumbnail_meta_box', 'ourbrand', 'normal', 'high');
}
function add_ourbrand_meta_box()
{
    add_meta_box("ourbrand-meta-box", esc_html__(" Our Brands Url", 'ttposttype'), "ourbrand_meta_box_markup", "ourbrand", "normal", "high", null);
}

add_action("add_meta_boxes", "add_ourbrand_meta_box");
function ourbrand_meta_box_markup($object)
{
    wp_nonce_field(basename(__FILE__), "ourbrand-meta-box-nonce");

    ?>
        <div>
            <label for="meta-box-text"><?php esc_html_e('Brand Url','ttposttype'); ?></label>
			<br>
            <input name="brand_url" type="text" value="<?php echo get_post_meta($object->ID, "brand_url", true); ?>">
            
        </div>
    <?php  
}
function save_ourbrand_meta_box($post_id, $post, $update)
{
    if (!isset($_POST["ourbrand-meta-box-nonce"]) || !wp_verify_nonce($_POST["ourbrand-meta-box-nonce"], basename(__FILE__)))
        return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $slug = "ourbrand";
    if($slug != $post->post_type)
        return $post_id;

    $meta_box_text_value = "";

    if(isset($_POST["brand_url"]))
    {
        $meta_box_text_value = esc_url($_POST["brand_url"]);
    }   
    update_post_meta($post_id, "brand_url", $meta_box_text_value);
}

add_action("save_post", "save_ourbrand_meta_box", 10, 3);

add_filter( 'manage_ourbrand_posts_columns', 'set_custom_edit_ourbrand_columns' );
add_action( 'manage_ourbrand_posts_custom_column' , 'custom_ourbrand_column', 10, 2 );

function set_custom_edit_ourbrand_columns($columns) {
$columns = array(
		'cb' => '<input type="checkbox" />',                
		'thumbnail' => esc_html__( 'Thumbnail', 'ttposttype' ),
                'title' => esc_html__( 'Title', 'ttposttype' ),
		'brand_url' => esc_html__( 'Brand Url', 'ttposttype' ),
		'author' => esc_html__( 'Author', 'ttposttype' ),
		'date' => esc_html__( 'Date', 'ttposttype' )
	);
    return $columns;
}

function custom_ourbrand_column( $column, $post_id ) {
    switch ( $column ) {

       /* case 'thumbnail' :
            if ( has_post_thumbnail() )
                echo get_the_post_thumbnail($post_id);
            break; */

        case 'brand_url' :
            echo get_post_meta( $post_id , 'brand_url' , true ); 
            break;
			/* Just break out of the switch statement for everything else. */
		default :
			break;

    }
}


add_filter( 'init', 'our_team_init' );
/**
 * Register a Our Team post type.
 *
 */
function our_team_init() {
	$labels = array(
		'name'               => _x( 'Our Team', 'post type general name', 'ttposttype' ),
		'singular_name'      => _x( 'Our Team', 'post type singular name', 'ttposttype' ),
		'menu_name'          => _x( 'Our Teams', 'admin menu', 'ttposttype' ),
		'name_admin_bar'     => _x( 'Team Member', 'add new on admin bar', 'ttposttype' ),
		'add_new'            => _x( 'Add New', 'Team Member', 'ttposttype' ),
		'add_new_item'       => __( 'Add New Team Member', 'ttposttype' ),
		'new_item'           => __( 'New Team Member', 'ttposttype' ),
		'edit_item'          => __( 'Edit Team Member', 'ttposttype' ),
		'view_item'          => __( 'View Team Member', 'ttposttype' ),
		'all_items'          => __( 'All Our Team Members', 'ttposttype' ),
		'search_items'       => __( 'Search Testimonials', 'ttposttype' ),
		'parent_item_colon'  => __( 'Parent Testimonials:', 'ttposttype' ),
		'not_found'          => __( 'No team members found.', 'ttposttype' ),
		'not_found_in_trash' => __( 'No team members found in Trash.', 'ttposttype' )
	);

	$args = array(
		'labels'             => $labels,
                'description'        => __( 'Description.', 'ttposttype' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'ourteam' ),
		'capability_type'    => 'post',
		'menu_icon'          =>'dashicons-businessman',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail' )
	);

	register_post_type( 'ourteam', $args );
}
function add_ourteam_meta_box()
{
    add_meta_box("ourteam-meta-box", esc_html__( "Our Team Details" , 'ttposttype' ), "ourteam_meta_box_markup", "ourteam", "advanced", "high", null);
}

add_action("add_meta_boxes", "add_ourteam_meta_box");
function ourteam_meta_box_markup($object)
{
    wp_nonce_field(basename(__FILE__), "ourteam-meta-box-nonce");
    $test_designition = get_post_meta($object->ID, "ourteam_designation", true);
    $facebook_link = get_post_meta($object->ID, "facebook_link", true);
    $twitter_link = get_post_meta($object->ID, "twitter_link", true);
    $Gplus_link = get_post_meta($object->ID, "Gplus_link", true);
    $instagram_link = get_post_meta($object->ID, "instagram_link", true);
    ?>
        <div class="our_team_detail">
            <label for="meta-box-text"><?php esc_html_e('Designation','ttposttype') ?></label>
            <br>
            <input name="ourteam_designation" type="text" value="<?php echo esc_html($test_designition); ?>">
            <br>
            <label for="meta-box-text"><?php esc_html_e('Facebook Link','ttposttype') ?></label>
            <br>
            <input name="facebook_link" type="text" value="<?php echo esc_url($facebook_link); ?>">
            <br>
            <label for="meta-box-text"><?php esc_html_e('Twitter Link','ttposttype') ?></label>
            <br>
            <input name="twitter_link" type="text" value="<?php echo esc_url($twitter_link); ?>">
            <br>
            <label for="meta-box-text"><?php esc_html_e('Google Plus Link','ttposttype') ?></label>
            <br>
            <input name="Gplus_link" type="text" value="<?php echo esc_url($Gplus_link); ?>">
            <br>
            <label for="meta-box-text"><?php esc_html_e('Instagram Link','ttposttype') ?></label>
            <br>
            <input name="instagram_link" type="text" value="<?php echo esc_url($instagram_link); ?>">
            
        </div>
    <?php  
}
function save_ourteam_meta_box($post_id, $post, $update)
{
    if (!isset($_POST["ourteam-meta-box-nonce"]) || !wp_verify_nonce($_POST["ourteam-meta-box-nonce"], basename(__FILE__)))
        return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $slug = "ourteam";
    if($slug != $post->post_type)
        return $post_id;

    $meta_box_text_value = "";

    if(isset($_POST["ourteam_designation"]))
    {
        $meta_box_text_value = esc_html($_POST["ourteam_designation"]);
    }   
    update_post_meta($post_id, "ourteam_designation", $meta_box_text_value);
    
    if(isset($_POST["facebook_link"]))
    {
        $facebook_link = esc_html($_POST["facebook_link"]);
    }else{
        $facebook_link = '#';
    } 
    update_post_meta($post_id, "facebook_link", $facebook_link);  
    if(isset($_POST["twitter_link"]))
    {
        $twitter_link = esc_html($_POST["twitter_link"]);
    }else{
        $twitter_link = '#';
    }     
    update_post_meta($post_id, "twitter_link", $twitter_link);
    if(isset($_POST["Gplus_link"]))
    {
        $Gplus_link = esc_html($_POST["Gplus_link"]);
    }else{
        $Gplus_link = '#';
    }     
    update_post_meta($post_id, "Gplus_link", $Gplus_link);
    if(isset($_POST["instagram_link"]))
    {
        $instagram_link = esc_html($_POST["instagram_link"]);
    } else{
        $instagram_link = '#';
    }  
    update_post_meta($post_id, "instagram_link", $instagram_link);
    
}

add_action("save_post", "save_ourteam_meta_box", 10, 3);

add_filter( 'manage_ourteam_posts_columns', 'set_custom_edit_ourteam_columns' );
add_action( 'manage_ourteam_posts_custom_column' , 'custom_ourteam_column', 10, 2 );

function set_custom_edit_ourteam_columns($columns) {
$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => esc_html__( 'Title', 'ttposttype' ),
		'thumbnail' => esc_html__( 'Thumbnail', 'ttposttype' ),
		'designation' => esc_html__( 'designation', 'ttposttype' ),
		'author' => esc_html__( 'Author', 'ttposttype' ),
		'date' => esc_html__( 'Date', 'ttposttype' )
	);
    return $columns;
}

function custom_ourteam_column( $column, $post_id ) {
    switch ( $column ) {

        /*case 'thumbnail' :
            if ( has_post_thumbnail() )
                echo get_the_post_thumbnail($post_id);
            break;*/

        case 'designation' :
            echo get_post_meta( $post_id , 'ourteam_designation' , true ); 
            break;
			/* Just break out of the switch statement for everything else. */
		default :
			break;

    }
}


/**
 * Media uploader code changed in Options Framework 1.5
 * and no longer uses a custom post type.
 *
 * Function removes the post type 'optionsframework'
 * Media attached to the post type remains in the media library
 *
 * @access      public
 * @since       1.5
 * @return      void
 */
function optionsframework_update_to_version_1_5() {
    register_post_type('modernshop-framework', array(
        'labels' => array(
            'name' => esc_html__('Theme Options Media', 'ttposttype'),
        ),
        'show_ui' => false,
        'rewrite' => false,
        'show_in_nav_menus' => false,
        'public' => false
    ));

    // Get all the optionsframework post type
    $query = new WP_Query(array(
        'post_type' => 'modernshop-framework',
        'numberposts' => -1,
    ));

    while ($query->have_posts()) :
        $query->the_post();
        $attachments = get_children(array(
            'post_parent' => the_ID(),
            'post_type' => 'attachment'
                )
        );
        if (!empty($attachments)) {
            // Unassign each of the attachments from the post
            foreach ($attachments as $attachment) {
                wp_update_post(array(
                    'ID' => $attachment->ID,
                    'post_parent' => 0
                        )
                );
            }
        }
        wp_delete_post(the_ID(), true);
    endwhile;

    wp_reset_postdata();
}
add_action( 'init', 'optionsframework_update_to_version_1_5', 21 );


/* Define the custom box */
 
add_action( 'add_meta_boxes', 'add_sidebar_metabox' );
add_action( 'save_post', 'save_sidebar_postdata' );
 
/* Adds a box to the side column on the Post and Page edit screens */
function add_sidebar_metabox()
{
    add_meta_box( 
        'custom_sidebar',
        __( 'Custom Sidebar 1', 'megashop' ),
        'custom_sidebar_callback',
        'post',
        'side'
    );
    add_meta_box( 
        'custom_sidebar',
        __( 'Custom Sidebar 1', 'megashop' ),
        'custom_sidebar_callback',
        'page',
        'side'
    );
}
/* Prints the box content */
function custom_sidebar_callback( $post )
{
    global $wp_registered_sidebars;
     
    $custom = get_post_custom($post->ID);
     
    if(isset($custom['custom_sidebar_1']))
        $val = $custom['custom_sidebar_1'][0];
    else
        $val = "default";
 
    // Use nonce for verification
    wp_nonce_field( 'custom_sidebar_nonce_feild_1', 'custom_sidebar_nonce' );
 
    // The actual fields for data entry
    $output = '<p><label for="custom_sidebar_new_field">'.__("Choose a sidebar to display", 'megashop' ).'</label></p>';
    $output .= "<select name='custom_sidebar_1'>";
 
    // Add a default option
    $output .= "<option";
    if($val == "default")
        $output .= " selected='selected'";
    $output .= " value='default'>".__('default', 'megashop')."</option>";
     
    // Fill the select element with all registered sidebars
    foreach($wp_registered_sidebars as $sidebar_id => $sidebar)
    {
        $output .= "<option";
        if($sidebar_id == $val)
            $output .= " selected='selected'";
        $output .= " value='".$sidebar_id."'>".$sidebar['name']."</option>";
    }
   
    $output .= "</select>";
     
    echo $output;
}
/* When the post is saved, saves our custom data */
function save_sidebar_postdata( $post_id )
{
    // verify if this is an auto save routine. 
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;
 
    // verify this came from our screen and with proper authorization,
    // because save_post can be triggered at other times
 if(isset($_POST['custom_sidebar_nonce'])){
    if ( !wp_verify_nonce( $_POST['custom_sidebar_nonce'], 'custom_sidebar_nonce_feild_1' ) )
      return;
 
    if ( !current_user_can( 'edit_page', $post_id ) )
        return;
 
    $data = $_POST['custom_sidebar_1'];
 
    update_post_meta($post_id, "custom_sidebar_1", $data);
 }
}

/* Define the custom box */
add_action( 'add_meta_boxes', 'add_sidebar_metabox_2' );
add_action( 'save_post', 'save_sidebar_postdata_2' );
 
/* Adds a box to the side column on the Post and Page edit screens */
function add_sidebar_metabox_2()
{
    add_meta_box( 
        'custom_sidebar_2',
        __( 'Custom Sidebar 2', 'megashop' ),
        'custom_sidebar_callback_2',
        'page',
        'side'
    );
}
/* Prints the box content */
function custom_sidebar_callback_2( $post )
{
    global $wp_registered_sidebars;
     
    $custom = get_post_custom($post->ID);
     
    if(isset($custom['custom_sidebar_2']))
        $val = $custom['custom_sidebar_2'][0];
    else
        $val = "default";
 
    // Use nonce for verification
    wp_nonce_field( 'custom_sidebar_nonce_feild', 'custom_sidebar_nonce_1' );
 
    // The actual fields for data entry
    $output = '<p><label for="custom_sidebar_new_field">'.__("Choose a sidebar to display ", 'megashop' ).'</label></p>';
    $output .= "<select name='custom_sidebar_2'>";
 
    // Add a default option
    $output .= "<option";
    if($val == "default")
        $output .= " selected='selected'";
    $output .= " value='default'>".__('default', 'megashop')."</option>";
     
    // Fill the select element with all registered sidebars
    foreach($wp_registered_sidebars as $sidebar_id => $sidebar)
    {
        $output .= "<option";
        if($sidebar_id == $val)
            $output .= " selected='selected'";
        $output .= " value='".$sidebar_id."'>".$sidebar['name']."</option>";
    }
   
    $output .= "</select>";
     
    echo $output;
}
/* When the post is saved, saves our custom data */
function save_sidebar_postdata_2( $post_id )
{
    // verify if this is an auto save routine. 
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;
 
    // verify this came from our screen and with proper authorization,
    // because save_post can be triggered at other times
 if(isset($_POST['custom_sidebar_nonce'])){
    if ( !wp_verify_nonce( $_POST['custom_sidebar_nonce_1'], 'custom_sidebar_nonce_feild' ) )
      return;
 
    if ( !current_user_can( 'edit_page', $post_id ) )
        return;
 
    $data = $_POST['custom_sidebar_2'];
 
    update_post_meta($post_id, "custom_sidebar_2", $data);
 }
}

/* ----------------------------------------------------- */
/* Add Portfolio Custom Post Type
/* ----------------------------------------------------- */
function tt_portfolio_register() {  

global $tt_data;

if(isset($tt_data['text_portfolioslug']) && $tt_data['text_portfolioslug'] != ''){
$portfolio_slug = $tt_data['text_portfolioslug'];
} else {
$portfolio_slug = 'portfolio-item';
}

$labels = array(
'name' => __( 'Portfolio', 'ttposttype' ),
'singular_name' => __( 'Portfolio Item', 'ttposttype' ),
'add_new' => __( 'Add New Item', 'ttposttype' ),
'add_new_item' => __( 'Add New Portfolio Item', 'ttposttype' ),
'edit_item' => __( 'Edit Portfolio Item', 'ttposttype' ),
'new_item' => __( 'Add New Portfolio Item', 'ttposttype' ),
'view_item' => __( 'View Item', 'ttposttype' ),
'search_items' => __( 'Search Portfolio', 'ttposttype' ),
'not_found' => __( 'No portfolio items found', 'ttposttype' ),
'not_found_in_trash' => __( 'No portfolio items found in trash', 'ttposttype' )
);

    $args = array(  
        'labels' => $labels,
        'public' => true,  
        'show_ui' => true,  
        'capability_type' => 'post',  
        'hierarchical' => false,  
        'menu_icon' => 'dashicons-portfolio',
        'rewrite' => array('slug' => $portfolio_slug), // Permalinks format
        'supports' => array('title', 'editor', 'thumbnail', 'comments', 'excerpt')  
       );  
  
    register_post_type( 'portfolio' , $args );  
}
add_action('init', 'tt_portfolio_register', 1);   


/* ----------------------------------------------------- */
/* Register Taxonomy
/* ----------------------------------------------------- */
function tt_portfolio_taxonomy() {

register_taxonomy("portfolio_filter", array("portfolio"), array("hierarchical" => true, "label" => "Portfolio Filter", "singular_label" => "Project Filter", "rewrite" => true));

}
add_action('init', 'tt_portfolio_taxonomy', 1);   

/* ----------------------------------------------------- */
/* Add Columns to Portfolio Edit Screen
/* ----------------------------------------------------- */
function tt_portfolio_edit_columns( $portfolio_columns ) {
$portfolio_columns = array(
"cb" => "<input type=\"checkbox\" />",
"title" => __('Title', 'ttposttype'),
"thumbnail" => __('Thumbnail', 'ttposttype'),
"portfolio_filter" => __('Filter', 'ttposttype'),
"author" => __('Author', 'ttposttype'),
"comments" => __('Comments', 'ttposttype'),
"date" => __('Date', 'ttposttype'),
);
$portfolio_columns['comments'] = '<div class="vers"><img alt="Comments" src="' . esc_url( admin_url( 'images/comment-grey-bubble.png' ) ) . '" /></div>';
return $portfolio_columns;
}
add_filter( 'manage_portfolio_posts_columns', 'tt_portfolio_edit_columns' );

/* ----------------------------------------------------- */

function tt_portfolio_column_display( $portfolio_columns, $post_id ) {

switch ( $portfolio_columns ) {

// Display the thumbnail in the column view
case "thumbnail":
$width = (int) 80;
$height = (int) 80;
$thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );

// Display the featured image in the column view if possible
if ( $thumbnail_id ) {
$thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
}
if ( isset( $thumb ) ) {
echo $thumb; // No need to escape
} else {
echo __('None', 'ttposttype');
}
break;	

// Display the portfolio tags in the column view
case "portfolio_filter":

if ( $category_list = get_the_term_list( $post_id, 'portfolio_filter', '', ', ', '' ) ) {
echo $category_list; // No need to escape
} else {
echo __('None', 'ttposttype');
}
break;	
}
}
add_action( 'manage_posts_custom_column', 'tt_portfolio_column_display', 10, 2 );

/* ----------------------------------------------------- */
/* EOF */
/* ----------------------------------------------------- */