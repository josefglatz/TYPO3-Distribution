<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function ($extKey, $table, $type) {
        $languageFileBePrefix = 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_BackendGeneral.xlf:';
        $languageFileCePrefix = 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_ContentElements.xlf:';

        /***************
         * CE feature flags
         */
        $disableLinksForLogos = true;
        $minAmountLogos = 1;

        /***************
         * Add CE
         */
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
            $table,
            'CType',
            [
                $languageFileCePrefix . $type . '.title',
                $type,
                'theme-content-logos'
            ],
            'theme_youtube',
            'after'
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
                            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.headers;headers,
                            image,
                            ' . \JosefGlatz\Theme\Utility\Tca::getShowitemDefault(2)
                    ,
                    'columnsOverrides' => [
                        'image' => [
                            'label' => $languageFileBePrefix . 'field.tt_content.image.label.type.' . $type,
                            'config' => [
                                'filter' => [
                                    0 => [
                                        'parameters' => [
                                            'allowedFileExtensions' => $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['theme']['content']['theme_logo_list']['logoImage']['allowedImageFileExt']
                                        ],
                                    ],
                                ],
                                'overrideChildTca' => [
                                    'types' => [
                                    ],
                                    'columns' => [
                                        'uid_local' => [
                                            'config' => [
                                                'appearance' => [
                                                    'elementBrowserAllowed' => $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['theme']['content']['theme_logo_list']['logoImage']['allowedImageFileExt']
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                                'appearance' => [
                                    'createNewRelationLinkTitle' => $languageFileBePrefix . 'field.tt_content.image.irre.new.label.type.' . $type,
                                ],
                                'minitems' => (int)$minAmountLogos,
                            ],
                        ],
                    ],
                    'pageLayoutViewEnrichment' => [
                        'footer' => [
                            'badges' => [
                                // @TODO: TYPO3-Distribution: CE theme_logo_list: enable value badge once it's finalized
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
        if ($disableLinksForLogos) {
            $GLOBALS['TCA'][$table]['types'][$type]['columnsOverrides']['image']['config']['overrideChildTca'] = array_replace_recursive(
                $GLOBALS['TCA'][$table]['types'][$type]['columnsOverrides']['image']['config']['overrideChildTca'],
                [
                    'types' => [
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                            'showitem' => '
                                --palette--;;tx-theme-image-nolink,
                                --palette--;;filePalette',
                            'columnsOverrides' => [],
                        ],
                    ],
                ]
            );
        }

        /***************
         * Configure cropVariants
         */
        \JosefGlatz\CropVariantsBuilder\Builder::getInstance($table, 'image', $type)
            ->disableDefaultCropVariants()
            ->addCropVariant(
                \JosefGlatz\CropVariantsBuilder\CropVariant::create('logo')
                    ->addAllowedAspectRatios(\JosefGlatz\CropVariantsBuilder\Defaults\AspectRatio::get(['3:2']))
                    ->get()
            )
            ->persistToTca();

        /***************
         * Assign Icon
         */
        $GLOBALS['TCA'][$table]['ctrl']['typeicon_classes'][$type] = 'theme-content-logos';
    },
    'theme',
    'tt_content',
    'theme_logo_list'
);
