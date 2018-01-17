<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Domain\Model\Dto;

class EmConfiguration
{

    /**
     * Fill the properties properly
     *
     * @param array $configuration em configuration
     */
    public function __construct(array $configuration)
    {
        foreach ($configuration as $key => $value) {
            if (property_exists(__CLASS__, $key)) {
                $this->$key = $value;
            }
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
