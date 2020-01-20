<?php
declare(strict_types = 1);
namespace JosefGlatz\Theme\Backend\FormDataProvider;

use Symfony\Component\Yaml\Yaml;
use TYPO3\CMS\Backend\Form\FormDataProviderInterface;
use TYPO3\CMS\Core\Core\Environment;

class ColorValuePickerItemDataProvider implements FormDataProviderInterface
{
    public const EXT = 'theme';

    /**
     * Configuration Matrix
     * <tablename> => [ <columnName> ]
     */
    public const TABLES_COLUMNS = [];
    public const CONFIG_FIELD = 'colors';
    public const CONFIG_FILE = '/colors.yaml';

    public function addData(array $result): array
    {
        if (array_key_exists($result['tableName'], self::TABLES_COLUMNS)) {
            foreach (self::TABLES_COLUMNS[$result['tableName']] as $column) {
                if (isset($result['processedTca']['columns'][$column])) {
                    $themeConfigFile = Environment::getConfigPath() . '/sites/' . $result['site']->getIdentifier() . self::CONFIG_FILE;

                    if (file_exists($themeConfigFile)) {
                        $config = Yaml::parseFile($themeConfigFile);

                        if (isset($config[self::CONFIG_FIELD])) {
                            $colors = $config[self::CONFIG_FIELD];
                            foreach ($colors as $color) {
                                $result['processedTca']['columns'][$column]['config']['valuePicker']['items'][] = [
                                    $color['key'],
                                    $color['value'],
                                ];
                            }
                        }
                    }
                }
            }
        }

        return $result;
    }
}
