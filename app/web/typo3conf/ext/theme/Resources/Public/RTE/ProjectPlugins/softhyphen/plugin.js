/**
 * soft hyphen character for CKEditor
 */

CKEDITOR.plugins.add("softhyphen", {
	lang: "en,de", // %REMOVE_LINE_CORE%
	init: function (editor) {

		// create command "insertNbsp" which inserts the html tag `&nbsp;`
		editor.addCommand('insertSoftHyphen', {
			exec: function (editor) {
				editor.insertHtml('&shy;');
			}
		});
		editor.ui.addButton && editor.ui.addButton( 'Soft Hyphen', {
			label: "Insert a soft hyphen", // @TODO: Fix translation problem: `editor.lang.softhyphen.insertButton`
			command: 'insertSoftHyphen',
			toolbar: 'insertcharacters'
		} );
		// enable shortcut ctrl+dash to insert a non-breaking space in CKEditor
		editor.setKeystroke(CKEDITOR.CTRL + 189 /* char 189 = dash */, 'insertSoftHyphen');
	}
} );
