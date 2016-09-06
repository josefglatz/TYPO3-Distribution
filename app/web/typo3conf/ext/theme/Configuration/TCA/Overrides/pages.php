<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function ($extKey) {

        // Add theme's general PageTSConfig
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
            'theme',
            'Configuration/TSConfig/PageGeneral.tsc',
            'theme :: General PageTSConfig'
        );

        // Add "Only X" PageTSConfig
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
            'theme',
            'Configuration/TSConfig/Page/Specifc/NewOnlyFeUsers.tsc',
            'theme :: Restrict pages to FeUsers/FeGroups'
        );

        // Add "Only X" PageTSConfig
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
            'theme',
            'Configuration/TSConfig/Page/Specific/NewOnlyNews.tsc',
            'theme :: Restrict pages to News/SysCategories/SysNote'
        );

        // Add "Only X" PageTSConfig
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
            $extKey,
            'Configuration/TSConfig/Page/Specific/HideTableTtContent.tsc',
            'theme :: Hide table TtContent'
        );

        // Add "Only X" PageTSConfig
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
            $extKey,
            'Configuration/TSConfig/Page/Specific/ClearCacheNews.tsc',
            'theme :: ClearCacheCmd->cacheTag:tx_news'
        );

    },
    'theme'
);
