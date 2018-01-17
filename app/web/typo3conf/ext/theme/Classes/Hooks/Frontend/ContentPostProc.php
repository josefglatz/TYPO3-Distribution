<?php declare(strict_types = 1);

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
