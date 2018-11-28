<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Signals\Backend;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Controller\EditDocumentController;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\HttpUtility;

/**
 * Enrich/Customize EditDocumentController via SignalSlot usage
 */
class EditDocumentControllerInitSlot
{
    /**
     * preInitAfter SignalSlot
     *   - restrict creating sys_template records in database
     *
     * @param EditDocumentController $editDocumentController
     * @param ServerRequestInterface $request
     */
    public function adjustEditDocumentController(EditDocumentController $editDocumentController, ServerRequestInterface $request): void
    {
        $parsedBody = $request->getParsedBody();
        $queryParams = $request->getQueryParams();
        $parsedRequestParams = $parsedBody['edit']['sys_template'] ?? $queryParams['edit']['sys_template'] ?? [];
        if (!empty($parsedRequestParams) && \in_array('new', $parsedRequestParams, true)
        ) {
            $this->addFlashMessage();
            HttpUtility::redirect($queryParams['returnUrl'], HttpUtility::HTTP_STATUS_403);
        }
    }

    /**
     * Add flash message to queue to inform the TYPO3 backend administrator about the restriction.
     */
    protected function addFlashMessage(): void
    {
        /**
         * @var FlashMessage $message Error message to inform the backend user about the barrier
         */
        $message = GeneralUtility::makeInstance(
            FlashMessage::class,
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
    }

    /**
     * @return LanguageService
     */
    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}
