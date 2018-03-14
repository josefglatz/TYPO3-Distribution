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

        \JosefGlatz\Theme\Backend\CropVariants\Builder::getInstance($table, 'crop')
            ->addCropVariant(
                \JosefGlatz\Theme\Backend\CropVariants\CropVariant::create('default')
                    ->setCropArea(\JosefGlatz\Theme\Backend\CropVariants\Defaults\CropArea::get())
                    ->addAllowedAspectRatios(\JosefGlatz\Theme\Backend\CropVariants\Defaults\AspectRatio::getDefaults())
                    ->setSelectedRatio('NaN')
                    ->get()
            )
            ->persistToDefaultTableTca();
    },
    'theme',
    'sys_file_reference'
);
