<?php

declare(strict_types=1);

namespace JosefGlatz\Theme\Hooks\Backend\Toolbar;

use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\Toolbar\ClearCacheActionsHookInterface;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ClearRealurlAutoConfMenuItem implements ClearCacheActionsHookInterface
{
    /**
     * @var IconFactory
     */
    protected $iconFactory;

    /**
     * Add an entry to CacheMenuItems array.
     *
     * @param array $cacheActions Array of CacheMenuItems
     * @param array $optionValues Array of AccessConfigurations-identifiers (typically  used by userTS with options.clearCache.identifier)
     */
    public function manipulateCacheActions(&$cacheActions, &$optionValues)
    {
        $backendUser = $this->getBackendUser();
        $languagePrefix = 'LLL:EXT:theme/Resources/Private/Language/locallang_BackendGeneral.xlf:clearcacheaction.realurl.autoConf';

        $menuItemPath = $this->getUriBuilder()->buildUriFromRoute('ajax_'.'theme_realurl_deleteautoconf');

        $extConfRealurl = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['realurl'], [false]);

        if (ExtensionManagementUtility::isLoaded('realurl') && $extConfRealurl['enableAutoConf']) {
            if ($backendUser->isAdmin() || $backendUser->getTSConfigVal('options.clearCache.realurl.autoconf')) {
                $cacheActions[] = [
                    'id'             => 'theme_realurl_deleteautoconf',
                    'title'          => $languagePrefix.'Title',
                    'description'    => $languagePrefix.'Description',
                    'href'           => $menuItemPath,
                    'iconIdentifier' => 'theme-backend-realurl-reset',
                ];
                $optionValues[] = 'theme_realurl_deleteautoconf';
            }
        }
    }

    /**
     * Returns the current BE user.
     *
     * @return \TYPO3\CMS\Core\Authentication\BackendUserAuthentication
     */
    protected function getBackendUser(): \TYPO3\CMS\Core\Authentication\BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }

    /**
     * Returns UriBuilder.
     *
     * @return UriBuilder
     */
    protected function getUriBuilder(): \TYPO3\CMS\Backend\Routing\UriBuilder
    {
        return GeneralUtility::makeInstance(UriBuilder::class);
    }
}
