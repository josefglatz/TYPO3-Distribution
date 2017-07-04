<?php

declare(strict_types=1);

/**
 * This file is part of the "theme" Extension which is part of
 * the jousch/TYPO3-Distribution for TYPO3 CMS.
 */

namespace JosefGlatz\Theme\Hooks\Backend;

use TYPO3\CMS\Backend\View\PageLayoutViewDrawFooterHookInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class PageLayoutViewEnrichmentFooter implements PageLayoutViewDrawFooterHookInterface
{

    /**
     * Preprocesses the preview footer rendering of a content element.
     *
     * @param \TYPO3\CMS\Backend\View\PageLayoutView $parentObject Calling parent object
     * @param string $info Processed values
     * @param array $row Record row of tt_content
     * @return void
     */
    public function preProcess(\TYPO3\CMS\Backend\View\PageLayoutView &$parentObject, &$info, array &$row)
    {
        if (GeneralUtility::getApplicationContext()->isDevelopment() || $this->getBackendUser()->isAdmin()) {
            $info[] = '<span 
                            style="display: block;text-align: right;opacity: .4" 
	                        title="Only visible in Development applicationContext"
                >'
                . 'CType: ' . $row['CType']
                . '</span>';
        }
    }

    /**
     * Returns the current BE user.
     *
     * @return \TYPO3\CMS\Core\Authentication\BackendUserAuthentication
     */
    protected function getBackendUser()
    {
        return $GLOBALS['BE_USER'];
    }
}
