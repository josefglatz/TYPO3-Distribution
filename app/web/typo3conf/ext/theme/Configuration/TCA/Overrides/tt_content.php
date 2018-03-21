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
        ];
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $additionalColumns);

        // Default Content Element
        $GLOBALS['TCA'][$table]['columns']['CType']['config']['default'] = 'text';
    },
    'theme',
    'tt_content'
);
