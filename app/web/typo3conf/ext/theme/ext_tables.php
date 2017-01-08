<?php

defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function ($extKey) {

        // Add/register icons
        if (TYPO3_MODE === 'BE') {

            // register svg icons: identifier and filename
            $iconsSvg = [
                'theme-backend-realurl-reset' => 'theme-backend-realurl-reset.svg',
                'theme-content-inheritance-stop' => 'theme-content-inheritance-stop.svg',
                'theme-content-gridelement' => 'GridElements/theme-content-gridelement.svg',
                'theme-content-gridelement-2-col' => 'GridElements/theme-content-gridelement-2-col.svg',
                'theme-content-gridelement-3-col' => 'GridElements/theme-content-gridelement-3-col.svg',
                'theme-content-gridelement-4-col' => 'GridElements/theme-content-gridelement-4-col.svg',
                'theme-content-gridelement-accordion' => 'GridElements/theme-content-gridelement-accordion.svg',
                'theme-content-gridelement-carousel' => 'GridElements/theme-content-gridelement-carousel.svg',
                'theme-content-gridelement-container' => 'GridElements/theme-content-gridelement-container.svg',
                'theme-content-gridelement-single-column-header-footer' => 'GridElements/theme-content-gridelement-single-column-header-footer.svg',
                'theme-content-gridelement-single-column-horizontal' => 'GridElements/theme-content-gridelement-single-column-horizontal.svg',
                'theme-content-gridelement-single-column-vertical' => 'GridElements/theme-content-gridelement-single-column-vertical.svg',
                'theme-content-gridelement-tab' => 'GridElements/theme-content-gridelement-tab.svg',
            ];
            $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
            foreach ($iconsSvg as $identifier => $path) {
                $iconRegistry->registerIcon(
                    $identifier,
                    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
                    ['source' => 'EXT:' . $extKey . '/Resources/Public/Icons/Backend/' . $path]
                );
            }

            // to register bitmap icons (e.g. png) you must register them using the BitmapIconProvider
        }
    },
    $_EXTKEY
);
