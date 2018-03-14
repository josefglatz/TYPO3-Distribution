<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function ($extKey, $table) {
        $languageFileBePrefix = 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_BackendGeneral.xlf:';
        $pathSegment = 'Configuration/TSConfig/';
        $fileExt = '.tsc';
        $labelPrefix = 'theme :: ';

        // register elements (path/filename without extension, label without prefix)
        $elements = [
            'PageGeneral' => 'General PageTSConfig',
            'Page/Specific/NewOnlyFeUsers' => 'New: Restrict page(s) to FeUsers/FeGroups/SysNote',
            'Page/Specific/ClearCachePages' => 'ClearCacheCmd->pages',
            'Page/Specific/ClearCacheRegistrationSpecific' => 'ClearCacheCmd->cacheTag:customregistration,pages',
            'Page/Specific/HideTableTtContent' => 'Hide table TtContent',
            'Page/Specific/DisableCopyButtons' => 'Disable Backend Copy Buttons',
            'Page/Specific/DisableTranslateButtons' => 'Disable Backend Translate Buttons',
            'Page/Specific/Extension/News/NewOnlyNews' => 'New: Restrict page(s) to News/SysCategories/SysNote',
            'Page/Specific/Extension/News/ClearCacheNews' => 'ClearCacheCmd->cacheTag:tx_news',
            'Page/Specific/Extension/News/NewDefaultTypeSysFolderNews' => 'New: Set News Page Icon',
            'Page/Specific/Extension/News/NewsLimitCategories' => 'News->Limit Categories',
            'Page/Specific/Extension/News/NewsLimitMedia' => 'News->Limit Media',
            'Page/Specific/Extension/News/NewsMediaDefaultShowinpreviewOn' => 'News->Default "show in preview" per default on',
            'Page/Specific/Extension/News/PreviewRecordsNewsDetailDefault' => 'News->Preview Record (Default)',
            'Page/Specific/Extension/Powermail/NewOnlyPowermailRecords' => 'New: Restrict page(s) to Powermail/SysNote',
            'Page/Specific/NewDefaultPageActive' => 'New: Set any new sub page active per default',
        ];
        // register each $elements item as PageTSConfig file
        foreach ($elements as $fileName => $label) {
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
                $extKey,
                $pathSegment . $fileName . $fileExt,
                $labelPrefix . $label
            );
        }

        // Add custom page tree icons
        $customPageTreeIcons = [
            [
                'storage',  // last string of LLL
                'records',  // last part of typeicon_classes item
                'apps-pagetree-folder-contains-records' // icon-identifier
            ],
            [
                'pages',
                'pages',
                'apps-pagetree-folder-contains-pages',
            ],
            [
                'impress',
                'impress',
                'apps-pagetree-page-contains-impress',
            ],
            [
                'attention',
                'attention',
                'apps-pagetree-page-contains-attention',
            ],
            [
                'search',
                'search',
                'apps-pagetree-page-contains-search',
            ],
            [
                'news',
                'newsplugins',
                'apps-pagetree-page-contains-newsplugins',
            ],
            [
                'drafts',
                'drafts',
                'apps-pagetree-folder-contains-drafts',
            ],
        ];
        foreach ($customPageTreeIcons as $customPageTreeIcon) {
            $GLOBALS['TCA'][$table]['columns']['module']['config']['items'][] = [
                0 => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_BackendGeneral.xlf:icon.pagetree.' . $customPageTreeIcon[0] . '',
                1 => '' . $customPageTreeIcon[1] . '',
                2 => '' . $customPageTreeIcon[2] . '',
            ];
        }

        \TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule(
            $GLOBALS['TCA'][$table],
            [
                'ctrl' => [
                    'typeicon_classes' => [
                        'contains-impress' => 'apps-pagetree-page-contains-impress',
                        'contains-attention' => 'apps-pagetree-page-contains-attention',
                        'contains-search' => 'apps-pagetree-page-contains-search',
                        'contains-newsplugins' => 'apps-pagetree-page-contains-newsplugins',
                        'contains-records' => 'apps-pagetree-folder-contains-records',
                        'contains-pages' => 'apps-pagetree-folder-contains-pages',
                        'contains-drafts' => 'apps-pagetree-folder-contains-drafts',
                    ],
                ]
            ]
        );

        $additionalColumns = [
            'tx_theme_hide_page_heading' => [
                'exclude' => true,
                'label' => $languageFileBePrefix . 'field.pages.tx_theme_hide_page_heading.label',
                'config' => [
                    'type' => 'check',
                    'default' => '0',
                    'items' => [
                        '1' => [
                            '0' => $languageFileBePrefix . 'field.pages.tx_theme_hide_page_heading.check_0'
                        ]
                    ]
                ]
            ],
            'tx_theme_link_label' => [
                'exclude' => true,
                'label' => $languageFileBePrefix . 'field.pages.tx_theme_link_label.label',
                'config' => [
                    'type' => 'input',
                    'size' => 30,
                    'default' => '',
                    'eval' => 'trim',
                    'max' => 40
                ],
            ],
            'tx_theme_nav_image' => [
                'exclude' => true,
                'label' => $languageFileBePrefix . 'field.pages.tx_theme_nav_image.label',
                'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('tx_theme_nav_image', [
                    'overrideChildTca' => [
                        'types' => [
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                                'showitem' => '
                                alternative,title,
                                --linebreak--,crop,
                                --palette--;;filePalette',
                                'columnsOverrides' => [],
                            ],
                        ],
                        'columns' => [
                        ],
                    ],
                    'maxitems' => 1,
                ],
                    $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
                )
            ],
            'tx_theme_sharing_enabled' => [
                'exclude' => true,
                'label' => $languageFileBePrefix . 'field.pages.sharing_enabled',
                'config' => [
                    'type' => 'check',
                    'default' => '1',
                    'items' => [
                        '1' => [
                            '0' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                        ]
                    ]
                ]
            ],
            'tx_theme_show_in_secondary_navigation' => [
                'exclude' => true,
                'label' => $languageFileBePrefix . 'field.pages.tx_theme_show_in_secondary_navigation.label',
                'config' => [
                    'type' => 'check',
                    'default' => '0',
                    'items' => [
                        '1' => [
                            '0' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                        ]
                    ]
                ]
            ],
            'tx_theme_related' => [
                'exclude' => true,
                'label' => $languageFileBePrefix . 'field.pages.tx_theme_related.label',
                'config' => [
                    'type' => 'group',
                    'internal_type' => 'db',
                    'allowed' => 'pages',
                    'foreign_table' => 'pages',
                    'MM_opposite_field' => 'related_from',
                    'size' => 3,
                    'MM' => 'tx_theme_related_pages_mm',
                    'wizards' => [
                        'suggest' => [
                            'type' => 'suggest',
                            'default' => [
                                'searchWholePhrase' => true,
                                'addWhere' => ' AND pages.uid != ###THIS_UID###'
                            ]
                        ],
                    ],
                ]
            ],
            'tx_theme_robot_index' => [
                'exclude' => true,
                'label' => $languageFileBePrefix . 'field.pages.robot_index',
                'config' => [
                    'type' => 'check',
                    'default' => '1',
                    'items' => [
                        '1' => [
                            '0' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                        ]
                    ]
                ]
            ],
            'tx_theme_robot_follow' => [
                'exclude' => true,
                'label' => $languageFileBePrefix . 'field.pages.robot_follow',
                'config' => [
                    'type' => 'check',
                    'default' => '1',
                    'items' => [
                        '1' => [
                            '0' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                        ]
                    ]
                ]
            ],
            'tx_theme_opengraph_title' => [
                'label' => $languageFileBePrefix . 'field.pages.tx_theme_opengraph_title.label',
                'config' => [
                    'type' => 'input',
                    'eval' => 'trim',
                ]
            ],
            'tx_theme_opengraph_description' => [
                'label' => $languageFileBePrefix . 'field.pages.tx_theme_opengraph_description.label',
                'config' => [
                    'type' => 'input',
                    'eval' => 'trim',
                ]
            ],
            'tx_theme_opengraph_image' => [
                'exclude' => true,
                'label' => $languageFileBePrefix . 'field.pages.tx_theme_opengraph_image.label',
                'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                    'tx_theme_opengraph_image',
                    [
                        'overrideChildTca' => [
                            'types' => [
                                \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                                    'showitem' => '
                                    crop,
                                    --palette--;;filePalette',
                                    'columnsOverrides' => [],
                                ],
                                \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                                    'showitem' => '
                                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.videoOverlayPalette;videoOverlayPalette,
                                --palette--;;filePalette'
                                ],
                            ],
                            'columns' => [
                            ],
                        ],
                        'maxitems' => 1,
                    ],
                    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['theme']['sharing']['opengraph']['allowedImageFileExt']
                )
            ],
            'tx_theme_twitter_title' => [
                'label' => $languageFileBePrefix . 'field.pages.tx_theme_twitter_title.label',
                'config' => [
                    'type' => 'input',
                    'eval' => 'trim',
                    'max' => 70,
                ]
            ],
            'tx_theme_twitter_description' => [
                'label' => $languageFileBePrefix . 'field.pages.tx_theme_twitter_description.label',
                'config' => [
                    'type' => 'input',
                    'eval' => 'trim',
                ]
            ],
            'tx_theme_twitter_image' => [
                'exclude' => true,
                'label' => $languageFileBePrefix . 'field.pages.tx_theme_twitter_image.label',
                'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                    'tx_theme_twitter_image',
                    [
                        'overrideChildTca' => [
                            'types' => [
                                \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                                    'showitem' => '
                                crop,
                                --palette--;;filePalette',
                                    'columnsOverrides' => []
                                ],
                                \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                                    'showitem' => '
                                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.videoOverlayPalette;videoOverlayPalette,
                                --palette--;;filePalette'
                                ],
                            ],
                            'columns' => [
                            ],
                        ],
                        'maxitems' => 1,
                    ],
                    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['theme']['sharing']['opengraph']['allowedImageFileExt']
                )
            ],
        ];
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns($table, $additionalColumns);

        /**
         * Set cropVariants configuration
         */
        \JosefGlatz\Theme\Backend\CropVariants\Builder::getInstance($table, 'tx_theme_nav_image')
            ->disableDefaultCropVariants()
            ->addCropVariant(
                \JosefGlatz\Theme\Backend\CropVariants\CropVariant::create('xs')
                    ->addAllowedAspectRatios(\JosefGlatz\Theme\Backend\CropVariants\Defaults\AspectRatio::get(['4:3']))
                    ->get()
            )
            ->addCropVariant(
                \JosefGlatz\Theme\Backend\CropVariants\CropVariant::create('md')
                    ->addAllowedAspectRatios(\JosefGlatz\Theme\Backend\CropVariants\Defaults\AspectRatio::get(['4:3']))
                    ->get()
            )
            ->addCropVariant(
                \JosefGlatz\Theme\Backend\CropVariants\CropVariant::create('lg')
                    ->addAllowedAspectRatios(\JosefGlatz\Theme\Backend\CropVariants\Defaults\AspectRatio::get(['4:3']))
                    ->get()
            )
            ->persistToTca();

        \JosefGlatz\Theme\Backend\CropVariants\Builder::getInstance($table, 'tx_theme_opengraph_image')
            ->disableDefaultCropVariants()
            ->addCropVariant(
                \JosefGlatz\Theme\Backend\CropVariants\CropVariant::create('opengraph')
                    ->addAllowedAspectRatios(\JosefGlatz\Theme\Backend\CropVariants\Defaults\AspectRatio::get(['1.91:1']))
                    ->get()
            )
            ->persistToTca();

        \JosefGlatz\Theme\Backend\CropVariants\Builder::getInstance($table, 'tx_theme_twitter_image')
            ->disableDefaultCropVariants()
            ->addCropVariant(
                \JosefGlatz\Theme\Backend\CropVariants\CropVariant::create('twitterimage')
                    ->addAllowedAspectRatios(\JosefGlatz\Theme\Backend\CropVariants\Defaults\AspectRatio::get(['1.91:1']))
                    ->get()
            )
            ->persistToTca();

        /**
         * Set TCA palettes
         */
        \TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule(
            $GLOBALS['TCA'][$table]['palettes'],
            [
                'tx-theme-opengraph' => [
                    'showitem' => '
                        tx_theme_opengraph_title,tx_theme_opengraph_description,
                        --linebreak--,tx_theme_opengraph_image
                    '
                ],
                'tx-theme-twitter' => [
                    'showitem' => '
                        tx_theme_twitter_title,tx_theme_twitter_description,
                        --linebreak--,tx_theme_twitter_image
                    '
                ],
                'tx-theme-related' => [
                    'showitem' => '
                        tx_theme_related
                    '
                ],
                'tx-theme-robot-instructions' => [
                    'showitem' => '
                        tx_theme_robot_index, tx_theme_robot_follow
                    '
                ],
            ]
        );

        /**
         * Make further adoptions to table
         */
        // Extend core's "abstract" palette
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
            $table,
            'abstract',
            '--linebreak--,tx_theme_link_label,tx_theme_nav_image',
            ''
        );
        // Add seo focused palettes
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
            $table,
            '--div--;' . $languageFileBePrefix . 'div.pages.seo,
            --palette--;' . $languageFileBePrefix . 'palette.pages.opengraph;tx-theme-opengraph,
            --palette--;' . $languageFileBePrefix . 'palette.pages.twitter;tx-theme-twitter',
            '',
            'after:TSconfig'
        );
        // Add robots meta tag palette
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
            $table,
            '--palette--;' . $languageFileBePrefix . 'palette.pages.robot_instructions;tx-theme-robot-instructions',
            (string) \TYPO3\CMS\Frontend\Page\PageRepository::DOKTYPE_DEFAULT,
            'after:description'
        );
        // Extend core's "editorial" palette
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
            $table,
            'editorial',
            '--linebreak--,tx_theme_sharing_enabled',
            'after:lastUpdated'
        );
        // Add related palette
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
            $table,
            '--palette--;' . $languageFileBePrefix . 'palette.pages.related;tx-theme-related',
            (string) \TYPO3\CMS\Frontend\Page\PageRepository::DOKTYPE_DEFAULT,
            'after:tx_theme_sharing_enabled'
        );
        // Extend core's "layout" palette
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
            $table,
            'layout',
            'tx_theme_hide_page_heading',
            'after:layout'
        );
        // Extend core's "visibility" palette
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
            $table,
            'visibility',
            'tx_theme_show_in_secondary_navigation',
            'after:nav_hide'
        );
    },
    'theme',
    'pages'
);
