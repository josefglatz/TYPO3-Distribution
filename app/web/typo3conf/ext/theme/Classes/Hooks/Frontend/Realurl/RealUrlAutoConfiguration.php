<?php
namespace JosefGlatz\Theme\Hooks\Frontend\Realurl;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

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
                            'type' => 9201,
                        ]
                    ],
                ]
            ],
            'postVarSets' => [
                // @TODO: add my common ext:news default realurl config
            ],
            'preVars' => [
            ],
        ]);

        return $processedConfig;
    }
}
