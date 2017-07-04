<?php

declare(strict_types=1);

namespace JosefGlatz\Theme\Error;

/**
 * This file is part of the "theme" Extension which is part of
 * the jousch/TYPO3-Distribution for TYPO3 CMS.
 */
use GeorgRinger\Logging\Log\MonologManager;
use JosefGlatz\Theme\Controller\ErrorPageController;
use Throwable;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Exception handler for production
 */
class ProductionExceptionHandler extends \TYPO3\CMS\Core\Error\ProductionExceptionHandler
{

    /**
     * Echoes an exception for the web.
     *
     * @param Throwable $exception The throwable object.
     */
    public function echoExceptionWeb(Throwable $exception)
    {
        $this->sendStatusHeaders($exception);
        $this->writeLogEntries($exception, self::CONTEXT_WEB);
        $this->logError($exception);
        echo GeneralUtility::makeInstance(ErrorPageController::class)->errorAction(
            $this->getTitle($exception),
            $this->getMessage($exception),
            AbstractMessage::ERROR,
            $this->discloseExceptionInformation($exception) ? $exception->getCode() : 0
        );
    }

    /**
     * Log error
     *
     * @param Throwable $exception
     */
    protected function logError(Throwable $exception)
    {
        if (ExtensionManagementUtility::isLoaded('logging')) {
            $logger = GeneralUtility::makeInstance(MonologManager::class)->getLogger(__CLASS__);
            $logger->error($exception->getMessage());
        }
    }
}
