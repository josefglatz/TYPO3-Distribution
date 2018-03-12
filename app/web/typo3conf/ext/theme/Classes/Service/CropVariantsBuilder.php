<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Service;

use JosefGlatz\Theme\Utility\CropVariants\CropVariantDefaults;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class CropVariantsBuilder
{
    /**
     * Default used imageManipulationField name
     */
    public const DEFAULT_IMAGE_MANIPULATION_FIELD = 'crop';

    /**
     * Table with system wide default cropVariants basic settings
     */
    public const DEFAULT_CROP_VARIANTS_TABLE = 'sys_file_reference';

    /**
     * TCA table name
     *
     * @var string
     */
    protected $table = '';

    /**
     * TCA column name
     *
     * @var string
     */
    protected $fieldName = '';

    /**
     * TCA type name
     *
     * @var string
     */
    protected $type = '';

    /**
     * All eligible cropVariants
     *
     * @var array
     */
    protected $cropVariants = [];

    public function __construct(string $tableName, string $fieldName, string $type = '')
    {
        $this->table = $tableName;
        $this->fieldName = $fieldName;
        $this->type = $type;
    }

    /**
     * @param string $table
     * @param string $field
     * @param string $type
     * @return self
     * @throws \InvalidArgumentException
     */
    public static function getInstance(string $table, string $field, string $type = ''): self
    {
        return GeneralUtility::makeInstance(self::class, $table, $field, $type);
    }

    /** Add cropVariant
     *
     * @TODO: TYPO3-Distribution: check if cropVariant have at least minimum config keys
     * @TODO: TYPO3-Distribution: check if cropVariant is already set – if yes – throw exception
     *
     * @param array $cropVariant
     * @return CropVariantsBuilder
     */
    public function addCropVariant(array $cropVariant): self
    {
        foreach ($cropVariant as $key => $item) {
            $this->cropVariants[$key] = $item;
        }

        return $this;
    }

    /**
     * Disable all default cropVariants
     *
     * This is mostly needed to disable any – as default set – cropVariant.
     *
     * For example: if you want to allow only specific cropVariants for a particular field configuration.
     *
     * @return $this
     * @throws \UnexpectedValueException
     */
    public function disableDefaultCropVariants()
    {
        $defaultCropVariants = CropVariantDefaults::getDefaultCropVariants();
        $cropVariants = $this->cropVariants;

        if ((null !== $defaultCropVariants) && \is_array($defaultCropVariants) && !empty($defaultCropVariants)) {
            foreach ($defaultCropVariants as $defaultCropVariant) {
                // remove possible existing cropVariant configuration
                unset($cropVariants[$defaultCropVariant]);
                // configure cropVariant as disabled
                $cropVariants[$defaultCropVariant]['disabled'] = true;
            }
        } else {
            throw new \UnexpectedValueException('Removing default cropVariants not possible. Default cropVariants can\'t be processed.', 1520488435);
        }

        $this->cropVariants = $cropVariants;

        return $this;
    }

    /**
     * Return the final configuration for further processing
     *
     * This is mostly needed if you don't want to use persistToTca() method to allow modifications to the array, which
     * is not covered by the CropVariantsBuilder class.
     *
     * @return array
     * @throws \UnexpectedValueException
     */
    public function get(): array
    {
        if (empty($this->cropVariants)) {
            throw new \UnexpectedValueException('Final cropVariants configuration could not be queried. The property cropVariants contains an empty array.', 1520861189);
        }
        return $this->cropVariants;
    }

    /**
     * Persist the cropVariants configuration for specific a) table, b) column, (possibly) c) type
     * to Table Configuration Array (TCA)
     *
     * @param int $customChildType
     * @param bool $force
     * @param string $imageManipulationField
     * @return self
     * @throws \Exception
     */
    public function persistToTca(int $customChildType = null, bool $force = false, string $imageManipulationField = self::DEFAULT_IMAGE_MANIPULATION_FIELD): self
    {
        $config = [
            $imageManipulationField => [
                'config' => [
                    'cropVariants' => $this->cropVariants
                ]
            ]
        ];

        if ($this->table = 'sys_file_reference') {
            throw new \RuntimeException('Persisting cropVariants configuration not possible for table sys_file_reference! Please use method persistToTcaForDefaultTable().', 1520885631);
        }

        // Unset existing existing cropVariants configuration
        if ($force) {
            if ($customChildType === null) {
                if (empty($this->type)) {
                    unset($GLOBALS['TCA'][$this->table]['columns'][$this->fieldName]['config']['overrideChildTca']['columns'][$imageManipulationField]['config']['cropVariants']);
                    $GLOBALS['TCA'][$this->table]['columns'][$this->fieldName]['config']['overrideChildTca']['columns'][array_shift(array_keys($config))] = $config;
                } else {
                    unset($GLOBALS['TCA'][$this->table]['types'][$this->type]['columnsOverrides'][$this->fieldName]['config']['overrideChildTca']['types'][$customChildType]['columnsOverrides'][$imageManipulationField]['config']['cropVariants']);
                    $GLOBALS['TCA'][$this->table]['types'][$this->type]['columnsOverrides'][$this->fieldName]['config']['overrideChildTca']['types'][$customChildType]['columnsOverrides'][array_shift(array_keys($config))] = $config;
                }
            } else {
                if (empty($this->type)) {
                    unset($GLOBALS['TCA'][$this->table]['columns'][$this->fieldName]['config']['overrideChildTca']['types'][$customChildType]['columnsOverrides'][$imageManipulationField]['config']['cropVariants']);
                    $GLOBALS['TCA'][$this->table]['columns'][$this->fieldName]['config']['overrideChildTca']['types'][$customChildType]['columnsOverrides'][array_shift(array_keys($config))] = $config;
                } else {
                    unset($GLOBALS['TCA'][$this->table]['types'][$this->type]['columnsOverrides'][$this->fieldName]['config']['overrideChildTca']['types'][$customChildType]['columnsOverrides'][$imageManipulationField]['config']['cropVariants']);
                    $GLOBALS['TCA'][$this->table]['types'][$this->type]['columnsOverrides'][$this->fieldName]['config']['overrideChildTca']['types'][$customChildType]['columnsOverrides'][array_shift(array_keys($config))] = $config;
                }
            }

            return $this;
        }


        if ($customChildType === null) {
            if (empty($this->type)) {
                // no type set, no customChildType
                if (!empty($GLOBALS['TCA'][$this->table]['columns'][$this->fieldName]['config']['overrideChildTca']['columns'][$imageManipulationField]['config']['cropVariants'])) {
                    throw new \UnexpectedValueException('cropVariants configuration can not be persisted.
                    cropVariants configuration already exists for ' . $this->table . '.' . $this->fieldName . (!empty($this->type) ? ' (type ' . $this->type . ')' : '') . '.', 1520884066);
                }
                $GLOBALS['TCA'][$this->table]['columns'][$this->fieldName]['config']['overrideChildTca']['columns'][array_shift(array_keys($config))] = $config;
            } else {
                // type set, no customChildType
                if (!empty($GLOBALS['TCA'][$this->table]['types'][$this->type]['columnsOverrides'][$this->fieldName]['config']['overrideChildTca']['columns'][$imageManipulationField]['config']['cropVariants'])) {
                    throw new \UnexpectedValueException('cropVariants configuration can not be persisted.
                    cropVariants configuration already exists for' . $this->table . '.' . $this->fieldName . (!empty($this->type) ? ' (type ' . $this->type . ')' : '') . '.', 1520884830);
                }
                $GLOBALS['TCA'][$this->table]['types'][$this->type]['columnsOverrides'][$this->fieldName]['config']['overrideChildTca']['columns'][array_shift(array_keys($config))] = $config;
            }
        } else {
            if (empty($this->type)) {
                // type set, customChildType set
                if (!empty($GLOBALS['TCA'][$this->table]['columns'][$this->fieldName]['config']['overrideChildTca']['types'][$customChildType]['columnsOverrides'][$imageManipulationField]['config']['cropVariants'])) {
                    throw new \UnexpectedValueException('cropVariants configuration can not be persisted.
                    cropVariants configuration already exists for ' . $this->table . '.' . $this->fieldName . (!empty($this->type) ? ' (type ' . $this->type . ')' : '') . ' (customChildType ' . trim($customChildType) . '.', 1520885194);
                }
                $GLOBALS['TCA'][$this->table]['columns'][$this->fieldName]['config']['overrideChildTca']['types'][$customChildType]['columnsOverrides'][array_shift(array_keys($config))] = $config;
            } else {
                // no type set, customChildType set
                if (!empty($GLOBALS['TCA'][$this->table]['types'][$this->type]['columnsOverrides'][$this->fieldName]['config']['overrideChildTca']['types'][$customChildType]['columnsOverrides'][$imageManipulationField]['config']['cropVariants'])) {
                    throw new \UnexpectedValueException('cropVariants configuration can not be persisted.
                    cropVariants configuration already exists for ' . $this->table . '.' . $this->fieldName . (!empty($this->type) ? ' (type ' . $this->type . ')' : '') . ' (customChildType ' . trim($customChildType) . '.', 1520885283);
                }
                $GLOBALS['TCA'][$this->table]['types'][$this->type]['columnsOverrides'][$this->fieldName]['config']['overrideChildTca']['types'][$customChildType]['columnsOverrides'][array_shift(array_keys($config))] = $config;
            }
        }

        return $this;
    }
}
