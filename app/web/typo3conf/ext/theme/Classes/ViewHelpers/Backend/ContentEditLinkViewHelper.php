<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\ViewHelpers\Backend;

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\ViewHelpers\Be\AbstractBackendViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;

/**
 * Wraps an argument/value without any escaping and wraps it with an edit record link.
 *
 * PAY SPECIAL ATTENTION TO SECURITY HERE (especially Cross Site Scripting),
 * as the output is NOT SANITIZED!
 *
 * = Examples =
 *
 * <code title="Child nodes">
 * <theme:backend.contentEditLink>{string}</theme:backend.contentEditLink>
 * </code>
 * <output>
 * <a href="..."> {string }</a>
 * </output>
 *
 * <code title="Value attribute">
 * <theme:backend.contentEditLink value="{string}" />
 * </code>
 * <output>
 * <a href="..."> {string} </a>
 * </output>
 *
 * <code title="Inline notation">
 * {string -> theme:backend.contentEditLink()}
 * </code>
 * <output>
 * <a href="..."> {string} </a>
 * </output>
 *
 */
class ContentEditLinkViewHelper extends AbstractBackendViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    /**
     * @var bool
     */
    protected $escapeChildren = false;

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
        $this->registerArgument('value', 'mixed', 'The value to output');
    }

    /**
     * @param array $arguments
     * @param callable $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     * @throws \UnexpectedValueException
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ): string {
        $content = $renderChildrenClosure();
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
            // only add link markup around content, if permissions have been granted
            $content = '<a class="theme-content-edit-link" href="' . BackendUtility::getModuleUrl('record_edit', $urlParameter) . '">' . $content . '</a>';
        }

        return $content;
    }

    /**
     * @return BackendUserAuthentication
     */
    protected static function getBackendUser(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }
}
