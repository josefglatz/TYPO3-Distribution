<?php
declare(strict_types = 1);

namespace JosefGlatz\Theme\ViewHelpers\Format;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * Returns only the domain part of a given URL. It actually
 * returns only the domain name without TLD. This could be
 * easily extended of course by extending the VH.
 */
class DomainNameViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /** @var bool */
    protected $escapeOutput = false;

    /**
     * Initialize arguments
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('url', 'string', 'Url where the domain must be extracted', false);
    }

    /**
     * Return domain name
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext): ?string
    {
        $url = $arguments['url'] ??  $renderChildrenClosure();
        try {
            return self::parseUrl($arguments['url'], $arguments);
        } catch (\Exception $e) {
            // @TODO VH format.domainName logging
            return 'domainName-extraction-not-possible';
        }
    }

    protected static function parseUrl($url, $arguments)
    {
        $url = substr($url, 0, 4) === 'http' ? $url : 'http://' . $url;
        $d = parse_url($url);
        $tmp = explode('.', $d['host']);
        $n = \count($tmp);
        if ($n >= 2) {
            if ($n == 4 || ($n == 3 && strlen($tmp[($n - 2)]) <= 3)) {
                $d['domain'] = $tmp[($n - 3)] . '.' . $tmp[($n - 2)] . '.' . $tmp[($n - 1)];
                $d['domainX'] = $tmp[($n - 3)];
            } else {
                $d['domain'] = $tmp[($n - 2)] . '.' . $tmp[($n - 1)];
                $d['domainX'] = $tmp[($n - 2)];
            }
        }
        return $d['domainX'];
    }
}
