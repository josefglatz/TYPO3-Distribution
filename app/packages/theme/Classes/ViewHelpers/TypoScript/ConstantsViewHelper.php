<?php
declare(strict_types = 1);

namespace JosefGlatz\Theme\ViewHelpers\TypoScript;

use TYPO3\CMS\Core\TypoScript\Parser\TypoScriptParser;
use TYPO3\CMS\Core\TypoScript\TypoScriptService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * ViewHelper to retrieve a specific TypoScript constants path
 *
 * = Examples =
 *
 * <code title="register namespace in fluid first">
 * xmlns:theme="http://typo3.org/ns/JosefGlatz/Theme/ViewHelpers"
 * </code>
 *
 * <code title="Usage in XML tag style: Make TypoScript constants `site.` available as Fluid variable `site`.">
 * <theme:typoScript.constants path="site" as="site" />
 * </code>
 *
 * <result>
 *  Make the final and processed TypoScript constants array of `site.` available as Fluid variable.
 * </result>
 *
 * <code title="Usage within attribute of another VH (f:variable)">
 * <f:variable name="somevars" value="{theme:typoScript.constants(path: 'site.breakpoints')}" />
 * </code>
 *
 * <result>
 *  Returns the final and processed TypoScript constants array of `site.breakpoints` to the <f:variable /> VH.
 * </result>
 *
 * <code title="usage within attribute of image VH where you know, that the gathered TypoScript constants path">
 * <f:image maxWidth="{theme:typoScript.constants(path: 'site.breakpoints.xs-max')}" />
 * </code>
 */
class ConstantsViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * Disable escaping interceptors for the VH output
     *
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * Initialize arguments.
     */
    public function initializeArguments(): void
    {
        $this->registerArgument(
            'path',
            'string',
            'Path to TypoScript configuration array/key',
            false,
            'site'
        );
        $this->registerArgument(
            'as',
            'string',
            'This parameter specifies the name of the variable that will be used for the returned ' .
            'ViewHelper result.',
            false,
            ''
        );
    }

    /**
     * Render method of the ViewHelper
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return mixed
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $asName = trim($arguments['as']);
        $flatConstants = static::getFlatConstants(trim($arguments['path']));
        $typoScriptParser = GeneralUtility::makeInstance(TypoScriptParser::class);
        $typoScriptParser->parse($flatConstants);
        $typoScriptArray = $typoScriptParser->setup;
        $typoScriptService = GeneralUtility::makeInstance(TypoScriptService::class);
        $constants = $typoScriptService->convertTypoScriptArrayToPlainArray($typoScriptArray);

        // Try to gather value if the provided path is no array
        if (empty($constants)) {
            $constants = static::getFlatConstant(trim($arguments['path']));
        }
        // Make the array/value available in Fluid template engine as variable.
        if ($asName) {
            $renderingContext->getVariableProvider()->add($asName, $constants);
        }

        return $constants;
    }

    /**
     * Get TypoScript constants array (already processed) for the desired TypoScript path
     * out of the TypoScriptFrontendController
     *
     * @param string $key
     * @return string
     */
    public static function getFlatConstants($key): string
    {
        $flatVariables = '';
        $prefix = $key . '.';
        $frontendController = static::getFrontendController();
        if ($frontendController->tmpl->flatSetup === null
            || !\is_array($frontendController->tmpl->flatSetup)
            || \count($frontendController->tmpl->flatSetup) === 0) {
            $frontendController->tmpl->generateConfig();
        }
        /** @noinspection ForeachSourceInspection */
        foreach ($frontendController->tmpl->flatSetup as $constant => $value) {
            if (strpos($constant, $prefix) === 0) {
                $flatVariables .= substr($constant, \strlen($prefix)) . ' = ' . $value . PHP_EOL;
            }
        }
        // Substitute gathered constants
        // The reason is, that TypoScript constants can be also used within TypoScript constants
        $flatVariables = $frontendController->tmpl->substituteConstants($flatVariables);

        return $flatVariables;
    }

    /**
     * Get TypoScript constants value (already processed) for the desired TypoScript path
     * out of the TypoScriptFrontendController
     *
     * @param string $key
     * @return string
     */
    public static function getFlatConstant(string $key): string
    {
        $constant = $key;
        $frontendController = static::getFrontendController();
        if ($frontendController->tmpl->flatSetup === null
            || !\is_array($frontendController->tmpl->flatSetup)
            || \count($frontendController->tmpl->flatSetup) === 0) {
            $frontendController->tmpl->generateConfig();
        }
        if (!array_key_exists($constant, $frontendController->tmpl->flatSetup)) {
            return '';
        }

        return $frontendController->tmpl->flatSetup[$constant];
    }

    /**
     * @return \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
     */
    public static function getFrontendController(): \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'];
    }
}
