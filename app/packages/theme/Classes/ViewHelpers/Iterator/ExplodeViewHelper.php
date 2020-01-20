<?php
declare(strict_types = 1);
namespace JosefGlatz\Theme\ViewHelpers\Iterator;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * Class ExplodeViewHelper to explode a string by glue
 */
class ExplodeViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument(
            'content',
            'string',
            'String to be exploded by glue',
            false
        );
        $this->registerArgument(
            'glue',
            'string',
            'String "glue" that separates values.',
            false,
            ','
        );
        $this->registerArgument(
            'limit',
            'int',
            'If limit is set and positive, the returned array will contain a maximum of limit elements with the last ' .
            'element containing the rest of string. If the limit parameter is negative, all components except the ' .
            'last-limit are returned. If the limit parameter is zero, then this is treated as 1.',
            false,
            PHP_INT_MAX
        );
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return array|mixed
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        $content = $renderChildrenClosure() ?? $arguments['content'];
        $glue = $arguments['glue'];
        $limit = $arguments['limit'] ?? PHP_INT_MAX;

        return explode($glue, $content, $limit);
    }
}
