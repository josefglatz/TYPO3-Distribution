<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function ($extKey, $table, $type) {
        $languageFileBePrefix = 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_BackendGeneral.xlf:';

        /*
         * Add type
         */
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
            $table,
            'type',
            [
                $languageFileBePrefix . 'field.' . $table . '.types.' . $type . '.label',
                $type,
                'theme-content-gallery'
            ]
        );

        // Set default to core's static sys_file_collection type
        $GLOBALS['TCA'][$table]['types'][$type] = $GLOBALS['TCA'][$table]['types']['static'];

        $tca = [
            'columns' => [
            ],
            'types' => [
                $type => [
                    // Adopt IRRE configuration to allow only image file types for this file collection type.
                    'columnsOverrides' => [
                        'files' => [
                            'config' => [
                                'overrideChildTca' => [
                                    'columns' => [
                                        'uid_local' => [
                                            'config' => [
                                                'appearance' => [
                                                    'elementBrowserType' => 'file',
                                                    'elementBrowserAllowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                                'filter' => [
                                    [
                                        'userFunc' => \TYPO3\CMS\Core\Resource\Filter\FileExtensionFilter::class . '->filterInlineChildren',
                                        'parameters' => [
                                            'allowedFileExtensions' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
                                            'disallowedFileExtensions' => ''
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
        $GLOBALS['TCA'][$table] = array_replace_recursive($GLOBALS['TCA'][$table], $tca);

        $GLOBALS['TCA'][$table]['ctrl']['typeicon_classes'][$type] = 'theme-content-gallery';
    },
    'theme',
    'sys_file_collection',
    'tx_theme_images'
);
