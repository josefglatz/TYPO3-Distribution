<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Hooks\Frontend;

/**
 * Hook which runs at the latest possible place
 */
class ContentPostProc
{
    /**
     * Just add your search/replace items.
     * Each item will be replaced in the output.
     *
     * @var array
     */
    protected $simpleSearchReplacements = [
//        'stringToReplace' => 'ReplacementString',
    ];

    /**
     * @param array $parameters
     */
    public function run(array &$parameters)
    {
        $parameters['pObj']->content = $this->simpleReplacements($parameters['pObj']->content);
    }

    /**
     * Simple string replacements
     * if $this->simpleSearchReplacements has replacements
     *
     * @param $searchText
     * @return string
     */
    protected function simpleReplacements($searchText): string
    {
        if (!empty($this->simpleSearchReplacements)) {
            return str_replace(array_keys($this->simpleSearchReplacements), array_values($this->simpleSearchReplacements), $searchText);
        }

        return $searchText;
    }
}
