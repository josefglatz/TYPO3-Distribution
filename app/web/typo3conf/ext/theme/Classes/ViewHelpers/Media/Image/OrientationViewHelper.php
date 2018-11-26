<?php
declare(strict_types = 1);

namespace JosefGlatz\Theme\ViewHelpers\Media\Image;

use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Type\File\ImageInfo;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * Returns the orientation of the provided image file.
 *
 *  The VH requires the relative path to an image file.
 *  TYPO3 core's ImageInfo functions are used to gather details
 *  about the image file.
 *  The viewhelper returns `portrait` or `landscape` as string.
 *
 * = Examples
 * <code title="basic inline viewhelper usage">
 *  {f:uri.image(image:'{files.0}', cropVariant:'image_default') -> theme:media.image.orientation()}
 * </code>
 * <output>
 * orientation
 * <output>
 */
class OrientationViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext): string
    {
        $child = Environment::getPublicPath() . '/' . $renderChildrenClosure();
        $imageInfo = GeneralUtility::makeInstance(ImageInfo::class, $child);
        $height = $imageInfo->getHeight();
        $width = $imageInfo->getWidth();

        return $height > $width ? 'portrait' : 'landscape';
    }
}
