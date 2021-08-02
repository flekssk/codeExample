<?php

namespace App\Command\DocumentTemplate;

use App\Application\DocumentTemplate\DocumentTemplateService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class UpdateDocumentTemplateCommand.
 *
 * Команда для обновления шаблонов приказов из CRM.
 */
class UpdateDocumentTemplateCommand extends Command
{
    /**
     * @var DocumentTemplateService
     */
    private DocumentTemplateService $documentTemplateService;
    
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * UpdateDocumentTemplateCommand constructor.
     *
     * @param DocumentTemplateService $documentTemplateService
     * @param LoggerInterface $logger
     */
    public function __construct(DocumentTemplateService $documentTemplateService, LoggerInterface $logger)
    {
        parent::__construct();
        $this->documentTemplateService = $documentTemplateService;
        $this->logger = $logger;
    }

    /**
     * Configuration.
     */
    protected function configure(): void
    {
        $this->setName('app:document-template:update')
                ->setDescription('Обновляет шаблоны документов из CRM');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->write('begin update...');
        $this->logger->info('Update document templates from CRM - begin update...');

        $processedCount = $this->documentTemplateService->update();

        $output->writeln('done.');
        $this->logger->warning("[CMD] Update document templates from CRM - done, processed {$processedCount} item(s).");

        return 0;
    }
}
