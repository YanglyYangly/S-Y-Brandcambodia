<?php
/**
 * The template for the sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Megashop
 * @since Megashop 1.0.4
 */
?>

<?php
$sidebar = 'sidebar-1';
$class = "";
$options = get_post_custom(get_the_ID());
 
if(isset($options['custom_sidebar_1'])){
    $sidebar_choice = $options['custom_sidebar_1'][0];
    if($sidebar_choice == 'default'){
        $sidebar_choice = "sidebar-1";
    }
}else{
    $sidebar_choice = "sidebar-1";
}

 $class .= 'col-md-3 col-sm-3 col-xs-12 col-sm-pull-9 col-md-pull-9';
if ( is_active_sidebar( $sidebar )  ) : ?>
	<aside id="secondary" class="sidebar widget-area <?php echo esc_attr($class); ?>">
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
										?><nav id="site-navigation" class="verticle-navigation"  aria-label="<?php esc_html_e( 'Primary Menu', 'megashop' ); ?>"><?php
                                        if (!empty($locations) && array_key_exists('left_menu', $locations)) {
                                            wp_nav_menu(array('theme_location' => 'left_menu','container_class' => 'mega-menu-wrap-new', 'menu_class' => 'mega-menu'));
                                        }
                                    ?></nav>
                            <?php } ?>
            </section> 
            <?php }    
                dynamic_sidebar( $sidebar_choice ); ?>
	</aside><!-- .sidebar .widget-area -->
<?php endif; ?>