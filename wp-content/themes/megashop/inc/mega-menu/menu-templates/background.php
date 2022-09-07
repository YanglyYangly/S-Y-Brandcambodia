<# var itemId = data.data['menu-item-db-id']; #>
<div id="ttm-panel-background" class="ttm-panel-background ttm-panel">
            <input type="hidden" name="{{ ttm.getFieldName( 'icon', data.data['menu-item-db-id'] ) }}" value="{{ data.megaData.icon }}" class="">
            <input type="hidden" name="{{ ttm.getFieldName( 'width', data.data['menu-item-db-id'] ) }}" value="{{ data.megaData.width }}" class="">
            <input type="hidden" name="{{ ttm.getFieldName( 'border.left', data.data['menu-item-db-id'] ) }}" value="{{ data.megaData.border.left }}" class="">
            <input type="hidden" name="{{ ttm.getFieldName( 'disable_link', data.data['menu-item-db-id'] ) }}" value="{{ data.megaData.disable_link }}" class="">
            <input type="hidden" name="{{ ttm.getFieldName( 'hide_text', data.data['menu-item-db-id'] ) }}" value="{{ data.megaData.hide_text }}" class="">
            <input type="hidden" name="{{ ttm.getFieldName( 'iconimage', data.data['menu-item-db-id'] ) }}" value="{{ data.megaData.iconimage }}" class="">
            <textarea name="{{ ttm.getFieldName( 'content', data.data['menu-item-db-id'] ) }}" class="widefat itemContent" rows="20" contenteditable="true">{{{ data.megaData.content }}}</textarea>
	<p class="background-image">
		<label><?php esc_html_e( 'Background Image', 'megashop' ) ?></label><br>
		<span class="background-image-preview">
			<# if ( data.megaData.background.image ) { #>
				<img src="{{ data.megaData.background.image }}">
			<# } #>
		</span>

		<button type="button" class="button remove-button <# if ( ! data.megaData.background.image ) { print( 'hidden' ) } #>"><?php esc_html_e( 'Remove', 'megashop' ) ?></button>
		<button type="button" class="button upload-button" id="background_image-button"><?php esc_html_e( 'Select Image', 'megashop' ) ?></button>

		<input type="hidden" name="{{ ttm.getFieldName( 'background.image', itemId ) }}" value="{{ data.megaData.background.image }}">
	</p>

	<p class="background-color">
		<label><?php esc_html_e( 'Background Color', 'megashop' ) ?></label><br>
		<input type="text" class="background-color-picker" name="{{ ttm.getFieldName( 'background.color', itemId ) }}" value="{{ data.megaData.background.color }}">
	</p>

	<p class="background-repeat">
		<label><?php esc_html_e( 'Background Repeat', 'megashop' ) ?></label><br>
		<select name="{{ ttm.getFieldName( 'background.repeat', itemId ) }}">
			<option value="no-repeat" {{ 'no-repeat' == data.megaData.background.repeat ? 'selected="selected"' : '' }}><?php esc_html_e( 'No Repeat', 'megashop' ) ?></option>
			<option value="repeat" {{ 'repeat' == data.megaData.background.repeat ? 'selected="selected"' : '' }}><?php esc_html_e( 'Tile', 'megashop' ) ?></option>
			<option value="repeat-x" {{ 'repeat-x' == data.megaData.background.repeat ? 'selected="selected"' : '' }}><?php esc_html_e( 'Tile Horizontally', 'megashop' ) ?></option>
			<option value="repeat-y" {{ 'repeat-y' == data.megaData.background.repeat ? 'selected="selected"' : '' }}><?php esc_html_e( 'Tile Vertically', 'megashop' ) ?></option>
		</select>
	</p>

	<p class="background-position background-position-x">
		<label><?php esc_html_e( 'Background Position', 'megashop' ) ?></label><br>

		<select name="{{ ttm.getFieldName( 'background.position.x', itemId ) }}">
			<option value="left" {{ 'left' == data.megaData.background.position.x ? 'selected="selected"' : '' }}><?php esc_html_e( 'Left', 'megashop' ) ?></option>
			<option value="center" {{ 'center' == data.megaData.background.position.x ? 'selected="selected"' : '' }}><?php esc_html_e( 'Center', 'megashop' ) ?></option>
			<option value="right" {{ 'right' == data.megaData.background.position.x ? 'selected="selected"' : '' }}><?php esc_html_e( 'Right', 'megashop' ) ?></option>
			<option value="custom" {{ 'custom' == data.megaData.background.position.x ? 'selected="selected"' : '' }}><?php esc_html_e( 'Custom', 'megashop' ) ?></option>
		</select>

		<input
			type="text"
			name="{{ ttm.getFieldName( 'background.position.custom.x', itemId ) }}"
			value="{{ data.megaData.background.position.custom.x }}"
			class="{{ 'custom' != data.megaData.background.position.x ? 'hidden' : '' }}">
	</p>

	<p class="background-position background-position-y">
		<select name="{{ ttm.getFieldName( 'background.position.y', itemId ) }}">
			<option value="top" {{ 'top' == data.megaData.background.position.y ? 'selected="selected"' : '' }}><?php esc_html_e( 'Top', 'megashop' ) ?></option>
			<option value="center" {{ 'center' == data.megaData.background.position.y ? 'selected="selected"' : '' }}><?php esc_html_e( 'Middle', 'megashop' ) ?></option>
			<option value="bottom" {{ 'bottom' == data.megaData.background.position.y ? 'selected="selected"' : '' }}><?php esc_html_e( 'Bottom', 'megashop' ) ?></option>
			<option value="custom" {{ 'custom' == data.megaData.background.position.y ? 'selected="selected"' : '' }}><?php esc_html_e( 'Custom', 'megashop' ) ?></option>
		</select>
		<input
			type="text"
			name="{{ ttm.getFieldName( 'background.position.custom.y', itemId ) }}"
			value="{{ data.megaData.background.position.custom.y }}"
			class="{{ 'custom' != data.megaData.background.position.y ? 'hidden' : '' }}">
	</p>

	<p class="background-attachment">
		<label><?php esc_html_e( 'Background Attachment', 'megashop' ) ?></label><br>
		<select name="{{ ttm.getFieldName( 'background.attachment', itemId ) }}">
			<option value="scroll" {{ 'scroll' == data.megaData.background.attachment ? 'selected="selected"'  : '' }}><?php esc_html_e( 'Scroll', 'megashop' ) ?></option>
			<option value="fixed" {{ 'fixed' == data.megaData.background.attachment ? 'selected="selected"'  : '' }}><?php esc_html_e( 'Fixed', 'megashop' ) ?></option>
		</select>
	</p>

	<p class="background-size">
		<label><?php esc_html_e( 'Background Size', 'megashop' ) ?></label><br>
		<select name="{{ ttm.getFieldName( 'background.size', itemId ) }}">
			<option value=""><?php esc_html_e( 'Default', 'megashop' ) ?></option>
			<option value="cover" {{ 'cover' == data.megaData.background.size ? 'selected="selected"' : '' }}><?php esc_html_e( 'Cover', 'megashop' ) ?></option>
			<option value="contain" {{ 'contain' == data.megaData.background.size ? 'selected="selected"' : '' }}><?php esc_html_e( 'Contain', 'megashop' ) ?></option>
		</select>
	</p>
</div>