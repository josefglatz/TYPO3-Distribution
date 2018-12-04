<?php declare(strict_types=1);

namespace JosefGlatz\Theme\Configuration;

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration as ExtensionConfigurationCore;
use TYPO3\CMS\Core\SingletonInterface;

class ExtensionConfiguration implements SingletonInterface
{

    /**
     * Fill the properties properly
     *
     * @param array $configuration em configuration
     */
    public function __construct()
    {
        try {
            $settings = GeneralUtility::makeInstance(ExtensionConfigurationCore::class)->get('theme');
            $this->pageLayoutViewEnrichmentFooter = (bool)$settings['pageLayoutViewEnrichmentFooter'];
        } catch (\Exception $e) {

        }
    }

    /**
     * @var boolean;
     */
    protected $pageLayoutViewEnrichmentFooter = true;

    /**
     * @return bool
     */
    public function isPageLayoutViewEnrichmentFooter(): bool
    {
        return (bool)$this->pageLayoutViewEnrichmentFooter;
    }
}
