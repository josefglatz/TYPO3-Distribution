<?php

declare(strict_types=1);

namespace JosefGlatz\Theme\Controller;

/**
 * This file is part of the "theme" Extension which is part of
 * the jousch/TYPO3-Distribution for TYPO3 CMS.
 */
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Dynamic robots txt
 */
class RobotsTxtController
{
    public function processRequest()
    {
        $content = [];
        $applicationContext = GeneralUtility::getApplicationContext();
        if ($applicationContext->isProduction()) {
        } else {
            $content = [
                'User-agent: *',
                'Disallow: /'
            ];
        }

        header('Content-Type: text/plain', true);
        echo implode(LF, $content);
    }
}
