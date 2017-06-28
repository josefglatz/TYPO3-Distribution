<?php

declare(strict_types=1);

/**
 * This file is part of the "theme" Extension which is part of
 * the jousch/TYPO3-Distribution for TYPO3 CMS.
 */

namespace JosefGlatz\Theme\ViewHelpers;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Frontend\Resource\FileCollector;

/**
 * Class FalViewHelper.
 *
 * = Example =
 *
 * <code title="register namespace in fluid first">
 * xmlns:theme="http://typo3.org/ns/JosefGlatz/Theme/ViewHelpers"
 * </code>
 *
 * <code title="default notation">
 * <theme:fal table="pages" field="image" id="{row.uid}" as="references">
 * <f:if condition="{references}">
 *  <f:then>
 *    <f:media file="{references.0}" class="foobar" title="{references.0.propertiesOfFileReference.title}"/>
 *  </f:then>
 *  <f:else>
 *    <img class="dummy" src="https://dummyimage.com/600x600/444/fff" alt="">
 *  </f:else>
 * </f:if>
 * </theme:fal>
 * </code>
 */
class FalViewHelper extends AbstractViewHelper
{
    /**
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * @param string $table
     * @param string $field
     * @param string $id
     * @param string $as
     *
     * @return string
     */
    public function render(string $table, string $field, string $id, string $as = 'references')
    {
        // create query builder object
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable($table);
        // query
        $row = $queryBuilder
            ->select('*')
            ->from($table)
            ->where('uid='.(int) $id)
            ->execute()
            ->fetch();
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
}
