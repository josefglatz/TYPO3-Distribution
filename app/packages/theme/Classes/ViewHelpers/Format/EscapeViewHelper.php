<?php
declare(strict_types = 1);

namespace Supseven\Theme\ViewHelpers\Format;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;

/**
 * Like f:format.htmlspecialchars just shorter and avoids double escaping
 */
class EscapeViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    protected $escapeChildren = false;

    protected $escapeOutput = false;

    public function initializeArguments()
    {
        $this->registerArgument('content', 'string', '');
    }

    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        $content = (string)$renderChildrenClosure();
        $content = html_entity_decode($content, ENT_QUOTES, 'UTF-8');
        $content = htmlspecialchars($content, ENT_QUOTES | ENT_HTML5, 'UTF-8', true);

        return $content;
    }
}
