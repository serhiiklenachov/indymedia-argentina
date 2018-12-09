( function( api ) {
	api.data = window._wpIndymediaData;

	api.bind( 'ready', function() {
		api.section.add(
			new api.Section( 'indymedia_fonts', {
				title: api.data.l10n.fontsSectionTitle,
				panel: 'viral_general_settings_panel',
				priority: 50
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

		api.control( 'indymedia_refresh' , function( control ) {
			control.container.find( '.button' ).on( 'click', function() {
				wp.customize.previewer.refresh();
			});
		});
	});
}( wp.customize ) );
