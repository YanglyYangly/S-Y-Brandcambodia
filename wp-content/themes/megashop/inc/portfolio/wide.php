<div class="portfolio_wide clearfix">
	
	<?php
        $images = rwmb_meta( 'tt_screenshot', 'type=image_advanced&size=standard' );
        if( get_post_meta( get_the_ID(), 'tt_embed', true ) == "" && !empty($images) ){ ?>
				
		<div class="portfolio-gallery">
            <ul class="slides">
                <?php $images = rwmb_meta( 'tt_screenshot', 'type=image_advanced&size=standard' );
					foreach ( $images as $image ) {
						echo "<li><img src='".esc_url($image['url'])."' width='".esc_attr($image['width'])."' height='".esc_attr($image['height'])."' alt='".esc_attr($image['alt'])."' /></li>";
					} 
				?>
            </ul>
        </div>
			    
	<?php } elseif(get_post_meta( get_the_ID(), 'tt_embed', true ) != "") { ?>

		<div id="portfolio-embed">
		    <?php   
		    if (get_post_meta( get_the_ID(), 'tt_source', true ) == 'videourl') {  
		    	$embed_code = wp_oembed_get(esc_url(get_post_meta( get_the_ID(), 'tt_embed', true )));
		    	echo do_shortcode($embed_code); // No need to escape here
		    }  
		    else {  
		        echo wp_kses(get_post_meta( get_the_ID(), 'tt_embed', true ), tt_expand_allowed_tags()); 
		    }  
		    ?>
	    </div>

	<?php }elseif(has_post_thumbnail()){
            the_post_thumbnail();
        } ?>
		
	<div class="portfolio-detail-title">
		<h1 class="page-title"><?php the_title(); ?></h1>
	</div>
        <?php if( get_post_meta( get_the_ID(), 'tt_portfolio-details', true ) == 1 ) { ?>
            <div class="portfolio-detail-attributes col-sm-4 padding_left_0">
		<ul>
                        <?php if( get_post_meta( get_the_ID(), 'tt_portfolio-client', true ) != "") { ?>
                        <li class="clearfix port-att"><strong><?php _e('Client', 'megashop'); ?></strong> <span><?php echo esc_html(get_post_meta( get_the_ID(), 'tt_portfolio-client', true )); ?></span></li>
                        <?php } ?>	
                        <li class="clearfix port-att"><strong><?php _e('Date', 'megashop'); ?></strong> <span><?php the_date() ?></span></li>
                        <li class="clearfix port-att"><strong><?php _e('Tags', 'megashop'); ?></strong> <span><?php $taxonomy = strip_tags( get_the_term_list($post->ID, 'portfolio_filter', '', ', ', '') ); echo esc_html($taxonomy); ?></span></li>
                        <?php if( get_post_meta( get_the_ID(), 'tt_portfolio-link', true ) != "") { ?>
                        <li class="clearfix port-att"><strong><?php _e('URL', 'megashop'); ?></strong> <span><a href="<?php echo esc_url(get_post_meta( get_the_ID(), 'tt_portfolio-link', true )); ?>" target="_blank"><?php _e('View Project', 'megashop'); ?></a></span></li>
                        <?php } ?>	
                </ul>
	</div>
	<?php } ?>
	<div class="portfolio-detail-description <?php if( get_post_meta( get_the_ID(), 'tt_portfolio-details', true ) == 1 ) { echo 'col-sm-8 padding_right_0'; } else { echo 'col-sm-12 padding_0'; } ?> columns">
		<div class="portfolio-detail-description-text"><?php the_content(); ?></div>
	</div>
	
	

</div> <!-- End of portfolio-wide -->