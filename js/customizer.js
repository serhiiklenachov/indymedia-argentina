( function( api ) {
	api.data = window._wpIndymediaData;

	api.bind( 'ready', function() {
		api.section.add(
			new api.Section( 'indymedia_fonts', {
				title: api.data.l10n.fontsSectionTitle,
				panel: 'viral_general_settings_panel',
				priority: 50,
				customizeAction: api.data.l10n.customSectionAction
			})
		);

		api.control.add(
			new api.Control( 'indymedia_section_tag_font_selector', {
				label: api.data.l10n.sectionTagsFont,
				section: 'indymedia_fonts',
				setting: api( 'indymedia_section_tag_font' ),
				type: 'select',
				choices: api.data.fonts
			})
		);

		api.control.add(
			new api.Control( 'indymedia_hero_title_font_selector', {
				label: api.data.l10n.heroTitleFont,
				description: api.data.l10n.heroTitleFontDescription,
				section: 'indymedia_fonts',
				setting: api( 'indymedia_hero_title_font' ),
				type: 'select',
				choices: api.data.fonts
			})
		);

		api.control.add(
			new api.Control( 'indymedia_block_title_font_selector', {
				label: api.data.l10n.blockTitleFont,
				description: api.data.l10n.blockTitleFontDescription,
				section: 'indymedia_fonts',
				setting: api( 'indymedia_block_title_font' ),
				type: 'select',
				choices: api.data.fonts
			})
		);

		api.control.add(
			new api.Control( 'indymedia_post_title_font_selector', {
				label: api.data.l10n.postTitleFont,
				description: api.data.l10n.postTitleFontDescription,
				section: 'indymedia_fonts',
				setting: api( 'indymedia_post_title_font' ),
				type: 'select',
				choices: api.data.fonts
			})
		);

		api.control.add(
			new api.Control( 'indymedia_post_excerpt_font_selector', {
				label: api.data.l10n.postExcerptFont,
				description: api.data.l10n.postExcerptFontDescription,
				section: 'indymedia_fonts',
				setting: api( 'indymedia_post_excerpt_font' ),
				type: 'select',
				choices: api.data.fonts
			})
		);

		api.control.add(
			new api.Control( 'indymedia_widget_title_font_selector', {
				label: api.data.l10n.widgetTitleFont,
				description: api.data.l10n.widgetTitleFontDescription,
				section: 'indymedia_fonts',
				setting: api( 'indymedia_widget_title_font' ),
				type: 'select',
				choices: api.data.fonts
			})
		);

		api.control.add(
			new api.Control( 'indymedia_entry_title_font_selector', {
				label: api.data.l10n.entryTitleFont,
				description: api.data.l10n.entryTitleFontDescription,
				section: 'indymedia_fonts',
				setting: api( 'indymedia_entry_title_font' ),
				type: 'select',
				choices: api.data.fonts
			})
		);

		api.control.add(
			new api.Control( 'indymedia_entry_content_font_selector', {
				label: api.data.l10n.entryContentFont,
				description: api.data.l10n.entryContentFontDescription,
				section: 'indymedia_fonts',
				setting: api( 'indymedia_entry_content_font' ),
				type: 'select',
				choices: api.data.fonts
			})
		);

		api.control.add(
			new api.Control( 'indymedia_top_header_font_selector', {
				label: api.data.l10n.topHeaderFont,
				description: api.data.l10n.topHeaderFontDescription,
				section: 'indymedia_fonts',
				setting: api( 'indymedia_top_header_font' ),
				type: 'select',
				choices: api.data.fonts
			})
		);

		api.control.add(
			new api.Control( 'indymedia_main_navigation_font_selector', {
				label: api.data.l10n.mainNavigationFont,
				description: api.data.l10n.mainNavigationFontDescription,
				section: 'indymedia_fonts',
				setting: api( 'indymedia_main_navigation_font' ),
				type: 'select',
				choices: api.data.fonts
			})
		);

		api.control.add(
			new api.Control( 'indymedia_ticker_font_selector', {
				label: api.data.l10n.tickerFont,
				description: api.data.l10n.tickerFontDescription,
				section: 'indymedia_fonts',
				setting: api( 'indymedia_ticker_font' ),
				type: 'select',
				choices: api.data.fonts
			})
		);

		api.panel.add(
			new api.Panel( 'indymedia_categories_panel', {
				title: api.data.l10n.categoriesPanelTitle,
				priority: 21
			})
		);

		for ( id in api.data.categories ) {
			api.section.add(
				new api.Section( 'indymedia_category_' + id, {
					title: api.data.categories[id].title,
					panel: 'indymedia_categories_panel',
					customizeAction: api.data.l10n.customSectionAction
				})
			);

			if ( api.data.categories[id].subcategories ) {
				for ( sid in api.data.categories[id].subcategories ) {
					api.section.add(
						new api.Section( 'indymedia_category_' + sid, {
							title: api.data.categories[id].title + ' / ' + api.data.categories[id].subcategories[sid],
							panel: 'indymedia_categories_panel',
							customizeAction: api.data.l10n.customSectionAction
						})
					);

					customizerCategoriesAddControls( sid );
				}
			} else {
				customizerCategoriesAddControls( id );
			}
		}

		api.control( 'indymedia_refresh' , function( control ) {
			control.container.find( '.button' ).on( 'click', function() {
				wp.customize.previewer.refresh();
			});
		});

		function customizerCategoriesAddControls( category ) {
			var image_path = api.data.theme.parent.url + '/images/';

			api.control.add(
				new api.MediaControl( 'indymedia_category_' + category + '_image_control', {
					label: api.data.l10n.categoriesImageControlLabel,
					section: 'indymedia_category_' + category,
					description: api.data.l10n.categoriesImageControlDescription,
					setting: api('indymedia_category_' + category + '_image'),
					mime_type: 'image',
					button_labels: {
						change: api.data.l10n.changeLogo,
						default: api.data.l10n.default,
						frame_button: api.data.l10n.chooseLogo,
						frame_title: api.data.l10n.chooseLogo,
						placeholder: api.data.l10n.logoNotSelected,
						remove: api.data.l10n.remove,
						select: api.data.l10n.chooseLogo
					}
				})
			);

			api.control.add(
				new api.IndymediaRepeaterControl( 'indymedia_category_' + category + '_social_control', {
					label: api.data.l10n.categoriesSocialControlLabel,
					blockLabel: api.data.l10n.categoriesSocialControlLabel,
					section: 'indymedia_category_' + category,
					setting: api('indymedia_category_' + category + '_social'),
					strings: {
						'add_button': api.data.l10n.categoriesSocialControlAddButton
					},
					fields: {
						type: {
							type: 'select',
							label: api.data.l10n.socialNetwork,
							options: {
								facebook: 'Facebook',
								google: 'Google+',
								twitter: 'Twitter',
								instagram: 'Instagram',
								pinterest: 'Pinterest',
								telegram: 'Telegram',
								vimeo: 'Vimeo',
								youtube: 'YouTube'
							}
						},
						name: {
							type: 'text',
							label: 'Nombre'
						},
						url: {
							type: 'text',
							label: 'URL'
						}
					}
				})
			);

			api.control.add(
				new api.IndymediaEditorControl( 'indymedia_category_' + category + '_editor_control', {
					label: api.data.l10n.categoriesEditorControlLabel,
					section: 'indymedia_category_' + category,
					setting: api('indymedia_category_' + category + '_editor')
				})
			);

			api.control.add(
				new api.IndymediaRepeaterControl( 'indymedia_category_' + category + '_top_blocks_control', {
					label: api.data.l10n.topBlocksLabel,
					blockLabel: api.data.l10n.newsSection,
					section: 'indymedia_category_' + category,
					setting: api('indymedia_category_' + category + '_top_blocks'),
					strings: {
						'add_button': api.data.l10n.addSection
					},
					fields: {
						layout: {
							type: 'image-option',
							label: 'Layouts',
							description: api.data.l10n.layoutsDescription,
							options: {
								style1: image_path + 'top-layout1.png',
								style2: image_path + 'top-layout2.png',
								style3: image_path + 'top-layout3.png',
								style4: image_path + 'top-layout4.png'
							},
							default: 'style1'
						},
						highlight: {
							type: 'switch',
							label: api.data.l10n.highlighted,
							switch: {
								on: api.data.l10n.optionYes,
								off: api.data.l10n.optionNo
							},
							default: 'off'
						},
						enable: {
							type: 'switch',
							label: api.data.l10n.enableSection,
							switch: {
								on: api.data.l10n.optionYes,
								off: api.data.l10n.optionNo
							},
							default: 'off'
						},
					}
				})
			);

			api.control.add(
				new api.IndymediaRepeaterControl( 'indymedia_category_' + category + '_middle_blocks_control', {
					label: api.data.l10n.contentBlocksLabel,
					blockLabel: api.data.l10n.newsSection,
					section: 'indymedia_category_' + category,
					setting: api('indymedia_category_' + category + '_middle_blocks'),
					strings: {
						'add_button': api.data.l10n.addSection
					},
					fields: {
						layout: {
							type: 'image-option',
							label: 'Layouts',
							description: api.data.l10n.layoutsDescription,
							options: {
								style1: image_path + 'middle-layout1.png',
								style2: image_path + 'middle-layout2.png',
								style3: image_path + 'middle-layout3.png',
								style4: image_path + 'middle-layout4.png'
							},
							default: 'style1'
						},
						enable: {
							type: 'switch',
							label: api.data.l10n.enableSection,
							switch: {
								on: api.data.l10n.optionYes,
								off: api.data.l10n.optionNo
							},
							default: 'off'
						},
					}
				})
			);
		}
	});
}( wp.customize ) );
