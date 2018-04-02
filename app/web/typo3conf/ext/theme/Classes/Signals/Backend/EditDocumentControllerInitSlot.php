<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Signals\Backend;

use TYPO3\CMS\Backend\Controller\EditDocumentController;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Enrich/Customize EditDocumentController via SignalSlot usage
 * @package JosefGlatz\Theme\Signals\Backend
 */
class EditDocumentControllerInitSlot
{
    /**
     * preInitAfter SignalSlot
     *   - restrict creating sys_template records in database
     *
     * @param EditDocumentController $editDocumentController
     */
    public function adjustEditDocumentController(EditDocumentController $editDocumentController): void
    {
        $editconf = $editDocumentController->editconf;

        if (isset($editconf['sys_template'])) {
            if (reset(reset($editconf)) === 'new') {
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

                // Return to previous url without saving anything
                $editDocumentController->closeDocument();
            }
        }
    }
}
