<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\ViewHelpers\Math;

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * Returns the sum of a and b.
 */
class SimpleSumViewHelper extends AbstractViewHelper implements CompilableInterface
{
    use CompileWithRenderStatic;

    /** @var bool */
    protected $escapeOutput = false;

    /**
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('a', 'string', 'First number', true);
        $this->registerArgument('b', 'string', 'Second number', true);
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
            return self::sum($arguments);
        } catch (\Exception $e) {
            // @TODO: TYPO3-Distribution: VH math.SimpleSum logging when calculation is not possible
            return '';
        }
    }

    protected static function sum($arguments): float
    {
        return (float)$arguments['a'] + (float)$arguments['b'];
    }
}
