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
                'crop' => [
                    'config' => [
                        'cropVariants' => [
                            'default' => [
                                'title' => $languageFileBePrefix . 'crop_variants.default.label',
                                'coverAreas' => [],
                                'cropArea' => \JosefGlatz\Theme\Utility\CropVariants\CropAreaDefaults::get(),
                                'allowedAspectRatios' => \JosefGlatz\Theme\Utility\CropVariants\AspectRatioDefaults::getDefaults(),
                                'selectedRatio' => 'NaN'
                            ],
                        ],
                    ],
                ],
            ],
            'types' => [
            ],
        ];
        $GLOBALS['TCA'][$table] = array_replace_recursive($GLOBALS['TCA'][$table], $tca);
    },
    'theme',
    'sys_file_reference'
);
