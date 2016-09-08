<?php
namespace Sup7even\Theme\ViewHelpers;

use \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use \TYPO3\CMS\Core\Utility\GeneralUtility;

class ContextViewHelper extends AbstractViewHelper
{

    /**
     * returns the TYPO3_CONTEXT
     *
     * @return string TYPO3_CONTEXT
     */
    public function render() {
    	return GeneralUtility::getApplicationContext()->__toString();
    }
}