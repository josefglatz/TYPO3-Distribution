<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\ViewHelpers\Media;

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

/*
 * YouTube Embed ViewHelper with 2 modes
 *
 * A) The Viewhelper renders a complete YouTube HTML markup, if the ViewHelper has no child HTML markup.
 * B) The Viewhelper returns a fluid variable object with processed values if the ViewHelper has child HTML markup.
 */
class YoutubeViewHelper extends AbstractTagBasedViewHelper
{

    /**
     * Base url
     *
     * @var string
     */
    public const YOUTUBE_BASEURL = 'https://www.youtube.com';

    /**
     * Base url for extended privacy
     *
     * @var string
     */
    public const YOUTUBE_PRIVACY_BASEURL = 'https://www.youtube-nocookie.com';

    /**
     * @var string
     */
    protected $tagName = 'iframe';

    /**
     * Initialize arguments.
     *
     * @return void
     * @api
     */
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerUniversalTagAttributes();
        $this->registerArgument(
            'as',
            'string',
            'This parameter specifies the name of the variable that will be used if you want to write the ' .
            'the whole HTML markup by your own. E.g. useful if you want to embed a GDPR compliant YouTube video.',
            false,
            'processedVideo'
        );
        $this->registerArgument('videoId', 'string', 'YouTube id of the video to embed.', true);
        $this->registerArgument(
            'width',
            'integer',
            'Width of the video in pixels. Defaults to 640 for 16:9 content.',
            false,
            640
        );
        $this->registerArgument(
            'height',
            'integer',
            'Height of the video in pixels. Defaults to 385 for 16:9 content.',
            false,
            385
        );
        $this->registerArgument(
            'autoplay',
            'boolean',
            'Play the video automatically on load. Defaults to FALSE.',
            false,
            false
        );
        $this->registerArgument('legacyCode', 'boolean', 'Whether to use the legacy flash video code.', false, false);
        $this->registerArgument(
            'showRelated',
            'boolean',
            'Whether to show related videos after playing.',
            false,
            false
        );
        $this->registerArgument('extendedPrivacy', 'boolean', 'Whether to use cookie-less video player.', false, true);
        $this->registerArgument('hideControl', 'boolean', 'Hide video player\'s control bar.', false, false);
        $this->registerArgument('hideInfo', 'boolean', 'Hide video player\'s info bar.', false, false);
        $this->registerArgument('enableJsApi', 'boolean', 'Enable YouTube JavaScript API', false, false);
        $this->registerArgument('playlist', 'string', 'Comma seperated list of video IDs to be played.');
        $this->registerArgument('loop', 'boolean', 'Play the video in a loop.', false, false);
        $this->registerArgument('start', 'integer', 'Start playing after seconds.');
        $this->registerArgument('end', 'integer', 'Stop playing after seconds.');
        $this->registerArgument('lightTheme', 'boolean', 'Use the YouTube player\'s light theme.', false, false);
        $this->registerArgument('modestbranding', 'boolean', 'Do not show YouTube logo.', false, false);
        $this->registerArgument(
            'videoQuality',
            'string',
            'Set the YouTube player\'s video quality (hd1080,hd720,highres,large,medium,small).'
        );
        $this->registerArgument(
            'windowMode',
            'string',
            'Set the Window-Mode of the YouTube player (transparent,opaque). This is necessary for ' .
            'z-index handling in IE10/11.',
            false
        );
        $this->registerArgument(
            'color',
            'string',
            'This parameter specifies the color that will be used in the player\'s video progress bar ' .
            'to highlight the amount of the video that the viewer has already seen. Valid parameter values are red ' .
            'and white, and, by default, the player uses the color red. Setting the color parameter to white will ' .
            'disable the modestbranding option.'
        );
    }

    /**
     * Render method
     *
     * @return string
     */
    public function render(): string
    {
        $videoId = $this->arguments['videoId'];
        $width = $this->arguments['width'];
        $height = $this->arguments['height'];

        $this->tag->addAttribute('width', $width);
        $this->tag->addAttribute('height', $height);

        $src = $this->getSourceUrl($videoId);

        if (false === (boolean) $this->arguments['legacyCode']) {
            $this->tag->addAttribute('src', $src);
            $this->tag->addAttribute('frameborder', 0);
            $this->tag->addAttribute('allowFullScreen', 'allowFullScreen');
            $this->tag->forceClosingTag(true);
        } else {
            $this->tag->setTagName('object');

            $tagContent = '';

            $paramAttributes = [
                'movie' => $src,
                'allowFullScreen' => 'true',
                'scriptAccess' => 'always',
            ];
            foreach ($paramAttributes as $name => $value) {
                $tagContent .= $this->renderChildTag('param', [$name => $value], true);
            }

            $embedAttributes = [
                'src' => $src,
                'type' => 'application/x-shockwave-flash',
                'width' => $width,
                'height' => $height,
                'allowFullScreen' => 'true',
                'scriptAccess' => 'always',
            ];
            $tagContent .= $this->renderChildTag('embed', $embedAttributes, true);

            $this->tag->setContent($tagContent);
        }

        // Return the final YouTube Embed HTML markup if the ViewHelper has no child markup
        if (empty($this->renderChildren())) {
            return $this->tag->render();
        }

        // Return available attributes as fluid variable if the ViewHelper has child markup
        // This is used to build the HTML markup by your own.
        $this->templateVariableContainer->add(
            $this->arguments['as'],
            [
                'arguments' => $this->arguments,
                'tag' => $this->tag->getAttributes()
            ]
        );
        $output = $this->renderChildren();
        $this->templateVariableContainer->remove($this->arguments['as']);

        return $output;
    }

    /**
     * Returns video source url according to provided arguments
     *
     * @param string $videoId
     * @return string
     */
    private function getSourceUrl(string $videoId): string
    {
        $src = $this->arguments['extendedPrivacy'] ? self::YOUTUBE_PRIVACY_BASEURL : self::YOUTUBE_BASEURL;

        $params = [];

        if (false === (boolean) $this->arguments['showRelated']) {
            $params[] = 'rel=0';
        }
        if (true === (boolean) $this->arguments['autoplay']) {
            $params[] = 'autoplay=1';
        }
        if (true === (boolean) $this->arguments['hideControl']) {
            $params[] = 'controls=0';
        }
        if (true === (boolean) $this->arguments['hideInfo']) {
            $params[] = 'showinfo=0';
        }
        if (true === (boolean) $this->arguments['enableJsApi']) {
            $params[] = 'enablejsapi=1';
        }
        if (true === (boolean) $this->arguments['modestbranding']) {
            $params[] = 'modestbranding=1';
        }
        if (false === empty($this->arguments['playlist'])) {
            $params[] = 'playlist=' . $this->arguments['playlist'];
        }
        if (false === empty($this->arguments['color'])) {
            $params[] = 'color=' . $this->arguments['color'];
        }
        if (true === (boolean) $this->arguments['loop']) {
            $params[] = 'loop=1';
        }
        if (false === empty($this->arguments['start'])) {
            $params[] = 'start=' . $this->arguments['start'];
        }
        if (false === empty($this->arguments['end'])) {
            $params[] = 'end=' . $this->arguments['end'];
        }
        if (true === (boolean) $this->arguments['lightTheme']) {
            $params[] = 'theme=light';
        }
        if (false === empty($this->arguments['videoQuality'])) {
            $params[] = 'vq=' . $this->arguments['videoQuality'];
        }
        if (false === empty($this->arguments['windowMode'])) {
            $params[] = 'wmode=' . $this->arguments['windowMode'];
        }

        if (false === $this->arguments['legacyCode']) {
            $src .= '/embed/' . $videoId;
            $seperator = '?';
        } else {
            $src .= '/v/' . $videoId . '?version=3';
            $seperator = '&';
        }

        if (false === empty($params)) {
            $src .= $seperator . implode('&', $params);
        }

        return $src;
    }

    /**
     * Renders the provided tag and its attributes
     *
     * @param string $tagName
     * @param array $attributes
     * @param bool $forceClosingTag
     * @return string
     */
    private function renderChildTag(string $tagName, array $attributes = [], bool $forceClosingTag = false): string
    {
        $tagBuilder = clone $this->tag;
        $tagBuilder->reset();
        $tagBuilder->setTagName($tagName);
        $tagBuilder->addAttributes($attributes);
        $tagBuilder->forceClosingTag($forceClosingTag);
        $childTag = $tagBuilder->render();
        unset($tagBuilder);

        return $childTag;
    }
}
