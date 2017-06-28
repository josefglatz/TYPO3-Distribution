<?php declare(strict_types=1);
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function ($extKey) {
        $languageFileCePrefix = 'LLL:EXT:theme/Resources/Private/Language/locallang_ContentElements.xlf:';

        $defaultCropArea = [
            'x' => '0.0',
            'y' => '0.0',
            'width' => '1.0',
            'height' => '1.0',
        ];

        /**
         * Add CE: stop inheritance
         */
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
            'tt_content',
            'CType',
            [
                $languageFileCePrefix . 'theme_inheritance_stop.title',
                'theme_inheritance_stop',
                'apps-pagetree-drag-place-denied'
            ],
            'menu',
            'after'
        );
        $tca = [
            'types' => [
                'theme_inheritance_stop' => [
                    'showitem' => '
                        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
                            --palette--;;hidden,
                            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
                        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                            --palette--;;language,
                        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
                            categories,
                        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
                            rowDescription,
                        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
                    ',
                    'columnsOverrides' => [

                    ],
                ],
            ],
        ];
        $GLOBALS['TCA']['tt_content'] = array_replace_recursive($GLOBALS['TCA']['tt_content'], $tca);

        // Default Content Element
        $GLOBALS['TCA']['tt_content']['columns']['CType']['config']['default'] = 'text';
    },
    'theme'
);
