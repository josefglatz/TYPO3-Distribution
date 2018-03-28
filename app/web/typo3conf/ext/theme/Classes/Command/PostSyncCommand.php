<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class PostSyncCommand
 *
 * @TODO: TYPO3-Distribution: Add output which tasks were executed and which not
 * @TODO: TYPO3-Distribution: TYPO3v9LTS: check if PostSyncCommand->enableDevSysDomains is still needed
 *
 */
class PostSyncCommand extends Command
{
    private $VirtualHostTld = '';

    protected function configure(): void
    {
        $description = 'PostSync Commands';

        $this->setDescription($description);
        $this->setVirtualHostTld($this->getEnvVarValue('VIRTUAL_HOST'));
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     * @throws \InvalidArgumentException
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        if (GeneralUtility::getApplicationContext()->isDevelopment()) {
            $this->enableDevSysDomains();
        }
    }

    /**
     *
     * @throws \InvalidArgumentException
     */
    private function enableDevSysDomains(): void
    {
        if ($this->getVirtualHostTld() !== '') {
            $table = 'sys_domain';
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getQueryBuilderForTable($table);
            $queryBuilder->update($table)
                ->where(
                    $queryBuilder->expr()->like(
                        'domainName',
                        $queryBuilder->createNamedParameter(
                            '%.' . $queryBuilder->escapeLikeWildcards($this->getVirtualHostTld()),
                            \PDO::PARAM_STR
                        )
                    )
                )
                ->set('hidden', 0)
                ->set('sorting', 0)
                ->execute();
        }
    }

    /**
     * Return value of an environment variable
     *
     * @param string $environmentVariable
     * @return string
     */
    private function getEnvVarValue(string $environmentVariable): string
    {
        if (isset($_SERVER[trim($environmentVariable)])) {
            return array_values(\array_slice(explode('.', array_values(\array_slice(explode(' ', $_SERVER[$environmentVariable]), -1))[0]), -1))[0];
        }
        return '';
    }

    /**
     * @return string
     */
    public function getVirtualHostTld(): string
    {
        return $this->VirtualHostTld;
    }

    /**
     * @param string $VirtualHostTld
     */
    public function setVirtualHostTld(string $VirtualHostTld): void
    {
        $this->VirtualHostTld = $VirtualHostTld;
    }
}
