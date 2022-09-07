<div id="ttm-panel-mega" class="ttm-panel-mega ttm-panel">
	<p class="mega-settings">
		<span class="setting-field">
			<label>
				<?php esc_html_e( 'Enable mega menu', 'megashop' ) ?><br>
				<select class="megaEnable" name="{{ ttm.getFieldName( 'mega', data.data['menu-item-db-id'] ) }}">
					<option value="0"><?php esc_html_e( 'No', 'megashop' ) ?></option>
					<option value="1" {{ parseInt( data.megaData.mega ) ? 'selected="selected"' : '' }}><?php esc_html_e( 'Yes', 'megashop' ) ?></option>
				</select>
			</label>
		</span>
                <span class="setting-field">
			<label>
				<?php esc_html_e( 'mega menu Column', 'megashop' ) ?><br>
				<select class="megaColumn" name="{{ ttm.getFieldName( 'megaColumn', data.data['menu-item-db-id'] ) }}">
					<option value="1" {{ '1' ==  parseInt( data.megaData.megaColumn ) ? 'selected="selected"' : '' }}><?php esc_html_e( '1 column', 'megashop' ) ?></option>
					<option value="2" {{ '2' ==  parseInt( data.megaData.megaColumn ) ? 'selected="selected"' : '' }}><?php esc_html_e( '2 column', 'megashop' ) ?></option>
                                        <option value="3" {{ '3' ==  parseInt( data.megaData.megaColumn ) ? 'selected="selected"' : '' }}><?php esc_html_e( '3 column', 'megashop' ) ?></option>
                                        <option value="4" {{ '4' ==  parseInt( data.megaData.megaColumn ) ? 'selected="selected"' : '' }}><?php esc_html_e( '4 column', 'megashop' ) ?></option>
                                        <option value="5" {{ '5' ==  parseInt( data.megaData.megaColumn ) ? 'selected="selected"' : '' }}><?php esc_html_e( '5 column', 'megashop' ) ?></option>
                                        <option value="6" {{ '6' ==  parseInt( data.megaData.megaColumn ) ? 'selected="selected"' : '' }}><?php esc_html_e( '6 column', 'megashop' ) ?></option>
				</select>
			</label>
		</span>

		<span class="setting-field">
			<label>
				<?php esc_html_e( 'Mega panel width', 'megashop' ) ?><br>
				<input type="text" name="{{ ttm.getFieldName( 'width', data.data['menu-item-db-id'] ) }}" placeholder="auto" value="{{ data.megaData.width }}">
			</label>
		</span>
	</p>

	<div id="ttm-mega-content" class="ttm-mega-content">
		<#
		var items = _.filter( data.children, function( item ) {
			return item.subDepth == 0;
		} );
		#>
		<# _.each( items, function( item, index ) { #>

			<div class="ttm-submenu-column" data-width="{{ item.megaData.width }}">
                                <input type="hidden" name="{{ ttm.getFieldName( 'width', item.data['menu-item-db-id'] ) }}" value="{{ item.megaData.width }}" class="menu-item-width">
				<ul>
					<li class="menu-item menu-item-depth-{{ item.subDepth }}">
						<# if ( item.megaData.icon ) { #>
						<i class="{{ item.megaData.icon }}"></i>
						<# } #>
						{{{ item.data['menu-item-title'] }}}
						<# if ( item.subDepth == 0 ) { #>
						<span class="ttm-column-handle ttm-resizable-e"><i class="dashicons dashicons-arrow-left-alt2"></i></span>
						<span class="ttm-column-width-label"></span>
						<span class="ttm-column-handle ttm-resizable-w"><i class="dashicons dashicons-arrow-right-alt2"></i></span>
						<input type="hidden" name="{{ ttm.getFieldName( 'width', item.data['menu-item-db-id'] ) }}" value="{{ item.megaData.width }}" class="menu-item-width">
                                                <input type="hidden" name="{{ ttm.getFieldName( 'width', item.data['menu-item-db-id'] ) }}" value="{{ item.megaData.width }}" class="menu-item-width">
                                                
						<# } #>
                                                <input type="hidden" name="{{ ttm.getFieldName( 'width', item.data['menu-item-db-id'] ) }}" value="{{ item.megaData.width }}" class="menu-item-width">
                                                <input type="hidden" name="{{ ttm.getFieldName( 'menuColumn', item.data['menu-item-db-id'] ) }}" value="{{ item.megaData.menuColumn }}" class="menu-item-menuColumn">
                                                <input type="hidden" name="{{ ttm.getFieldName( 'icon', item.data['menu-item-db-id'] ) }}" value="{{ item.megaData.icon }}" class="">
                                                <input type="hidden" name="{{ ttm.getFieldName( 'border.left', item.data['menu-item-db-id'] ) }}" value="{{ item.megaData.border.left }}" class="">
                                                <textarea type="hidden" name="{{ ttm.getFieldName( 'content', item.data['menu-item-db-id'] ) }}" class="" style="display:none;">{{ item.megaData.content }}</textarea>
                                                <input type="hidden" name="{{ ttm.getFieldName( 'disable_link', item.data['menu-item-db-id'] ) }}" value="{{ item.megaData.disable_link }}" class="">
                                                <input type="hidden" name="{{ ttm.getFieldName( 'hide_text', item.data['menu-item-db-id'] ) }}" value="{{ item.megaData.hide_text }}" class="">
                                                <input type="hidden" name="{{ ttm.getFieldName( 'iconimage', item.data['menu-item-db-id'] ) }}" value="{{ item.megaData.iconimage }}" class="">
					</li>
				</ul>
			</div>

		<# } ) #>
	</div>
</div>
