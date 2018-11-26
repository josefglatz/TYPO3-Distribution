<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class PostSyncCommand
 *
 * @TODO: TYPO3-Distribution: TYPO3v9LTS: check if PostSyncCommand->enableDevSysDomains is still needed
 */
class PostSyncCommand extends Command
{
    private $virtualHostTld = '';

    protected function configure(): void
    {
        $this
            ->setDescription('PostSync Commands')
            ->setHelp('
Assumptions:
- you run this command on local development environments
- you know what each of the executed methods do
- you want to sort you devDomain (sys_domain) to the first position in all page trees
- you have set your devDomain via environment variable "VIRTUAL_HOST" 
- you must run the this command controller with correct ApplicationContext/TYPO3_CONTEXT')
            ->virtualHostTld = $this->getEnvVarValue('VIRTUAL_HOST');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws \InvalidArgumentException
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $io = new SymfonyStyle($input, $output);
        $io->title($this->getDescription() . ' Results:');
        if (GeneralUtility::getApplicationContext()->isDevelopment()) {
            $this->enableDevSysDomains($io);
        }
        $io->newLine(1);
    }

    /**
     * @param SymfonyStyle $io necessary for outputting information
     */
    private function enableDevSysDomains($io): void
    {
        if ($this->virtualHostTld !== '') {
            $table = 'sys_domain';
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getQueryBuilderForTable($table);
            $updatedRows = $queryBuilder->update($table)
                ->where(
                    $queryBuilder->expr()->like(
                        'domainName',
                        $queryBuilder->createNamedParameter(
                            '%.' . $queryBuilder->escapeLikeWildcards($this->virtualHostTld),
                            \PDO::PARAM_STR
                        )
                    )
                )
                ->set('hidden', 0)
                ->set('sorting', 0)
                ->execute();
            if ($updatedRows > 0) {
                $io->success(sprintf('%d %s records were enabled and sorting was set to 0.', $updatedRows, $table));

                return;
            }
            $io->note(sprintf('No %s records were enabled or re-sorted', $table));

            return;
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
}
