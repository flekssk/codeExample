<?php

namespace App\Command\SpecialistStatus;

use App\Application\SpecialistStatus\SpecialistStatusService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Psr\Log\LoggerInterface;

/**
 * Class UpdateSpecialistStatusCommand.
 *
 * Команда для обновления статусов специалистов.
 */
class UpdateSpecialistStatusCommand extends Command
{
    /**
     * @var SpecialistStatusService
     */
    private SpecialistStatusService $statusService;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * UpdatePostCatalogCommand constructor.
     *
     * @param SpecialistStatusService $statusService
     * @param LoggerInterface $logger
     */
    public function __construct(SpecialistStatusService $statusService, LoggerInterface $logger)
    {
        parent::__construct();
        $this->statusService = $statusService;
        $this->logger = $logger;
    }

    /**
     * Configuration.
     */
    protected function configure(): void
    {
        $this->setName('app:status:update')
            ->setDescription('Обновляет статусы специалистов');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->logger->info('Update specialist statuses - begin update...');

        $numberOfSpecialistsToUpdate = $this->statusService->getNumberOfSpecialistsToUpdate();

        $progressBar = new ProgressBar($output);

        // Значение 'debug' используется для вывода объема занятой памяти.
        $progressBar->setFormat('debug');

        // Обновление статусов.
        $progressBar->start($numberOfSpecialistsToUpdate);
        foreach ($this->statusService->update() as $value) {
            $progressBar->advance();
        }
        $progressBar->finish();

        $this->logger->warning("[CMD] Update specialist statuses - done, processed {$numberOfSpecialistsToUpdate} item(s).");

        return 0;
    }
}
