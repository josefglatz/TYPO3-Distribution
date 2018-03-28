<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function ($extKey, $table, $type) {
        $languageFileBePrefix = 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_BackendGeneral.xlf:';
        $languageFileCePrefix = 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_ContentElements.xlf:';

        /**
         * Add CE
         */
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
            $table,
            'CType',
            [
                $languageFileCePrefix . $type . '.title',
                $type,
                'content-textpic'
            ],
            'textpic',
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
                            bodytext;' . $languageFileBePrefix . 'field.tt_content.bodytext.label.type.textimage,
                            --div--;' . $languageFileBePrefix . 'tabs.label.single-image,
                            tx_theme_big_media,
                            image;' . $languageFileBePrefix . 'field.tt_content.image.label.type.textimage,
                            ' . \JosefGlatz\Theme\Utility\Tca::getShowitemDefault(2)
                    ,
                    'columnsOverrides' => [
                        'bodytext' => [
                            'config' => [
                                'enableRichtext' => true,
                                'richtextConfiguration' => 'theme_defaultNoTables',
                                'eval' => 'required'
                            ]
                        ],
                        'image' => [
                            'config' => [
                                'minitems' => 1,
                                'maxitems' => 1,
                                'appearance' => [
                                    'createNewRelationLinkTitle' => $languageFileBePrefix . 'field.tt_content.image.irre.new.label.type.textimage',
                                    'collapseAll' => false,
                                ],
                            ],
                        ],
                    ],
                    'pageLayoutViewEnrichment' => [
                        'footer' => [
                            'badges' => [
                                JosefGlatz\Theme\Backend\Enrichment\Badge\Configuration::isTrue('tx_theme_big_media'),
                            ],
                        ],
                    ],
                ],
            ],
        ];
        $GLOBALS['TCA'][$table] = array_replace_recursive($GLOBALS['TCA'][$table], $tca);

        \JosefGlatz\Theme\Backend\CropVariants\Builder::getInstance($table, 'image')
            ->disableDefaultCropVariants()
            ->addCropVariant(
                \JosefGlatz\Theme\Backend\CropVariants\CropVariant::create('xs')
                    ->addAllowedAspectRatios(\JosefGlatz\Theme\Backend\CropVariants\Defaults\AspectRatio::get(['3:2']))
                    ->setCropArea(\JosefGlatz\Theme\Backend\CropVariants\Defaults\CropArea::get())
                    ->get()
            )
            ->addCropVariant(
                \JosefGlatz\Theme\Backend\CropVariants\CropVariant::create('md')
                    ->addAllowedAspectRatios(\JosefGlatz\Theme\Backend\CropVariants\Defaults\AspectRatio::get(['3:2']))
                    ->setCropArea(\JosefGlatz\Theme\Backend\CropVariants\Defaults\CropArea::get())
                    ->get()
            )
            ->addCropVariant(
                \JosefGlatz\Theme\Backend\CropVariants\CropVariant::create('lg')
                    ->addAllowedAspectRatios(\JosefGlatz\Theme\Backend\CropVariants\Defaults\AspectRatio::get(['3:2']))
                    ->setCropArea(\JosefGlatz\Theme\Backend\CropVariants\Defaults\CropArea::get())
                    ->get()
            )
            ->persistToTca();

        /**
         * Assign Icon
         */
        $GLOBALS['TCA'][$table]['ctrl']['typeicon_classes'][$type] = 'content-textpic';
    },
    'theme',
    'tt_content',
    'theme_textimage'
);
