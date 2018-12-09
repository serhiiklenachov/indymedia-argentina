( function( exports, $ ) {
	var api = wp.customize;

	api.IndymediaRepeaterControl = api.Control.extend({
		defaults: _.extend(
			{},
			api.Control.prototype.defaults,
			{
				templateId: 'customize-control-indymedia-repeater-content',
				type: 'indymedia-repeater',
				default: '[{}]',
				blockLabel: 'Bloque'
			}
		),

		ready: function() {
			let control = this;

			$( 'ul', control.container ).sortable({
				cursor: 'move',
				placeholder: 'block-placeholder',
				orientation: 'vertical',
				update: control.prepareData
			});

			_.bindAll( control, 'prepareCheckboxes', 'prepareImageOptions', 'addBlock', 'removeBlock', 'prepareData' );

			control.container.on( 'click keydown', '.top', control.toggleDetails );

			control.container.on( 'keyup change', '[data-name]:not([type=hidden])', control.prepareData );
			control.container.on( 'change', 'input[type="checkbox"][data-name]', control.prepareCheckboxes );
			control.container.on( 'click', '.image-option label', control.prepareImageOptions );
			control.container.on( 'click', '.indymedia-repeater-remove-button', control.removeBlock );
			control.container.on( 'click', '.indymedia-repeater-add-button', control.addBlock );
		},

		toggleDetails: function( e ) {
			let $target = $( e.currentTarget );

			$target.next().toggle();

			let $icon = $( 'dashicons', $target );

			$icon.toggleClass( 'dashicons-arrow-down' );
			$icon.toggleClass( 'dashicons-arrow-up' );
		},

		prepareCheckboxes: function( e ) {
			let target = e.currentTarget;

			if ( target.checked ) {
				target.value = 'on';
			} else {
				target.value = 'off';
			}

			this.prepareData();
		},

		prepareImageOptions: function( e ) {
			let $target = $( e.currentTarget );

			$target.toggleClass( 'selected' );
			$target.siblings().removeClass( 'selected' );

			$target.siblings( '[type=hidden]' ).val( $target.attr( 'data-value' ) ).trigger( 'change' );

			this.prepareData();
		},

		removeBlock: function( e ) {
			let $target = e.currentTarget;

			$( $target ).closest( '.indymedia-repeater-control' ).fadeToggle( 400, 'swing', function() {
				$( $target ).remove();

				this.prepareData();
			});
		},

		addBlock: function( e ) {
			let $target = $( e.currentTarget );
			let $siblings = $target.siblings( '.indymedia-repeater-control-container' );
			let $field = $siblings.find( '.indymedia-repeater-control:first' ).clone();

			$field.find( 'input[type=text][data-name]' ).each( function() {
				let defaultValue = $target.attr( 'data-default' );
				$target.val( defaultValue );
			});

			$field.find( 'select[data-name]' ).each( function() {
				var defaultValue = $target.attr( 'data-default' );
				$target.val( defaultValue );
			});

			$field.find( '.image-option label' ).each( function() {
				let defaultValue = $target.siblings( '[type=hidden]' ).attr( 'data-default' );
				$target.siblings( '[type=hidden]' ).val( defaultValue );

				if ( $target.attr( 'data-value' ) == defaultValue ) {
					$target.addClass( 'selected' );
				} else {
					$target.removeClass( 'selected' );
				}
			});

			$siblings.append( $field );

			this.prepareData();
		},

		prepareData: function() {
			$( '.indymedia-repeater-control-container', this.container ).each( function() {
				let values = [];

				$( this ).find( '.indymedia-repeater-control' ).each( function() {
					var newValue = {};

					$( this ).find( '[data-name]' ).each( function() {
						newValue[ $( this ).attr( 'data-name' ) ] = $( this ).val();
					});

					values.push( newValue );
				});

				$( this ).next( '.indymedia-repeater-storage' ).val( JSON.stringify( values ) ).trigger( 'change' );
			});
		}
	});
}( wp, jQuery ) );
