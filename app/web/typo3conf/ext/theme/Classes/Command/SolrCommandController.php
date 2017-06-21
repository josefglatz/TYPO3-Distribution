<?php declare(strict_types=1);

/**
 * This file is part of the "theme" Extension which is part of
 * the jousch/TYPO3-Distribution for TYPO3 CMS.
 */
namespace JosefGlatz\Theme\Command;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
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
