/**
 * soft hyphen character for CKEditor
 */

CKEDITOR.plugins.add("softhyphen", {
	lang: "de,en", // %REMOVE_LINE_CORE%
	// lang: "ar,ca,da,de,el,en,es,eu,fa,fi,fr,he,hr,hu,it,ja,nl,no,pl,pt,pt-br,ru,sk,sv,tr,zh-cn", // %REMOVE_LINE_CORE% // @TODO: Add missing translations
	init: function (editor) {

		// Default Config
		var defaultConfig = {
			enableShortcut: true
		};
		var config = CKEDITOR.tools.extend(defaultConfig, editor.config.softhyphen || {}, true);

		// create command "insertNbsp" which inserts the html tag `&nbsp;`
		editor.addCommand('insertSoftHyphen', {
			exec: function (editor) {
				editor.insertHtml('&shy;');
			}
		});

		if (config.enableShortcut) {
			// enable shortcut ctrl+dash to insert a non-breaking space in CKEditor
			editor.setKeystroke(CKEDITOR.CTRL + 189 /* char 189 = dash */, 'insertSoftHyphen');
		}

		// add additional button to insert soft hyphen via CKEditor toolbar
		editor.ui.addButton && editor.ui.addButton( 'Soft Hyphen', {
			label: editor.lang.softhyphen.InsertButton,
			command: 'insertSoftHyphen',
			toolbar: 'insertcharacters'
		} );
	}
} );
