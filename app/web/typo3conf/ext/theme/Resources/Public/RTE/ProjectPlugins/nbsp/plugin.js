/**
 * Insert non-breaking space for CKEditor
 */

CKEDITOR.plugins.add('nbsp',
	{
		init: function (editor) {
			// create command "insertNbsp" which inserts the html tag `&nbsp;`
			editor.addCommand('insertNbsp', {
				exec: function (editor) {
					editor.insertHtml('&nbsp;');
				}
			});
			// enable shortcut ctrl+space to insert a non-breaking space in CKEditor
			editor.setKeystroke(CKEDITOR.CTRL + 32 /* char 32 = space */, 'insertNbsp');
		}

	});
