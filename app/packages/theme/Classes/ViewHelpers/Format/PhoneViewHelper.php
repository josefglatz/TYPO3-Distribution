<?php
declare(strict_types=1);

namespace JosefGlatz\Theme\ViewHelpers\Format;

use TYPO3\CMS\Core\Utility\StringUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;

/**
 * Process string to be used as a phone number with the tel: web handler
 */
class PhoneViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    protected $escapeChildren = false;

    protected $escapeOutput = false;

    public function initializeArguments()
    {
        $this->registerArgument('number', 'string', '');
    }

    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        $content = (string)$renderChildrenClosure();
        $content = html_entity_decode($content, ENT_QUOTES, 'UTF-8');
        $content = trim($content);
        $hasPlus = StringUtility::beginsWith($content, '+');

        if (stripos($content, '(0)-') !== -1) {
            $content = str_replace('(0)', '', $content);
        }

        $content = preg_replace('/[^\\d]+/', '', $content);

        if ($hasPlus) {
            $content = '00' . $content;
        }

        return $content;
    }
}
