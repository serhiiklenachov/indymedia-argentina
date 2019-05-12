<?php
/**
 * @package Viral
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('vl-article-content'); ?>>
	<header class="entry-header">
		<div class="entry-social">
			<?php viral_social_share( false ) ?>
		</div>
		<?php viral_post_date(); ?>
	</header>
	
	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'viral' ),
				'after'  => '</div>',
			) );
		?>
	</div>
	
	<footer class="entry-footer">
		<?php viral_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

