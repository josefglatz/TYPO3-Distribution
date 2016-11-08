<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function ($extKey) {

        /**
         * set common image crop ratios
         *
         * - 3x2
         * - 4x3
         * - NaN/free
         */
        $GLOBALS['TCA']['sys_file_reference']['columns']['crop']['config']['ratios'] = [
            '1.5' => '3 x 2',
            '1.333333333' => '4 x 3',
            'NaN' => 'LLL:EXT:lang/locallang_wizards.xlf:imwizard.ratio.free',
        ];


        /**
         * Add subheader property to content elements
         * where it makes basically sense
         *
         * @TODO Switch to a nice way to replace header-palette with headers-palette?
         */
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
            'tt_content',
            'subheader',
            'textmedia,bullets,table,uploads,menu,shortcut',
            'after:header'
        );
    },
    'theme'
);
