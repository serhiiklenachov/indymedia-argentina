<?php

function control_indymedia_repeater_print_template() {
?>
<script id="tmpl-customize-control-indymedia-repeater-content" type="text/html">
	<# let prefix = _.uniqueId( 'indymedia-repeater-' ) #>
	<# console.log(data) #>
	<# if ( data.label != '') { #>
	<h3 id="{{ prefix }}_label">{{ data.label }}</h3>
	<# } #>
	<# if ( data.description != '') { #>
	<span id="{{ prefix }}_description" class="description customize-control-description">{{ data.label }}</span>
	<# } #>
	<ul class="indymedia-repeater-control-container">
		<# let values = JSON.parse(data.setting() != '' ? data.setting() : data.default) #>
		<# for ( i in values ) {  #>
			<# let storage = values[i]; #>
			<li class="indymedia-repeater-control" id="{{ prefix }}">
				<div class="top">
					<button type="button">
						<div class="dashicons dashicons-arrow-down"></div>
					</button>
					<h3>{{ data.blockLabel }}</h3>
				</div>
				<div class="content">
				<# for ( name in data.fields ) { #>
					<# let field = data.fields[name] #>
					<# if ( storage[name] == undefined ) storage[name] = field.default #>
					<div class="indymedia-repeater-field indymedia-repeater-control-{{ field.type }}">
					<# if ( field.type != 'checkbox' ) { #>
						<span class="customize-control-title">{{ field.label }}</span>
					<# } #>
						<span class="description customize-control-description">{{ field.description }}</span>
					<# switch( field.type ) {
						case 'checkbox':
							let checked = storage[name] == 'on' ? ' checked' : '';
							print('<label>');
							print('<input type="checkbox" data-default="' + field.default + '" data-name="' + name + '" value="' + storage[name] + '" ' + checked + '>');
							print(field.label + '</label>');
							break;
						case 'category':
							if ( field.multiple ) {
								print('<select multiple data-name="' + name + '" data-default="0">');
								for ( id in wp.customize.data.categories ) {
									let selected = id == storage[name] ? ' selected' : '';
									print('<option value="' + id + '"' + selected + '>' + wp.customize.data.categories[id] + '</option>');
								}
								print('</select>');
							} else {
								print('<select data-name="' + name + '" data-default="0">');
								print('<option value="0">' + data.strings.select_category + '</option>');
								let selected = storage[name] == -1 ? ' selected' : '';
								print('<option value="-1"' + selected + '>' + data.strings.latest_news + '</option>');
								for ( id in wp.customize.data.categories ) {
									let selected = id == storage[name] ? ' selected' : '';
									print('<option value="' + id + '"' + selected + '>' + wp.customize.data.categories[id] + '</option>');
								}
								print('</select>');
							}
							break;
						case 'image-option':
							print('<div class="image-option">');
							for ( id in field.options ) {
								let selected = id == storage[name] ? ' class="selected"' : '';

								print('<label data-value="' + id + '"' + selected + '>');
								print('<img src="' + field.options[id] + '"/>')
								print('</label>');
							}
							print('<input type="hidden" data-name="' + name + '" data-default="' + field.default + '" value="' + storage[name] + '">');
							print('</div>');
							break;
						case 'select':
							print('<select data-default="' + field.default + '" data-name="' + name + '" value="' + storage[name] + '">');
							for ( id in field.options ) {
								let selected = id == storage[name] ? ' class="selected"' : '';
								print('<option data-value="' + id + '"' + selected + '>');
								print(field.options[id]);
								print('</option>');
							}
							print('</select>');
							break;
						case 'text':
							print('<input type="text" data-default="' + field.default + '" data-name="' + name + '" value="' + storage[name] + '">');
							break;
						case 'textarea':
							
							break;
					} #>
					</div>
				<# } #>
					<div class="options">
						<button type="button" class="button-link button-link-delete indymedia-repeater-remove-button">Borrar</button>
					</div>
				</div>
			</li>
		<# } #>
	</ul>
	<input type="hidden" class="indymedia-repeater-storage" value="{{ data.value }}" data-customize-setting-key-link="default" />
	<button type="button" class="button indymedia-repeater-add-button">{{ data.strings.add_button }}</button>
</script>
<?php
}
add_action( 'customize_controls_print_footer_scripts', 'control_indymedia_repeater_print_template');

function control_indymedia_repeater_load_scripts() {
	wp_register_style( 'control-indymedia-repeater', get_stylesheet_directory_uri() . '/css/control-repeater.css', array(), null );
	wp_enqueue_style( 'control-indymedia-repeater' );

	wp_enqueue_script( 'control-indymedia-repeater', get_stylesheet_directory_uri() . '/js/control-repeater.js', array( 'jquery' ), '1.0.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'control_indymedia_repeater_load_scripts' );