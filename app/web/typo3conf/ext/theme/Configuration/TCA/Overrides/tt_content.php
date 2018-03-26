<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function ($extKey, $table) {
        $languageFileBePrefix = 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_BackendGeneral.xlf:';
        $languageFileCePrefix = 'LLL:EXT:theme/Resources/Private/Language/locallang_ContentElements.xlf:';

        $tca = [
            /*
             * ['ctrl'] configuration
             */
            'ctrl' => [
                // Add 'imageposition' to search fields - so its included in the backend search results
                'searchFields' => $GLOBALS['TCA'][$table]['ctrl']['searchFields'] . ',imageposition',
            ],
            /*
             * Columns configuration
             */
            'columns' => [
                'bodytext' => [
                    'config' => [
                        // Make bodytext searchable in all cTypes (Backend Search)
                        'search' => [
                            'pidonly' => 0,
                            'case' => 0,
                        ],
                    ],
                ],
                'header_link' => [
                    'config' => [
                        'fieldControl' => [
                            'linkPopup' => [
                                'options' => [
                                    'blindLinkFields' => 'class'
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            /*
             * Types configuration
             */
            'types' => [

            ],
        ];
        $GLOBALS['TCA'][$table] = array_replace_recursive($GLOBALS['TCA'][$table], $tca);

        /**
         * Additional columns
         */
        $additionalColumns = [
            'tx_theme_bodytext_1' => [
                'l10n_mode' => 'prefixLangTitle',
                'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.text',
                'config' => [
                    'type' => 'text',
                    'cols' => '80',
                    'rows' => '15',
                    'softref' => 'typolink_tag,images,email[subst],url',
                    'search' => [
                        'andWhere' => '{#CType}=\'text\' OR {#CType}=\'textpic\' OR {#CType}=\'textmedia\''
                    ]
                ]
            ],
            'tx_theme_bodytext_2' => [
                'l10n_mode' => 'prefixLangTitle',
                'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.text',
                'config' => [
                    'type' => 'text',
                    'cols' => '80',
                    'rows' => '15',
                    'softref' => 'typolink_tag,images,email[subst],url',
                    'search' => [
                        'andWhere' => '{#CType}=\'text\' OR {#CType}=\'textpic\' OR {#CType}=\'textmedia\''
                    ]
                ]
            ],
            'tx_theme_unfolded' => [
                'label' => $languageFileBePrefix . 'field.tt_content.tx_theme_unfolded.label',
                'config' => [
                    'type' => 'check',
                    'default' => 0,
                    'items' => [
                        '1' => [
                            '0' => $languageFileBePrefix . 'field.tt_content.tx_theme_unfolded.check_0'
                        ]
                    ]
                ],
            ],
            'tx_theme_prefer_download' => [
                'label' => $languageFileBePrefix . 'field.tt_content.tx_theme_prefer_download.label',
                'config' => [
                    'type' => 'check',
                    'default' => 0,
                    'items' => [
                        '1' => [
                            '0' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                        ]
                    ]
                ],
            ],
        ];
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns($table, $additionalColumns);

        // Default Content Element
        $GLOBALS['TCA'][$table]['columns']['CType']['config']['default'] = 'text';
    },
    'theme',
    'tt_content'
);
