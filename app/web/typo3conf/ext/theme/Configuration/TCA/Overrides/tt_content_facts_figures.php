<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function ($extKey, $table, $type) {
        $languageFileBePrefix = 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_BackendGeneral.xlf:';
        $languageFileCePrefix = 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_ContentElements.xlf:';

        /***************
         * CE feature flags
         */
        $minAmountFacts = 1;
        $maxAmountFacts = 4;
        $factLinkRequired = true;
        $factValueMustBeInt = false;
        $factIconActivated = true;

        $foreignShowItemValue = 'sys_language_uid,l10n_parent,l10n_diffsource,label,value,link,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime,endtime';
        if ((bool)$factIconActivated) {
            $foreignShowItemValue = str_replace('link,', 'link,icon,', $foreignShowItemValue);
        }

        /***************
         * Add CE
         */
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
            $table,
            'CType',
            [
                $languageFileCePrefix . $type . '.title',
                $type,
                'theme-content-facts-figures'
            ],
            '',
            ''
        );

        /***************
         * Configure CE
         */
        $tca = [
            'columns' => [

            ],
            'palettes' => [
            ],
            'types' => [
                $type => [
                    'showitem' => \JosefGlatz\Theme\Utility\Tca::getShowitemDefault(1) . '
                            tx_theme_facts_figures,
                            ' . \JosefGlatz\Theme\Utility\Tca::getShowitemDefault(2)
                    ,
                    'columnsOverrides' => [
                        'tx_theme_facts_figures' => [
                            'config' => [
                                'filter' => [
                                    0 => [
                                        'parameters' => [
                                            'allowedFileExtensions' => $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['theme']['content']['theme_facts_figures']['factImage ']['allowedImageFileExt']
                                        ],
                                    ],
                                ],
                                'overrideChildTca' => [
                                    'types' => [
                                        1 => [
                                            'showitem' => $foreignShowItemValue,
                                        ],
                                    ],
                                    'columns' => [
                                        'uid_local' => [
                                            'config' => [
                                                'appearance' => [
                                                    'elementBrowserAllowed' => $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['theme']['content']['theme_facts_figures']['factImage']['allowedImageFileExt']
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                                'appearance' => [
                                    'createNewRelationLinkTitle' => $languageFileBePrefix . 'field.tt_content.tx_theme_facts_figures.irre.new.label.type.' . $type,
                                    'collapseAll' => false,
                                ],
                                'minitems' => (int)$minAmountFacts,
                                'maxitems' => (int)$maxAmountFacts,
                            ],
                        ],
                    ],
                    'pageLayoutViewEnrichment' => [
                        'footer' => [
                            'badges' => [
                                // @TODO: TYPO3-Distribution: CE theme_facts_figures: enable value badge once it's finalized
                            ],
                        ],
                    ],
                ],
            ],
        ];
        $GLOBALS['TCA'][$table] = array_replace_recursive($GLOBALS['TCA'][$table], $tca);


        /***************
         * CE feature flags
         */
        if ((bool)$factLinkRequired) {
            $GLOBALS['TCA'][$table]['types'][$type]['columnsOverrides']['tx_theme_facts_figures']['config']['overrideChildTca'] = array_replace_recursive(
                $GLOBALS['TCA'][$table]['types'][$type]['columnsOverrides']['tx_theme_facts_figures']['config']['overrideChildTca'],
                [
                    'columns' => [
                        'link' => [
                            'config' => [
                                'eval' => 'required',
                            ],
                        ]
                    ],
                ]
            );
        }
        if ((bool)$factValueMustBeInt) {
            $GLOBALS['TCA'][$table]['types'][$type]['columnsOverrides']['tx_theme_facts_figures']['config']['overrideChildTca'] = array_replace_recursive(
                $GLOBALS['TCA'][$table]['types'][$type]['columnsOverrides']['tx_theme_facts_figures']['config']['overrideChildTca'],
                [
                    'columns' => [
                        'value' => [
                            'config' => [
                                'eval' => 'int,required',
                                'size' => '6',
                                'max' => '6',
                            ],
                        ]
                    ],
                ]
            );
        }

        /***************
         * Assign Icon
         */
        $GLOBALS['TCA'][$table]['ctrl']['typeicon_classes'][$type] = 'theme-content-facts-figures';
    },
    'theme',
    'tt_content',
    'theme_facts_figures'
);
