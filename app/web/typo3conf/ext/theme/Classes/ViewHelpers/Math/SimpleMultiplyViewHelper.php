<?php
declare(strict_types = 1);

namespace JosefGlatz\Theme\ViewHelpers\Math;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * Returns a multiplied by b
 */
class SimpleMultiplyViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /** @var bool */
    protected $escapeOutput = false;

    /**
     * Initialize arguments
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('a', 'string', 'First number', true);
        $this->registerArgument('b', 'string', 'Second number', true);
        $this->registerArgument('round', 'bool', 'Round result', false);
    }

    /**
     * Return result
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return float
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext): ?float
    {
        if ($arguments['round']) {
            return round(self::multiplication($arguments));
        }
        return self::multiplication($arguments);
    }

    protected static function multiplication($arguments): float
    {
        return (float)$arguments['a'] * (float)$arguments['b'];
    }
}
