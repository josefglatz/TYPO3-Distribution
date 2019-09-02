<?php
declare(strict_types = 1);

namespace JosefGlatz\Theme\ViewHelpers\Format;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * Returns only the videoId of a given and supported YouTube URL.
 *
 * = Example =
 *
 * <code title="register namespace in fluid first">
 * xmlns:theme="http://typo3.org/ns/JosefGlatz/Theme/ViewHelpers"
 * </code>
 *
 * <code title="default notation">
 *  <theme:format.youtubeVideoId url="{file.publicUrl}" />
 * </code>
 *
 * <code title="inline notation">
 *  {theme:format.youtubeVideoId(url: {file.publicUrl})}
 * </code>
 */
class YoutubeVideoIdViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /** @var bool */
    protected $escapeOutput = false;

    /**
     * Initialize arguments
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('url', 'string', 'Public YouTube Video Url', true);
    }

    /**
     * Return videoId
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext): ?string
    {
        try {
            return self::parseUrl($arguments['url']);
        } catch (\Exception $e) {
            return '';
        }
    }

    protected static function parseUrl($url)
    {
        /** @noinspection SpellCheckingInspection */
        $pattern = '~(?:http|https|)(?::\/\/|)(?:www.|)(?:youtu\.be\/|youtube\.com(?:\/embed\/|\/v\/|\/watch\?v=|\/ytscreeningroom\?v=|\/feeds\/api\/videos\/|\/user\S*[^\w\-\s]|\S*[^\w\-\s]))([\w\-]{11})[a-z0-9;:@?&%=+\/\$_.-]*~i';
        return preg_replace($pattern, '$1', $url);
    }
}
