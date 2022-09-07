<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

get_template_part('admin/megashop_menu/megashop', 'menu_header');
?>

<div class="activate_licence">
    <div class="inner-panel">
        <h3><?php _e('Theme Purchase code', 'megashop'); ?></h3>
        <?php
        $slug = basename(get_template_directory());

        //get errors so we can show them
        $errors = get_option($slug . '_tt_errors', array());
        delete_option($slug . '_tt_errors'); //delete existing errors as we will handle them next
        //check if we have a purchase code saved already
        $purchase_code = sanitize_text_field(get_option($slug . '_wpup_purchase_code', ''));

        //output errors and notifications
        if (!empty($errors)) {
            echo '<div class="notice-error notice-alt"><p>' . $errors . '</p></div>';
        }
        if (!empty($purchase_code)) {
            if (!empty($errors)) {
                //since there is already a purchase code present - notify the user
                $slug = basename(get_template_directory());
                update_option(strtolower($slug) . '_wpup_purchase_code', '');
                $purchase_code = false;
                echo '<div class="notice-warning notice-alt"><p>' . esc_html__('Purchase code removed.','megashop') . '</p></div>';
            } else {
                //this means a valid purchase code is present and no errors were found
                echo '<div class="notice-success notice-alt notice-large" style="margin-bottom:15px!important">' . __('Your <strong>purchase code is valid</strong>. Thank you! Enjoy megashop Theme.','megashop') . '</div>';
            }
        }

        if (empty($purchase_code)) { ?>
           <form class="wupdates_purchase_code" action="" method="post">
            <p><?php _e('Enter your purchase code and ','megashop'); ?>
                <strong><?php _e('hit return/enter ','megashop'); ?></strong><?php _e('. Find out how to ','megashop'); ?>
                <a href="<?php echo esc_url('https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-'); ?>" target="_blank"><?php _e('get your purchase code. ','megashop'); ?></a></p>
            <input type="hidden" name="wupdates_pc_theme" value="<?php  echo esc_html($slug); ?>" />
            <input class="purchase_code" type="text" id="<?php echo sanitize_title($slug); ?>_wpup_purchase_code" name="<?php echo sanitize_title($slug); ?>_wpup_purchase_code"
              value="" placeholder="Purchase code ( e.g. 9g2b13fa-10aa-883a-4cf9b5 )" style="width:100%; padding:10px;"/><br/><br/>
            <?php
            $n1=rand(1,6); //Generate First number between 1 and 6 
            $n2=rand(5,9); //Generate Second number between 5 and 9 
            $answer=$n1+$n2; 

            echo esc_html__("What is ",'megashop').$n1." + ".$n2." : "; 
            $_SESSION['vercode'] = $answer;
            ?>
            <input name="captcha" type="text">
            <br/><br/>
            <input type="submit" id="purchase_active" class="button button-large button-primary" value="Activate"/>
            </form>
        <?php } else {
            echo __('Your Purchase code : ', 'megashop') . $purchase_code;
            ?>  <p><a href="<?php echo esc_url('http://support.templatetrip.com/'); ?>" target="_blank" class="button button-secondary"><?php echo sprintf(esc_html('Generate Ticket Here', 'megashop')); ?></a><?php echo __(' Incase Any Query', 'megashop'); ?></p>
            <?php
        }
        ?>
    </div>
    <div class="changelog">
        <div class="return-to-dashboard">
            <a href="<?php echo esc_url(self_admin_url('themes.php')); ?>"><?php is_blog_admin() ? _e('Back to Themes', 'megashop') : _e('Back to Themes', 'megashop'); ?></a>
        </div>
    </div>
</div>