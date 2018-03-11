<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Utility;

use JosefGlatz\Theme\Utility\CropVariants\CropAreaDefaults;
use JosefGlatz\Theme\Utility\CropVariants\CropVariantDefaults;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Lang\LanguageService;

class CropVariant
{
    protected const LLPATH = 'LLL:EXT:theme/Resources/Private/Language/locallang_BackendGeneral.xlf:';
    protected const LLPATHPREFIX = 'crop_variants.';
    protected const LLPATHSUFFIX = '.label';

    /**
     * Name (key)
     *
     * @var string
     */
    protected $name;

    /**
     * Visible Title (LLL)
     *
     * @var string
     */
    protected $title = '';

    /**
     * cropArea configuration
     *
     * @var array
     */
    protected $cropArea = [];

    /**
     * coverAreas configuration
     *
     * @var
     */
    protected $coverAreas = [];

    /**
     * cropVariants configuration
     *
     * @var array
     */
    protected $allowedAspectRatios = [];

    /**
     * selectedRatio
     *
     * @var string
     */
    protected $selectedRatio = '';

    /**
     * CropVariant constructor.
     *  - set provided name
     *  - try to set title based on LLL strings
     *  - set default cropArea
     *
     * @param string $name name of this cropVariant
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->setDefaultTitle();
        $this->cropArea = CropAreaDefaults::get();
    }

    /**
     * Instantiation of class
     *
     * @param string $name name/key for this cropVariant
     * @return CropVariant
     */
    public static function create(string $name)
    {
        return GeneralUtility::makeInstance(self::class, $name);
    }

    /**
     * Set title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set cropArea
     *
     * @param array $cropArea
     * @return $this
     */
    public function setCropArea(array $cropArea)
    {
        $this->cropArea = $cropArea;
        return $this;
    }

    public function addCoverAreas(array $coverAreas)
    {
        foreach ($coverAreas as $coverArea) {
            $this->coverAreas[] = $coverArea;
        }

        return $this;
    }

    public function addAllowedAspectRatios(array $ratios)
    {
        $this->allowedAspectRatios = $ratios;

        return $this;
    }

    public function setSelectedRatio(string $ratio)
    {
        $this->selectedRatio = $ratio;

        return $this;
    }

    public function get(): array
    {
        return [
            $this->name => [
                'title' => $this->title
            ]
        ];
    }

    /**
     * Retrieve as default declared cropVariants
     *
     * @return array default cropVariants (only key)
     */
    protected function getDefaultCropVariants(): array
    {
        return CropVariantDefaults::getDefaultCropVariants();
    }

    /**
     * Try to set the title
     *  - a) based on per convention defined localized strings in specific xlf file
     *  - b) use $this->name as fallback title
     */
    protected function setDefaultTitle(): void
    {
        $title = '';
        if ($this->name !== '') {
            // Try a) if name has no space charactar
            if (!strrpos($this->name, ' ')) {
                $title = $this->defaultLocalizationAttempt($this->name);
            }
            // Try b)
            if ($title === '') {
                $title = str_replace('_', ' ', $this->name);
            }
            $this->title = $title;
        }
    }

    /**
     * Translation attempt
     *  based on label convention key `crop_variants.$key.label`
     *
     * @param string $key
     * @return string Localized string or empty string if localization wasn't successful
     */
    protected function defaultLocalizationAttempt(string $key): string
    {
        $result = '';
        $translated = $this->getLanguageService()->sL(
            self::LLPATH . self::LLPATHPREFIX . trim(htmlspecialchars($key)) . self::LLPATHSUFFIX
        );

        if (!empty($translated)) {
            $result = $translated;
        }

        return $result;
    }

    /**
     * Returns LanguageService
     *
     * @return LanguageService
     */
    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}
