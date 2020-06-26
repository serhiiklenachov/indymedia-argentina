<?php

function control_indymedia_editor_print_template() {
?>
<script id="tmpl-customize-control-indymedia-editor-content" type="text/html">
	<# let prefix = _.uniqueId( 'indymedia-editor-' ) #>
	<# if ( data.label != '') { #>
	<h3 id="{{ prefix }}_label">{{ data.label }}</h3>
	<# } #>
	<# if ( data.description != '') { #>
	<span id="{{ prefix }}_description" class="description customize-control-description">{{ data.label }}</span>
	<# } #>
	<textarea id="{{ prefix }}" value="{{ data.value }}" data-customize-setting-key-link="default"></textarea>
</script>
	<?php
}

add_action( 'customize_controls_print_footer_scripts', 'control_indymedia_editor_print_template');

function control_indymedia_editor_load_scripts() {
	wp_enqueue_script( 'control-indymedia-editor', get_stylesheet_directory_uri() . '/scripts/control-editor.js', array(), '1.1.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'control_indymedia_editor_load_scripts' );