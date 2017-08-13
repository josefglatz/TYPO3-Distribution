<?php declare(strict_types=1);

namespace JosefGlatz\Theme\Command;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\CommandController;

/**
 * Controller to run solr specific tasks via CLI
 */
class SolrCommandController extends CommandController
{

    /**
     * Update EXT:solr connections task
     *
     *  Older EXT:solr versions do not support executing
     *
     */
    public function updateConnectionsCommand()
    {
        /** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */
        $connectionManager = GeneralUtility::makeInstance(\ApacheSolrForTypo3\Solr\ConnectionManager::class);
        $connectionManager->updateConnections();
        $this->outputLine('<info>EXT:solr connections are updated in the registry.</info>');
        $this->sendAndExit();
    }
}
