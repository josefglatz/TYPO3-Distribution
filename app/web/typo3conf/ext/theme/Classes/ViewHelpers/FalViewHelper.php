<?php
declare(strict_types = 1);

namespace JosefGlatz\Theme\ViewHelpers;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Resource\FileCollector;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * Class FalViewHelper
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
    use CompileWithRenderStatic;

    /**
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * Initialize arguments
     */
    public function initializeArguments(): void
    {
        $this->registerArgument(
            'table',
            'string',
            'Table (Foreign table)',
            true
        );
        $this->registerArgument(
            'field',
            'string',
            'Field (Foreign field)',
            true
        );
        $this->registerArgument(
            'id',
            'int',
            'ID (Foreign uid)',
            true
        );
        $this->registerArgument(
            'as',
            'string',
            'This parameter specifies the name of the variable that will be used for the returned ' .
            'ViewHelper result.',
            false,
            'references'
        );
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return mixed
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        // create query builder object
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable($arguments['table']);
        // query
        $row = $queryBuilder
            ->select('*')
            ->from($arguments['table'])
            ->where($queryBuilder->expr()->eq(
                'uid',
                $queryBuilder->createNamedParameter($arguments['id'], \PDO::PARAM_INT)
            ))
            ->execute()
            ->fetch();

        $templateVariableContainer = $renderingContext->getVariableProvider();

        if ($row) {
            $fileCollector = GeneralUtility::makeInstance(FileCollector::class);
            $fileCollector->addFilesFromRelation($arguments['table'], $arguments['field'], $row);

            $templateVariableContainer->add($arguments['as'], $fileCollector->getFiles());
        }

        $content = $renderChildrenClosure();

        if ($row) {
            $templateVariableContainer->remove($arguments['as']);
        }

        return $content;
    }
}
