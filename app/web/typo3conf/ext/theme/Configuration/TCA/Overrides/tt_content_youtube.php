<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function ($extKey, $table, $type) {
        $languageFileBePrefix = 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_BackendGeneral.xlf:';
        $languageFileCePrefix = 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_ContentElements.xlf:';

        /***************
         * CE feature flags
         */
        $maxAmountVideos = 1;

        /**
         * Add CE
         */
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
            $table,
            'CType',
            [
                $languageFileCePrefix . $type . '.title',
                $type,
                'theme-content-youtube'
            ],
            'uploads',
            'after'
        );

        $tca = [
            'columns' => [
            ],
            'palettes' => [
            ],
            'types' => [
                $type => [
                    'showitem' => \JosefGlatz\Theme\Utility\Tca::getShowitemDefault(1) . '
                            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.headers;headers,
                            bodytext,
                            assets,
                            ' . \JosefGlatz\Theme\Utility\Tca::getShowitemDefault(2)
                    ,
                    'columnsOverrides' => [
                        'bodytext' => [
                            'config' => [
                                'enableRichtext' => true,
                                'richtextConfiguration' => 'theme_defaultNoTables',
                            ]
                        ],
                        'assets' => [
                            'label' => $languageFileBePrefix . 'field.tt_content.assets.label.type.youtube',
                            'config' => [
                                'minitems' => 1,
                                'maxitems' => (int)$maxAmountVideos,
                                'overrideChildTca' => [
                                    'types' => [
                                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                                            'showitem' => '
                                            description,
                                            --palette--;' . $languageFileBePrefix . 'palette.sys_file_reference.tx-theme-video-cover;tx-theme-video-cover,
                                            --palette--;' . $languageFileBePrefix . 'palette.sys_file_reference.tx-theme-video-settings;tx-' . $extKey . '-video-settings,
                                            --palette--;;filePalette',
                                        ],
                                    ],
                                    'columns' => [
                                        'uid_local' => [
                                            'config' => [
                                                'appearance' => [
                                                    'elementBrowserAllowed' => 'youtube',
                                                ],
                                            ],
                                        ],
                                        'description' => [
                                            'config' => [
                                                'type' => 'input',
                                                'size' => 50,
                                            ],
                                        ],
                                    ],
                                ],
                                'appearance' => [
                                    'createNewRelationLinkTitle' => $languageFileBePrefix . 'field.tt_content.assets.irre.new.label.type.youtube',
                                    'collapseAll' => false,
                                ],
                                'filter' => [
                                    [
                                        'userFunc' => \TYPO3\CMS\Core\Resource\Filter\FileExtensionFilter::class . '->filterInlineChildren',
                                        'parameters' => [
                                            'allowedFileExtensions' => 'youtube',
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

        /**
         * Assign Icon
         */
        $GLOBALS['TCA'][$table]['ctrl']['typeicon_classes'][$type] = 'theme-content-youtube';
    },
    'theme',
    'tt_content',
    'theme_youtube'
);
