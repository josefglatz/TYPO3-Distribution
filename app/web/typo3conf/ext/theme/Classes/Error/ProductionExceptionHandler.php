<?php declare(strict_types=1);

namespace JosefGlatz\Theme\Error;

use JosefGlatz\Theme\Controller\ErrorPageController;
use Psr\Log\LoggerInterface;
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
        $this->getLogger()->alert(sprintf($errorMessage, $code), ['exception' => $exception]);
    }

    /**
     * @return LoggerInterface
     */
    protected function getLogger()
    {
        if (ExtensionManagementUtility::isLoaded('logging')) {
            return GeneralUtility::makeInstance(\GeorgRinger\Logging\Log\MonologManager::class)->getLogger(__CLASS__);
        } else {
            return GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
        }
    }
}
