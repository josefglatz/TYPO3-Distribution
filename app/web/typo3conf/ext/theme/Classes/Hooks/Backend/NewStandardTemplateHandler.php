<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Hooks\Backend;

use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Tstemplate\Controller\TypoScriptTemplateInformationModuleFunctionController;
use TYPO3\CMS\Tstemplate\Controller\TypoScriptTemplateModuleController;

class NewStandardTemplateHandler
{
    /**
     * Prevent creating a new sys_template record for a new website (TypoScriptTemplateModuleController)
     *
     * @param array $params
     * @param TypoScriptTemplateModuleController $parentObject
     * @return void
     */
    public function restrict(array &$params, $parentObject): void
    {
        /**
         * @var FlashMessage $message Error message to inform the backend user about the barrier
         */
        $message = GeneralUtility::makeInstance(FlashMessage::class,
            htmlspecialchars($this->getLanguageService()
                ->sL('LLL:EXT:theme/Resources/Private/Language/locallang_BackendGeneral.xlf:hooks.dataHandler.prevent.sys_template.description')),
            htmlspecialchars($this->getLanguageService()
                ->sL('LLL:EXT:theme/Resources/Private/Language/locallang_BackendGeneral.xlf:hooks.dataHandler.prevent.sys_template.title')),
            FlashMessage::ERROR,
            true
        );
        $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
        $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
        $messageQueue->addMessage($message);

        // @TODO: TYPO3-Distribution: TYPO3v9LTS: Check whether the BackendUtility:getModuleUrl is deprecated and probably switch to implementation like ViewHelpers/Be/UriViewHelper.php
        // Simply redirect back to web_ts module on same page ID
        $redirectUri = (string)GeneralUtility::makeInstance(UriBuilder::class)->buildUriFromRoute(
            'web_ts',
            [
                'id' => $params['id'],
                'function' => TypoScriptTemplateInformationModuleFunctionController::class
            ]
        );
        @ob_end_clean();
        // Core's HttpUtility isn't used here – it would load the entire backend in the content frame of TYPO3 backend
        header('Location: ' . GeneralUtility::locationHeaderUrl($redirectUri));
        die();
    }

    /**
     * @return LanguageService
     */
    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}
