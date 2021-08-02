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
 * Class GenerateIssueOfADocumentOrdersCommand.
 *
 * Команда для генерации приказов о выдаче документа.
 */
class GenerateIssueOfADocumentOrdersCommand extends Command
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
     * GenerateIssueOfADocumentOrdersCommand constructor.
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
            ->setName('app:order:generate-issue_of_a_document')
            ->setDescription('Генерирует приказы о выдаче документа')
            ->addArgument('dateFrom', InputArgument::OPTIONAL, '', $dateTime);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     *
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $input->validate();

        $this->logger->info('Generate issue of a document orders - begin update...');

        /** @var string $dateValue */
        $dateValue = $input->getArgument('dateFrom');
        $dateFrom = new DateTimeImmutable($dateValue);

        $numberOfOrdersToIssue = $this->specialistOrderService->getNumberOfOrdersToIssue($dateFrom);

        $progressBar = new ProgressBar($output);

        // Значение 'debug' используется для вывода объема занятой памяти.
        $progressBar->setFormat('debug');

        // Генерация приказов.
        $progressBar->start($numberOfOrdersToIssue);
        foreach ($this->specialistOrderService->generateIssueOfADocumentOrders($dateFrom) as $value) {
            $progressBar->advance();
        }
        $progressBar->finish();

        $this->logger->warning("[CMD] Generate issue of a document orders - done, processed {$numberOfOrdersToIssue} order(s).");
        
        return 0;
    }
}
