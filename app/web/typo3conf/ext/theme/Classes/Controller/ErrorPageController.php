<?php
declare(strict_types=1);

namespace JosefGlatz\Theme\Controller;

/**
 * This file is part of the "theme" Extension which is part of
 * the jousch/TYPO3-Distribution for TYPO3 CMS.
 */

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContext;
use TYPO3Fluid\Fluid\View\TemplatePaths;
use TYPO3Fluid\Fluid\View\TemplateView;

/**
 * A class representing error messages shown on a page, rendered via fluid.
 * Classic Example: "No pages are found on rootlevel"
 */
class ErrorPageController extends \TYPO3\CMS\Core\Controller\ErrorPageController
{

    /**
     * Sets up the view
     */
    public function __construct()
    {
        parent::__construct();
        $this->view = GeneralUtility::makeInstance(TemplateView::class);
        $context = new RenderingContext($this->view);
        $context->setControllerName('ErrorPage');
        $context->setTemplatePaths(new TemplatePaths([
            'templateRootPaths' => [
                ExtensionManagementUtility::extPath('theme', 'Resources/Private/Templates/ErrorPage/')
            ]
        ]));
        $this->view->setRenderingContext($context);
    }
}
