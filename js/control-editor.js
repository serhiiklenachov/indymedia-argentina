( function( exports, $ ) {
	var api = wp.customize;
	api.IndymediaEditorControl = api.Control.extend({
		defaults: _.extend(
			{},
			api.Control.prototype.defaults,
			{
				templateId: 'customize-control-indymedia-editor-content',
				type: 'indymedia-editor'
			}
		),

		ready: function() {
			let control = this;

			let settings = _.extend(
				{},
				wp.editor.getDefaultSettings(),
				{
					mediaButtons: true,
					quicktags: true,
					tinymce: {
						toolbar1: 'formatselect,bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,wp_more,spellchecker,fullscreen,wp_adv',
						toolbar2: 'strikethrough,hr,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help',
						setup: control.onChange
					}
				}
			);

			let id = $( 'textarea', control.container ).attr('id');

			wp.editor.initialize( id ,
				settings
			);
		},

		onChange: function(editor) {
			var cb = function () {
				let $storage = $( this.targetElm );
				$storage.val(editor.getContent());
				$storage.trigger( 'change' );
			}

			editor.on('Change', cb);
			editor.on('Undo', cb);
			editor.on('Redo', cb);
		}
	});
}( wp, jQuery ) );
