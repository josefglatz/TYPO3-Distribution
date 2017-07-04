<?php declare(strict_types=1);

namespace JosefGlatz\Theme\Error;

/**
 * This file is part of the "theme" Extension which is part of
 * the jousch/TYPO3-Distribution for TYPO3 CMS.
 */
use Psr\Log\LoggerInterface;
use TYPO3\CMS\Core\Crypto\Random;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\AbstractContentObject;
use TYPO3\CMS\Frontend\ContentObject\Exception\ExceptionHandlerInterface;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContext;
use TYPO3Fluid\Fluid\View\TemplatePaths;
use TYPO3Fluid\Fluid\View\TemplateView;

/**
 * Exception handler class for content object rendering
 */
class ContentExceptionHandler implements ExceptionHandlerInterface
{
    /**
     * @var array
     */
    protected $configuration = [];

    /**
     * The view object
     * @var TemplateView
     */
    protected $view;

    /**
     * @param array $configuration
     */
    public function __construct(array $configuration = [])
    {
        $this->configuration = $configuration;
        $this->view = GeneralUtility::makeInstance(TemplateView::class);
        $context = new RenderingContext($this->view);
        $context->setControllerName('ErrorPage');
        $context->setTemplatePaths(new TemplatePaths([
            'templateRootPaths' => [
                ExtensionManagementUtility::extPath('theme', 'Resources/Private/Templates/ErrorPage/')
            ]
        ]));
        $this->view->setRenderingContext($context);
    }

    /**
     * The severity level
     * @var int
     */
    protected $severity = AbstractMessage::ERROR;

    /**
     * Handles exceptions thrown during rendering of content objects
     * The handler can decide whether to re-throw the exception or
     * return a nice error message for production context.
     *
     * @param \Exception $exception
     * @param AbstractContentObject $contentObject
     * @param array $contentObjectConfiguration
     * @return string
     * @throws \Exception
     */
    public function handle(\Exception $exception, AbstractContentObject $contentObject = null, $contentObjectConfiguration = [])
    {
        if (!empty($this->configuration['ignoreCodes.'])) {
            if (in_array($exception->getCode(), array_map('intval', $this->configuration['ignoreCodes.']), true)) {
                throw $exception;
            }
        }
        $errorMessage = isset($this->configuration['errorMessage']) ? $this->configuration['errorMessage'] : 'Oops, an error occurred! Code: %s';
        $code = date('YmdHis', $_SERVER['REQUEST_TIME']) . GeneralUtility::makeInstance(Random::class)->generateRandomHexString(8);

        $this->logException($exception, $errorMessage, $code);

        return $this->view->render('ContentError');
    }

    /**
     * @param \Exception $exception
     * @param string $errorMessage
     * @param string $code
     */
    protected function logException(\Exception $exception, $errorMessage, $code)
    {
        $this->getLogger()->alert(sprintf($errorMessage, $code), ['exception' => $exception]);
    }

    /**
     * @return LoggerInterface
     */
    protected function getLogger()
    {
        return GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
    }
}
