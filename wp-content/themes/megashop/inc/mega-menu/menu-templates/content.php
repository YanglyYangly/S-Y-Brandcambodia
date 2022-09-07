<div id="ttm-panel-content" class="ttm-panel-content ttm-panel">
	<p>
            <input type="hidden" name="{{ ttm.getFieldName( 'menuColumn', data.data['menu-item-db-id'] ) }}" value="{{ data.megaData.menuColumn }}" class="menu-item-menuColumn">
                <input type="hidden" name="{{ ttm.getFieldName( 'icon', data.data['menu-item-db-id'] ) }}" value="{{ data.megaData.icon }}" class="">
                <input type="hidden" name="{{ ttm.getFieldName( 'width', data.data['menu-item-db-id'] ) }}" value="{{ data.megaData.width }}" class="">
                <input type="hidden" name="{{ ttm.getFieldName( 'border.left', data.data['menu-item-db-id'] ) }}" value="{{ data.megaData.border.left }}" class="">
                <input type="hidden" name="{{ ttm.getFieldName( 'disable_link', data.data['menu-item-db-id'] ) }}" value="{{ data.megaData.disable_link }}" class="">
                <input type="hidden" name="{{ ttm.getFieldName( 'hide_text', data.data['menu-item-db-id'] ) }}" value="{{ data.megaData.hide_text }}" class="">
                <input type="hidden" name="{{ ttm.getFieldName( 'iconimage', data.data['menu-item-db-id'] ) }}" value="{{ data.megaData.iconimage }}" class="">
		<textarea name="{{ ttm.getFieldName( 'content', data.data['menu-item-db-id'] ) }}" class="widefat itemContent" rows="20" contenteditable="true">{{ data.megaData.content }}</textarea>
	</p>
	<?php add_my_media_button(); ?>
	<p class="description"><?php esc_html_e( 'Tip: Build your content inside a page with visual page builder then copy generated content here.', 'megashop' ) ?></p>
</div>
