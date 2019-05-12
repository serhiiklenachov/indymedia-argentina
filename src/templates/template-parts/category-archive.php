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
<?php $category = get_queried_object(); ?>
<header class="category vl-main-header vl-clearfix">
	<?php
		$indymedia_category_image = get_theme_mod("indymedia_category_{$category->term_id}_image");

		if ( $indymedia_category_image ) {
			$attr = array(
				'class' => 'category-logo'
			);
			echo wp_get_attachment_image( $indymedia_category_image, 'full', false, $attr );
		} else {
			the_archive_title( '<h1>', '</h1>' );
			the_archive_description( '<div class="taxonomy-description">', '</div>' );
		}

		$indymedia_category_networks = get_theme_mod("indymedia_category_{$category->term_id}_social");
		
		if ( $indymedia_category_networks ) {
			echo '<div class="category-social">';
			$indymedia_category_networks = json_decode($indymedia_category_networks);

			foreach ($indymedia_category_networks as $indymedia_category_network ) {
				if ( $indymedia_category_network->url ) {
					switch ( $indymedia_category_network->type ) {
						case 'facebook':
							echo '<a title="'.$indymedia_category_network->name.'" target="_blank" href="'.$indymedia_category_network->url.'" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i> '.$indymedia_category_network->name.'</a>';
							break;
						case 'google':
							echo '<a title="'.$indymedia_category_network->name.'" target="_blank" href="'.$indymedia_category_network->url.'" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i> '.$indymedia_category_network->name.'</a>';
							break;
						case 'twitter':
							echo '<a title="'.$indymedia_category_network->name.'" target="_blank" href="'.$indymedia_category_network->url.'" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i> '.$indymedia_category_network->name.'</a>';
							break;
						case 'instagram':
							echo '<a title="'.$indymedia_category_network->name.'" target="_blank" href="'.$indymedia_category_network->url.'" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i> '.$indymedia_category_network->name.'</a>';
							break;
						case 'youtube':
							echo '<a title="'.$indymedia_category_network->name.'" target="_blank" href="'.$indymedia_category_network->url.'" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i> '.$indymedia_category_network->name.'</a>';
							break;
						case 'vimeo':
							echo '<a title="'.$indymedia_category_network->name.'" target="_blank" href="'.$indymedia_category_network->url.'" target="_blank"><i class="fa fa-vimeo" aria-hidden="true"></i> '.$indymedia_category_network->name.'</a>';
							break;
						case 'pinterest':
							echo '<a title="'.$indymedia_category_network->name.'" target="_blank" href="'.$indymedia_category_network->url.'" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i> '.$indymedia_category_network->name.'</a>';
							break;
					}
				}
			}
			echo '</div>';
		}

		$indymedia_category_editor = get_theme_mod("indymedia_category_{$category->term_id}_editor");

		if ( $indymedia_category_editor ) {
			echo '<div class="category-editor">' . $indymedia_category_editor . '</div>';
		}
	?>
</header>
<div id="vl-middle-section" class="vl-clearfix">
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
	<?php get_sidebar(); ?>
</div>