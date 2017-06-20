/**
 * Check for empty tags plugin
 */

'use strict';

(function () {
	CKEDITOR.plugins.add('emptytags', {
		lang: "de,en",
		version: 0.1,
		requires: 'htmlwriter,notification,undo,wordcount',
		bbcodePluginLoaded: false,
		icons: 'emptytags',
		onLoad: function(editor) {
			CKEDITOR.document.appendStyleSheet(this.path + "css/emptytags.css");
		},
		afterInit: function(editor) {
			CKEDITOR.addCss(
				'.cke_editable .rte-empty {' +
					' border: 1px dotted red!important;' +
					' background-color: rgba(255,0,0,.05)!important;' +
				'}' +
				'.cke_editable .rte-empty:after {' +
					'content: "' + editor.lang.emptytags.InlineInfoMessage + '";' +
					'background: red;' +
					'padding: 0px 10px 2px;' +
					'color: white;' +
					'font-size: 10px;' +
					'font-weight: bold;' +
					'width: calc(100% - 20px);' +
					'display: block;' +
					'word-break: break-all;' +
				'}'
			);
		},
		init: function (editor) {
			var intervalId;

			// Default Config
			var defaultConfig = {
				enableShortcut: true,
				enableToolbarNotification: true, // @TODO: Implement switch for toolbar
				enalbeToolbarCumulatedCounter: false, // @TODO: Implement cumulated counter
				tagsToCheck: {0: 'p'}
			};
			var config = CKEDITOR.tools.extend(defaultConfig, editor.config.emptytags || {}, true);

			editor.addCommand('checkForEmptyTags', {
				exec: function (editor) {
					var editorContent = editor.getData();
					// Stop check and inform editor if the editor has no content.
					if (editorContent === '') {
						top.TYPO3.Notification.info(editor.lang.emptytags.AlertEditorContentEmpty, '', 5);
						return;
					}
					// Check if tag name's to check are set
					if (config.tagsToCheck.length > 0 && config.tagsToCheck[0] !== null) {
						var index,
						noEmptyTagFound = true;
						for (index = 0; index < config.tagsToCheck.length; ++index) {
							var tagName = config.tagsToCheck[index];
							var tags = editor.document.$.getElementsByTagName(tagName);
							for (var i=0; i < tags.length; i++) {
								if (checkForRealEmptyTag(tags[i].innerHTML)
									|| checkForEmptyTagWithSpace(tags[i].innerHTML)
									|| checkForEmptyTagWithNbsp(tags[i].innerHTML)
								) {
									if(tags[i].className.indexOf("rte-empty") < 0){
										tags[i].className += "rte-empty";
									}
									noEmptyTagFound = false;
								} else {
									tags[i].classList.remove("rte-empty");
								}
							}
						}
						// Inform editor that no empty tag can be found (anymore)
						if (noEmptyTagFound === true) {
							top.TYPO3.Notification.success(
								editor.lang.emptytags.AlertEditorNoEmptyTagFoundTitle,
								editor.lang.emptytags.AlertEditorNoEmptyTagFound,
								10);
						}
					}
				}
			});
			editor.setKeystroke(CKEDITOR.CTRL + 188 /* char 69 = e */, 'checkforEmptyTags'); // http://keycode.info/

			editor.ui.addButton && editor.ui.addButton('Check for empty tags', {
				label: editor.lang.emptytags.ToolbarButton,
				command: 'checkForEmptyTags',
				toolbar: 'insertcharacters',
				icon: 'emptytags'
			});

			function counterId(editorInstance) {
				return "cke_emptytags_badges_" + editorInstance.name;
			}

			function counterIdLabel(editorInstance) {
				return "cke_emptytags_label_" + editorInstance.name;
			}

			function counterElement(editorInstance) {
				return document.getElementById(counterId(editorInstance));
			}

			function counterElementLabel(editorInstance) {
				return document.getElementById(counterIdLabel(editorInstance));
			}

			function updateCounter(editorInstance) {
				if (config.tagsToCheck.length > 0 && config.tagsToCheck[0] !== null) {
					var index;
					var result = [];
					var content = '';
					var showNotification = false;
					for (index = 0; index < config.tagsToCheck.length; ++index) {
						var tagName = config.tagsToCheck[index];
						if (editor.mode === 'wysiwyg') {
							var tags = editor.document.$.getElementsByTagName(tagName),
								emptyCount = 0;
							for (var i=0; i < tags.length; i++) {
								if (checkForRealEmptyTag(tags[i].innerHTML)
									|| checkForEmptyTagWithSpace(tags[i].innerHTML)
									|| checkForEmptyTagWithNbsp(tags[i].innerHTML)
								) {
									emptyCount++;
								}
							}
							result[index] = [tagName, emptyCount];
						}
					}

					for (index = 0; index < result.length; ++index) {
						if (result[index][1] !== 0) {
							content += "<span class=\"badge\">" + result[index][0].toUpperCase() + ': ' + result[index][1] + '</span> ';
							showNotification = true;
						}
					}

					counterElement(editorInstance).innerHTML = content;

					if (showNotification) {
						counterElement(editorInstance).classList.remove('hidden');
						counterElementLabel(editorInstance).classList.remove('hidden');
					} else {
						counterElement(editorInstance).classList.add('hidden');
						counterElementLabel(editorInstance).classList.add('hidden');
					}
				}
			}

			editor.on("key", function (event) {
				if (editor.mode === "source") {
					updateCounter(event.editor);
				}
			}, editor, null, 100);

			editor.on("change", function (event) {
				updateCounter(event.editor);
			}, editor, null, 100);

			// Add counter area to CKEditor's toolbar
			editor.on("uiSpace", function (event) {
				if (editor.elementMode === CKEDITOR.ELEMENT_MODE_INLINE) {
					if (event.data.space == "top") {
						event.data.html += "<div class=\"cke_emptytags\" style=\"\"" +
							" title=\"" +
							editor.lang.emptytags.ToolbarTitle +
							"\"" +
							"><span id=\"" + counterIdLabel(event.editor) + "\" class=\"cke_path_item cke_emptytags_label\">" + editor.lang.emptytags.ToolbarLabel + ":</span> <span id=\"" +
							counterId(event.editor) +
							"\" class=\"cke_path_item\">%paragraphs%</span></div>";
					}
				} else {
					if (event.data.space == "bottom") {
						event.data.html += "<div class=\"cke_emptytags\" style=\"\"" +
							" title=\"" +
							editor.lang.emptytags.ToolbarTitle +
							"\"" +
							"><span id=\"" + counterIdLabel(event.editor) + "\" class=\"cke_path_item cke_emptytags_label\">" + editor.lang.emptytags.ToolbarLabel + ":</span> <span id=\"" +
							counterId(event.editor) +
							"\" class=\"cke_path_item\">%paragraphs%</span></div>";
					}
				}

			}, editor, null, 100);

			editor.on("dataReady", function (event) {
				updateCounter(event.editor);
			}, editor, null, 100);

			editor.on("afterPaste", function (event) {
				updateCounter(event.editor);
			}, editor, null, 100);

			editor.on("blur", function () {
				if (intervalId) {
					window.clearInterval(intervalId);
				}
			}, editor, null, 300);
		}
	});

	function checkForRealEmptyTag(content) {
		return content.length === 0;

	}

	function checkForEmptyTagWithNbsp(content) {
		// return content === '&nbsp;' || content.trim() === '<br>';
		return content === '&nbsp;' || /^<br\s*[\/]?>/gi.test(content.trim());
	}

	function checkForEmptyTagWithSpace(content) {
		return content.trim().length === 0;
	}

	function checkForEmptyTagWithMultipleLines(content) {
		//return content.trim()
		// @TODO Finalize tag with multiple br tags
	}

})();

