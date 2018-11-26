<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\ViewHelpers\Format;

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;

/**
 * Cleanup $content string
 */
class CleanupStringViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    /**
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('content', 'string', 'String to cleanup');
        $this->registerArgument('whitespace', 'boolean', 'Eliminate ALL whitespace characters', false, false);
        $this->registerArgument('tabs', 'boolean', 'Eliminate only tab whitespaces', false, false);
        $this->registerArgument('lineBreaks', 'boolean', 'Eliminate combined line breaks', false, false);
        $this->registerArgument('unixBreaks', 'boolean', 'Eliminate only UNIX line breaks', false, false);
        $this->registerArgument('windowsBreaks', 'boolean', 'Eliminates only Windows carriage returns', false, false);
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext): string
    {
        $content = $renderChildrenClosure();
        if (true === $arguments['whitespace']) {
            $content = static::eliminateWhitespace($content);
        }
        if (true === $arguments['tabs']) {
            $content = static::eliminateTabs($content);
        }
        if (true === $arguments['lineBreaks']) {
            $content = static::eliminateLineBreaks($content);
        }
        if (true === $arguments['unixBreaks']) {
            $content = static::eliminateUnixBreaks($content);
        }
        if (true === $arguments['windowsBreaks']) {
            $content = static::eliminateWindowsCarriageReturns($content);
        }

        return $content;
    }

    /**
     * @param string $content
     * @return string
     */
    protected static function eliminateWhitespace($content): string
    {
        $content = (string)preg_replace('/\s+/', '', $content);
        return $content;
    }

    /**
     * @param string $content
     * @return string
     */
    protected static function eliminateTabs($content): string
    {
        $content = str_replace("\t", '', $content);
        return $content;
    }

    /**
     * @param string $content
     * @return string
     */
    protected static function eliminateLineBreaks($content): string
    {
        $content = str_replace("\n\r", '', $content);
        return $content;
    }

    /**
     * @param string $content
     * @return string
     */
    protected static function eliminateUnixBreaks($content): string
    {
        $content = str_replace("\n", '', $content);
        return $content;
    }

    /**
     * @param string $content
     * @return string
     */
    protected static function eliminateWindowsCarriageReturns($content): string
    {
        $content = str_replace("\r", '', $content);
        return $content;
    }
}
