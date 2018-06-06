( function( $ ) {
	wp.customize( 'indymedia_section_tag_font', function( value ) {
		value.bind( function( to ) {
			font = to.split(':')[0];
			$('.post-categories li a').css( { 'font-family': font } );
		});
	});

	wp.customize( 'indymedia_hero_title_font', function( value ) {
		value.bind( function( to ) {
			font = to.split(':')[0];
			$('.vl-title-container h3').css( { 'font-family': font } );
		});
	});

	wp.customize( 'indymedia_block_title_font', function( value ) {
		value.bind( function( to ) {
			font = to.split(':')[0];
			$('.vl-block-title span').css( { 'font-family': font } );
		});
	});

	wp.customize( 'indymedia_post_title_font', function( value ) {
		value.bind( function( to ) {
			font = to.split(':')[0];
			$('.vl-post-item h3').css( { 'font-family': font } );
			$('.vl-post-content h3').css( { 'font-family': font } );
		});
	});

	wp.customize( 'indymedia_post_excerpt_font', function( value ) {
		value.bind( function( to ) {
			font = to.split(':')[0];
			$('.vl-post-item .vl-excerpt').css( { 'font-family': font } );
		});
	});

	wp.customize( 'indymedia_widget_title_font', function( value ) {
		value.bind( function( to ) {
			font = to.split(':')[0];
			$('h3.widget-title').css( { 'font-family': font } );
		});
	});

	wp.customize( 'indymedia_entry_title_font', function( value ) {
		value.bind( function( to ) {
			font = to.split(':')[0];
			$('.vl-main-header h1').css( { 'font-family': font } );
			$('.entry-title').css( { 'font-family': font } );
		});
	});

	wp.customize( 'indymedia_entry_content_font', function( value ) {
		value.bind( function( to ) {
			font = to.split(':')[0];
			$('article .entry-content').css( { 'font-family': font } );
		});
	});

	wp.customize( 'indymedia_top_header_font', function( value ) {
		value.bind( function( to ) {
			font = to.split(':')[0];
			$('.vl-top-header').css( { 'font-family': font } );
		});
	});

	wp.customize( 'indymedia_main_navigation_font', function( value ) {
		value.bind( function( to ) {
			font = to.split(':')[0];
			$('.vl-main-navigation').css( { 'font-family': font } );
		});
	});

	wp.customize( 'indymedia_ticker_font', function( value ) {
		value.bind( function( to ) {
			font = to.split(':')[0];
			$('.vl-ticker').css( { 'font-family': font } );
		});
	});

	wp.customize( 'indymedia_main_color', function( value ) {
		value.bind( function( to ) {
			$('input[type="submit"]').css( { 'background': to } );
			$('a:hover').css( { 'color': to } );
			$('.widget-title').css( { 'border-left': '6px solid ' + to } );
			$('.vl-post-info').css( { 'background': to } );
			$('.entry-categories .fa').css( { 'color': to } );
			$('.entry-footer .vl-read-more').css( { 'background': to } );
			$('.widget-area a:hover').css( { 'color': to } );
			$('.vl-timeline .vl-post-item:hover:after').css( { 'background': to } );
			$('h3#reply-title').css( { 'border-left': '6px solid ' + to } );
			$('h3.comments-title').css( { 'border-left': '6px solid ' + to } );
			$('.comment-list a:hover').css( { 'color': to } );
			$('.comment-navigation .nav-previous a').css( { 'background': to } );
			$('.comment-navigation .nav-next a').css( { 'background': to } );
			$('.comment-navigation .nav-next a:after').css( { 'border-left': '11px solid ' + to } );
			$('.comment-navigation .nav-previous a:after').css( { 'border-right': '11px solid ' + to } );
			$('.pagination a').css( { 'background': to } );
			$('.pagination span').css( { 'background': to } );
			$('.vl-top-header').css( { 'background': to } );
			$('.vl-site-title a').css( { 'color': to } );
			$('.vl-site-description').css( { 'color': to } );
			$('#vl-site-navigation').css( { 'background': to } );
			$('.vl-main-navigation ul ul').css( { 'background': to } );
			$('.post-navigation a:hover').css( { 'color': to } );
			$('.vl-ticker-title').css( { 'background': to } );
			$('.vl-ticker-title:after').css( { 'border-color': 'transparent transparent transparent ' + to } );
			$('.vl-ticker .owl-item a:hover').css( { 'color': to } );
			$('.vl-ticker .owl-prev').css( { 'background': to } );
			$('.vl-ticker .owl-next').css( { 'background': to } );
			$('.vl-title-container h3:after').css( { 'background': to } );
			$('.vl-top-block .post-categories li a:hover').css( { 'background': to } );
			$('.vl-top-block.style4 .vl-post-item:after').css( { 'background': to } );
			$('.vl-block-title').css( { 'border-left': '10px solid ' + to } );
			$('.vl-post-item h3 a:hover').css( { 'color': to } );
			$('#vl-back-top').css( { 'background': to } );
			
		} );
	} );
} )( jQuery );