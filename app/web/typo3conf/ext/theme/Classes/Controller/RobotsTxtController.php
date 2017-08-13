<?php
declare(strict_types=1);

namespace JosefGlatz\Theme\Controller;

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
