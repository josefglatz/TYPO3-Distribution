<?php

declare(strict_types=1);

/**
 * This file is part of the "theme" Extension which is part of
 * the jousch/TYPO3-Distribution for TYPO3 CMS.
 */

namespace JosefGlatz\Theme\Hooks\Frontend;

/**
 * Hook which runs at the latest possible place
 */
class ContentPostProc
{

    /**
     * @param array $parameters
     */
    public function run(array &$parameters)
    {
        $searchReplace = [
            'stringToReplace' => 'ReplacementString',
        ];
        $parameters['pObj']->content = str_replace(array_keys($searchReplace), array_values($searchReplace), $parameters['pObj']->content);
    }
}
