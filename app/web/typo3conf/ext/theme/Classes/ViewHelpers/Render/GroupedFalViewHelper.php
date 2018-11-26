<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\ViewHelpers\Render;

use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;
use TYPO3\CMS\Frontend\Resource\FileCollector;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * Group FAL items per first char (FileReference/File)
 *
 * = Example 1
 *
 * <theme:render.groupedFal files="{files}" as="grouped">
 *     <f:debug>{grouped}</f:debug>
 * </theme:render.groupedFal>
 *
 * = Example 2
 *
 * <theme:render.groupedFal files="{files}" as="grouped">
 *     <f:for each="{grouped}" as="group" key="title">
 *         <f:if condition="{group -> f:count()} > 0">
 *             <f:render section="Group" arguments="{title: title, items: group, data: data}" />
 *         </f:if>
 *     </f:for>
 * </theme:render.groupedFal>
 *
 * <f:section name="Group">
 *     <h2 class="h3" id="ce{data.uid}-{title}">{title -> f:format.case(mode: 'upper')}</h2>
 *     <div class="ce-logos-group-grid" data-items-amount="{items -> f:count()}">
 *         <f:for each="{items}" as="item" iteration="i">
 *             <f:render section="Item" arguments="{_all}" />
 *         </f:for>
 *     </div>
 * </f:section>
 *
 * <f:section name="Item">
 *     <div class="ce-logos-group-grid-item" data-uid="{item.uid}">
 *         <f:link.typolink parameter="{item.link}" title="{item.title}" target="_blank">
 *             <f:image class="img-fluid" image="{item}" title="{item.title}" width="640c" height="365c" />
 *         </f:link.typolink>
 *     </div>
 * </f:section>
 */
class GroupedFalViewHelper extends AbstractViewHelper implements CompilableInterface
{
    use CompileWithRenderStatic;

    /** @var bool */
    protected $escapeOutput = false;

    /**
     * Initialize required arguments
     */
    public function initializeArguments()
    {
        $this->registerArgument('as', 'string', 'Output variable', true);
        $this->registerArgument('folder', 'string', 'Folder');
        $this->registerArgument('storage', 'string', 'Storage');
        $this->registerArgument('collections', 'string', 'List of collections');
        $this->registerArgument('files', 'array', 'Array of files/filereferences');
        $this->registerArgument('sortBy', 'string', 'Sorting property (title, ...)');
    }

    /**
     * Output grouped files/filereferences
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext): string
    {
        $fileCollector = GeneralUtility::makeInstance(FileCollector::class);

        // File Collections
        if (!empty($arguments['collections'])) {
            $collections = GeneralUtility::intExplode(',', $arguments['collections'], true);
            if (!empty($collections)) {
                $fileCollector->addFilesFromFileCollections($collections);
            }
        }

        // Folders
        if (!empty($arguments['folder']) && !empty($arguments['storage'])) {
            $identifier = $arguments['storage'] . ':' . $arguments['folder'];
            $fileCollector->addFilesFromFolder($identifier);
        }

        // Files
        if (!empty($arguments['files'])) {
            // Using addFileObjects() allows
            $fileCollector->addFileObjects($arguments['files']);
        }

        // Sort by specific File/FileReference property (e.g. `title`)
        if (!empty($arguments['sortBy'])) {
            $fileCollector->sort(trim($arguments['sortBy']));
        }

        // Fetch accumulated data
        $files = $fileCollector->getFiles();

        // Create array containing a range of numbers and letters
        $alphabet = array_merge(range('0', '9'), range('a', 'z'));
        $groupedItems = [];
        foreach ($alphabet as $letter) {
            $groupedItems[$letter] = [];
        }

        foreach ($files as $file) {
            if (\get_class($file) === FileReference::class) {
                /** @var FileReference $file */
                $title = $file->getTitle() ?: $file->getName();
            } elseif (\get_class($file) === File::class) {
                /** @var File $file */
                $props = $file->getProperties();
                $title = $props['title'] ?: $props['name'];
            } else {
                throw new \RuntimeException(sprintf('not supported type "%s"', \get_class($file)), 1513153485);
            }

            $firstLetter = mb_strtolower($title{0});
            switch ($firstLetter) {
                case 'ö':
                    $firstLetter = 'o';
                    break;
                case 'u':
                    $firstLetter = 'u';
                    break;
                case 'ä':
                    $firstLetter = 'a';
                    break;
            }
            $groupedItems[$firstLetter][] = $file;
        }

        $as = $arguments['as'];

        $renderingContext->getVariableProvider()->add($as, $groupedItems);
        $output = $renderChildrenClosure();
        $renderingContext->getVariableProvider()->remove($as);

        return $output;
    }
}
