<?php
if ( !defined( 'ABSPATH' ) ) exit;

function indymedia_customize_categories( $wp_customize ) {
	$categories = get_categories(array(
		'parent'  => 0,
		'orderby' => 'name',
		'order'   => 'ASC',
		'hide_empty' => false,
	));

	$wp_customize->add_panel(
		'indymedia_categories_panel',
		array(
			'title' 			=> __( 'Categorias', 'indymedia' ),
			'priority'          => 21
		)
	);

	foreach( $categories as $category ) {
		$wp_customize->add_section(
			"indymedia_category_{$category->term_id}",
			array(
				'title'				=> $category->name,
				'panel'				=> 'indymedia_categories_panel'
			)
		);

		$subcategories = get_categories(array(
			'parent' => $category->term_id,
			'orderby' => 'name',
			'order'   => 'ASC',
			'hide_empty' => false,
		));

		if ( count($subcategories) > 0 ) {
			foreach( $subcategories as $subcategory ) {
				$wp_customize->add_section(
					"indymedia_category_{$subcategory->term_id}",
					array(
						'title'				=> $category->name . ' / ' . $subcategory->name,
						'panel'				=> 'indymedia_categories_panel'
					)
				);

				indymedia_customize_categories_add_controls( $wp_customize, $subcategory->term_id );
			}
		} else {
			indymedia_customize_categories_add_controls( $wp_customize, $category->term_id );
		}

	}
}

function indymedia_customize_categories_add_controls( $wp_customize, $category ) {
	$image_path_url = get_template_directory_uri().'/images/';

	$wp_customize->add_setting(
		"indymedia_category_{$category}_image",
		array(
			'default'			=> '',
			'capability'		=> 'edit_theme_options'
		)
	);

	$wp_customize->add_control( 
		new WP_Customize_Media_Control( 
			$wp_customize, 
			"indymedia_category_{$category}_image_control",
			array(
				'label'       => __( 'Imagen', 'indymedia' ),
				'section'     => "indymedia_category_{$category}",
				'description' => 'Imagen a mostrar en la cabecera de la sección',
				'settings'    => "indymedia_category_{$category}_image",
				'mime_type'   => 'image',
			)
		)
	);

	$wp_customize->add_setting(
		"indymedia_category_{$category}_social",
		array(
			'capability'		=> 'edit_theme_options',
			'default'			=> json_encode(array(
				array(
					'name' => '',
					'url' => ''
					)
			))
		)
	);

	$wp_customize->add_control( 
		new Viral_Repeater_Controler(
			$wp_customize, 
			"indymedia_category_{$category}_social_control",
			array(
				'label'   => __('Redes sociales', 'indymedia'),
				'section' => "indymedia_category_{$category}",
				'settings' => "indymedia_category_{$category}_social",
				'viral_box_label' => __('Redes Sociales','indymedia'),
				'viral_box_add_control' => __('Agregar Red Social','indymedia'),
			),
			array(
				'type' => array(
					'type'          => 'select',
					'label'         => __( 'Red Social', 'indymedia' ),
					'options'       => array(
						'facebook'  => __( 'Facebook', 'indymedia' ),
						'google'    => __( 'Google+', 'indymedia' ),
						'twitter'   => __( 'Twitter', 'indymedia' ),
						'instagram' => __( 'Instagram', 'indymedia' ),
						'pinterest' => __( 'Pinterest', 'indymedia' ),
						'telegram'  => __( 'Telegram', 'indymedia' ),
						'vimeo'     => __( 'Vimeo', 'indymedia' ),
						'youtube'   => __( 'YouTube', 'indymedia' ),
					)
				),
				'name' => array(
					'type'        => 'text',
					'label'       => __( 'Nombre', 'indymedia' ),
					'default'     => ''
				),
				'url' => array(
					'type'        => 'text',
					'label'       => __( 'URL', 'indymedia' ),
					'default'     => ''
				),
			)
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

	$wp_customize->add_control(
		new WP_Customize_Editor(
			$wp_customize,
			"indymedia_category_{$category}_editor_control",
			array(
				'label' => 'Texto en cabecera',
				'section' => "indymedia_category_{$category}",
				'settings' => "indymedia_category_{$category}_editor",
				'type' => 'textarea'
			)
		)
	);

	$wp_customize->add_setting( 
		"indymedia_category_{$category}_top_blocks",
		array(
		'sanitize_callback' => 'viral_sanitize_repeater',
		'default' => json_encode(array(
			array(
				'category' => '0',
				'layout' => 'style1',
				'highlight' => 'off',
				'enable' => 'on'
				)
		))
	));

	$wp_customize->add_control( 
		new Viral_Repeater_Controler(
			$wp_customize, 
			"indymedia_category_{$category}_top_blocks_control",
			array(
				'label'   => __('Bloques de cabecera','indymedia'),
				'section' => "indymedia_category_{$category}",
				'settings' => "indymedia_category_{$category}_top_blocks",
				'viral_box_label' => __('News Section','viral'),
				'viral_box_add_control' => __('Add Section','viral'),
			),
			array(
				'layout' => array(
					'type'        => 'selector',
					'label'       => __( 'Layouts', 'viral' ),
					'description' => __( 'Select the Block Layout', 'viral' ),
					'options' => array(
						'style1' => $image_path_url.'top-layout1.png',
						'style2' => $image_path_url.'top-layout2.png',
						'style3' => $image_path_url.'top-layout3.png',
						'style4' => $image_path_url.'top-layout4.png',
						),
					'default'     => 'style1'
				),
				'highlight' => array(
					'type'        => 'switch',
					'label'       => __( 'Destacados', 'indymedia' ),
					'switch' => array(
						'on' => 'Si',
						'off' => 'No'
						),
					'default'     => 'off'
				),
				'enable' => array(
					'type'        => 'switch',
					'label'       => __( 'Enable Section', 'viral' ),
					'switch' => array(
						'on' => 'Si',
						'off' => 'No'
						),
					'default'     => 'on'
				)
			)
		) 
	);

	$wp_customize->add_setting( 
		"indymedia_category_{$category}_middle_blocks",
		array(
		'sanitize_callback' => 'viral_sanitize_repeater',
		'default' => json_encode(array(
			array(
				'category' => '0',
				'layout' => 'style1',
				'enable' => 'on'
				)
		))
	));

	$wp_customize->add_control( 
		new Viral_Repeater_Controler(
			$wp_customize, 
			"indymedia_category_{$category}_middle_blocks_control",
			array(
				'label'   => __('Bloques de contenido','indymedia'),
				'section' => "indymedia_category_{$category}",
				'settings' => "indymedia_category_{$category}_middle_blocks",
				'viral_box_label' => __('News Section','viral'),
				'viral_box_add_control' => __('Add Section','viral'),
			),
			array(
				'layout' => array(
					'type'        => 'selector',
					'label'       => __( 'Layouts', 'viral' ),
					'description' => __( 'Select the Block Layout', 'viral' ),
					'options' => array(
						'style1' => $image_path_url.'middle-layout1.png',
						'style2' => $image_path_url.'middle-layout2.png',
						'style3' => $image_path_url.'middle-layout3.png',
						'style4' => $image_path_url.'middle-layout4.png',
						),
					'default'     => 'style1'
				),
				'enable' => array(
					'type'        => 'switch',
					'label'       => __( 'Enable Section', 'viral' ),
					'switch' => array(
						'on' => 'Si',
						'off' => 'No'
						),
					'default'     => 'on'
				)
			)
		) 
	);
}

add_action( 'customize_register', 'indymedia_customize_categories' );