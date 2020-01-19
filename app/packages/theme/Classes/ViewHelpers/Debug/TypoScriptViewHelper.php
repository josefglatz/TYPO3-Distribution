<?php
declare(strict_types = 1);

namespace JosefGlatz\Theme\ViewHelpers\Debug;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

class TypoScriptViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * Output of this viewhelper is already escaped
     *
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext): string
    {
        if (GeneralUtility::getApplicationContext()->isDevelopment()) {
            $extbaseFrameworkConfiguration = GeneralUtility::makeInstance(ObjectManager::class)
                ->get(ConfigurationManager::class)
                ->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
            return DebuggerUtility::var_dump(
                $extbaseFrameworkConfiguration,
                'CONFIGURATION_TYPE_FULL_TYPOSCRIPT || Use the admin panel to view the final rendered TypoScript!',
                500
            );
        }

        return '';
    }
}
