<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Service;

use TYPO3\CMS\Core\Utility\GeneralUtility;

class CropVariantsBuilder
{
    protected $cropVariant = [];

    protected $table = '';

    protected $fieldName = '';

    protected $type = '';

    public function __construct(string $tableName, string $fieldName, string $type = '')
    {
        $this->table = $tableName;
        $this->fieldName = $fieldName;
        $this->type = $type;
    }

    public static function getInstance($table, $field, $type)
    {
        return GeneralUtility::makeInstance(self::class, $table, $field, $type);
    }

    public function addCropVariants($cropVariant)
    {
        $this->cropVariant[] = $cropVariant;
        return $this;
    }

    public function removeDefaultCropVariants()
    {
        return $this;
    }

    public function getAll()
    {
//        TODO: add the final configuration for further "local" changes (if `persistToTCA()` is to generic)
    }

    public function persistToTca(string $customPath)
    {
        // TODO:
//          a) Default, if no type is given:
//              possible if crop is based on ChildTca's type: $GLOBALS['TCA']['a_table']['columns'][$this->fieldName]['config']['overrideChildTca']['types'][\TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE]['columnsOverrides']['crop']['config']['cropVariants'] = "set all cropVariants"
//              better and easier AND most common: $GLOBALS['TCA'][$this->table]['columns'][$this->fieldName]['config']['overrideChildTca']['columns']['crop']['config']['cropVariants'] = "set all cropVariants"
//
//
//          b) If a type is given:
//
//        $GLOBALS['TCA'][$this->table]['types'][$this->type]['columnsOverrides'][$this->fieldName]['config']['overrideChildTca']['columns']['crop']['config']['cropVariants'] = "set all cropVariants"
    }
}
