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
 * Class UpdateDocumentsForSpecificSpecialistCommand.
 *
 * Команда для обновления документов из CRM для определенного специалиста.
 */
class UpdateDocumentsForSpecificSpecialistCommand extends Command
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
     * UpdateDocumentsForSpecificSpecialistCommand constructor.
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
        $this->setName('app:document:update-for-specific-specialist')
            ->setDescription('Обновляет документы из CRM для определенного специалиста')
            ->addArgument('id', InputArgument::REQUIRED, 'ID специалиста, для которого будут обновлены документы');
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
        $this->logger->info('Update documents from CRM for specific specialist - begin update...');

        /** @var int $id */
        $id = $input->getArgument('id');
        $this->documentService->updateForSpecialistId($id);

        $output->writeln('done.');
        $this->logger->warning('[CMD] Update documents from CRM for specific specialist - done, processed 1 specialist.');

        return 0;
    }
}
