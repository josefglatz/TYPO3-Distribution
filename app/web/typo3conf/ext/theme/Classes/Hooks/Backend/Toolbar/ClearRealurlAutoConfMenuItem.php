<?php declare(strict_types=1);

namespace JosefGlatz\Theme\Hooks\Backend\Toolbar;

use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\Toolbar\ClearCacheActionsHookInterface;
use TYPO3\CMS\Core\Imaging\Icon;
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
     * Add an entry to CacheMenuItems array
     *
     * @param array $cacheActions Array of CacheMenuItems
     * @param array $optionValues Array of AccessConfigurations-identifiers (typically  used by userTS with options.clearCache.identifier)
     */
    public function manipulateCacheActions(&$cacheActions, &$optionValues)
    {
        $backendUser = $this->getBackendUser();
        $languageService = $this->getLanguageService();
        $languagePrefix = 'LLL:EXT:theme/Resources/Private/Language/locallang_BackendGeneral.xlf:clearcacheaction.realurl.autoConf';
        $this->iconFactory = GeneralUtility::makeInstance(IconFactory::class);

        $menuItemPath = $this->getUriBuilder()->buildUriFromRoute('ajax_' . 'theme_realurl_deleteautoconf');

        $extConfRealurl = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['realurl']);

        if (ExtensionManagementUtility::isLoaded('realurl') && $extConfRealurl['enableAutoConf']) {
            if ($backendUser->isAdmin() || $backendUser->getTSConfigVal('options.clearCache.realurl.autoconf')) {
                $cacheActions[] = [
                    'id' => 'theme_realurl_deleteautoconf',
                    'title' => htmlspecialchars($languageService->sL($languagePrefix . 'Title')),
                    'description' => htmlspecialchars($languageService->sL($languagePrefix . 'Description')),
                    'href' => $menuItemPath,
                    'icon' => $this->iconFactory->getIcon('theme-backend-realurl-reset', Icon::SIZE_SMALL)->render()
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
    protected function getBackendUser()
    {
        return $GLOBALS['BE_USER'];
    }

    /**
     * Returns LanguageService
     *
     * @return \TYPO3\CMS\Lang\LanguageService
     */
    protected function getLanguageService()
    {
        return $GLOBALS['LANG'];
    }

    /**
     * Returns UriBuilder
     *
     * @return UriBuilder
     */
    protected function getUriBuilder()
    {
        return GeneralUtility::makeInstance(UriBuilder::class);
    }
}
