<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Backend\CropVariants;

use JosefGlatz\Theme\Utility\ArrayTool;
use JosefGlatz\Theme\Backend\CropVariants\Defaults\CropArea;
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
     * focusArea configuration
     *
     * @var array
     */
    protected $focusArea = [];

    /**
     * coverAreas configuration
     *
     * @var array
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
     *  - try to set title based on LLL strings (per convention)
     *  - set default cropArea
     *
     * @param string $name name of this cropVariant
     * @throws \InvalidArgumentException
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->setDefaultTitle();
        $this->cropArea = CropArea::get();
    }

    /**
     * Instantiation of class
     *
     * @param string $name name/key for this cropVariant
     * @return self
     * @throws \InvalidArgumentException
     */
    public static function create(string $name): self
    {
        return GeneralUtility::makeInstance(self::class, $name);
    }

    /**
     * Set title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = trim($title);

        return $this;
    }

    /**
     * Set cropArea
     *
     * @param array $cropArea
     * @return $this
     */
    public function setCropArea(array $cropArea): self
    {
        $this->cropArea = $cropArea;

        return $this;
    }

    /**
     * Set focusArea
     *
     * @param array $focusArea
     * @return $this
     * @throws \UnexpectedValueException
     */
    public function setFocusArea(array $focusArea): self
    {
        if (!empty($focusArea) && !ArrayTool::arrayKeysExists(['x', 'y', 'width', 'height'], $this->focusArea)) {
            throw new \UnexpectedValueException(
                'focusArea array for cropVariant "' . $this->name . '" does not have set all necessary keys set.', 1520894420
            );
        }
        $this->focusArea = $focusArea;

        return $this;
    }

    /**
     * Add coverAreas
     *
     * @param array $coverAreas
     * @return $this
     */
    public function addCoverAreas(array $coverAreas)
    {
        foreach ($coverAreas as $coverArea) {
            $this->coverAreas[] = $coverArea;
        }

        return $this;
    }

    /**
     * Add allowedAspectRatio(s)
     *
     * @param array $ratios
     * @return $this
     * @throws \RuntimeException
     */
    public function addAllowedAspectRatios(array $ratios)
    {
        if (!empty($ratios)) {
            foreach ($ratios as $key => $ratio) {
                // Check wether aspectRatio with same name ($key) is already set
                if (\array_key_exists($key, $this->allowedAspectRatios)) {
                    throw new \RuntimeException(
                        'allowedAspectRatio "' . $ratio . '" already exists in the configuration.
                        Please remove it with removeAllowedAspectRatio() before adding new with same name.',
                        1520891285
                    );
                }
                $this->allowedAspectRatios[$key] = $ratio;
            }
        }
        $this->allowedAspectRatios = $ratios;

        return $this;
    }

    /**
     * Remove a allowedAspectRatio
     *
     * @param string $ratio name of allowed aspect ratio
     * @return $this
     * @throws \UnexpectedValueException
     */
    public function removeAllowedAspectRatio(string $ratio)
    {
        if (\array_key_exists(trim($ratio), $this->allowedAspectRatios)) {
            unset($this->allowedAspectRatios[$ratio]);
        } else {
            throw new \UnexpectedValueException(
                'Aspect ratio "' . htmlspecialchars(trim($ratio)) . '" for cropVariant "' . $this->name . '" can\'t be removed.
                It isn\'t defined in allowedAspectRatios for this cropVariant.',
                1520854115
            );
        }

        return $this;
    }

    /**
     * Set selectedRatio for cropVariant (optional)
     *
     * @param string $ratio
     * @return $this
     * @throws \UnexpectedValueException
     */
    public function setSelectedRatio(string $ratio)
    {
        if (\array_key_exists(trim($ratio), $this->allowedAspectRatios)) {
            $this->selectedRatio = $ratio;
        } else {
            throw new \UnexpectedValueException(
                'selectedRatio "' . trim($ratio) . '" key does not exists in cropVariants configuration.',
                1520891907
            );
        }

        return $this;
    }

    /**
     * Return final cropVariant configuration
     *  and throw exceptions if some necessary options aren't set
     *
     * @TODO: TYPO3-Distribution: Only return non emtpy sub-arrays
     * @TODO: TYPO3-Distribution: Reduce checks by moving them to their classes (still needs introduced)
     *
     * @return array
     * @throws \UnexpectedValueException
     */
    public function get(): array
    {
        // Check if title is set
        if (empty($this->title)) {
            throw new \UnexpectedValueException(
                'Title for cropVariant "' . $this->name . '" not set.', 1520731261);
        }
        // Check if necessary keys are set
        if (empty($this->cropArea)) {
            throw new \UnexpectedValueException(
                'cropArea array for cropVariant "' . $this->name . '" not set.', 1520731402);
        }
        if (!ArrayTool::arrayKeysExists(['x', 'y', 'width', 'height'], $this->cropArea)) {
            throw new \UnexpectedValueException(
                'cropArea array for cropVariant "' . $this->name . '" does not have set all necessary keys.', 1520732819);
        }
        if (!empty($this->focusArea) && !ArrayTool::arrayKeysExists(['x', 'y', 'width', 'height'], $this->focusArea)) {
            throw new \UnexpectedValueException(
                'focusArea array for cropVariant "' . $this->name . '" does not have set all necessary keys.', 1520892162
            );
        }
        if (!empty($this->coverAreas)) {
            foreach ($this->coverAreas as $coverArea) {
                if (!ArrayTool::arrayKeysExists(['x', 'y', 'width', 'height'], $coverArea)) {
                    throw new \UnexpectedValueException(
                        'coverAreas array for cropVariant "' . $this->name . '" are not configured correctly. \
                        Not every coverArea is configured correctly.', 1520733632);
                }
            }
        }
        if (empty($this->allowedAspectRatios)) {
            throw new \UnexpectedValueException(
                'No allowedAspectRatios set for cropVariant "' . $this->name . '". Seems like you forgot to add allowedAspectRatios via addAllowedAspectRatios().',
                1520962836
            );
        }

        return [
            $this->name => [
                'title' => $this->title,
                'cropArea' => $this->cropArea,
                'focusArea' => $this->focusArea,
                'coverAreas' => $this->coverAreas,
                'allowedAspectRatios' => $this->allowedAspectRatios,
                'selectedRatio' => $this->selectedRatio
            ]
        ];
    }

    /**
     * Try to set the title
     *
     *  - a) ...based on per convention defined localized strings in specific xlf file
     *  - b) by value of $this->name as a fallback
     *
     * @throws \InvalidArgumentException
     */
    protected function setDefaultTitle(): void
    {
        $title = '';
        if ($this->name !== '') {
            // Try a) if name has no space character
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
     *
     *  based on label convention key `crop_variants.$key.label`
     *
     * @param string $key
     * @return string 'LLL:...' string or empty string if localization wasn't successful
     * @throws \InvalidArgumentException
     */
    protected function defaultLocalizationAttempt(string $key): string
    {
        $result = '';
        $lllKeyToCheck = self::LLPATH . self::LLPATHPREFIX . trim(htmlspecialchars($key)) . self::LLPATHSUFFIX;
        if (!empty($this->getLanguageService()->sL($lllKeyToCheck))) {
            return $lllKeyToCheck;
        }

        return $result;
    }

    /**
     * Returns LanguageService
     *
     * @return LanguageService
     * @throws \InvalidArgumentException
     */
    protected function getLanguageService(): LanguageService
    {
        return GeneralUtility::makeInstance(LanguageService::class);
    }
}
