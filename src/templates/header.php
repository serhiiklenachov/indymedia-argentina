<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="vl-page">
	<header id="vl-masthead" class="vl-site-header">
		<div class="vl-top-header">
			<div class="vl-container clearfix">
				<div class="vl-top-left-header">
					<?php do_action('viral_left_header_content') ?>
				</div>

				<div class="vl-top-right-header">
					<?php do_action('viral_right_header_content') ?>
				</div>
			</div>
		</div>

		<div class="vl-header">
<?php
$images = get_theme_mod('indymedia_background_header_images');
if (is_array($images)) {
	$counter = 0;
	echo '<div id="header-cycler">';
	foreach ($images as $id) {
		$image = wp_get_attachment_image_src($id, 'full');
		echo '<img src="' . $image[0] . '"' . ($counter == 0 ? ' class="active"': ' ')  . ' />';
		$counter++;
	}
	echo '</div>';
}
?>
			<div class="vl-container clearfix">
			<div id="vl-site-branding">
					<?php 
					if ( function_exists( 'has_custom_logo' ) && has_custom_logo() ) :
						the_custom_logo();
					else : 
						if ( is_front_page() ) : ?>
							<h1 class="vl-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<?php else : ?>
							<p class="vl-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
						<?php endif; ?>
						<p class="vl-site-description"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'description' ); ?></a></p>
					<?php endif; ?>
				</div>

				<?php if(is_active_sidebar('viral-header-ads')){ ?> 
				<div class="vl-header-ads">
					<?php dynamic_sidebar('viral-header-ads'); ?>
				</div>
				<?php } ?>
			</div>
		</div>

		<nav id="vl-site-navigation" class="vl-main-navigation">
		<div class="vl-toggle-menu"><span></span></div>
			<?php wp_nav_menu( 
					array( 
					'theme_location' => 'primary', 
					'container_class' => 'vl-menu vl-clearfix' ,
					'menu_class' => 'vl-clearfix',
					'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>', 
					) 
				); 
			?>
		</nav>
		<?php if ( !is_category() ): ?>
		<img src="<?php echo get_template_directory_uri(); ?>/images/shadow.png">
		<?php endif; ?>
	</header>

	<div id="vl-content" class="vl-site-content">