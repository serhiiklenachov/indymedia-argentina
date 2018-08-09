<?php

class WP_Customize_Editor extends WP_Customize_Control {
	public $type = 'editor';

	public function render_content() { ?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<input id="<?php echo $this->id; ?>-link" type="hidden" class="wp-editor-area" <?php $this->link(); ?> value="<?php echo esc_textarea( $this->value() ); ?>">
			<?php
			$settings = array(
				'textarea_name' => $this->id,
				'media_buttons' => true,
				'tinymce' => array(
					'setup' => "function (editor) {
						var cb = function () {
							var linkInput = document.getElementById('$this->id-link')
							linkInput.value = editor.getContent()
							linkInput.dispatchEvent(new Event('change'))
						}
						editor.on('Change', cb)
						editor.on('Undo', cb)
						editor.on('Redo', cb)
						editor.on('KeyUp', cb) // Remove this if it seems like an overkill
					}"
				)
			);
			wp_editor($this->value(), $this->id, $settings );

			do_action('admin_footer');
			do_action('admin_print_footer_scripts');
		?>
		</label>
	<?php
	}
}
