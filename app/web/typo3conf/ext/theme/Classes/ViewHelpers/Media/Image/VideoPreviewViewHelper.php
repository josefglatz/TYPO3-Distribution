<?php
declare(strict_types = 1);

namespace JosefGlatz\Theme\ViewHelpers\Media\Image;

use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Resource\OnlineMedia\Helpers\OnlineMediaHelperRegistry;
use TYPO3\CMS\Core\Resource\ProcessedFile;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * Returns the public URL for the preview image of a given video file.
 * For online media the Core's OnlineMediaHelper is used, for other video files
 * any image with the same name in the same folder is fetched.
 *
 * Example
 * <f:image src="{theme:media.image.videoPreview(video: '{item.media.originalResource}')}" maxWidth="720" />
 */
class VideoPreviewViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * Initialize arguments
     */
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('video', 'object', 'Video file', true);
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     * @throws \TYPO3\CMS\Core\Resource\Exception\InsufficientFolderAccessPermissionsException
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext): string
    {
        $file = $arguments['video'];
        $video = null;

        if ($file instanceof File) {
            $video = $file;
        } elseif ($file instanceof ProcessedFile) {
            $video = $file->getOriginalFile();
        } elseif ($file instanceof FileReference) {
            $video = $file->getOriginalFile();
        } else {
            throw new \RuntimeException('Invalid file object. Type is: ' . \get_class($file));
        }

        $onlineHelper = OnlineMediaHelperRegistry::getInstance()->getOnlineMediaHelper($video);
        if ($onlineHelper) {
            return PathUtility::getAbsoluteWebPath($onlineHelper->getPreviewImage($video));
        }

        foreach ($video->getStorage()->getFilesInFolder($video->getParentFolder()) as $preview) {
            if (
                $preview->getType() === File::FILETYPE_IMAGE
                && $preview->getNameWithoutExtension() === $video->getNameWithoutExtension()
            ) {
                return $preview->getPublicUrl();
            }
        }

        return '';
    }
}
