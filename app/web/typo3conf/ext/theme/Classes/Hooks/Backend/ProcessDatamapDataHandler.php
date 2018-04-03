<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Hooks\Backend;

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Lang\LanguageService;
use TYPO3\CMS\Tstemplate\Controller\TypoScriptTemplateInformationModuleFunctionController;

class ProcessDatamapDataHandler
{
    /**
     * Prevent creating a new sys_template record
     *
     * @param DataHandler $parentObject
     */
    public function processDatamap_beforeStart(DataHandler $parentObject): void
    {
        if (isset($parentObject->datamap['sys_template']['NEW'])) {
            /**
             * @var FlashMessage $message Error message to inform the backend user about the barrier
             */
            $message = GeneralUtility::makeInstance(FlashMessage::class,
                $this->getLanguageService()
                    ->sL('LLL:EXT:theme/Resources/Private/Language/locallang_BackendGeneral.xlf:hooks.dataHandler.prevent.sys_template.description', true),
                $this->getLanguageService()
                    ->sL('LLL:EXT:theme/Resources/Private/Language/locallang_BackendGeneral.xlf:hooks.dataHandler.prevent.sys_template.title', true),
                FlashMessage::ERROR,
                true
            );
            $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
            $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
            $messageQueue->addMessage($message);

            $redirectUri = BackendUtility::getModuleUrl(
                'web_ts',
                [
                    'id' => (int)$parentObject->datamap['sys_template']['NEW']['pid'],
                    'function' => TypoScriptTemplateInformationModuleFunctionController::class
                ]
            );
            @ob_end_clean();
            header('Location: ' . GeneralUtility::locationHeaderUrl($redirectUri));
            die();
        }
    }

    /**
     * Hook into DataHandler for enrich formEngine while editing records
     *
     * @noinspection PhpUnusedParameterInspection
     *
     * @param $status
     * @param $table
     * @param $id
     * @param $fieldArray
     * @param DataHandler $pObj
     */
    public function processDatamap_postProcessFieldArray($status, $table, $id, &$fieldArray, &$pObj): void
    {
        // Add warning message, if somebody add or edit PageTSConfig directly.
        if ($table === 'pages' && isset($fieldArray['TSconfig']) && ($fieldArray['TSconfig'] !== '')) {
            $message = GeneralUtility::makeInstance(FlashMessage::class,
                'Read EXT:theme/Configuration/TSConfig/Page/Specific/README.md for instructions ' .
                'how to add page specific TSConfig with an alternative way.',
                'Please consider NOT saving Page TS Config directly to database!',
                FlashMessage::WARNING,
                true
            );
            $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
            $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
            $messageQueue->addMessage($message);
        }
    }


    /**
     * @return LanguageService
     */
    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}
