<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function ($extKey) {
        $languageFileCePrefix = 'LLL:EXT:theme/Resources/Private/Language/locallang_ContentElements.xlf:';

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


        /**
         * Add CE: stop inheritance
         */
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
            'tt_content',
            'CType',
            [
                $languageFileCePrefix . 'theme_inheritance_stop.title',
                'theme_inheritance_stop',
                'apps-pagetree-drag-place-denied'
            ],
            'menu',
            'after'
        );
        $tca = [
            'types' => [
                'theme_inheritance_stop' => [
                    'showitem' => '
                        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
                            --palette--;;hidden,
                            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
                        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                            --palette--;;language,
                        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
                            categories,
                        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
                            rowDescription,
                        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
                    ',
                    'columnsOverrides' => [

                    ],
                ],
            ],
        ];
        $GLOBALS['TCA']['tt_content'] = array_replace_recursive($GLOBALS['TCA']['tt_content'], $tca);

    },
    'theme'
);
