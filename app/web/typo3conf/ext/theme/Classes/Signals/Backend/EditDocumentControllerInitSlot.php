<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Signals\Backend;

use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Backend\Controller\EditDocumentController;

class EditDocumentControllerInitSlot
{
    public function adjustEditDocumentController(EditDocumentController $editDocumentController)
    {
        $editconf = $editDocumentController->editconf;

        if (isset($editconf['sys_template'])) {
            if (reset(reset($editconf)) === 'new') {
                $pageRenderer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
                    \TYPO3\CMS\Core\Page\PageRenderer::class
                );

                // Create Error message to inform the backend user about the barrier
                $message = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Messaging\FlashMessage::class,
                    'sys_template records are created via runThroughTemplatesPostProcessing hook in EXT:theme/Classes/Hooks/Frontend/TypoScriptHook.php. ' .
                    'These can not be versioned and offer potential for technical debt.',
                    'Creating a sys_template record in the database is not allowed!',
                    \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR,
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
