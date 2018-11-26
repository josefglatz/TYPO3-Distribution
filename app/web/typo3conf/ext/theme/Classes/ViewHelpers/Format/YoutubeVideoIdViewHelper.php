<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\ViewHelpers\Format;

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
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
class YoutubeVideoIdViewHelper extends AbstractViewHelper implements CompilableInterface
{
    use CompileWithRenderStatic;

    /** @var bool */
    protected $escapeOutput = false;

    /**
     */
    public function initializeArguments()
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
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        try {
            return self::parseUrl($arguments['url'], $arguments);
        } catch (\Exception $e) {
            // @TODO: TYPO3-Distribution: VH format.youtubeVideoId logging when videoId can't be extracted
            return '';
        }
    }

    protected static function parseUrl($url)
    {
        $pattern = '~(?:http|https|)(?::\/\/|)(?:www.|)(?:youtu\.be\/|youtube\.com(?:\/embed\/|\/v\/|\/watch\?v=|\/ytscreeningroom\?v=|\/feeds\/api\/videos\/|\/user\S*[^\w\-\s]|\S*[^\w\-\s]))([\w\-]{11})[a-z0-9;:@?&%=+\/\$_.-]*~i';
        return preg_replace($pattern, '$1', $url);
    }
}
