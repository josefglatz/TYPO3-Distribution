<?php
declare(strict_types = 1);

namespace JosefGlatz\Theme\ViewHelpers\Format;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;

/**
 * Trims $content by stripping off $characters (string list
 * of individual chars to strip off, default is all whitespaces).
 */
class TrimViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    /**
     * Initialize arguments
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('content', 'string', 'String to trim');
        $this->registerArgument('characters', 'string', 'List of characters to trim, no separators, e.g. "abc123".');
    }

    /**
     * Trims content by stripping off $characters
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return mixed
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $characters = $arguments['characters'];
        $content = $renderChildrenClosure();
        if (false === empty($characters)) {
            $content = trim($content, $characters);
        } else {
            $content = trim($content);
        }
        return $content;
    }
}
