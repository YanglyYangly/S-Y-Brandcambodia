<?php
/**
 * Template Name: Both Sidebar Page
 *
 * @package WordPress
 * @subpackage Megashop
 * @since Megashop 1.0.4
 */

get_header();

$options = get_post_custom(get_the_ID());
 
if(isset($options['custom_sidebar_1'])){
    $sidebar_choice = $options['custom_sidebar_1'][0];
    if($sidebar_choice == 'default'){
        $sidebar_choice = "sidebar-1";
    }
}else{
    $sidebar_choice = "sidebar-1";
}
if(isset($options['custom_sidebar_2'])){
    $sidebar_choice_2 = $options['custom_sidebar_2'][0];
    if($sidebar_choice_2 == 'default'){
        $sidebar_choice_2 = "right-sidebar";
    }
}else{
    $sidebar_choice_2 = "right-sidebar";
}

?>
<div class="left_sidebar container padding_0">
   <div class="page-title-wrapper">
    <?php TT_wp_breadcrumb(); ?>
    </div>
<div id="main-content" class="main-content col-md-6 col-sm-6 col-xs-12 col-sm-push-3 col-md-push-3 col-lg-push-2 col-lg-8">
	<div id="primary" class="content-area">
		<div id="content" class="site-content" >
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					// Include the page content template.
					get_template_part( 'template-parts/content', 'page' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				endwhile; ?>
				
				    
		</div><!-- #content -->
	</div><!-- #primary -->
</div>
<aside id="secondary" class="sidebar widget-area col-sm-3 col-lg-2 col-md-3 col-md-pull-6 col-sm-pull-6 col-lg-pull-8">
                <?php
                        if ( has_nav_menu( 'left_menu' ) ) { 
                ?>
                <section id="maxmegamenu_mega" class="widget widget_maxmegamenu">            
                                <?php if ( has_nav_menu( 'left_menu' ) ) { ?>
                                        <?php
                                        //if you after the menu at a specific location
                                            $location = 'left_menu';
                                            $menu_obj = megashop_get_menu_by_location($location); 
                                            $locations = get_nav_menu_locations();
                                            if($menu_obj->name == 'left-menu'){
                                                $title = esc_html('Categories','megashop');
                                            }else{
                                                $title = $menu_obj->name;
                                            }
                                            echo "<h2 class='widget-title'>".esc_attr($title)."</h2>";
                                            if (!empty($locations) && array_key_exists('left_menu', $locations)) {
                                                wp_nav_menu(array('theme_location' => 'left_menu','container_class' => 'mega-menu-wrap-new', 'menu_class' => 'mega-menu'));
                                            }
                                        ?>
                                <?php } ?>
                </section> 
            <?php }  dynamic_sidebar($sidebar_choice); ?>
                </aside><!-- .sidebar .widget-area -->
<aside id="rightsidebar" class="sidebar widget-area col-sm-3 col-lg-2 col-md-3 col-xs-12">
        <?php dynamic_sidebar( $sidebar_choice_2 ); ?>
</aside><!-- .sidebar .widget-area -->
<?php 
get_footer();
