<?php
namespace Sup7even\Theme\ViewHelpers;

use TYPO3\CMS\Core\Database\DatabaseConnection;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Frontend\Resource\FileCollector;

/**
 * Class FalViewHelper
 */
class FalViewHelper extends AbstractViewHelper
{

    /**
     * @var boolean
     */
    protected $escapeOutput = FALSE;

    /**
     * @param string $table
     * @param string $field
     * @param string $id
     * @param string $as
     * @return string
     */
    public function render(string $table, string $field, string $id, string $as = 'references')
    {
        // @TODO: Doctrine dbal rewrite
        $row = $this->getDatabaseConnection()->exec_SELECTgetSingleRow('*', $table, 'uid=' . (int)$id);
        if (!$row) {
            return '';
        }

        $fileCollector = GeneralUtility::makeInstance(FileCollector::class);
        $fileCollector->addFilesFromRelation($table, $field, $row);

        $this->templateVariableContainer->add($as, $fileCollector->getFiles());
        $output = $this->renderChildren();
        $this->templateVariableContainer->remove($as);

        return $output;
    }

    /**
     * @return DatabaseConnection
     */
    protected function getDatabaseConnection()
    {
        // @TODO: Doctrine dbal rewrite
        return $GLOBALS['TYPO3_DB'];
    }


}
