<?php
declare(strict_types = 1);

namespace JosefGlatz\Theme\ViewHelpers\Format;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;

/**
 * Remove empty P tags from $content by using preg_replace
 *
 * Removes only "two types" of an empty P tag:
 *  - an actually empty P tag without really no child element(s)
 *  - an P tag with one no-breaking-space HTML entity
 */
class RemoveEmptyParagraphViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    /**
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * Initialize arguments
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('content', 'string', 'String to be relieved of empty paragraphs');
    }

    /**
     * Return $content without empty paragraphs
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return mixed
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $content = $renderChildrenClosure();
        $content = preg_replace('~\\s?<p>(\\s|&nbsp;)+</p>\\s?~', '', $content);

        return $content;
    }
}
