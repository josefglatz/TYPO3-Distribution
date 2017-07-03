<?php

defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function ($extKey) {
        // Add fields to rootLineFields
        $GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields'] .= '';

        // Hook for adding realurl custom configuration
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/realurl/class.tx_realurl_autoconfgen.php']['extensionConfiguration'][] =
            'JosefGlatz\\Theme\\Hooks\\Frontend\\Realurl\\RealUrlAutoConfiguration->addThemeConfig';

        // Disable ext:news realurl hook
//        unset($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/realurl/class.tx_realurl_autoconfgen.php']['extensionConfiguration']['news']);

        // Add general UserTSConfig
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig(
            '<INCLUDE_TYPOSCRIPT: source="FILE: EXT:' . $extKey . '/Configuration/TSConfig/UserGeneral.tsc">'
        );

        // Add EXT:solr CommandController support for older versions
        if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('solr') && !class_exists(\ApacheSolrForTypo3\Solr\Command\SolrCommandController::class)) {
            $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = \JosefGlatz\Theme\Command\SolrCommandController::class;
        }

        $GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['robotstxt'] = \JosefGlatz\Theme\Controller\RobotsTxtController::class . '::processRequest';

        // Custom translations https://docs.typo3.org/typo3cms/CoreApiReference/Internationalization/Translation/Index.html?highlight=locallangxmloverride#custom-translations
//        $GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['EXT:cms/locallang_tca.xlf'][] = 'EXT:' . $extKey . '/Resources/Private/Language/custom.xlf';
//        $GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['de']['EXT:news/Resources/Private/Language/locallang_modadministration.xlf'][] = 'EXT:' . $extKey . '/Resources/Private/Language/Overrides/de.locallang_modadministration.xlf';

        // Hook for changing output before showing it
//        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-output'][]
//            = \JosefGlatz\Theme\Hooks\Frontend\ContentPostProc::class . '->run';

        // Register own RTE (ckeditor) presets
        $rtePresets = [                             // Final preset identifier:
            'default' => 'Default',                 //  'theme_default'
            'defaultNoTables' => 'DefaultNoTables', //  'theme_defaultNoTables'
            'minimal' => 'Minimal',                 //  'theme_minimal'
        ];
        foreach ($rtePresets as $identifier => $fileName) {
            $GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['' . $extKey . '_' . $identifier . '']
                = 'EXT:' . $extKey . '/Configuration/RTE/' . $fileName . '.yaml';
        }

        // Only backend relevant stuff
        if (TYPO3_MODE === 'BE') {

            // Add custom cache action item: delete realurl configuration file
            $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['additionalBackendItems']['cacheActions'][$extKey] = \JosefGlatz\Theme\Hooks\Backend\Toolbar\ClearRealurlAutoConfMenuItem::class;

            // Hook for enriching content element preview footer in BE with additional data
            $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawFooter'][] =
                \JosefGlatz\Theme\Hooks\Backend\PageLayoutViewEnrichmentFooter::class;

            // Register FormDataProviders
            $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['formDataGroup']['tcaDatabaseRecord'][\JosefGlatz\Theme\Backend\FormDataProvider\Div::class] = [
                'depends' => [
                    \TYPO3\CMS\Backend\Form\FormDataProvider\PageTsConfigMerged::class
                ]
            ];
        }
    },
    $_EXTKEY
);
