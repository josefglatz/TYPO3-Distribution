<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function ($extKey) {

        $pathSegment = 'Configuration/TSConfig/';
        $fileExt = '.tsc';
        $labelPrefix = 'theme :: ';

        // register elements (path/filename without extension, label without prefix)
        $elements = [
            'Page/PageGeneral' => 'General PageTSConfig',
            'Page/Specific/NewOnlyFeUsers' => 'Restrict page(s) to FeUsers/FeGroups',
            'Page/Specific/ClearCachePages' => 'ClearCacheCmd->pages',
            'Page/Specific/ClearCacheRegistrationSpecific' => 'ClearCacheCmd->cacheTag:customregistration,pages',
            'Page/Specific/HideTableTtContent' => 'Hide table TtContent',
            'Page/Specific/Extension/News/NewOnlyNews' => 'Restrict page(s) to News/SysCategories/SysNote',
            'Page/Specific/Extension/News/ClearCacheNews' => 'ClearCacheCmd->cacheTag:tx_news',
            'Page/Specific/Extension/News/NewsLimitCategories' => 'News->Limit Categories',
            'Page/Specific/Extension/News/NewsLimitMedia' => 'News->Limit Media',
            'Page/Specific/Extension/News/NewsMediaDefaultShowinpreviewOn' => 'News->Default "show in preview" per default on',
        ];
        // register each $elements item as PageTSConfig file
        foreach ($elements as $fileName => $label) {
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
                $extKey,
                $pathSegment . $fileName . $fileExt,
                $labelPrefix . $label
            );
        }

        $tca = [
            'tx_theme_title_prefix' => [
                'label' => 'Title Tag Prefix',
                'config' => [
                    'type' => 'input',
                    'eval' => 'trim',
                    'rows' => 3,
                    'max' => 255,
                ]
            ],
            'tx_theme_title_suffix' => [
                'label' => 'Title Tag Suffix',
                'config' => [
                    'type' => 'input',
                    'eval' => 'trim',
                    'rows' => 3,
                    'max' => 255,
                ]
            ],
            'tx_theme_title_override' => [
                'label' => 'Complete Title Tag Override',
                'config' => [
                    'type' => 'input',
                    'eval' => 'trim',
                    'rows' => 3,
                    'max' => 255,
                ]
            ],
        ];

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', $tca);
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
            'pages',
            '--div--;Title Tag,tx_theme_title_prefix,tx_theme_title_suffix,tx_theme_title_override',
            '',
            'after:tx_realurl_pathoverride'
        );

    },
    'theme'
);
