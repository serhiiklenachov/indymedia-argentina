<?php get_header(); ?>
<div class="vl-container">
<?php
	if ( $wp_query->is_paged ) {
		get_template_part( 'template-parts/category', 'archive' );
	} else {
		get_template_part( 'template-parts/category', 'main' );
		
		$wp_query->post_count = count( WP_Deduplicator::get() );
		$to_show = $wp_query->found_posts - $wp_query->post_count;
		$wp_query->max_num_pages = absint( ceil( $to_show / $posts_per_page + 1 ) );

		the_posts_pagination( array(
			'add_args' => array(
				'offset' => count( $wp_query->post_count )
			) )
		);
	}
?>
</div>
<?php get_footer(); ?>