<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function ($extKey, $table) {
        $languageFileBePrefix = 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_BackendGeneral.xlf:';
        $pathSegment = 'Configuration/TsConfig/';
        $fileExt = '.tsconfig.typoscript';
        $labelPrefix = 'theme :: ';

        // register elements (path/filename without extension, label without prefix)
        $elements = [
            'PageGeneral' => 'General PageTSConfig',
            'Page/Specific/NewOnlyFeUsers' => 'New: Restrict page(s) to FeUsers/FeGroups/SysNote',
            'Page/Specific/NewPagePermissions-G-show-editcontent' => 'New: Permissions: Group: show, editcontent',
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
                'apps-pagetree-folder-dark' // icon-identifier
            ],
            [
                'pages',
                'pages',
                'apps-pagetree-page-shortcut',
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
                'news',
                'newsplugins',
                'apps-pagetree-page-contains-newsplugins',
            ],
            [
                'landingpages',
                'landingpages',
                'apps-pagetree-folder-contains-landingpages',
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
                        'contains-newsplugins' => 'apps-pagetree-page-contains-newsplugins',
                        'contains-records' => 'apps-pagetree-folder-dark',
                        'contains-pages' => 'apps-pagetree-page-shortcut',
                        'contains-landingpages' => 'apps-pagetree-folder-contains-landingpages',
                    ],
                ]
            ]
        );

        $tca = [
            /*
             * ['ctrl'] configuration
             */
            'ctrl' => [
                // Add columns to search fields - so its included in the backend search results
                'searchFields' => $GLOBALS['TCA'][$table]['ctrl']['searchFields'] . ',',
            ],
            /*
             * ['interface'] configuration
             */
            'interface' => [
                // Extend showRecordFieldList
                'showRecordFieldList' => $GLOBALS['TCA'][$table]['interface']['showRecordFieldList'] . ',tx_theme_hide_page_heading,tx_theme_link_label,tx_theme_nav_image,tx_theme_sharing_enabled,tx_theme_show_in_secondary_navigation,tx_theme_related',
            ],
            /*
             * Columns configuration
             */
            'columns' => [

            ],
            /*
             * Types configuration
             */
            'types' => [

            ],
        ];
        $GLOBALS['TCA'][$table] = array_replace_recursive($GLOBALS['TCA'][$table], $tca);

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
                'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                    'tx_theme_nav_image',
                    [
                    'appearance' => [
                        'createNewRelationLinkTitle' => $languageFileBePrefix . 'field.pages.tx_theme_nav_image.irre.new.label',
                    ],
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
                    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['theme']['pages']['tx_theme_nav_image']['default']['allowedImageFileExt']
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
                            '0' => 'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:labels.enabled'
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
                            '0' => 'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:labels.enabled'
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
                    'suggestOptions' => [
                        'default' => [
                            'searchWholePhrase' => true,
                            'addWhere' => ' AND pages.uid != ###THIS_UID###'
                        ]
                    ],
                ]
            ],
        ];
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns($table, $additionalColumns);

        /**
         * Set cropVariants configuration
         */
        \JosefGlatz\CropVariantsBuilder\Builder::getInstance($table, 'tx_theme_nav_image')
            ->disableDefaultCropVariants()
            ->addCropVariant(
                \JosefGlatz\CropVariantsBuilder\CropVariant::create('xs')
                    ->addAllowedAspectRatios(\JosefGlatz\CropVariantsBuilder\Defaults\AspectRatio::get(['4:3']))
                    ->get()
            )
            ->addCropVariant(
                \JosefGlatz\CropVariantsBuilder\CropVariant::create('md')
                    ->addAllowedAspectRatios(\JosefGlatz\CropVariantsBuilder\Defaults\AspectRatio::get(['4:3']))
                    ->get()
            )
            ->addCropVariant(
                \JosefGlatz\CropVariantsBuilder\CropVariant::create('lg')
                    ->addAllowedAspectRatios(\JosefGlatz\CropVariantsBuilder\Defaults\AspectRatio::get(['4:3']))
                    ->get()
            )
            ->persistToTca();

        /**
         * Set TCA palettes
         */
        \TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule(
            $GLOBALS['TCA'][$table]['palettes'],
            [
                'tx-theme-related' => [
                    'showitem' => '
                        tx_theme_related
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
            (string)\TYPO3\CMS\Frontend\Page\PageRepository::DOKTYPE_DEFAULT,
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
