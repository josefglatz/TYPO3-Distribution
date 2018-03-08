<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Service;

use JosefGlatz\Theme\Utility\CropVariants;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class CropVariantsBuilder
{
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

    public static function getInstance($table, $field, $type = '')
    {
        return GeneralUtility::makeInstance(self::class, $table, $field, $type);
    }

    public function addCropVariants(array $cropVariants)
    {
        // @TODO: TYPO3-Distribution: addCropVariants() functionality
        //    $this->cropVariants[] = $cropVariant;

        // Check if parameter isn't empty

        // Foreach
        //     Check

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
     */
    public function disableDefaultCropVariants()
    {
        $defaultCropVariants = CropVariants::getDefaultCropVariants();
        $cropVariants = $this->cropVariants;

        if (isset($defaultCropVariants) && \is_array($defaultCropVariants) && !empty($defaultCropVariants)) {
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
     */
    public function getAll(): array
    {
//        @TODO: TYPO3-Distribution: add the final configuration for further "local" changes (if `persistToTCA()` is to generic)

        return [];
    }

    /**
     * Persist the cropVariants configuration for specific a) table, b) column, (possibly) c) type
     * to Table Configuration Array (TCA)
     *
     * @TODO:TYPO3-Distribution: add option/feature to allow custom TCA array path for persisting. E.g. if you want to add crop config based on ChildTca type for example.
     *
     *
     * @param string $customPath
     *
     */
    public function persistToTca(string $customPath)
    {
        // @TODO: TYPO3-Distribution: add persistToTca functionality
//          a) Default, if no type is given:
//              possible if crop is based on ChildTca's type: $GLOBALS['TCA']['a_table']['columns'][$this->fieldName]['config']['overrideChildTca']['types'][\TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE]['columnsOverrides']['crop']['config']['cropVariants'] = "set all cropVariants"
//              better and easier AND most common: $GLOBALS['TCA'][$this->table]['columns'][$this->fieldName]['config']['overrideChildTca']['columns']['crop']['config']['cropVariants'] = "set all cropVariants"
//
//
//          b) If a type is given:
//
//        $GLOBALS['TCA'][$this->table]['types'][$this->type]['columnsOverrides'][$this->fieldName]['config']['overrideChildTca']['columns']['crop']['config']['cropVariants'] = "set all cropVariants"

        /*
            What should/can the final array contain?
                - cropVariants
                    - title
                    - cropArea
                    - coverAreas
                    - allowedAspectRatios
                    - selectedRatio

         */
    }
}
