<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function ($extKey, $table, $type) {
        $languageFileCePrefix = 'LLL:EXT:theme/Resources/Private/Language/locallang_ContentElements.xlf:';

        /**
         * Add CE
         */
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
            $table,
            'CType',
            [
                $languageFileCePrefix . $type . '.title',
                $type,
                'theme-content-download'
            ],
            'uploads',
            'after'
        );

        $tca = [
            'columns' => [

            ],
            'palettes' => [
                'tx-' . $extKey . '-' . $type . '-uploads' => [
                    'showitem' => '
                        media;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:media.ALT.uploads_formlabel,
                        --linebreak--,
                        file_collections;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:file_collections.ALT.uploads_formlabel,
                        --linebreak--,
                        filelink_sorting,
                        target,
                        tx_theme_prefer_download
                    ',
                ],
            ],
            'types' => [
                $type => [
                    'showitem' => \JosefGlatz\Theme\Utility\Tca::getShowitemDefault(1) . '
                            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.headers;headers,
                            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:media;tx-' . $extKey . '-' . $type . '-uploads,
                            ' . \JosefGlatz\Theme\Utility\Tca::getShowitemDefault(2)
                    ,
                    'columnsOverrides' => [
                    ],
                    'pageLayoutViewEnrichment' => [
                        'footer' => [
                            'badges' => [
                                'isFilelinkSorting',
                                'isTarget',
                                'isPreferDownload',
                            ],
                        ],
                    ],
                ],
            ],
        ];
        $GLOBALS['TCA'][$table] = array_replace_recursive($GLOBALS['TCA'][$table], $tca);

        /**
         * Assign Icon
         */
        $GLOBALS['TCA'][$table]['ctrl']['typeicon_classes'][$type] = 'theme-content-download';
    },
    'theme',
    'tt_content',
    'theme_download_box'
);
