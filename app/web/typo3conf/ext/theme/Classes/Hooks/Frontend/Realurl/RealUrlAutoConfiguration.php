<?php declare(strict_types=1);

namespace JosefGlatz\Theme\Hooks\Frontend\Realurl;

/**
 * RealUrlAutoConfiguration for RealURL extension v2.x
 */
class RealUrlAutoConfiguration
{
    /**
     * Generates additional RealURL configuration and replace it with provided configuration recursively
     * - Add basic/often used/common RealUrl configuration
     * - Configuration reference: https://github.com/dmitryd/typo3-realurl/wiki/Configuration-reference
     *
     * @param array $params Default configuration
     * @return array Updated configuration
     */
    public function addThemeConfig($params)
    {
        $pageTypes = [
            'robots' => 9201,
            'rssFeed' => 9818,
        ];
        $pids = [
            'newsDetailPage' => 123,
            'loginPage' => 123,
        ];

        $processedConfig = array_replace_recursive($params['config'], [
            'init' => [
            ],
            'pagePath' => [
            ],
            'fileName' => [
                'defaultToHTMLsuffixOnPrev' => 0,
                'acceptHTMLsuffix' => 0,
                'index' => [
                    'robots.txt' => [
                        'keyValues' => [
                            'type' => $pageTypes['robots'],
                        ]
                    ],
                    'feed.rss' => [
                        'keyValues' => [
                            'type' => $pageTypes['rssFeed'],
                        ]
                    ],
                ]
            ],
            'postVarSets' => [
                // @TODO: add my common ext:news default realurl config
            ],
            'preVars' => [
                // L parameter preVars are automatically set in
                // \DmitryDulepov\Realurl\Configuration\AutomaticConfigurator::addLanguages
                // even if there is no EXT:static_info_tables installed.
            ],
        ]);

        $processedConfig = array_merge_recursive($processedConfig, [
            'preVars' => [
                [
                    'GETvar' => 'no_cache',
                    'valueMap' => [
                        'no_cache' => 1,
                    ],
                    'noMatch' => 'bypass',
                ],
            ],
        ]);

        return $processedConfig;
    }
}
