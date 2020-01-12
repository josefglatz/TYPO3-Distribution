<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function ($extKey, $table) {
        $languageFileBePrefix = 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_BackendGeneral.xlf:';

        /***************
         * feature flags
         */
        $limitFalMediaToImagefileExt = false;

        /***************
         * Apply changes only if EXT:news is loaded
         */
        if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('news')) {
            $tca = [
                'columns' => [
                ],
                'types' => [
                ],
            ];
            $GLOBALS['TCA'][$table] = array_replace_recursive($GLOBALS['TCA'][$table], $tca);

            /***************
             * Additional columns
             */
            $additionalColumns = [

            ];
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns($table, $additionalColumns);

            /***************
             * CE feature flags
             */
            if ($limitFalMediaToImagefileExt) {
                $GLOBALS['TCA'][$table]['columns'] = array_replace_recursive(
                    $GLOBALS['TCA'][$table]['columns'],
                    [
                        'fal_media' => [
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
                    ]
                );
            }

            /***************
             * Configure cropVariants
             */
            \JosefGlatz\CropVariantsBuilder\Builder::getInstance($table, 'fal_media')
                ->disableDefaultCropVariants()
                ->addCropVariant(
                    \JosefGlatz\CropVariantsBuilder\CropVariant::create('teaser')
                        ->setCropArea(\JosefGlatz\CropVariantsBuilder\Defaults\CropArea::get())
                        ->addAllowedAspectRatios(\JosefGlatz\CropVariantsBuilder\Defaults\AspectRatio::get(['3:2']))
                        ->get()
                )
                ->persistToTca();
        }
    },
    'theme',
    'tx_news_domain_model_news'
);
