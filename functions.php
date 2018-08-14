<?php
if ( !defined( 'ABSPATH' ) ) exit;

include get_stylesheet_directory() . '/inc/editor.php';
include get_stylesheet_directory() . '/inc/customizer.php';
include get_stylesheet_directory() . '/inc/categories.php';
include get_stylesheet_directory() . '/inc/deduplicator.php';
include get_stylesheet_directory() . '/inc/hooks.php';
include get_stylesheet_directory() . '/inc/meta.php';
include get_stylesheet_directory() . '/inc/template-tags.php';
include get_stylesheet_directory() . '/inc/gallery.php';

if ( !function_exists( 'indymedia_theme_setup' ) ) {
	function indymedia_theme_setup() {
		wp_enqueue_style( 'viral-style', trailingslashit( get_template_directory_uri() ) . 'style.css', array( 'font-awesome','owl-carousel' ) );
		wp_enqueue_style( 'font-awesome', get_stylesheet_directory_uri() . '/css/font-awesome.min.css', array(), '4.7.0' );
		wp_enqueue_style( 'fancybox-style', get_stylesheet_directory_uri() . '/vendor/fancybox/jquery.fancybox.min.css', array(), '3.2.10', 'screen' );
		wp_enqueue_style( 'flexslider-style', get_stylesheet_directory_uri() . '/vendor/flexslider/flexslider.css', array(), '2.7.0', 'screen' );
		wp_style_add_data( 'flexslider-style', 'rtl', get_stylesheet_directory_uri() . '/vendor/flexslider/flexslider-rtl-min.css', array(), '2.7.0', 'screen' );
		wp_enqueue_style( 'indymedia-style', get_stylesheet_directory_uri() . '/style.css', 'parent-style' );

		wp_enqueue_script( 'fancybox-script', get_stylesheet_directory_uri() . '/vendor/fancybox/jquery.fancybox.min.js', array( 'jquery' ), '3.2.10', true );
		wp_enqueue_script( 'flexslider-script', get_stylesheet_directory_uri() . '/vendor/flexslider/jquery.flexslider-min.js', array( 'jquery' ), '2.7.0', true );
	}
}

add_action( 'wp_enqueue_scripts', 'indymedia_theme_setup' );

