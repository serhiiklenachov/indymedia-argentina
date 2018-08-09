<?php
$category = get_queried_object();

if ( isset( $_GET['offset'] ) ) {
	$offset = intval( $_GET['offset'] );
	$ppp = get_option('posts_per_page');
	$page_offset = $offset + ( ($wp_query->query_vars['paged'] - 2) * $ppp );
}

$args = array(
	'cat'=> $category->term_id
);

if ( isset($page_offset) ) {
	$args['offset'] = $page_offset;
}

$query = new WP_Query( $args );

?>
	<div id="primary" class="content-area">
		<br />
		<header class="vl-main-header">
			<?php
				the_archive_title( '<h1>', '</h1>' );
				the_archive_description( '<div class="taxonomy-description">', '</div>' );
			?>
		</header>

		<?php if ( $query->have_posts() ) : ?>

			<?php while ( $query->have_posts() ) : $query->the_post(); ?>

				<?php
					get_template_part( 'template-parts/content' );
				?>

			<?php endwhile; ?>

			<?php the_posts_pagination(); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

	</div>