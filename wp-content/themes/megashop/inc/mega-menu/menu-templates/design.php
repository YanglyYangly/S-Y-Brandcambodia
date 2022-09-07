<div id="ttm-panel-design" class="ttm-panel-design ttm-panel">
	<table class="form-table">
		<tr>
			<th scope="row"><?php esc_html_e( 'Border', 'megashop' ) ?></th>
			<td>
                            <input type="hidden" name="{{ ttm.getFieldName( 'width', data.data['menu-item-db-id'] ) }}" value="{{ data.megaData.width }}" class="">
                                <input type="hidden" name="{{ ttm.getFieldName( 'menuColumn', data.data['menu-item-db-id'] ) }}" value="{{ data.megaData.menuColumn }}" class="menu-item-menuColumn">
                                <input type="hidden" name="{{ ttm.getFieldName( 'icon', data.data['menu-item-db-id'] ) }}" value="{{ data.megaData.icon }}" class="">
                                <textarea type="hidden" name="{{ ttm.getFieldName( 'content', data.data['menu-item-db-id'] ) }}" class="" style="display:none;">{{ data.megaData.content }}</textarea>
                                <input type="hidden" name="{{ ttm.getFieldName( 'disable_link', data.data['menu-item-db-id'] ) }}" value="{{ data.megaData.disable_link }}" class="">
                                <input type="hidden" name="{{ ttm.getFieldName( 'hide_text', data.data['menu-item-db-id'] ) }}" value="{{ data.megaData.hide_text }}" class="">
                                <input type="hidden" name="{{ ttm.getFieldName( 'iconimage', data.data['menu-item-db-id'] ) }}" value="{{ data.megaData.iconimage }}" class="">
				<fieldset>
					<label>
						<input type="checkbox" name="{{ ttm.getFieldName( 'border.left', data.data['menu-item-db-id'] ) }}" value="1" {{ parseInt( data.megaData.border.left ) ? 'checked="checked"' : '' }}>
						<?php esc_html_e( 'Border Left', 'megashop' ) ?>
					</label>
				</fieldset>
			</td>
		</tr>
	</table>
</div>
