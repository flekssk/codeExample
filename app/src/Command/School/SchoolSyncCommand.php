<?php

namespace App\Command\School;

use App\Application\School\SchoolSync\SchoolSyncServiceInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SchoolSyncCommand.
 *
 * @package App\Command\School
 */
class SchoolSyncCommand extends Command
{
    /**
     * @var SchoolSyncServiceInterface
     */
    private SchoolSyncServiceInterface $schoolSyncService;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * SchoolSyncCommand constructor.
     *
     * @param SchoolSyncServiceInterface $schoolSyncService
     * @param LoggerInterface $logger
     */
    public function __construct(SchoolSyncServiceInterface $schoolSyncService, LoggerInterface $logger)
    {
        $this->schoolSyncService = $schoolSyncService;
        $this->logger = $logger;

        parent::__construct();
    }

    /**
     * Configuration.
     */
    protected function configure(): void
    {
        $this->setName('app:school:sync')
            ->setDescription('Синхронизация школ.');
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->write('begin update...');
        $this->logger->info('Update schools - begin update...');

        $processedCount = $this->schoolSyncService->sync();

        $output->write('done.');
        $this->logger->warning("[CMD] Update schools - done, processed {$processedCount} item(s).");

        return 0;
    }
}
