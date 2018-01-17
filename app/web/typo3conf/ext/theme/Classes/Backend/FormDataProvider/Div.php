<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Backend\FormDataProvider;

use TYPO3\CMS\Backend\Form\FormDataProviderInterface;

/**
 * Class Div
 */
class Div implements FormDataProviderInterface
{
    const TYPE = 'div';
    const TABLE_NAME = 'tt_content';

    /**
     * @param array $result
     *
     * @return array
     */
    public function addData(array $result): array
    {
        if ($this->providerExecutable($result)) {
            // Columns to hide for this content element
            $columnsToHide = [
                'sectionIndex',
                'linkToTop',
            ];
            foreach ($columnsToHide as $column) {
                unset($result['processedTca']['columns']['' . $column . '']);
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
        if ($result['databaseRow']['CType'][0] === self::TYPE
            && $result['tableName'] === self::TABLE_NAME
        ) {
            return true;
        }

        return false;
    }
}