function indymedia_enqueue_dynamic_css() {
	$main_color = get_theme_mod('indymedia_main_color', '#f58220');
	$section_tag_font = esc_html(get_theme_mod('indymedia_section_tag_font'));
	$hero_title_font = esc_html(get_theme_mod('indymedia_hero_title_font'));
	$block_title_font = esc_html(get_theme_mod('indymedia_block_title_font'));
	$post_title_font = esc_html(get_theme_mod('indymedia_post_title_font'));
	$post_excerpt_font = esc_html(get_theme_mod('indymedia_post_excerpt_font'));
	$widget_title_font = esc_html(get_theme_mod('indymedia_widget_title_font'));
	$entry_title_font = esc_html(get_theme_mod('indymedia_entry_title_font'));
	$entry_content_font = esc_html(get_theme_mod('indymedia_entry_content_font'));
	$top_header_font = esc_html(get_theme_mod('indymedia_top_header_font'));
	$main_navigation_font = esc_html(get_theme_mod('indymedia_main_navigation_font'));
	$ticker_font = esc_html(get_theme_mod('indymedia_ticker_font'));

	$css = '';

	$css .= 'input[type="submit"] { background: ' . $main_color . '; }';
	$css .= 'a { color: ' . $main_color . '; }';
	$css .= '.widget-title{ border-left: 6px solid ' . $main_color . '; }';
	$css .= '.vl-post-info{ background: ' . $main_color . '; }';
	$css .= '.entry-categories .fa{ color: ' . $main_color . '; }';
	$css .= '.entry-footer .vl-read-more{ background: ' . $main_color . '; }';
	$css .= '.widget-area a:hover{ color: ' . $main_color . '; }';
	$css .= '.vl-timeline .vl-post-item:hover:after{ background: ' . $main_color . '; }';
	$css .= 'h3#reply-title, h3.comments-title{ border-left: 6px solid ' . $main_color . '; }';
	$css .= '.comment-list a:hover{ color: ' . $main_color . '; }';
	$css .= '.comment-navigation .nav-previous a, .comment-navigation .nav-next a{ background: ' . $main_color . '; }';
	$css .= '.comment-navigation .nav-next a:after{ border-left: 11px solid ' . $main_color . '; }';
	$css .= '.comment-navigation .nav-previous a:after{ border-right: 11px solid ' . $main_color . '; }';
	$css .= '.pagination a, .pagination span{ background: ' . $main_color . '; }';
	$css .= '.vl-top-header{ background: ' . $main_color . '; }';
	$css .= '.vl-site-title a{ color: ' . $main_color . '; }';
	$css .= '.vl-site-description{ color: ' . $main_color . '; }';
	$css .= '#vl-site-navigation{ background: ' . $main_color . '; }';
	$css .= '.vl-main-navigation ul ul { background: ' . $main_color . '; }';
	$css .= '.post-navigation a:hover{ color: ' . $main_color . '; }';
	$css .= '.vl-ticker-title{ background: ' . $main_color . '; }';
	$css .= '.vl-ticker-title:after{ border-color: transparent transparent transparent ' . $main_color . '; }';
	$css .= '.vl-ticker .owl-item a:hover{ color: ' . $main_color . '; }';
	$css .= '.vl-ticker .owl-prev, .vl-ticker .owl-next{ background: ' . $main_color . '; }';
	$css .= '.vl-title-container h3:after{ background: ' . $main_color . '; }';
	$css .= '.vl-top-block .post-categories li a:hover{ background: ' . $main_color . '; }';
	$css .= '.vl-top-block.style4 .vl-post-item:after{ background: ' . $main_color . '; }';
	$css .= '.vl-block-title{ border-left: 10px solid ' . $main_color . '; }';
	$css .= '.vl-post-item h3 a:hover{ color: ' . $main_color . '; }';
	$css .= '#vl-back-top{ background: ' . $main_color . '; }';

	if ( $section_tag_font ) {
		$font_data = explode(':', $section_tag_font);
		$css .= '.post-categories li a{ font-family: ' . $font_data[0] . ' }';
	}

	if ( $hero_title_font ) {
		$font_data = explode(':', $hero_title_font);
		$css .= '.vl-title-container h3{ font-family: ' . $font_data[0] . ' }';
	}

	if ( $block_title_font ) {
		$font_data = explode(':', $block_title_font);
		$css .= '.vl-block-title span{ font-family: ' . $font_data[0] . ' }';
	}

	if ( $post_title_font ) {
		$font_data = explode(':', $post_title_font);
		$css .= '.vl-post-item h3{ font-family: ' . $font_data[0] . ' }';
		$css .= '.vl-post-content h3{ font-family: ' . $font_data[0] . ' }';
	}

	if ( $post_excerpt_font ) {
		$font_data = explode(':', $post_excerpt_font);
		$css .= '.vl-post-item .vl-excerpt{ font-family: ' . $font_data[0] . ' }';
	}

	if ( $widget_title_font ) {
		$font_data = explode(':', $widget_title_font);
		$css .= 'h3.widget-title{ font-family: ' . $font_data[0] . ' }';
	}

	if ( $entry_title_font ) {
		$font_data = explode(':', $entry_title_font);
		$css .= '.vl-main-header h1{ font-family: ' . $font_data[0] . ' }';
		$css .= '.entry-title{ font-family: ' . $font_data[0] . ' }';
	}

	if ( $entry_content_font ) {
		$font_data = explode(':', $entry_content_font);
		$css .= 'article .entry-content{ font-family: ' . $font_data[0] . ' }';
	}

	if ( $top_header_font ) {
		$font_data = explode(':', $top_header_font);
		$css .= '.vl-top-header{ font-family: ' . $font_data[0] . ' }';
	}

	if ( $main_navigation_font ) {
		$font_data = explode(':', $main_navigation_font);
		$css .= '.vl-main-navigation{ font-family: ' . $font_data[0] . ' }';
	}

	if ( $ticker_font ) {
		$font_data = explode(':', $ticker_font);
		$css .= '.vl-ticker{ font-family: ' . $font_data[0] . ' }';
	}

	echo "<style>$css</style>";
}

add_action( 'wp_head', 'indymedia_enqueue_dynamic_css' );

function indymedia_footer() {
	$images = get_theme_mod('indymedia_background_header_images');
	$counter = get_theme_mod('indymedia_background_header_counter', 5000);
	if (is_array($images)) {
?>
<script type="text/javascript">
jQuery(function($) {
	function cycleImages() {
		var $active = $('#header-cycler .active');
		var $next = ($active.next().length > 0) ? $active.next() : $('#header-cycler img:first');
		$next.css('z-index', -4);
		$active.fadeOut(1500, function() {
			$next.css('z-index', -3).addClass('active');
			$active.css('z-index', -5).show().removeClass('active');
		});
	}
	setInterval(cycleImages, <?php echo $counter; ?>);

	$('#header-cycler').width($('.vl-header').width());
	$('#header-cycler').height($('.vl-header').height());
	$(window).resize(function() {
		$('#header-cycler').width($('.vl-header').width());
		$('#header-cycler').height($('.vl-header').height());
	});

	$('.gallery-item a').fancybox({});
});
</script>
<?php
	}
}

add_action( 'wp_footer', 'indymedia_footer', 22 );

function viral_show_date(){
	$viral_left_header_date = get_theme_mod('viral_left_header_date');
	if($viral_left_header_date){ 
		echo '<span><i class="fa fa-clock-o" aria-hidden="true"></i>';
		echo date_i18n('l, F j');
		echo '</span>';
	} 
}

function indymedia_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Cabecera página principal', 'indymedia' ),
		'id'            => 'indymedia-frontpage',
		'description'   => 'Parte superior de la página principal, entre el teletipo y las noticias destacadas',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'indymedia_widgets_init' );

function viral_excerpt( $content , $letter_count ){
	$content = strip_shortcodes( $content );
	$content = strip_tags( $content );

	if( strlen( $content ) > $letter_count ){
		$white = mb_stripos( $content, ' ', $letter_count - 1);
		$content = mb_substr( $content, 0 , $white );
		$content .= "...";
	}

	return $content;
}