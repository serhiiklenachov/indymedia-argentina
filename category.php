<?php
$category = get_queried_object();
get_header();
?>

<div class="vl-container">
	<header class="category vl-main-header">
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
						}
					}
				}
				echo '</div>';
			}
		?>
	</header>

	<div id="vl-top-section">
	<?php 

	$indymedia_category_top_blocks = get_theme_mod("indymedia_category_{$category->term_id}_top_blocks");

	if ( $indymedia_category_top_blocks ) {

		$indymedia_category_top_blocks = json_decode($indymedia_category_top_blocks);

		foreach ($indymedia_category_top_blocks as $indymedia_category_top_block) {

			if ( $category->term_id && ($indymedia_category_top_block->enable == 'on' )){
				$indymedia_layout = $indymedia_category_top_block->layout;
				
				$args = array(
					'cat' => $category->term_id,
					'layout' => $indymedia_layout
					);

				do_action('viral_top_section', $args);
			}
		}
	}
	?>
	</div>
	<div id="vl-middle-section" class="vl-clearfix">
		<div id="primary">
			<?php

			$indymedia_category_blocks = get_theme_mod("indymedia_category_{$category->term_id}_middle_blocks");

			if ( $indymedia_category_blocks ) {

				$indymedia_category_blocks = json_decode($indymedia_category_blocks);

				foreach ($indymedia_category_blocks as $indymedia_category_block) {

					if ( $category->term_id && ($indymedia_category_block->enable == 'on' )){
						$args = array(
							'cat' => $category->term_id,
							'layout' => $indymedia_category_block->layout,
							'title' => ''
						);

						do_action('viral_middle_section', $args);
					}

				}
			}
			?>
		</div>
		<?php get_sidebar(); ?>
	</div>
</div>
<?php get_footer(); ?>