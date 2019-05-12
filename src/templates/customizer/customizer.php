<?php
if ( !defined( 'ABSPATH' ) ) exit;

function indymedia_customize_register( $wp_customize ) {
	include 'control-editor.php';
	include 'control-repeater.php';
	/**
	 * Settings
	 */
	$wp_customize->add_setting(
		'indymedia_main_color',
		array(
			'default'			=> '#f58220',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'			=> 'postMessage',
		)
	);

	$defaultFont = 'Roboto:400,400italic,700,700italic';

	$wp_customize->add_setting(
		'indymedia_background_header_images',
		array(
			'default'			=> '',
			'capability'		=> 'edit_theme_options',
			'transport'			=> 'refresh',
		)
	);

	$wp_customize->add_setting(
		'indymedia_section_tag_font',
		array(
			'default'			=> $defaultFont,
			'capability'		=> 'edit_theme_options',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_setting(
		'indymedia_hero_title_font',
		array(
			'default'			=> $defaultFont,
			'capability'		=> 'edit_theme_options',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_setting(
		'indymedia_block_title_font',
		array(
			'default'			=> $defaultFont,
			'capability'		=> 'edit_theme_options',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_setting(
		'indymedia_post_title_font',
		array(
			'default'			=> $defaultFont,
			'capability'		=> 'edit_theme_options',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_setting(
		'indymedia_post_excerpt_font',
		array(
			'default'			=> $defaultFont,
			'capability'		=> 'edit_theme_options',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_setting(
		'indymedia_widget_title_font',
		array(
			'default'			=> $defaultFont,
			'capability'		=> 'edit_theme_options',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_setting(
		'indymedia_entry_title_font',
		array(
			'default'			=> $defaultFont,
			'capability'		=> 'edit_theme_options',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_setting(
		'indymedia_entry_content_font',
		array(
			'default'			=> $defaultFont,
			'capability'		=> 'edit_theme_options',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_setting(
		'indymedia_top_header_font',
		array(
			'default'			=> $defaultFont,
			'capability'		=> 'edit_theme_options',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_setting(
		'indymedia_main_navigation_font',
		array(
			'default'			=> $defaultFont,
			'capability'		=> 'edit_theme_options',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_setting(
		'indymedia_ticker_font',
		array(
			'default'			=> $defaultFont,
			'capability'		=> 'edit_theme_options',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_setting(
		'indymedia_background_header_counter',
		array(
			'default'			=> '5000',
			'capability'		=> 'edit_theme_options',
			'transport'			=> 'refresh',
		)
	);

	$wp_customize->add_setting(
		'viral_social_telegram',
		array(
			'default'			=> '',
			'sanitize_callback' => 'esc_url_raw'
		)
	);

	$categories = get_categories(array(
		'parent'  => 0,
		'orderby' => 'name',
		'order'   => 'ASC',
		'hide_empty' => false,
	));

	foreach( $categories as $category ) {
		indymedia_category_register_settings( $wp_customize, $category->term_id );

		$subcategories = get_categories(array(
			'parent' => $category->term_id,
			'orderby' => 'name',
			'order'   => 'ASC',
			'hide_empty' => false,
		));

		foreach( $subcategories as $subcategory ) {
			indymedia_category_register_settings( $wp_customize, $subcategory->term_id );
		}
	}

	/**
	 * Controls
	 */

	$wp_customize->add_control(
		new \CustomizeImageGalleryControl\Control(
			$wp_customize,
			'background_header_images',
			array(
				'label'				=> __( 'Imágenes', 'indymedia' ),
				'section'			=> 'viral_header_settings_sec',
				'settings'			=> 'indymedia_background_header_images',
				'priority'			=> 5
			)
		)
	);
}

add_action( 'customize_register', 'indymedia_customize_register' );

function indymedia_category_register_settings( $wp_customize, $category ) {
	$wp_customize->add_setting(
		"indymedia_category_{$category}_image",
		array(
			'default'			=> '',
			'capability'		=> 'edit_theme_options'
		)
	);

	$wp_customize->add_setting(
		"indymedia_category_{$category}_social",
		array(
			'capability' => 'edit_theme_options',
			'default'    => json_encode(array(array(
				'name' => '',
				'url'  => ''
			)))
		)
	);

	$wp_customize->add_setting(
		"indymedia_category_{$category}_editor",
		array(
			'default' => '',
			'transport' => 'refresh',
			'sanitize_callback' => 'wp_kses_post'
		)
	);

	$wp_customize->add_setting( 
		"indymedia_category_{$category}_top_blocks",
		array(
			'capability' => 'edit_theme_options',
			'default' => json_encode(array(array(
				'category' => '0',
				'layout' => 'style1',
				'highlight' => 'off',
				'enable' => 'on'
			)))
		)
	);

	$wp_customize->add_setting( 
		"indymedia_category_{$category}_middle_blocks",
		array(
		'sanitize_callback' => 'viral_sanitize_repeater',
		'default' => json_encode(array(array(
			'category' => '0',
			'layout' => 'style1',
			'enable' => 'on'
		)))
	));
}

function indymedia_customize_preview() {
	wp_enqueue_script( 'indymedia_customizer_preview', get_stylesheet_directory_uri() . '/js/preview.js', array( 'customize-preview' ), '20180224', true );
}
add_action( 'customize_preview_init', 'indymedia_customize_preview' );

function indymedia_customizer_controls() {
	wp_register_script( 'indymedia_customizer', get_stylesheet_directory_uri() . '/js/customizer.js', array(), null, true );

	$data = array();

	$data[ 'fonts' ] = array(
		'Arimo:400,700,400italic,700italic' => 'Arimo',
		'Arvo:400,700,400italic,700italic' => 'Arvo',
		'Bitter:400,700,400italic' => 'Bitter',
		'Cabin:400,700,400italic' => 'Cabin',
		'Droid Sans:400,700' => 'Droid Sans',
		'Droid Serif:400,700,400italic,700italic' => 'Droid Serif',
		'Fjalla One:400' => 'Fjalla One',
		'Francois One:400' => 'Francois One',
		'Josefin Sans:400,300,600,700' => 'Josefin Sans',
		'Lato:400,700,400italic,700italic' => 'Lato',
		'Libre Baskerville:400,400italic,700' => 'Libre Baskerville',
		'Lora:400,700,400italic,700italic' => 'Lora',
		'Merriweather:400,300italic,300,400italic,700,700italic' => 'Merriweather',
		'Montserrat:400,700' => 'Montserrat',
		'Open Sans:400italic,700italic,400,700' => 'Open Sans',
		'Open Sans Condensed:700,300italic,300' => 'Open Sans Condensed',
		'Oswald:400,700' => 'Oswald',
		'Oxygen:400,300,700' => 'Oxygen',
		'Playfair Display:400,700,400italic' => 'Playfair Display',
		'PT Sans:400,700,400italic,700italic' => 'PT Sans',
		'PT Sans Narrow:400,700' => 'PT Sans Narrow',
		'PT Serif:400,700' => 'PT Serif',
		'Raleway:400,700' => 'Raleway',
		'Roboto:400,400italic,700,700italic' => 'Roboto',
		'Roboto Condensed:400italic,700italic,400,700' => 'Roboto Condensed',
		'Roboto Slab:400,700' => 'Roboto Slab',
		'Rokkitt:400' => 'Rokkitt',
		'Source Sans Pro:400,700,400italic,700italic' => 'Source Sans Pro',
		'Ubuntu:400,700,400italic,700italic' => 'Ubuntu',
		'Yanone Kaffeesatz:400,700' => 'Yanone Kaffeesatz'
	);

	$data[ 'theme' ][ 'url' ] = get_stylesheet_directory_uri();
	$data[ 'theme' ][ 'parent' ][ 'url' ] = get_template_directory_uri();

	$categories = get_categories(array(
		'parent'  => 0,
		'orderby' => 'name',
		'order'   => 'ASC',
		'hide_empty' => false,
	));

	foreach( $categories as $category ) {
		$data[ 'categories' ][ $category->term_id ]['title'] = $category->name;

		$subcategories = get_categories(array(
			'parent' => $category->term_id,
			'orderby' => 'name',
			'order'   => 'ASC',
			'hide_empty' => false,
		));

		foreach( $subcategories as $subcategory ) {
			$data[ 'categories' ][ $category->term_id ]['subcategories'][ $subcategory->term_id ] = $subcategory->name;
		}
	}

	$data[ 'l10n' ] = array(
		'addSection' => __('Add Section','viral'),
		'backgroundImages' => __( 'Imágenes', 'indymedia' ),
		'blockTitleFont' => __( 'Títulos de Bloque', 'indymedia' ),
		'blockTitleFontDescription' => __( 'Fuente de los títulos de los bloques mostrados en primera plana', 'indymedia' ),
		'categoriesEditorControlLabel' => __( 'Texto en cabecera', 'indymedia' ),
		'categoriesImageControlLabel' => __( 'Imagen', 'indymedia' ),
		'categoriesImageControlDescription' => __( 'Imagen a mostrar en la cabecera de la sección', 'indymedia' ),
		'categoriesPanelTitle' => __( 'Categorias', 'indymedia' ),
		'categoriesSocialControlLabel' => __('Redes sociales', 'indymedia'),
		'categoriesSocialControlAddButton' => __('Agregar Red Social','indymedia'),
		'changeLogo' => __( 'Cambiar Logo', 'indymedia' ),
		'chooseLogo' => __( 'Seleccionar logo', 'indymedia' ),
		'contentBlocksLabel' => __('Bloques de contenido','indymedia'),
		'customSectionAction' => __( 'You are customizing %s' ),
		'default' => __( 'Predeterminado', 'indymedia' ),
		'enableSection' => __( 'Enable Section', 'viral' ),
		'entryContentFont' => __( 'Contenido de las Entradas', 'indymedia' ),
		'entryContentFontDescription' => __( 'Fuente del contenido de las entradas individuales', 'indymedia' ),
		'entryTitleFont' => __( 'Títulos de las Entradas', 'indymedia' ),
		'entryTitleFontDescription' => __( 'Fuente de los títulos de las entradas individuales', 'indymedia' ),
		'fontsSectionTitle' => __( 'Fuentes', 'indymedia' ),
		'headerCounterLabel' => __( 'Retardo', 'indymedia' ),
		'headerCounterDescription' => __( 'Tiempo en milisegundos que se verá cada imagen en la cabecera', 'indymedia' ),
		'heroTitleFont' => __( 'Títulos Destacados', 'indymedia' ),
		'heroTitleFontDescription' => __( 'Fuente de los títulos de las noticias destacadas mostradas en la parte superior de la primera plana', 'indymedia' ),
		'highlighted' => __( 'Destacados', 'indymedia' ),
		'layoutsLabel' => __( 'Layouts', 'viral' ),
		'layoutsDescription' => __( 'Select the Block Layout', 'viral' ),
		'logoNotSelected' => __( 'Logo no seleccionado', 'indymedia' ),
		'mainColorLabel' => __( 'Color principal', 'indymedia' ),
		'mainColorDescription' => __( 'Los colores que se muestran al pasar el mouse por encima de un objeto requieren recargar la página para actualizarlos', 'indymedia' ),
		'mainNavigationFont' => __( 'Menú Principal', 'indymedia' ),
		'mainNavigationFontDescription' => __( 'Fuente del menú principal del sitio', 'indymedia' ),
		'newsSection' => __('News Section','viral'),
		'optionYes' => __('Si', 'indymedia'),
		'optionNo' => __('No', 'indymedia'),
		'postTitleFont' => __( 'Títulos de Artículos', 'indymedia' ),
		'postTitleFontDescription' => __( 'Fuente de los títulos de artículos mostrados en primera plana', 'indymedia' ),
		'postExcerptFont' => __( 'Extractos de Artículos', 'indymedia' ),
		'postExcerptFontDescription' => __( 'Fuente de los resumenes de artículos mostrados en primera plana', 'indymedia' ),
		'refresh' => __( 'Recargar', 'indymedia' ),
		'remove' => __( 'Eliminar', 'indymedia' ),
		'sectionTagsFont' => __( 'Etiquetas de Sección', 'indymedia' ),
		'socialNetwork' => __( 'Red Social', 'indymedia' ),
		'tickerFont' => __( 'Teletipo', 'indymedia' ),
		'tickerFontDescription' => __( 'Fuente del teletipo, tanto título como contenido.', 'indymedia' ),
		'topBlocksLabel' => __('Bloques de cabecera','indymedia'),
		'topHeaderFont' => __( 'Menú Superior de la Cabecera', 'indymedia' ),
		'topHeaderFontDescription' => __( 'Fuente del menú ubicado en la parte superior de la página', 'indymedia' ),
		'widgetTitleFont' => __( 'Títulos de Widgets', 'indymedia' ),
		'widgetTitleFontDescription' => __( 'Fuente de los títulos de los widgets', 'indymedia' )

	);

	wp_localize_script( 'indymedia_customizer', '_wpIndymediaData', $data );
	wp_enqueue_script( 'indymedia_customizer' );
}
add_action( 'customize_controls_enqueue_scripts', 'indymedia_customizer_controls' );

function indymedia_customizer_font_frontend() {
	$fonts = array_values( array_unique( array(
		get_theme_mod( 'indymedia_section_tag_font' ),
		get_theme_mod( 'indymedia_hero_title_font' ),
		get_theme_mod( 'indymedia_block_title_font' ),
		get_theme_mod( 'indymedia_post_title_font' ),
		get_theme_mod( 'indymedia_post_excerpt_font' ),
		get_theme_mod( 'indymedia_widget_title_font' ),
		get_theme_mod( 'indymedia_entry_title_font' ),
		get_theme_mod( 'indymedia_entry_content_font' ),
		get_theme_mod( 'indymedia_top_header_font' ),
		get_theme_mod( 'indymedia_main_navigation_font' ),
		get_theme_mod( 'indymedia_ticker_font' ),
	) ) );

	for ( $i = 0; $i < count($fonts); $i++) {
		$name = explode( ':', $fonts[$i] );

		if ($name[0] == 'Roboto Condensed' || $name[0] == 'Roboto') {
			continue;
		}

		$name = strtolower( implode( explode( ' ', $name[0] ) ) );
		wp_enqueue_style( 'indymedia-font-' . $name, '//fonts.googleapis.com/css?family='. esc_html( $fonts[$i] ) );
	}
}
add_action( 'wp_enqueue_scripts', 'indymedia_customizer_font_frontend' );

function indymedia_customizer_font_backend() {
	$fonts = array(
		'Source Sans Pro:400,700,400italic,700italic',
		'Open Sans:400italic,700italic,400,700',
		'Oswald:400,700',
		'Playfair Display:400,700,400italic',
		'Montserrat:400,700',
		'Raleway:400,700',
		'Droid Sans:400,700',
		'Lato:400,700,400italic,700italic',
		'Arvo:400,700,400italic,700italic',
		'Lora:400,700,400italic,700italic',
		'Merriweather:400,300italic,300,400italic,700,700italic',
		'Oxygen:400,300,700',
		'PT Serif:400,700',
		'PT Sans:400,700,400italic,700italic',
		'PT Sans Narrow:400,700',
		'Cabin:400,700,400italic',
		'Fjalla One:400',
		'Francois One:400',
		'Josefin Sans:400,300,600,700',
		'Libre Baskerville:400,400italic,700',
		'Arimo:400,700,400italic,700italic',
		'Ubuntu:400,700,400italic,700italic',
		'Bitter:400,700,400italic',
		'Droid Serif:400,700,400italic,700italic',
		'Roboto:400,400italic,700,700italic',
		'Open Sans Condensed:700,300italic,300',
		'Roboto Condensed:400italic,700italic,400,700',
		'Roboto Slab:400,700',
		'Yanone Kaffeesatz:400,700',
		'Rokkitt:400',
	);

	for ($i = 0; $i < count($fonts); $i++ ) {
		$name = explode( ':', $fonts[$i] );

		if ($name[0] == 'Roboto Condensed' || $name[0] == 'Roboto') {
			continue;
		}

		$name = strtolower( implode( explode( ' ', $name[0] ) ) );
		wp_enqueue_style( 'indymedia-font-' . $name, '//fonts.googleapis.com/css?family='. esc_html( $fonts[$i] ) );
	}
}
add_action( 'customize_preview_init', 'indymedia_customizer_font_backend' );
