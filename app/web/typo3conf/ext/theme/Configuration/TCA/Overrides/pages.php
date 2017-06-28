<?php

declare(strict_types=1);
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function ($extKey) {
        $pathSegment = 'Configuration/TSConfig/';
        $fileExt = '.tsc';
        $labelPrefix = 'theme :: ';

        // register elements (path/filename without extension, label without prefix)
        $elements = [
            'PageGeneral'                                                  => 'General PageTSConfig',
            'Page/Specific/NewOnlyFeUsers'                                 => 'New: Restrict page(s) to FeUsers/FeGroups/SysNote',
            'Page/Specific/ClearCachePages'                                => 'ClearCacheCmd->pages',
            'Page/Specific/ClearCacheRegistrationSpecific'                 => 'ClearCacheCmd->cacheTag:customregistration,pages',
            'Page/Specific/HideTableTtContent'                             => 'Hide table TtContent',
            'Page/Specific/DisableCopyButtons'                             => 'Disable Backend Copy Buttons',
            'Page/Specific/DisableTranslateButtons'                        => 'Disable Backend Translate Buttons',
            'Page/Specific/Extension/News/NewOnlyNews'                     => 'New: Restrict page(s) to News/SysCategories/SysNote',
            'Page/Specific/Extension/News/ClearCacheNews'                  => 'ClearCacheCmd->cacheTag:tx_news',
            'Page/Specific/Extension/News/NewsLimitCategories'             => 'News->Limit Categories',
            'Page/Specific/Extension/News/NewsLimitMedia'                  => 'News->Limit Media',
            'Page/Specific/Extension/News/NewsMediaDefaultShowinpreviewOn' => 'News->Default "show in preview" per default on',
            'Page/Specific/Extension/News/PreviewRecordsNewsDetailDefault' => 'News->Preview Record (Default)',
        ];
        // register each $elements item as PageTSConfig file
        foreach ($elements as $fileName => $label) {
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
                $extKey,
                $pathSegment.$fileName.$fileExt,
                $labelPrefix.$label
            );
        }

        // Add custom page tree icons
        $customPageTreeIcons = [
            [
                'storage',  // last string of LLL
                'records',  // last part of typeicon_classes item
                'apps-pagetree-folder-contains-records', // icon-identifier
            ],
            [
                'pages',
                'pages',
                'apps-pagetree-folder-contains-pages',
            ],
            [
                'impress',
                'impress',
                'apps-pagetree-page-contains-impress',
            ],
            [
                'attention',
                'attention',
                'apps-pagetree-page-contains-attention',
            ],
            [
                'search',
                'search',
                'apps-pagetree-page-contains-search',
            ],
            [
                'news',
                'newsplugins',
                'apps-pagetree-page-contains-newsplugins',
            ],
            [
                'drafts',
                'drafts',
                'apps-pagetree-folder-contains-drafts',
            ],
        ];
        foreach ($customPageTreeIcons as $customPageTreeIcon) {
            $GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = [
                0 => 'LLL:EXT:'.$extKey.'/Resources/Private/Language/locallang_BackendGeneral.xlf:icon.pagetree.'.$customPageTreeIcon[0].'',
                1 => ''.$customPageTreeIcon[1].'',
                2 => ''.$customPageTreeIcon[2].'',
            ];
        }

        \TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule(
            $GLOBALS['TCA']['pages'],
            [
                'ctrl' => [
                    'typeicon_classes' => [
                        'contains-impress'     => 'apps-pagetree-page-contains-impress',
                        'contains-attention'   => 'apps-pagetree-page-contains-attention',
                        'contains-search'      => 'apps-pagetree-page-contains-search',
                        'contains-newsplugins' => 'apps-pagetree-page-contains-newsplugins',
                        'contains-records'     => 'apps-pagetree-folder-contains-records',
                        'contains-pages'       => 'apps-pagetree-folder-contains-pages',
                        'contains-drafts'      => 'apps-pagetree-folder-contains-drafts',
                    ],
                ],
            ]
        );
    },
    'theme'
);
