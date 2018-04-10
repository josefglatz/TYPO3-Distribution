<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function ($extKey, $table) {
        $languageFileBePrefix = 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_BackendGeneral.xlf:';

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
             * Configure cropVariants
             */
            \JosefGlatz\Theme\Backend\CropVariants\Builder::getInstance($table, 'fal_media')
                ->disableDefaultCropVariants()
                ->addCropVariant(
                    \JosefGlatz\Theme\Backend\CropVariants\CropVariant::create('teaser')
                        ->setCropArea(\JosefGlatz\Theme\Backend\CropVariants\Defaults\CropArea::get())
                        ->addAllowedAspectRatios(\JosefGlatz\Theme\Backend\CropVariants\Defaults\AspectRatio::get(['3:2']))
                        ->get()
                )
                ->persistToTca();
        }
    },
    'theme',
    'tx_news_domain_model_news'
);
