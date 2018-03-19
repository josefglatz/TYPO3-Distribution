<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Hooks\Backend;

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class PageLayoutView
{
    /**
     * @var PageRenderer
     */
    protected $pageRenderer;

    /**
     * Initialize the page renderer
     */
    public function __construct()
    {
        $this->pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
    }

    /**
     * Initialize the page renderer
     * and add custom css file
     *
     * @return void
     */
    public function render(): void
    {
        $this->pageRenderer->addCssFile(
            '../' . ExtensionManagementUtility::siteRelPath('theme') . 'Resources/Public/Css/Backend/PageLayoutView.css'
        );
    }
}
