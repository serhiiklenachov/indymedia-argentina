( function( $ ) {
	wp.customize.control( 'indymedia_refresh' , function( control ) {
		control.container.find( '.button' ).on( 'click', function() {
			wp.customize.previewer.refresh();
		});
	});

	wp.customizerCtrlEditor.init();
} )( jQuery );
