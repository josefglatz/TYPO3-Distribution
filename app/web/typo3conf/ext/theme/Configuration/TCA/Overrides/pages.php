<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function ($extKey) {
        $pathSegment = 'Configuration/TSConfig/';
        $fileExt = '.tsc';
        $labelPrefix = 'theme :: ';

        // register elements (path/filename without extension, label without prefix)
        $elements = [
            'PageGeneral' => 'General PageTSConfig',
            'Page/Specific/NewOnlyFeUsers' => 'New: Restrict page(s) to FeUsers/FeGroups/SysNote',
            'Page/Specific/ClearCachePages' => 'ClearCacheCmd->pages',
            'Page/Specific/ClearCacheRegistrationSpecific' => 'ClearCacheCmd->cacheTag:customregistration,pages',
            'Page/Specific/HideTableTtContent' => 'Hide table TtContent',
            'Page/Specific/Extension/News/NewOnlyNews' => 'New: Restrict page(s) to News/SysCategories/SysNote',
            'Page/Specific/Extension/News/ClearCacheNews' => 'ClearCacheCmd->cacheTag:tx_news',
            'Page/Specific/Extension/News/NewsLimitCategories' => 'News->Limit Categories',
            'Page/Specific/Extension/News/NewsLimitMedia' => 'News->Limit Media',
            'Page/Specific/Extension/News/NewsMediaDefaultShowinpreviewOn' => 'News->Default "show in preview" per default on',
            'Page/Specific/Extension/News/PreviewRecordsNewsDetailDefault' => 'News->Preview Record (Default)',
        ];
        // register each $elements item as PageTSConfig file
        foreach ($elements as $fileName => $label) {
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
                $extKey,
                $pathSegment . $fileName . $fileExt,
                $labelPrefix . $label
            );
        }


        // Add custom page tree icons
        // @TODO: Streamline adding new icons with simple foreach

        $GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = [
            0 => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_BackendGeneral.xlf:icon.pagetree.folder.storage',
            1 => 'records',
            2 => 'apps-pagetree-folder-contains-records',
        ];
        $GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = [
            0 => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_BackendGeneral.xlf:icon.pagetree.page.impress',
            1 => 'impress',
            2 => 'apps-pagetree-page-contains-impress',
        ];
        $GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = [
            0 => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_BackendGeneral.xlf:icon.pagetree.page.attention',
            1 => 'attention',
            2 => 'apps-pagetree-page-contains-attention',
        ];
        $GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = [
            0 => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_BackendGeneral.xlf:icon.pagetree.page.search',
            1 => 'search',
            2 => 'apps-pagetree-page-contains-search',
        ];
        $GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = [
            0 => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_BackendGeneral.xlf:icon.pagetree.page.news',
            1 => 'newsplugins',
            2 => 'apps-pagetree-page-contains-newsplugins',
        ];

        \TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule(
            $GLOBALS['TCA']['pages'],
            [
                'ctrl' => [
                    'typeicon_classes' => [
                        'contains-impress' => 'apps-pagetree-page-contains-impress',
                        'contains-attention' => 'apps-pagetree-page-contains-attention',
                        'contains-search' => 'apps-pagetree-page-contains-search',
                        'contains-newsplugins' => 'apps-pagetree-page-contains-news',
                        'contains-records' => 'apps-pagetree-folder-contains-records',
                    ],
                ]
            ]
        );
    },
    'theme'
);
