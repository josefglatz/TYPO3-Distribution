<?php

defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey) {
        // Add fields to rootLineFields
        $GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields'] .= '';

        // Disable ext:news realurl hook
//        unset($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/realurl/class.tx_realurl_autoconfgen.php']['extensionConfiguration']['news']);

//        @TODO: RealUrl Hooks for disabling cache and so on


        // Add general UserTSConfig
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig(
            '<INCLUDE_TYPOSCRIPT: source="FILE: EXT:' . $extKey . '/Configuration/TSConfig/UserGeneral.tsc">'
        );
    },
    $_EXTKEY
);
