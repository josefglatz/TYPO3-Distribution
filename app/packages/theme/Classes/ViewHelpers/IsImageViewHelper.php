<?php
declare(strict_types=1);

namespace JosefGlatz\Theme\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;

/**
 * Trims $content by stripping off $characters (string list
 * of individual chars to strip off, default is all whitespaces).
 */
class IsImageViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    public function initializeArguments()
    {
        $this->registerArgument('extension', 'string', 'the file extension');
    }

    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        $content = (string)$renderChildrenClosure();

        if ($arguments['extension'] !== '') {
            return in_array(strtolower($arguments['extension']), explode(',', $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']));
        }

        return $content;
    }
}
