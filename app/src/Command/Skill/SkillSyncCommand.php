<?php

namespace App\Command\Skill;

use App\Application\Skill\SkillSync\SkillSyncServiceInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SkillSyncCommand.
 *
 * @package App\Command\Skill
 */
class SkillSyncCommand extends Command
{
    /**
     * @var SkillSyncServiceInterface
     */
    private SkillSyncServiceInterface $skillSyncService;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * SkillSyncCommand constructor.
     *
     * @param SkillSyncServiceInterface $skillSyncService
     * @param LoggerInterface $logger
     */
    public function __construct(SkillSyncServiceInterface $skillSyncService, LoggerInterface $logger)
    {
        $this->skillSyncService = $skillSyncService;
        $this->logger = $logger;

        parent::__construct();
    }

    /**
     * Configuration.
     */
    protected function configure(): void
    {
        $this->setName('app:skill:sync')
            ->setDescription('Обновляет навыков.');
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->write('begin update...');
        $this->logger->info('Update skills - begin update...');

        $processedCount = $this->skillSyncService->sync();

        $output->write('done.');
        $this->logger->warning("[CMD] Update skills - done, processed {$processedCount} item(s).");

        return 0;
    }
}
