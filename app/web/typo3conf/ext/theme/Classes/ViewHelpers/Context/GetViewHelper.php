<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\ViewHelpers\Context;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * ### Context: Get
 *
 * Returns the current application context which may include possible sub-contexts.
 * The application context can be 'Production', 'Development' or 'Testing'.
 * Additionally each context can be extended with custom sub-contexts like: 'Production/Staging' or
 * 'Production/Staging/Server1'. If no application context has been set by the configuration, then the
 * default context is 'Production'.
 *
 * #### Note about how to set the application context
 *
 * The context TYPO3 CMS runs in is specified through the environment variable TYPO3_CONTEXT.
 * It can be set by .htaccess or in the server configuration
 *
 * See: http://docs.typo3.org/typo3cms/CoreApiReference/ApiOverview/Bootstrapping/Index.html#bootstrapping-context
 */
class GetViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;
    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext): string
    {
        return (string)GeneralUtility::getApplicationContext();
    }
}
