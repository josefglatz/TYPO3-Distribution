<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\ViewHelpers\Context;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\StringUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * ### Context: ProductionLive
 *
 * Returns true if the application context is Production/Live explicitly.
 *
 * #### Note about how to set the application context
 *
 * The context TYPO3 CMS runs in is specified through the environment variable TYPO3_CONTEXT.
 * It can be set by .htaccess or in the server configuration
 *
 * See: http://docs.typo3.org/typo3cms/CoreApiReference/ApiOverview/Bootstrapping/Index.html#bootstrapping-context
 */
class ProductionLiveViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;
    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return bool
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext): bool
    {
        return (bool)StringUtility::beginsWith(GeneralUtility::getApplicationContext()->__toString(), 'Production/Live');
    }
}
