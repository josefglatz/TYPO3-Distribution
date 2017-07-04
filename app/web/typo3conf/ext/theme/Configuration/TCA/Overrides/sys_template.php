<?php

declare(strict_types=1);

defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function ($extKey, $table) {

        /**
         * Embed static TypoScript template(s)
         * by adding all your available sites to $websites
         *
         * e.g.: siteDefault = EXT:theme/Configuration/TypoScript/Sites/SiteDefault
         */
        $websites = ['SiteDefault'];
        foreach ($websites as $website) {
            TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
                $extKey,
                'Configuration/TypoScript/Sites/' . $website,
                'Theme TS:' . $website
            );
        }
    },
    'theme',
    'sys_template'
);
