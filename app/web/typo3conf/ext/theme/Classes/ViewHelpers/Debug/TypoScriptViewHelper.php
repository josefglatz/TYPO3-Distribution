<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\ViewHelpers\Debug;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

class TypoScriptViewHelper extends AbstractViewHelper
{
    /**
     * @throws \InvalidArgumentException
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    public function render()
    {
        if (GeneralUtility::getApplicationContext()->isDevelopment()) {
            $extbaseFrameworkConfiguration = GeneralUtility::makeInstance(ObjectManager::class)
                ->get(ConfigurationManager::class)
                ->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
            DebuggerUtility::var_dump(
                $extbaseFrameworkConfiguration,
                'CONFIGURATION_TYPE_FULL_TYPOSCRIPT || Use the Adminpanel to view the final rendered TypoScript!',
                500
            );
        }
    }
}
