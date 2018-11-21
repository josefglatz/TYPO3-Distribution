<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\ViewHelpers\Backend;

use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\ViewHelpers\Be\AbstractBackendViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * Returns the URL for an edit record link if the backend user has the permission to edit.
 *
 * = Examples =
 *
 * <code title="Uid attribute">
 * <theme:backend.contentEditLinkUrl uid="{uid}" />
 * </code>
 * <output>
 * {string}
 * </output>
 *
 * <code title="Inline notation">
 * {theme:backend.contentEditLink(uid: uid)}
 * </code>
 * <output>
 * {string}
 * </output>
 *
 */
class ContentEditLinkUrlViewHelper extends AbstractBackendViewHelper
{
    use CompileWithRenderStatic;

    /**
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * @return void
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('uid', 'int', 'The record UID', true);
    }

    /**
     * @param array $arguments
     * @param callable $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string Empty or edit-link-url
     * @throws \UnexpectedValueException
     * @throws \TYPO3\CMS\Backend\Routing\Exception\RouteNotFoundException
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ): string {
        $url = '';
        // Check first whether the user has permissions to edit this record
        if (self::getBackendUser()->recordEditAccessInternals('tt_content', $arguments['uid'])) {
            $urlParameter = [
                'edit' => [
                    'tt_content' => [
                        $arguments['uid'] => 'edit'
                    ]
                ],
                'returnUrl' => GeneralUtility::getIndpEnv('TYPO3_REQUEST_URL') . '#element-tt_content-' . $arguments['uid'],
            ];
            $url = (string)GeneralUtility::makeInstance(UriBuilder::class)->buildUriFromRoute('record_edit', $urlParameter);
        }

        return $url;
    }

    /**
     * @return BackendUserAuthentication
     */
    protected static function getBackendUser(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }
}
