<?php

namespace App\Command\SpecialistDocument;

use App\Application\SpecialistDocument\SpecialistDocumentService;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Psr\Log\LoggerInterface;

/**
 * Class UpdateSpecialistDocumentsCommand.
 *
 * Команда для обновления документов из CRM.
 */
class UpdateSpecialistDocumentCommand extends Command
{
    /**
     * @var SpecialistDocumentService
     */
    private SpecialistDocumentService $documentService;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * UpdateSpecialistDocumentsCommand constructor.
     *
     * @param SpecialistDocumentService $documentService
     * @param LoggerInterface $logger
     */
    public function __construct(SpecialistDocumentService $documentService, LoggerInterface $logger)
    {
        parent::__construct();
        $this->documentService = $documentService;
        $this->logger = $logger;
    }

    /**
     * Configuration.
     */
    protected function configure(): void
    {
        $this->setName('app:document:update')
            ->setDescription('Обновляет документы из CRM начиная с даты')
            ->addArgument('date', InputArgument::OPTIONAL, 'дата с которой происходит обновление');
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
        $output->write('begin update...');
        $this->logger->info('Update documents from CRM - begin update...');

        /** @var string $dateString */
        $dateString = $input->getArgument('date');
        $date = $dateString ?
            new \DateTimeImmutable($dateString) :
            new \DateTimeImmutable();
        $processedCount = $this->documentService->update($date);

        $output->writeln('done.');
        $this->logger->warning("[CMD] Update documents from CRM - done, processed {$processedCount} item(s).");

        return 0;
    }
}
