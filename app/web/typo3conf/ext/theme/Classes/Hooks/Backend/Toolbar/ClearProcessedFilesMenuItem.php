<?php declare(strict_types=1);

/**
 * This file is part of the TYPO3 CMS distribution "jousch/TYPO3-Distribution".
 *
 *
 */

namespace JosefGlatz\Theme\Hooks\Backend\Toolbar;

use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\Toolbar\ClearCacheActionsHookInterface;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Resource\ProcessedFileRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Add a CacheMenuItem for clearing processed files.
 *
 * Class ClearProcessedFilesMenuItem
 */
class ClearProcessedFilesMenuItem implements ClearCacheActionsHookInterface
{
    /**
     * Add an entry to CacheMenuItems array
     *
     * @param array $cacheActions Array of CacheMenuItems
     * @param array $optionValues Array of AccessConfigurations-identifiers (typically  used by userTS with options.clearCache.identifier)
     */
    public function manipulateCacheActions(&$cacheActions, &$optionValues)
    {
        $backendUser = $this->getBackendUser();
        $languagePrefix = 'LLL:EXT:theme/Resources/Private/Language/locallang_BackendGeneral.xlf:clearcacheaction.clear.processedfiles.';
        $menuItemPath = $this->getUriBuilder()->buildUriFromRoute('ajax_' . 'theme_clear_processedfiles');

        if ($backendUser->isAdmin() && ($backendUser->getTSConfigVal('options.clearCache.processedfiles') || $this->applicationContextIsDevelopment())) {
            $cacheActions[] = [
                'id' => 'theme_clear_processedfiles',
                'title' => $languagePrefix . 'title',
                'description' => $languagePrefix . 'description',
                'href' => $menuItemPath,
                'iconIdentifier' => 'theme-backend-clear-processedfiles'
            ];
            $optionValues[] = 'theme_clear_processedfiles';
        }
    }

    /**
     * Clear processed files
     *
     * The sys_file_processedfile table is truncated and the physical files of local storages are deleted.
     */
    public function clearProcessedFiles()
    {
        $repository = GeneralUtility::makeInstance(ProcessedFileRepository::class);
        $repository->removeAll();
    }

    /**
     * Returns the current BE user.
     *
     * @return BackendUserAuthentication
     */
    protected function getBackendUser(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }

    /**
     * Check if current applicationContext is Development
     *
     * @return bool
     */
    protected function applicationContextIsDevelopment(): bool
    {
        $applicationContext = GeneralUtility::getApplicationContext();
        return $applicationContext->isDevelopment();
    }

    /**
     * Returns UriBuilder
     *
     * @return UriBuilder
     */
    protected function getUriBuilder(): UriBuilder
    {
        return GeneralUtility::makeInstance(UriBuilder::class);
    }
}
