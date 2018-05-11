<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Hooks\Backend;

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Backend\View\PageLayoutView;
use TYPO3\CMS\Backend\View\PageLayoutViewDrawItemHookInterface;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\StringUtility;
use TYPO3\CMS\Lang\LanguageService;

class PageLayoutViewEnrichment implements PageLayoutViewDrawItemHookInterface, SingletonInterface
{
    /**
     * @var IconFactory
     */
    protected $iconFactory;

    public function __construct()
    {
        $this->iconFactory = GeneralUtility::makeInstance(IconFactory::class);
    }

    /** @noinspection MoreThanThreeArgumentsInspection
     * @param PageLayoutView $parentObject
     * @param $drawItem
     * @param $headerContent
     * @param $itemContent
     * @param array $row
     */
    public function preProcess(PageLayoutView &$parentObject, &$drawItem, &$headerContent, &$itemContent, array &$row): void
    {
        // General enrichments
        $row['_extras']['editLink'] = $this->getEditLink($row);

        // Custom content element specific enrichments
        if (StringUtility::beginsWith($row['CType'], 'theme')) {
            // Prevent the header value from the tt_content element from showing up above the $itemContent
            $headerContent = '';
        }
    }

    /**
     * CE edit link
     *
     * @param array $row
     * @return string
     */
    protected function getEditLink(array $row): string
    {
        $url = '';
        if ($this->getBackendUser()->recordEditAccessInternals('tt_content', $row)) {
            $urlParameters = [
                'edit' => [
                    'tt_content' => [
                        $row['uid'] => 'edit'
                    ]
                ],
                'returnUrl' => GeneralUtility::getIndpEnv('REQUEST_URI') . '#element-tt_content-' . $row['uid'],
            ];
            $url = BackendUtility::getModuleUrl('record_edit', $urlParameters);
        }
        return $url;
    }

    /**
     * @return LanguageService
     */
    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }

    /**
     * @return BackendUserAuthentication
     */
    protected function getBackendUser(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }

    /**
     * Fetch related IRRE elements
     *
     * @param string $localField local tt_content field of the IRRE relation
     * @param int $localUid uid of tt_content row
     * @param string $foreignField foreign field of relation
     * @return array
     */
    protected function getIrreRecords($localField, $localUid, $foreignField = 'parentid'): array
    {
        // Read foreign table name from TCA
        $foreignTable = $GLOBALS['TCA']['tt_content']['columns'][$localField]['config']['foreign_table'];
        // process db query if foreign table could be fetched from TCA
        if (!empty($foreignTable)) {
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getQueryBuilderForTable($foreignTable);
            // Build Query
            $queryBuilder
                ->select('*')
                ->from($foreignTable)
                ->where(
                    $queryBuilder->expr()->eq(
                        $foreignField,
                        $queryBuilder->createNamedParameter($localUid, \PDO::PARAM_INT)
                    )
                );

            return $queryBuilder->execute()->fetchAll();
        }

        return [];
    }
}
