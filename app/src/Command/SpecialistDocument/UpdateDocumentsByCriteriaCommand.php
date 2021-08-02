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
 * Class UpdateDocumentsByCriteriaCommand.
 *
 * Команда для обновления документов из CRM по указанному критерию.
 */
class UpdateDocumentsByCriteriaCommand extends Command
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
        $help = [
            'Критерий обновления указывается в двойных кавычках. Синтаксис согласно документации Doctrine:',
            'https://www.doctrine-project.org/projects/doctrine-orm/en/2.7/reference/query-builder.html',
            'Для указания поля в таблице используйте алиас "sd"',
            'Например: "sd.id = 123", "sd.date1 > sd.date2" и тд.',
        ];

        $this->setName('app:document:update-by-criteria')
            ->setDescription('Обновляет документы из CRM по указанному критерию')
            ->addArgument('criteria', InputArgument::REQUIRED, 'Критерий обновления')
            ->setHelp(implode("\n", $help));
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
        $this->logger->info('Update documents from CRM by criteria - begin update...');

        /** @var string $criteria */
        $criteria = $input->getArgument('criteria');
        $processedCount = $this->documentService->updateByCriteria($criteria);

        $output->writeln('done.');
        $this->logger->warning("[CMD] Update documents from CRM by criteria - done, processed {$processedCount} item(s).");

        return 0;
    }
}
