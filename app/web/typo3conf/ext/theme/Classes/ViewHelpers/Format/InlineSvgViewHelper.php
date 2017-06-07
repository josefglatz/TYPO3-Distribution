<?php

/**
 * This file is part of the "theme" Extension which is part of
 * the jousch/TYPO3-Distribution for TYPO3 CMS.
 */

namespace JosefGlatz\Theme\ViewHelpers\Format;


use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Class InlineSvgViewHelper
 *
 * Return the adjusted content of a svg file
 *
 * = Examples
 * <code title="basic inline svg">
 *  <theme:svg source="{f:uri.resource(path: 'Icons/FileIcons/{file.extension}.svg', extensionName: 'foo')}" />
 * </code>
 * <output>
 * <svg><contentOfTheSvgFile</svg>
 * <output>
 */
class InlineSvgViewHelper extends AbstractViewHelper
{
    /**
     * Arguments initialization
     * @TODO: Make VH InlineSvgViewHelper compilable
     * @return void
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
     * @return string
     */
    public function render()
    {
        $sourceAbs = PATH_site . $this->arguments['source'];

        // return html comment, if file couldn't be found
        if (!file_exists($sourceAbs)) {
            return '<!-- SVG file couldn\'t be found -->';
        }

        return $this->getInlineSvg($sourceAbs);
    }

    /**
     * @param string $source
     *
     * @return string Rendered inline svg html markup with optional class, width and height attributes
     */
    protected function getInlineSvg($source)
    {
        $svgContent = file_get_contents($source);
        $svgContent = preg_replace('/<script[\s\S]*?>[\s\S]*?<\/script>/i', '', $svgContent);
        // Disables the functionality to allow external entities to be loaded when parsing the XML, must be kept
        $previousValueOfEntityLoader = libxml_disable_entity_loader(true);
        $svgElement = simplexml_load_string($svgContent);
        libxml_disable_entity_loader($previousValueOfEntityLoader);
        // remove xml version tag
        $domXml = dom_import_simplexml($svgElement);
        if (isset($this->arguments['class'])) {
            $domXml->setAttribute('class', $this->arguments['class']);
        }
        if (isset($this->arguments['width'])) {
            $domXml->setAttribute('width', $this->arguments['width']);
        }
        if (isset($this->arguments['height'])) {
            $domXml->setAttribute('height', $this->arguments['height']);
        }

        return $domXml->ownerDocument->saveXML($domXml->ownerDocument->documentElement);
    }
}
