<# if ( data.depth == 0 ) { #>
	<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Mega Menu Content', 'megashop' ) ?>" data-panel="mega"><?php esc_html_e( 'Mega Menu', 'megashop' ) ?></a>
	<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Mega Menu Background', 'megashop' ) ?>" data-panel="background"><?php esc_html_e( 'Background', 'megashop' ) ?></a>
	<div class="separator"></div>
	<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Icon', 'megashop' ) ?>" data-panel="icon"><?php esc_html_e( 'Icon', 'megashop' ) ?></a>
<# } else if ( data.depth == 1 ) { #>
	<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Menu Setting', 'megashop' ) ?>" data-panel="settings"><?php esc_html_e( 'Settings', 'megashop' ) ?></a>
	<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Design', 'megashop' ) ?>" data-panel="design"><?php esc_html_e( 'Design', 'megashop' ) ?></a>
	<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Content', 'megashop' ) ?>" data-panel="content"><?php esc_html_e( 'Content', 'megashop' ) ?></a>
	<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Icon', 'megashop' ) ?>" data-panel="icon"><?php esc_html_e( 'Icon', 'megashop' ) ?></a>
<# } else { #>
	<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Menu Content', 'megashop' ) ?>" data-panel="content"><?php esc_html_e( 'Content', 'megashop' ) ?></a>
	<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Icon', 'megashop' ) ?>" data-panel="icon"><?php esc_html_e( 'Icon', 'megashop' ) ?></a>
<# } #>
