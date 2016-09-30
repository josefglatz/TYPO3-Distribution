<?php
namespace Sup7even\Theme\Hooks\Frontend\Realurl;

use Tx\Realurl\Configuration\ConfigurationGenerator;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * Class RealUrlAutoConfiguration
 */
class RealUrlAutoConfiguration
{
    /**
     * Generates additional RealURL configuration and replace it with provided configuration recursively
     * - Add basic/often used/common RealUrl configuration
     * - Disable RealUrl Cache
     * - Set language preVars (since no ext:static_info_tables is installed)
     *
     * @param array $params Default configuration
     * @param ConfigurationGenerator $pObj Parent object
     * @return array Updated configuration
     */
    public function addThmConfig($params, ConfigurationGenerator &$pObj)
    {

        $processedConfig = array_replace_recursive($params['config'], [
            'init' => [
                'enableCHashCache' => false,
                'enableUrlDecodeCache' => false,
                'enableUrlEncodeCache' => false
            ],
            'pagePath' => [
                'disablePathCache' => true,
            ],
            'postVarSets' => [
                // @TODO: add my common ext:news default realurl config
            ],
            'preVars' => [
            ],
        ]);

        if (!ExtensionManagementUtility::isLoaded('static_info_tables')) {
            $processedConfig = array_replace_recursive($params['config'], [
                'preVars' => [
                    [
                        'GETvar' => 'L',
                        'valueMap' => [
                            'en' => 1,
                        ],
                        'noMatch' => 'bypass',
                    ],
                ],
            ]);
            unset($processedConfig['preVars'][0]['valueMap'][1]);
        }

        return $processedConfig;
    }
}
