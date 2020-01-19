<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function ($table) {
        $GLOBALS['SiteConfiguration'][$table]['columns']['trackingCode'] = [
            'label' => 'LLL:EXT:theme/Resources/Private/Language/locallang_BackendGeneral.xlf:site.trackingCode',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
                'placeholder' => 'GTM-123456',
            ],
        ];

        $GLOBALS['SiteConfiguration'][$table]['types']['0']['showitem'] .= ',--div--;LLL:EXT:theme/Resources/Private/Language/locallang_BackendGeneral.xlf:site.tab.extra,trackingCode';
    },
    'site'
);
