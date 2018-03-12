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
            throw new \UnexpectedValueException('Final cropVariants configuration couldn\'t be queried. The property cropVariants contains an empty array.', 1520861189);
        }
        return $this->cropVariants;
    }

    /**
     * Persist the cropVariants configuration for specific a) table, b) column, (possibly) c) type
     * to Table Configuration Array (TCA)
     *
     * @TODO: TYPO3-Distribution: check if any cropVariants configuration is already applied to TCA – otherwise throw an exception
     * @TODO: TYPO3-Distribution: force-feature: unset already configured cropVariants configuration
     *
     * @param int $customChildType
     * @param bool $force
     * @param string $imageManipulationField
     * @return self
     * @throws \Exception
     */
    public function persistToTca(int $customChildType = null, bool $force = false, string $imageManipulationField = self::DEFAULT_IMAGE_MANIPULATION_FIELD): self
    {
        if ($force) {
            throw new \RuntimeException('Implementation of persistToTca() with FORCE support must be implemented', 1520861570);
        } else {
            if (empty($this->type)) {
                if ($customChildType === null) {
                    $GLOBALS['TCA'][$this->table]['columns'][$this->fieldName]['config']['overrideChildTca']['columns'][$imageManipulationField]['config']['cropVariants'] = $this->cropVariants;
                } else {
                    $GLOBALS['TCA'][$this->table]['columns'][$this->fieldName]['config']['overrideChildTca']['types'][$customChildType]['columnsOverrides'][$imageManipulationField]['config']['cropVariants'] = $this->cropVariants;
                }
            } else {
                if ($customChildType === null) {
                    $GLOBALS['TCA'][$this->table]['types'][$this->type]['columnsOverrides'][$this->fieldName]['config']['overrideChildTca']['columns'][$imageManipulationField]['config']['cropVariants'] = $this->cropVariants;
                } else {
                    $GLOBALS['TCA'][$this->table]['types'][$this->type]['columnsOverrides'][$this->fieldName]['config']['overrideChildTca']['types'][$customChildType]['columnsOverrides'][$imageManipulationField]['config']['cropVariants'] = $this->cropVariants;
                }
            }
        }

        return $this;
    }
}
