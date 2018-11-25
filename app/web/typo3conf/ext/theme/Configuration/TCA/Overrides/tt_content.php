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
                // Add columns to search fields - so its included in the backend search results
                'searchFields' => $GLOBALS['TCA'][$table]['ctrl']['searchFields'] . ',imageposition,tx_theme_bodytext_1,tx_theme_bodytext_2,tx_theme_link_label,tx_theme_link',
            ],
            /*
             * ['interface'] configuration
             */
            'interface' => [
                // Extend showRecordFieldList
                'showRecordFieldList' => $GLOBALS['TCA'][$table]['ctrl']['interface']['showRecordFieldList'] . ',tx_theme_bodytext_1,tx_theme_bodytext_2,tx_theme_big_media,tx_theme_link_label,tx_theme_link,tx_theme_unfolded,tx_theme_prefer_download',
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
                'header' => [
                    'config' => [
                        'eval' => 'required',
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
            'tx_theme_author' => [
                'label' => $languageFileBePrefix . 'field.tt_content.tx_theme_author.label',
                'config' => [
                    'type' => 'input',
                    'size' => 20,
                    'default' => '',
                    'eval' => 'trim',
                    'max' => 30,
                ],
            ],
            'tx_theme_bodytext_1' => [
                'l10n_mode' => 'prefixLangTitle',
                'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.text',
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
                'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.text',
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
            'tx_theme_big_media' => [
                'label' => $languageFileBePrefix . 'field.tt_content.tx_theme_big_media.label',
                'config' => [
                    'type' => 'check',
                    'default' => 0,
                    'items' => [
                        '1' => [
                            '0' => $languageFileBePrefix . 'field.tt_content.tx_theme_big_media.check_0'
                        ]
                    ]
                ],
            ],
            'tx_theme_facts_figures' => [
                'label' => $languageFileBePrefix . 'field.tt_content.tx_theme_facts_figures.label',
                'config' => [
                    'type' => 'inline',
                    'foreign_table' => 'tx_theme_facts_figures',
                    'foreign_field' => 'parentid',
                    'foreign_table_field' => 'parenttable',
                    'foreign_sortby' => 'sorting',
                    'appearance' =>
                        [
                            'enabledControls' =>
                                [
                                    'dragdrop' => '1',
                                ],
                            'collapseAll' => '1',
                            'expandSingle' => '1',
                            'levelLinksPosition' => 'bottom',
                            'useSortable' => '1',
                        ],
                    ],
                'exclude' => '1',
                'l10n_mode' => 'copy',

            ],
            'tx_theme_link_label' => [
                'label' => $languageFileBePrefix . 'field.tt_content.tx_theme_link_label.label',
                'config' => [
                    'type' => 'input',
                    'size' => 15,
                    'default' => '',
                    'eval' => 'trim',
                    'max' => 30,
                ],
            ],
            'tx_theme_link' => [
                'label' => $languageFileBePrefix . 'field.tt_content.tx_theme_link.label',
                'config' => [
                    'type' => 'input',
                    'renderType' => 'inputLink',
                    'size' => 50,
                    'max' => 1024,
                    'eval' => 'trim',
                    'fieldControl' => [
                        'linkPopup' => [
                            'options' => [
                                'title' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_link_formlabel',
                            ],
                        ],
                    ],
                    'softref' => 'typolink'
                ],
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
                            '0' => 'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                        ]
                    ]
                ],
            ],
        ];
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns($table, $additionalColumns);

        /**
         * Make further adoptions to table
         */
        // Add palette "tx-theme-link"
        // (Usage example in showitem: "--palette--;' . $languageFileBePrefix . 'palette.' . $table . '.tx-theme-link;tx-theme-link,")
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
            $table,
            'tx-' . $extKey . '-link',
            'tx_theme_link, tx_theme_link_label'
        );

        // Default Content Element
        $GLOBALS['TCA'][$table]['columns']['CType']['config']['default'] = 'text';
    },
    'theme',
    'tt_content'
);
