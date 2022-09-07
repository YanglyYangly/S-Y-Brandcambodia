<div id="ttm-panel-settings" class="ttm-panel-settings ttm-panel">
	<# if ( data.depth == 1 ) { #>

		<table class="form-table">
			<tr><input type="hidden" name="{{ ttm.getFieldName( 'menuColumn', data.data['menu-item-db-id'] ) }}" value="{{ data.megaData.menuColumn }}" class="menu-item-menuColumn">
                        <textarea type="hidden" name="{{ ttm.getFieldName( 'content', data.data['menu-item-db-id'] ) }}" class="" style="display:none;">{{ data.megaData.content }}</textarea>
                        <input type="hidden" name="{{ ttm.getFieldName( 'border.left', data.data['menu-item-db-id'] ) }}" value="{{ data.megaData.border.left }}" class="menu-item-menuColumn">
                        <input type="hidden" name="{{ ttm.getFieldName( 'icon', data.data['menu-item-db-id'] ) }}" value="{{ data.megaData.icon }}" class="menu-item-menuColumn">
                        <input type="hidden" name="{{ ttm.getFieldName( 'width', data.data['menu-item-db-id'] ) }}" value="{{ data.megaData.width }}" class="">
                        <input type="hidden" name="{{ ttm.getFieldName( 'iconimage', data.data['menu-item-db-id'] ) }}" value="{{ data.megaData.iconimage }}" class="">
				<th scope="row"><?php esc_html_e( 'Hide label', 'megashop' ) ?></th>
				<td>
					<label>
						<input type="checkbox" name="{{ ttm.getFieldName( 'hide_text', data.data['menu-item-db-id'] ) }}" value="1" {{ parseInt( data.megaData.hide_text ) ? 'checked="checked"' : '' }}>
						<?php esc_html_e( 'Hide menu item text', 'megashop' ) ?>
					</label>
				</td>
			</tr>

			<tr>
				<th scope="row"><?php esc_html_e( 'Disable link', 'megashop' ) ?></th>
				<td>
					<label>
						<input type="checkbox" name="{{ ttm.getFieldName( 'disable_link', data.data['menu-item-db-id'] ) }}" value="1" {{ parseInt( data.megaData.disable_link ) ? 'checked="checked"' : '' }}>
						<?php esc_html_e( 'Disable menu item link', 'megashop' ) ?>
					</label>
				</td>
			</tr>
		</table>

	<# } #>
</div>
