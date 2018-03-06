<?php
/**
 * Use this file for adding your manual realurl configuration.
 *
 * Really need that? Take a look at the autoConfiguration hook, which realurl offers! (ext:theme/Classes/Hooks/Frontend/Realurl/RealUrlAutoConfiguration.php)
 * `$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/realurl/class.tx_realurl_autoconfgen.php']['extensionConfiguration']`
 */

/**
 * Default RealUrl configuration
 */
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl']['_DEFAULT'] = [
    'init' => [
        'appendMissingSlash' => 'ifNotFile,redirect',
        'emptyUrlReturnValue' => '/',
    ],
    'pagePath' => [
        'rootpage_id' => 1,
    ],
    'fixedPostVars' => [
        'newsDetailConfiguration' => [
            [
                'GETvar' => 'tx_news_pi1[action]',
                'noMatch' => 'bypass'
            ],
            [
                'GETvar' => 'tx_news_pi1[controller]',
                'noMatch' => 'bypass'
            ],
            [
                'GETvar' => 'tx_news_pi1[news]',
                'lookUpTable' => [
                    'table' => 'tx_news_domain_model_news',
                    'id_field' => 'uid',
                    'alias_field' => 'title',
                    'addWhereClause' => ' AND NOT deleted',
                    'useUniqueCache' => 1,
                    'useUniqueCache_conf' => [
                        'strtolower' => 1,
                        'spaceCharacter' => '-'
                    ],
                    'autoUpdate' => 1,
                    'expireDays' => 180,
                ]
            ]
        ],
        'newsTagConfiguration' => [
            [
                'GETvar' => 'tx_news_pi1[overwriteDemand][tags]',
                'lookUpTable' => [
                    'table' => 'tx_news_domain_model_tag',
                    'id_field' => 'uid',
                    'alias_field' => 'title',
                    'addWhereClause' => ' AND NOT deleted',
                    'useUniqueCache' => 1,
                    'useUniqueCache_conf' => [
                        'strtolower' => 1,
                        'spaceCharacter' => '-'
                    ],
                    'autoUpdate' => 1,
                    'expireDays' => 180,
                ]
            ],
            [
                'GETvar' => 'cHash',
                'noMatch' => 'bypass'
            ],
        ],
    ],
    'fileName' => [
        'defaultToHTMLsuffixOnPrev' => 0,
        'acceptHTMLsuffix' => 0,
        'index' => [
//                'print' => [
//                    'keyValues' => [
//                        'type' => 98,
//                    ],
//                ],
//        BE AWARE of activate 'robots.txt'
//          => we have a custom eID for this which is called via .htaccess configration
//                'robots.txt' => [
//                    'keyValues' => [
//                        'type' => 9201,
//                    ],
//                ],
//            'feed.rss' => [
//                'keyValues' => [
//                    'type' => 9818,
//                ],
//            ],
        ],
    ],
    'postVarSets' => [
        '_DEFAULT' => [
            'news' => [
                0 => [
                    'GETvar' => 'tx_news_pi1[news]',
                    'lookUpTable' => [
                        'table' => 'tx_news_domain_model_news',
                        'id_field' => 'uid',
                        'alias_field' => 'title',
                        'useUniqueCache' => 1,
                        'useUniqueCache_conf' => [
                            'strtolower' => 1,
                            'spaceCharacter' => '-',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'preVars' => [
//        no_cache parameter must be also activated in TypoScript!
//        But consider if you want to activate it!!!!!!
//        0 => [
//            'GETvar' => 'no_cache',
//            'valueMap' => [
//                'no_cache' => 1,
//            ],
//            'noMatch' => 'bypass',
//        ],
    ],
];

/**
 * Site configurations
 */
$siteConfiguration = [
    'projectDomainProductionLive.at' => [
        'rootUid' => 1,
        'fixedPostVars' => [
            19 => 'newsDetailConfiguration'
        ],
        'aliasDomains' => [
            'www.projectDomainProductionLive.at',
            'projectDomainProductionStaging.at',
            'www.projectDomainProductionStaging.at',
            'projectDomainProductionDev.at',
            'www.projectDomainProductionDev.at',
            'projectDomainDevelopment.docker',
            'projectDomainDevelopment.vm'
        ],
    ],
//    'projectPageTree2DomainProductionLive.at' => [
//        'rootUid' => 1234567,
//        'fixedPostVars' => [
//
//        ],
//        'aliasDomains' => [
//            'www.projectPageTree2DomainProductionLive.at',
//            'projectPageTree2DomainProductionStaging.at',
//            'www.projectPageTree2DomainProductionStaging.at',
//            'projectPageTree2DomainProductionDev.at',
//            'www.projectPageTree2DomainProductionDev.at',
//            'projectPageTree2DomainDevelopment.docker',
//            'projectPageTree2DomainDevelopment.vm'
//        ],
//    ],
//    'projectPageTree3DomainProductionLive.at' => [
//        'rootUid' => 2345678,
//        'fixedPostVars' => [
//
//        ],
//        'aliasDomains' => [
//            'www.projectPageTree3DomainProductionLive.at',
//            'projectPageTree3DomainProductionStaging.at',
//            'www.projectPageTree3DomainProductionStaging.at',
//            'projectPageTree3DomainProductionDev.at',
//            'www.projectPageTree3DomainProductionDev.at',
//            'projectPageTree3DomainDevelopment.docker',
//            'projectPageTree3DomainDevelopment.vm'
//        ],
//    ],
];

// Build the resulting RealUrl configuration
foreach ($siteConfiguration as $mainDomain => $site) {
    // inherit from default configuration
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl'][$mainDomain] = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl']['_DEFAULT'];
    // set site root uid
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl'][$mainDomain]['pagePath']['rootpage_id'] = $site['rootUid'];
    // apply all fixedPostVars presets for this pagetree
    foreach ($site['fixedPostVars'] as $id => $label) {
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl'][$mainDomain]['fixedPostVars'][$id] = $label;
    }
    // copy all configurations to all domain variants as last step
    foreach ($site['aliasDomains'] as $aliasDomain) {
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl'][$aliasDomain] = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl'][$mainDomain];
    }
}
