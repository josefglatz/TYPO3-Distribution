<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function ($extKey, $table) {
        $languageFileBePrefix = 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_BackendGeneral.xlf:';

        $tca = [
            'columns' => [
                'link' => [
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
            'types' => [
            ],
        ];
        $GLOBALS['TCA'][$table] = array_replace_recursive($GLOBALS['TCA'][$table], $tca);

        /**
         * Additional columns
         */
        $additionalColumns = [
            'tx_theme_video_autoplay' => [
                'exclude' => true,
                'label' => $languageFileBePrefix . 'field.sys_file_reference.tx_theme_video_autoplay.label',
                'config' => [
                    'type' => 'check',
                    'items' => [
                        [
                            'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:labels.enabled',
                        ],
                    ],
                ],
            ],
            'tx_theme_video_showinfo' => [
                'exclude' => true,
                'label' => $languageFileBePrefix . 'field.sys_file_reference.tx_theme_video_showinfo.label',
                'config' => [
                    'type' => 'check',
                    'items' => [
                        [
                            'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:labels.show',
                        ],
                    ],
                ],
            ],
            'tx_theme_video_rel' => [
                'exclude' => true,
                'label' => $languageFileBePrefix . 'field.sys_file_reference.tx_theme_video_rel.label',
                'config' => [
                    'type' => 'check',
                    'items' => [
                        [
                            'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:labels.show',
                        ],
                    ],
                ],
            ],
            'tx_theme_video_startminute' => [
                'exclude' => 0,
                'label' => $languageFileBePrefix . 'field.sys_file_reference.tx_theme_video_startminute.label',
                'config' => [
                    'type' => 'input',
                    'size' => '5',
                ],
            ],
            'tx_theme_video_startsecond' => [
                'exclude' => 0,
                'label' => $languageFileBePrefix . 'field.sys_file_reference.tx_theme_video_startsecond.label',
                'config' => [
                    'type' => 'input',
                    'size' => '10',
                    'eval' => 'trim,int',
                    'range' => [
                        'lower' => 0,
                        'upper' => 59,
                    ],
                    'default' => 0,
                    'slider' => [
                        'step' => 1,
                        'width' => 120,
                    ],
                ],
            ],
            'tx_theme_video_ratio' => [
                'exclude' => true,
                'label' => $languageFileBePrefix . 'field.sys_file_reference.tx_theme_video_ratio.label',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'items' => [], /* items set in page TsConfig */
                    'size' => 1,
                    'maxitems' => 1
                ]
            ],
            'tx_theme_video_fullscreen' => [
                'exclude' => true,
                'label' => $languageFileBePrefix . 'field.sys_file_reference.tx_theme_video_fullscreen.label',
                'config' => [
                    'type' => 'check',
                    'items' => [
                        [
                            $languageFileBePrefix . 'field.sys_file_reference.tx_theme_video_fullscreen.check_0',
                        ],
                    ],
                ],
            ],
            'tx_theme_video_loop' => [
                'exclude' => true,
                'label' => $languageFileBePrefix . 'field.sys_file_reference.tx_theme_video_loop.label',
                'config' => [
                    'type' => 'check',
                    'items' => [
                        [
                            'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:labels.enabled',
                        ],
                    ],
                ],
            ],
            'tx_theme_youtube_color' => [
                'exclude' => true,
                'label' => $languageFileBePrefix . 'field.sys_file_reference.tx_theme_youtube_color.label',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'items' => [
                        [
                            $languageFileBePrefix . 'field.sys_file_reference.tx_theme_youtube_color.check_red',
                            'red'
                        ],
                        [
                            $languageFileBePrefix . 'field.sys_file_reference.tx_theme_youtube_color.check_white',
                            'white'
                        ],
                    ],
                    'size' => 1,
                    'maxitems' => 1
                ],
            ],
            'tx_theme_video_covertitle' => [
                'exclude' => true,
                'label' => $languageFileBePrefix . 'field.sys_file_reference.tx_theme_video_covertitle.label',
                'config' => [
                    'type' => 'input',
                    'size' => '50',
                    'max' => '70',
                ],
            ],
            'tx_theme_video_covertext' => [
                'exclude' => true,
                'label' => $languageFileBePrefix . 'field.sys_file_reference.tx_theme_video_covertext.label',
                'config' => [
                    'type' => 'input',
                    'size' => '50',
                    'max' => '120',
                ],
            ],
            'tx_theme_video_coverimage' => [
                'exclude' => true,
                'label' => $languageFileBePrefix . 'field.sys_file_reference.tx_theme_video_coverimage.label',
                'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                    'tx_theme_video_coverimage',
                    [
                        'appearance' => [
                            'createNewRelationLinkTitle' => $languageFileBePrefix . 'field.' . $table . '.tx_theme_video_coverimage.irre.new.label',
                            'collapseAll' => false,
                        ],
                        'overrideChildTca' => [
                            'types' => [
                                \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                                    'showitem' => '
                                    crop,
                                    --palette--;;filePalette',
                                    'columnsOverrides' => [],
                                ],
                            ],
                            'columns' => [
                            ],
                        ],
                        'maxitems' => 1,
                    ],
                    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['theme']['content']['youtube']['coverImage']['allowedImageFileExt']
                )
            ],
        ];
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns($table, $additionalColumns);

        // Add palette "tx-theme-image-nolink"
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
            $table,
            'tx-' . $extKey . '-image-nolink',
            'title,alternative,--linebreak--,
            description,--linebreak--,crop'
        );
        // Add palette "tx-theme-image-nolink-nodescription"
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
            $table,
            'tx-' . $extKey . '-image-nolink-nodescription',
            'title,alternative,--linebreak--,
            --linebreak--,crop'
        );
        // Add palette "tx-theme-video-cover"
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
            $table,
            'tx-' . $extKey . '-video-cover',
            'tx_theme_video_covertitle,
            tx_theme_video_covertext,
            --linebreak--,
            tx_theme_video_coverimage,'
        );
        // Add palette "tx-theme-video-settings"
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
            $table,
            'tx-' . $extKey . '-video-settings',
            'tx_theme_video_ratio, tx_theme_video_startminute, tx_theme_video_startsecond, tx_theme_youtube_color,
            --linebreak--,
            tx_theme_video_autoplay, tx_theme_video_showinfo, tx_theme_video_rel, tx_theme_video_fullscreen, tx_theme_video_loop,'
        );

        // Default cropVariants configuration is automatically generated out of \JosefGlatz\Theme\Backend\CropVariants\Defaults\Configuration::CONFIGFILE
        $fileLoader = TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Configuration\Loader\YamlFileLoader::class);
        $configuration = $fileLoader->load(\JosefGlatz\Theme\Backend\CropVariants\Defaults\Configuration::CONFIGFILE);
        $defaults = $configuration['imageManipulation']['cropVariants']['defaults']['defaultCropVariantsConfiguration'];
        // Array must be at least available
        if (!\is_array($defaults)) {
            throw new \UnexpectedValueException(
                'The defaultCropVariantsConfiguration configuration can\'t be retrieved from the configuration file. (Please take a look at ' . \JosefGlatz\Theme\Backend\CropVariants\Defaults\Configuration::CONFIGFILE . ')',
                1524948477
            );
        }
        // Overwrite the TYPO3 core default cropVariant configuration if the necessary configuration has at least one entry
        if (!empty($defaults)) {
            $defaultCrop = \JosefGlatz\Theme\Backend\CropVariants\Builder::getInstance($table, 'crop');
            foreach ($defaults as $key => $config) {
                $defaultCrop = $defaultCrop->addCropVariant(
                    \JosefGlatz\Theme\Backend\CropVariants\CropVariant::create($key)
                        ->setCropArea(\JosefGlatz\Theme\Backend\CropVariants\Defaults\CropArea::get())
                        ->addAllowedAspectRatios(\JosefGlatz\Theme\Backend\CropVariants\Defaults\AspectRatio::get($config['aspectRatios']))
                        ->get()
                );
            }
            $defaultCrop->persistToDefaultTableTca();
        }

        // cropVariants configuration for sys_file_reference.tx_theme_video_coverimage column
        \JosefGlatz\Theme\Backend\CropVariants\Builder::getInstance($table, 'tx_theme_video_coverimage')
            ->disableDefaultCropVariants()
            ->addCropVariant(
                \JosefGlatz\Theme\Backend\CropVariants\CropVariant::create('video')
                    ->addAllowedAspectRatios(\JosefGlatz\Theme\Backend\CropVariants\Defaults\AspectRatio::get(['16:9', '4:3']))
                    ->setSelectedRatio('16:9')
                    ->get()
            )
            ->persistToTca();
    },
    'theme',
    'sys_file_reference'
);
