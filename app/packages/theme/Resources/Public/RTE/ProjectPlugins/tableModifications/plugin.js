/**
 * project specific CKEditor plugin container for modifying editor stuff (e.g. dialog elements)
 */
CKEDITOR.plugins.add('tableModifications', {
	requires: 'table'
});

CKEDITOR.on('dialogDefinition', function (ev) {
	var dialogName = ev.data.name;
	var dialogDefinition = ev.data.definition;

	/**
	 * Limit table dialog
	 */
	if (dialogName === 'tableProperties' || dialogName === 'table') {
		var tablePropertiesTabName = dialogDefinition.getContents('info');
		// Remove uneeded table configuration fields
		var tablePropertiesFieldsToRemove = [
			'txtCellPad',
			'txtCellSpace',
			'txtHeight',
			'txtWidth',
			'txtBorder',
			'cmbAlign'
		];
		for (index = 0; index < tablePropertiesFieldsToRemove.length; ++index) {
			tablePropertiesTabName.remove(tablePropertiesFieldsToRemove[index]);
		}

		// Remove unneeded items of the table header options selectbox (https://jsfiddle.net/qbyurazg/)
		var tablePropertiesSelectHeaders = tablePropertiesTabName.get( 'selHeaders');
		tablePropertiesSelectHeaders[ 'default' ] = 'row';

		for (var i = tablePropertiesSelectHeaders.items.length - 1; i >= 0; i--) {
			var itemValue = tablePropertiesSelectHeaders.items[i][1];
			if (itemValue !== '' && itemValue !== 'row') {
				tablePropertiesSelectHeaders.items.splice(i, 1);
			}
		}
	}

	/**
	 * Limit table cell dialog
	 */
	if (dialogName === 'cellProperties') {
		var cellPropertiesTabName = dialogDefinition.getContents('info');
		// Remove unneeded cell configuration fields
		var cellPropertiesfieldsToRemove = [
			'cellType',
			'width',
			'height',
			'widthType',
			'hAlign',
			'vAlign',
			'bgColor',
			'borderColor'
		];

		for (index = 0; index < cellPropertiesfieldsToRemove.length; ++index) {
			cellPropertiesTabName.remove(cellPropertiesfieldsToRemove[index]);
		}
	}
});
