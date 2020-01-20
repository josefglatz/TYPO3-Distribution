<?php
declare(strict_types = 1);
namespace JosefGlatz\Theme\ViewHelpers\Format;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class SubheaderViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * Difference of source header layout and resulting header layout
     */
    const DIFFERENCE = 1;

    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerUniversalTagAttributes();
        $this->registerArgument(
            'source',
            'integer',
            'The header layout from which the subheader layout must be calculated.',
            true
        );
        $this->registerArgument(
            'renderWhenHidden',
            'boolean',
            'To render or not to render content if the source header layout is > 99 (hidden)',
            false,
            false
        );
    }

    public function render(): string
    {
        $sourceHeaderLayout = (int)$this->arguments['source'];

        if ($sourceHeaderLayout > 99) {
            if ($this->arguments['renderWhenHidden']) {
                return $this->renderChildren();
            }

            return '';
        }
        $resultingHeaderType = $this->calculateResultingHeaderType($sourceHeaderLayout);
        $this->tag->setContent($this->renderChildren());
        $this->tag->setTagName('h' . $resultingHeaderType);

        return $this->tag->render();
    }

    private function calculateResultingHeaderType(int $sourceHeaderLayout)
    {
        $resultType = $sourceHeaderLayout + self::DIFFERENCE;

        if ($resultType > 6) {
            // limit to H6
            $resultType = 6;
        }

        return $resultType;
    }
}
