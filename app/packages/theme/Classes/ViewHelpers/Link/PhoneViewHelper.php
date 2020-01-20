<?php
declare(strict_types = 1);
namespace JosefGlatz\Theme\ViewHelpers\Link;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

/**
 * Phone link view helper.
 * Generates a phone number link
 *
 * = Examples =
 *
 * <code title="basic phone link">
 * <theme:link.phone phone="+49 123 456 7890" />
 * </code>
 * <output>
 * <a href="tel:+491234567890">+49 123 456 7890</a>
 * </output>
 *
 * <code title="Phone link with custom linktext">
 * <theme:link.phone phone="+49 123 456 7890">some custom content</theme:link.phone>
 * </code>
 * <output>
 * <a href="tel:+491234567890">some custom content</a>
 * </output>
 */
class PhoneViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * @var string
     */
    protected $tagName = 'a';

    /**
     * Arguments initialization
     */
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerUniversalTagAttributes();
        $this->registerArgument(
            'phone',
            'string',
            'The phone number like "+43 1 1234 567"',
            true
        );
        $this->registerTagAttribute('name', 'string', 'Specifies the name of an anchor');
        $this->registerTagAttribute('rel', 'string', 'Specifies the relationship between the current document and the linked document');
        $this->registerTagAttribute('rev', 'string', 'Specifies the relationship between the linked document and the current document');
        $this->registerTagAttribute('target', 'string', 'Specifies where to open the linked document');
    }

    /**
     * @return string Rendered phone link
     */
    public function render(): string
    {
        $phone = $this->arguments['phone'];
        $linkHref = 'tel:' . str_replace(' ', '', $phone);
        $linkText = $phone;

        $tagContent = $this->renderChildren();

        if ($tagContent !== null) {
            $linkText = $tagContent;
        }
        $this->tag->setContent($linkText);
        $this->tag->addAttribute('href', $linkHref);
        $this->tag->forceClosingTag(true);

        return $this->tag->render();
    }
}
