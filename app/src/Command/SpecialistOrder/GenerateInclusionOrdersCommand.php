<?php

namespace App\Command\SpecialistOrder;

use DateInterval;
use DateTimeImmutable;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Application\Specialist\SpecialistOrder\SpecialistOrderService;

/**
 * Class GenerateInclusionOrdersCommand.
 *
 * Команда для генерации приказов о включении в Реестр.
 */
class GenerateInclusionOrdersCommand extends Command
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var SpecialistOrderService
     */
    private SpecialistOrderService $specialistOrderService;

    /**
     * GenerateInclusionOrdersCommand constructor.
     *
     * @param LoggerInterface $logger
     * @param SpecialistOrderService $specialistOrderService
     */
    public function __construct(LoggerInterface $logger, SpecialistOrderService $specialistOrderService)
    {
        parent::__construct();
        $this->logger = $logger;
        $this->specialistOrderService = $specialistOrderService;
    }

    /**
     * Configuration.
     */
    protected function configure(): void
    {
        // Стандартное значение - текущее время минус 1 день.
        $currentDate = new DateTimeImmutable();
        $dateTime = $currentDate->sub(new DateInterval('P1D'))->format('Y-m-d H:i:s');
        $this
            ->setName('app:order:generate-inclusion')
            ->setDescription('Генерирует приказы о включении в Реестр')
            ->addArgument('dateFrom', InputArgument::OPTIONAL, '', $dateTime);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     *
     * @throws Exception
     *
     * @psalm-suppress PossiblyInvalidArgument
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $input->validate();

        $this->logger->info('Generate inclusion orders - begin update...');

        $dateFrom = new DateTimeImmutable($input->getArgument('dateFrom'));

        $numberOfSpecialistsToUpdate = $this->specialistOrderService->getNumberOfSpecialistForInclusion($dateFrom);

        $progressBar = new ProgressBar($output);

        // Значение 'debug' используется для вывода объема занятой памяти.
        $progressBar->setFormat('debug');

        // Генерация приказов.
        $progressBar->start($numberOfSpecialistsToUpdate);
        foreach ($this->specialistOrderService->generateInclusionOrders($dateFrom) as $value) {
            $progressBar->advance();
        }
        $progressBar->finish();

        $this->logger->warning("[CMD] Generate inclusion orders - done, processed {$numberOfSpecialistsToUpdate} specialist(s).");
        
        return 0;
    }
}
