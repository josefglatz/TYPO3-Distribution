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
                'theme-content-text-lead'
            ],
            'text',
            'before'
        );

        $tca = [
            'columns' => [

            ],
            'types' => [
                $type => [
                    'showitem' => \JosefGlatz\Theme\Utility\Tca::getShowitemDefault(1) . '
                            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.headers;headers,
                            bodytext;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:bodytext_formlabel,
                            ' . \JosefGlatz\Theme\Utility\Tca::getShowitemDefault(2)
                    ,
                    'columnsOverrides' => [
                        'bodytext' => [
                            'config' => [
                                'enableRichtext' => true,
                                'richtextConfiguration' => 'default'
                            ]
                        ],
                        'header_layout' => [
                            'config' => [
                                'readOnly' => 1,
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
        $GLOBALS['TCA'][$table]['ctrl']['typeicon_classes'][$type] = 'theme-content-text-lead';
    },
    'theme',
    'tt_content',
    'theme_lead_text'
);
