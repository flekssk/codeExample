<?php

namespace App\Command\Position;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Application\Position\PositionServiceInterface;
use Psr\Log\LoggerInterface;

/**
 * Class UpdatePositionCatalogCommand.
 *
 * Команда для обновления списка должностей из CRM.
 */
class UpdatePositionCatalogCommand extends Command
{

    /**
     * @var PositionServiceInterface
     */
    private PositionServiceInterface $positionService;
    
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * UpdatePostCatalogCommand constructor.
     *
     * @param PositionServiceInterface $positionService
     * @param LoggerInterface $logger
     */
    public function __construct(PositionServiceInterface $positionService, LoggerInterface $logger)
    {
        parent::__construct();
        $this->positionService = $positionService;
        $this->logger = $logger;
    }

    /**
     * Configuration.
     */
    protected function configure(): void
    {
        $this->setName('app:position:update')
                ->setDescription('Обновляет справочник должностей из CRM');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->write('begin update...');
        $this->logger->info('Update positions data from CRM - begin update...');

        $processedCount = $this->positionService->update();

        $output->writeln('done.');
        $this->logger->warning("[CMD] Update positions data from CRM - done, processed {$processedCount} item(s).");

        return 0;
    }
}
