/**
 * DeleteAll for CKEditor
 */
CKEDITOR.plugins.add('deleteall', {
	lang: 'de',
	icons: 'deleteall',
	hidpi: true,
	init: function ( editor ) {
		// create command "deleteAll" which deletes the content of the editor
		editor.addCommand('deleteAll', { modes: {wysiwyg: 1, source: 1},
			exec: function (editor) {
				editor.setData('');
			},
			canUndo: false
		} );

		editor.ui.addButton && editor.ui.addButton( 'deleteall', {
			label: editor.lang.deleteall.DeleteButton,
			command: 'deleteAll',
			toolbar: 'deleteall',
			icon: 'deleteall'
		} );
	}
} );
