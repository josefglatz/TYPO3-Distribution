<?php declare(strict_types=1);

/**
 * This file is part of the "theme" Extension which is part of
 * the jousch/TYPO3-Distribution for TYPO3 CMS.
 */
namespace JosefGlatz\Theme\ViewHelpers\Render;

use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * Class InlineSvgViewHelper
 *
 * Return the adjusted content of a svg file
 *
 * = Examples
 * <code title="basic inline svg">
 *  <theme:render.inlineSvg source="{f:uri.resource(path: 'Icons/FileIcons/{file.extension}.svg', extensionName: 'theme')}" />
 * </code>
 * <output>
 * <svg><contentOfTheSvgFile</svg>
 * <output>
 */
class InlineSvgViewHelper extends AbstractViewHelper implements CompilableInterface
{
    /**
     * @var bool
     */
    protected $escapeOutput = false;

    use CompileWithRenderStatic;

    /**
     * Arguments initialization
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('source', 'string', 'Source of svg resource', true);
        $this->registerArgument('class', 'string', 'Specifies an alternate class for the svg', false);
        $this->registerArgument('width', 'float', 'Specifies a width for the svg', false);
        $this->registerArgument('height', 'float', 'Specifies a height for the svg', false);
    }

    /**
     * Output different objects
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $file = PATH_site . $arguments['source'];

        // return html comment, if file couldn't be found
        if (empty($arguments['source']) || !file_exists($file)) {
            return '<!-- SVG file couldn\'t be found -->';
        }

        try {
            return self::getInlineSvg($file, $arguments);
        } catch (\Exception $e) {
            // @todo logging
            return '<!-- SVG generation produced error! -->';
        }
    }

    /**
     * @param string $source
     * @param array $arguments
     * @return string
     */
    protected static function getInlineSvg(string $source, array $arguments)
    {
        $svgContent = file_get_contents($source);
        $svgContent = preg_replace('/<script[\s\S]*?>[\s\S]*?<\/script>/i', '', $svgContent);
        // Disables the functionality to allow external entities to be loaded when parsing the XML, must be kept
        $previousValueOfEntityLoader = libxml_disable_entity_loader(true);
        $svgElement = simplexml_load_string($svgContent);
        libxml_disable_entity_loader($previousValueOfEntityLoader);
        // remove xml version tag
        $domXml = dom_import_simplexml($svgElement);
        if (isset($arguments['class'])) {
            $domXml->setAttribute('class', $arguments['class']);
        }
        if (isset($arguments['width'])) {
            $domXml->setAttribute('width', $arguments['width']);
        }
        if (isset($arguments['height'])) {
            $domXml->setAttribute('height', $arguments['height']);
        }

        return $domXml->ownerDocument->saveXML($domXml->ownerDocument->documentElement);
    }
}
