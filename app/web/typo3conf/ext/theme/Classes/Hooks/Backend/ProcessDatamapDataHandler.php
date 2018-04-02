<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Hooks\Backend;

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ProcessDatamapDataHandler
{
    /**
     * Prevent creating a new sys_template record
     *
     * @param DataHandler $parentObject
     */
    public function processDatamap_beforeStart(DataHandler $parentObject)
    {
        if (isset($parentObject->datamap['sys_template']['NEW'])) {
            /**
             * @var FlashMessage $message Error message to inform the backend user about the barrier
             */
            $message = GeneralUtility::makeInstance(FlashMessage::class,
                'while sys_template records are created via runThroughTemplatesPostProcessing ' .
                'hook in EXT:theme/Classes/Hooks/Frontend/TypoScriptHook.php. ' .
                'Records in the database can not be versioned and offer potential for technical debt.',
                'Creating a sys_template record in the database is not allowed!',
                FlashMessage::ERROR,
                true
            );
            $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
            $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
            $messageQueue->addMessage($message);

            $redirectUri = BackendUtility::getModuleUrl(
                'web_list',
                [
                    'id' => (int)$parentObject->datamap['sys_template']['NEW']['pid'],
                ]
            );
            @ob_end_clean();
            header('Location: ' . GeneralUtility::locationHeaderUrl($redirectUri));
            die();
        }
    }
}
