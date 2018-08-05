<?php get_header(); ?>
<div class="vl-container">
<?php
	if ( $wp_query->is_paged ) {
		set_query_var( 'offset', min( intval( $_GET['offset'] ), 25 ) );
		get_template_part('template-parts/category', 'archive');
	} else {
		get_template_part('template-parts/category', 'main');
		
		$wp_query->post_count = count(WP_Deduplicator::get());
		the_posts_pagination( array(
			'add_args' => array(
				'offset' => count(WP_Deduplicator::get())
			) )
		);
	}
?>
</div>
<?php //var_dump($wp_query); ?>
<?php get_footer(); ?>