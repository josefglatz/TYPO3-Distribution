<?php declare(strict_types=1);

namespace JosefGlatz\Theme\Utility;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * Utility class to get the settings from Extension Manager
 *
 */
class EmConfiguration
{

    /**
     * Parses the extension settings.
     *
     * @return \JosefGlatz\Theme\Domain\Model\Dto\EmConfiguration
     * @throws \Exception If the configuration is invalid.
     */
    public static function getSettings()
    {
        $configuration = self::parseSettings();
        require_once(ExtensionManagementUtility::extPath('theme') . 'Classes/Domain/Model/Dto/EmConfiguration.php');
        $settings = new \JosefGlatz\Theme\Domain\Model\Dto\EmConfiguration($configuration);

        return $settings;
    }

    /**
     * Parse settings and return it as array
     *
     * @return array unserialized extConf settings
     */
    public static function parseSettings(): array
    {
        $settings = unserialize(
            $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['theme'],
            []
        );

        if (!is_array($settings)) {
            $settings = [];
        }

        return $settings;
    }
}
