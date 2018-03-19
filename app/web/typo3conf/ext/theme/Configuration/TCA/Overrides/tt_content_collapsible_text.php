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
                'theme-content-accordion'
            ],
            'text',
            'after'
        );

        $tca = [
            'columns' => [

            ],
            'types' => [
                $type => [
                    'showitem' => \JosefGlatz\Theme\Utility\Tca::getShowitemDefault(1) . '
                            header;' . $languageFileCePrefix . 'theme_collapsible_text.label.header,
                            --linebreak--,
                            header_layout;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_layout_formlabel,
                            bodytext;' . $languageFileCePrefix . 'theme_collapsible_text.label.bodytext,
                            ' . \JosefGlatz\Theme\Utility\Tca::getShowitemDefault(2)
                    ,
                    'columnsOverrides' => [
                        'bodytext' => [
                            'config' => [
                                'enableRichtext' => true,
                                'richtextConfiguration' => 'default'
                            ]
                        ],
                    ],
                ],
            ],
        ];
        $GLOBALS['TCA'][$table] = array_replace_recursive($GLOBALS['TCA'][$table], $tca);

        /**
         * Assign Icon
         */
        $GLOBALS['TCA'][$table]['ctrl']['typeicon_classes'][$type] = 'theme-content-accordion';
    },
    'theme',
    'tt_content',
    'theme_collapsible_text'
);
