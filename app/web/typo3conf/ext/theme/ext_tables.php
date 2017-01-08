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
