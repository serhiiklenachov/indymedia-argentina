<?php

include get_stylesheet_directory() . '/inc/class-walker-category-checklist.php';

function indymedia_post_meta_boxes_setup() {

	add_meta_box(
		'indymedia_highlights',
		__('Destacar'),
		'indymedia_highlights_meta_box',
		'post',
		'side',
		'default'
	);
}

add_action( 'add_meta_boxes', 'indymedia_post_meta_boxes_setup' );

function indymedia_highlights_meta_box( $post ) {
	wp_nonce_field( 'indymedia_highlights_action', 'indymedia_highlights' );

	$highlights = get_post_meta( $post->ID, 'highlights' );
	$highlights = array_map( 'intval', $highlights[0] );

	$walker = new Indymedia_Walker_Category_Checklist;
?>
<div id="highlights-linkcategory" class="categorydiv">
	<p class="howto">Selecciona las categorías donde aparecerá destacada la entrada.</p>
	<ul id="category-tabs" class="category-tabs">
		<li class="tabs"><a href="#categories-all"><?php _e( 'All Categories' ); ?></a></li>
	</ul>

	<div id="categories-all" class="tabs-panel">
		<ul id="categorychecklist" data-wp-lists="list:category" class="categorychecklist form-no-clear">
			<?php wp_terms_checklist( $post, array( 'taxonomy' => 'category', 'selected_cats' => $highlights, 'walker' => $walker ) ); ?>
			</ul>
	</div>
</div>
	<?php
}

function indymedia_highlights_save_post( $post_id, $post ) {
	$nonce_name = isset( $_POST['indymedia_highlights'] ) ? $_POST['indymedia_highlights'] : '';
	$nonce_action = 'indymedia_highlights_action';

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

	$highlights = isset( $_POST[ 'highlights' ] ) ? sanitize_term( $_POST[ 'highlights' ], 'category' ) : array();

	update_post_meta( $post_id, 'highlights', $highlights );

}
add_action( 'save_post', 'indymedia_highlights_save_post', 10, 2 );