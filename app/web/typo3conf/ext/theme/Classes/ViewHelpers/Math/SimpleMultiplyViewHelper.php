<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\ViewHelpers\Math;

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * Returns a multiplied by b
 */
class SimpleMultiplyViewHelper extends AbstractViewHelper implements CompilableInterface
{
    use CompileWithRenderStatic;

    /** @var bool */
    protected $escapeOutput = false;

    /**
     */
    public function initializeArguments()
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
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        try {
            if ($arguments['round']) {
                return round(self::multiplication($arguments));
            }
            return self::multiplication($arguments);
        } catch (\Exception $e) {
            // @TODO: TYPO3-Distribution: VH math.SimpleSum logging when calculation is not possible
            return '';
        }
    }

    protected static function multiplication($arguments): float
    {
        return (float)$arguments['a'] * (float)$arguments['b'];
    }
}
