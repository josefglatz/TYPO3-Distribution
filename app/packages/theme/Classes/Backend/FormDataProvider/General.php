<?php
declare(strict_types = 1);
namespace JosefGlatz\Theme\Backend\FormDataProvider;

use TYPO3\CMS\Backend\Form\FormDataProviderInterface;

/**
 * Class General FormDataProvider for multiple tables and types
 */
class General implements FormDataProviderInterface
{
    /**
     * Configuration Matrix for table.type
     *  <tablename> => [ <typeValue> ]
     *
     *  <typeValue> => [
     *      // Hide specific columns for this type
     *      columnsToHide => [
     *          '<columnName>',
     *      ],
     *      // Set specific columns to readOnly for this type
     *      'readOnly' => [
     *          '<columnName>',
     *      ],
     *      // Remove all existing items from specific columns for this type
     *      'adoptItems' => [
     *          '<columnName>' => [
     *              'removeExistingItems' => true,
     *          ],
     *      ],
     *      // Remove items from specific columns for this type
     *      'adoptItems' => [
     *          '<columnName>' => [
     *              'removeItems' => [
     *                  '<value>',
     *              ],
     *          ],
     *      ],
     *      // Add items to specific columns for this type
     *      'adoptItems' => [
     *          '<columnName>' => [
     *              'addItems' => [
     *                  [ 'Label', '<value>' ],
     *              ],
     *          ],
     *      ],
     *      // Configure colorPicker keepLabels
     *      'adoptItems' => [
     *          '<columnName>' => [
     *              'colorPicker' => [
     *                  'keepLabels' => [
     *                      '<label>',
     *                  ],
     *              ],
     *          ],
     *      ],
     *  ]
     */
    public const MATRIX = [
        'tt_content' => [],
    ];

    /**
     * @var array Type config if provider is executable
     */
    protected $config = [];

    /**
     * Main method
     *
     * @param array $result
     * @return array
     */
    public function addData(array $result): array
    {
        if ($this->providerExecutable($result)) {
            // Columns to hide for this databaseRow
            if (!empty($this->config['columnsToHide'])) {
                foreach ($this->config['columnsToHide'] as $column) {
                    unset($result['processedTca']['columns'][$column]);
                }
            }
            // Set columns to readOnly
            if (!empty($this->config['readOnly'])) {
                foreach ($this->config['readOnly'] as $column) {
                    $result['processedTca']['columns'][$column]['config']['readOnly'] = true;
                }
            }
            // Adopt items of columns
            if (!empty($this->config['adoptItems'])) {
                foreach ($this->config['adoptItems'] as $column => $columnConfig) {
                    if (isset($columnConfig['removeExistingItems']) && $columnConfig['removeExistingItems']) {
                        unset($result['processedTca']['columns'][$column]['config']['items']);
                    }

                    if (!empty($columnConfig['addItems'])) {
                        foreach ($columnConfig['addItems'] as $item) {
                            $result['processedTca']['columns'][$column]['config']['items'][] = [
                                $item[0],
                                $item[1],
                            ];
                        }
                    }

                    if (!empty($columnConfig['removeItems'])) {
                        foreach ($columnConfig['removeItems'] as $item => $itemValue) {
                            foreach ($result['processedTca']['columns'][$column]['config']['items'] as $index => $value) {
                                if ((string)$value[1] === (string)$itemValue) {
                                    unset($result['processedTca']['columns'][$column]['config']['items'][$index]);
                                }
                            }
                        }
                    }

                    if (isset($columnConfig['colorPicker'])) {
                        if (isset($columnConfig['colorPicker']['keepLabels'])) {
                            $resultSet = [];
                            foreach ($columnConfig['colorPicker']['keepLabels'] as $keepLabelIndex => $keepLabel) {
                                foreach ($result['processedTca']['columns'][$column]['config']['valuePicker']['items'] as $index => $existingItem) {
                                    if ($existingItem[0] === $keepLabel) {
                                        $resultSet[] = $existingItem;
                                    }
                                }
                            }
                            $result['processedTca']['columns'][$column]['config']['valuePicker']['items'] = $resultSet;
                        }
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Check if this this data provider should modify TCA for this record type
     *
     * @param array $result
     *
     * @return bool
     */
    private function providerExecutable(array $result): bool
    {
        if (!$this->tableSupported($result['tableName'])) {
            return false;
        }
        $table = $result['tableName'];
        $type = $GLOBALS['TCA'][$table]['ctrl']['type'];
        $typeValue = $result['databaseRow'][$type][0];

        if ($typeValue === null) {
            return false;
        }

        $config = $this->getMatrixForTableType($table, $typeValue);

        if ($config !== null) {
            $this->config = $config;

            return true;
        }

        return false;
    }

    /**
     * Retrieve config from configuration matrix
     *
     * @param string $table
     * @param string $type
     * @return array|null
     */
    private function getMatrixForTableType(string $table, string $type): ?array
    {
        return self::MATRIX[trim($table)][trim($type)];
    }

    private function tableSupported($tableName)
    {
        return array_key_exists($tableName, self::MATRIX);
    }
}
