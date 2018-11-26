<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Utility;

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Utility class to get the settings from Extension Manager
 */
class EmConfiguration
{

    /**
     * Parses the extension settings.
     *
     * @return \JosefGlatz\Theme\Domain\Model\Dto\EmConfiguration
     * @throws \Exception If the configuration is invalid.
     */
    public static function getSettings(): \JosefGlatz\Theme\Domain\Model\Dto\EmConfiguration
    {
        $configuration = self::parseSettings();
        $settings = new \JosefGlatz\Theme\Domain\Model\Dto\EmConfiguration($configuration);
        return $settings;
    }

    /**
     * Return extension configuration as array
     *
     * @return array extension configuration as array
     * @throws \TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationExtensionNotConfiguredException
     * @throws \TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationPathDoesNotExistException
     */
    protected static function parseSettings(): array
    {
        $settings = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('theme');

        if (!\is_array($settings)) {
            $settings = [];
        }
        return $settings;
    }
}
