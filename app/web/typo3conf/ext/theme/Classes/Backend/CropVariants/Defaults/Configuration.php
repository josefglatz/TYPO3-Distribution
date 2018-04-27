<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Backend\CropVariants\Defaults;

use TYPO3\CMS\Core\Configuration\Loader\YamlFileLoader;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class Configuration
{
    /**
     * Relative path to configuration file
     */
    protected const CONFIGFILE = 'EXT:theme/Configuration/ImageManipulation/CropVariants.yaml';

    /**
     * Returns the plain configuration array from the YAML configuration file
     *
     * @param string $key specific configuration key
     * @return array
     * @throws \UnexpectedValueException
     */
    public static function defaultConfiguration(string $key = ''): array
    {
        $fileLoader = GeneralUtility::makeInstance(YamlFileLoader::class);
        $configuration = $fileLoader->load(self::CONFIGFILE);
        $defaults = $configuration['imageManipulation']['cropVariants']['defaults'];
        // Check if configuration array path exists
        if (!\is_array($defaults)) {
            throw new \UnexpectedValueException(
                'The imageManipulation configuration can\'t be retrieved from the configuration file. (Please take a look at ' . self::CONFIGFILE . ')',
                1524832974);
        }

        // Return the whole default configuration if key argument is empty
        if (empty($key)) {
            return $defaults;
        }

        // Check if requested key is set in the configuration
        if (!isset($defaults[trim($key)])) {
            throw new \UnexpectedValueException(
                'Requested key was not found. Is something missing in your configuration file? (Please take a look at ' . self::CONFIGFILE . ')',
                1524835641);
        }

        // Check if requested key is set in the configuration
        if (empty($defaults[trim($key)])) {
            throw new \UnexpectedValueException(
                'Requested key doesn\'t contain any children.  (Please take a look at ' . self::CONFIGFILE . ')',
                1524835441);
        }

        return $defaults[trim($key)];
    }
}
