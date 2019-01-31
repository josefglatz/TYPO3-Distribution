<?php declare(strict_types=1);

namespace JosefGlatz\Theme\DataProcessing;

use TYPO3\CMS\Core\Routing\SiteMatcher;
use TYPO3\CMS\Core\Site\Entity\SiteInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentDataProcessor;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Retrieve Site object and assigned it to 'site'
 */
class SiteProcessor implements DataProcessorInterface
{

    /**
     * @param ContentObjectRenderer $cObj The data of the content element or page
     * @param array $contentObjectConfiguration The configuration of Content Object
     * @param array $processorConfiguration The configuration of this processor
     * @param array $processedData Key/value store of processed data (e.g. to be passed to a Fluid View)
     * @return array the processed data as key/value store
     */
    public function process(ContentObjectRenderer $cObj, array $contentObjectConfiguration, array $processorConfiguration, array $processedData)
    {
        $processedData['site'] = $this->getCurrentSite();
        return $processedData;
    }


    /**
     * Returns the currently configured "site" if a site is configured (= resolved) in the current request.
     *
     * @return SiteInterface
     * @throws \TYPO3\CMS\Core\Exception\SiteNotFoundException
     */
    protected function getCurrentSite(): SiteInterface
    {
        $matcher = GeneralUtility::makeInstance(SiteMatcher::class);
        return $matcher->matchByPageId((int)$this->getTypoScriptFrontendController()->id);
    }

    /**
     * @return TypoScriptFrontendController
     */
    protected function getTypoScriptFrontendController(): TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'];
    }
}
