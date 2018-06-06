<?php
if ( !defined( 'ABSPATH' ) ) exit;

class Meta {
	public static function init() {
		add_action( 'admin_init', __CLASS__ . '::add_meta_box' );
		add_action( 'save_post', __CLASS__ . '::save_post', 10, 2 );
		add_action( "manage_posts_custom_column", __CLASS__  . '::columns_render', 10, 2 );
		add_filter( "manage_posts_columns", __CLASS__ . '::columns_update' );
	}

	public static function add_meta_box() {
		add_meta_box("indymedia-meta", "Fuente", __CLASS__ . '::get_meta_box', "post", "normal", "high");
	}

	public static function get_meta_box( $post ) {
		wp_nonce_field( 'indymedia_action', 'indymedia' );

		$fuente = get_post_meta( $post->ID, 'fuente', true );

		if( empty( $fuente ) ) $fuente = '';
		?>
			<p>
				<label for="fuente">Organización, Colectivo, Sindicato, étc</label>
				<input class="widefat" id="fuente" name="fuente" type="text" value="<?php echo $fuente ?>">
			</p>
		<?php
	}

	public static function save_post( $post_id, $post ) {
		$nonce_name   = isset( $_POST['indymedia'] ) ? $_POST['indymedia'] : '';
		$nonce_action = 'indymedia_action';
	
		if ( ! isset( $nonce_name ) )
			return;
	
		if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) )
			return;
	
		if ( ! current_user_can( 'edit_post', $post_id ) )
			return;
	
		if ( wp_is_post_autosave( $post_id ) )
			return;
	 
		if ( wp_is_post_revision( $post_id ) )
			return;

		$fuente = isset( $_POST[ 'fuente' ] ) ? sanitize_text_field( $_POST[ 'fuente' ] ) : '';

		update_post_meta( $post_id, 'fuente', $fuente );

	}

	public static function columns_render( $column, $post_id )	 {
		$data = '';
		
		if ( $column == 'fuente' )
				$data = get_post_meta( $post_id, 'fuente', true );

		if ( !$data )
			return '';

		echo esc_html($data);
	}

	public static function columns_update( array $columns ) {
		$columns[ 'fuente' ] = 'Fuente';

		return $columns;
	}
}

Meta::init();