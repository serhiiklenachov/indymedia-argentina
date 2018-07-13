<?php

class WP_Customize_Editor extends WP_Customize_Control
{
	public $type = 'editor';

	public function render_content() { ?>
		<label>
		  <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		  <?php
			$this->filter_editor_setting_link();
			wp_editor($this->value(), $this->id, array() );
		  ?>
		</label>
	<?php
		do_action('admin_footer');
		do_action('admin_print_footer_scripts');
	}

	private function filter_editor_setting_link() {
		add_filter( 'the_editor', function( $output ) { return preg_replace( '/<textarea/', '<textarea ' . $this->get_link(), $output, 1 ); } );
	}
}

function editor_customizer_script() {
	wp_enqueue_script( 'wp-editor-customizer', get_template_directory_uri() . '/js/customizer-panel.js', array( 'jquery' ), rand(), true );
}
add_action( 'customize_controls_enqueue_scripts', 'editor_customizer_script' );

