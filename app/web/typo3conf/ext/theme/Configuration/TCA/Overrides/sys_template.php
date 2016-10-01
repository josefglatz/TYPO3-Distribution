<?php

defined('TYPO3_MODE') || die ('Access denied.');

call_user_func(
    function ($extKey) {


        /**
         * Embed static TypoScript template(s)
         * by adding all your available sites to $websites
         *
         * e.g.: siteDefault = EXT:theme/Configuration/TypoScript/Sites/SiteDefault
         */
        $websites = ['SiteDefault'];
        foreach ($websites as $website) {
            TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
                'theme',
                'Configuration/TypoScript/Sites/'.$website,
                'Thm TS:'.$website
            );
        }


    },
    'theme'
);
