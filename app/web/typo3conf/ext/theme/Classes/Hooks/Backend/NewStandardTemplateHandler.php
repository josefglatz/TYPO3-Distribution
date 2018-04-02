<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Hooks\Backend;

use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Tstemplate\Controller\TypoScriptTemplateInformationModuleFunctionController;
use TYPO3\CMS\Tstemplate\Controller\TypoScriptTemplateModuleController;

class NewStandardTemplateHandler
{
    /**
     * Prevent creating a new sys_template record for a new website
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
            'while sys_template records are created via runThroughTemplatesPostProcessing hook' .
            'in EXT:theme/Classes/Hooks/Frontend/TypoScriptHook.php. ' .
            'Records in the database can not be versioned and offer potential for technical debt.',
            'Creating a sys_template record in the database is not allowed!',
            FlashMessage::ERROR,
            true
        );
        $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
        $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
        $messageQueue->addMessage($message);
        $redirectUri = BackendUtility::getModuleUrl(
            'web_ts',
            [
                'id' => $params['id'],
                'function' => TypoScriptTemplateInformationModuleFunctionController::class
            ]
        );
        @ob_end_clean();
        header('Location: ' . GeneralUtility::locationHeaderUrl($redirectUri));
        die();
    }

    /**
     * @return UriBuilder
     */
    protected function getUriBuilder(): UriBuilder
    {
        return GeneralUtility::makeInstance(UriBuilder::class);
    }
}
