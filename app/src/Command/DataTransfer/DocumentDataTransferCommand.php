<?php

namespace App\Command\DataTransfer;

use App\Domain\Entity\SpecialistDocument\SpecialistDocument;
use App\Domain\Entity\SpecialistDocument\ValueObject\DocumentNumber;
use App\Domain\Repository\DocumentTemplate\DocumentTemplateRepositoryInterface;
use App\Domain\Repository\Specialist\SpecialistRepositoryInterface;
use App\Domain\Repository\SpecialistDocument\SpecialistDocumentRepositoryInterface;
use DateTime;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class DocumentDataTransferCommand.
 *
 * @package App\Command\DataTransfer
 */
class DocumentDataTransferCommand extends Command
{
    /**
     * Путь до файла с данными.
     */
    private const FILE_PATH = '/var/www/src/Command/DataTransfer/data/erglav_documents.csv';

    /**
     * @var SpecialistDocumentRepositoryInterface $documentRepository
     */
    private SpecialistDocumentRepositoryInterface $documentRepository;

    /**
     * @var DocumentTemplateRepositoryInterface
     */
    private DocumentTemplateRepositoryInterface $documentTemplateRepository;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * DocumentDataTransferCommand constructor.
     *
     * @param SpecialistDocumentRepositoryInterface $documentRepository
     * @param DocumentTemplateRepositoryInterface $documentTemplateRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        SpecialistDocumentRepositoryInterface $documentRepository,
        DocumentTemplateRepositoryInterface $documentTemplateRepository,
        LoggerInterface $logger
    ) {
        $this->documentRepository = $documentRepository;
        $this->documentTemplateRepository = $documentTemplateRepository;
        $this->logger = $logger;

        parent::__construct();
    }

    /**
     * Configuration.
     */
    protected function configure(): void
    {
        $this->setName('app:data-transfer:document')
            ->setDescription('Загрузка данных о документах')
            ->addArgument('filePath', InputArgument::OPTIONAL, 'Путь до CSV файла с данными');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     *
     * @throws Exception
     *
     * @psalm-suppress PossiblyInvalidCast
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filePath = $input->getArgument('filePath') ?: self::FILE_PATH;

        $csvReader = new CsvReader((string) $filePath);

        foreach ($csvReader->getData() as $data) {
            if (!isset($data['crmid'])) {
                continue;
            }

            $crmId = $data['crmid'];

            // В некоторых случаях отсутствует crmId
            if (empty($crmId)) {
                $this->logger->warning("У документа с ID {$data['id']} пустое значение CRM ID.");
                continue;
            }

            $documentExists = $this->documentRepository->findOneBy(['crmId' => $crmId]);
            if ($documentExists) {
                $this->logger->warning("Документ с CRM ID {$crmId} уже существует.");
                continue;
            }

            $templateId = $this->getTemplateIdFromMapping($data['document_type']);
            $templateExists = $this->documentTemplateRepository->find($templateId);
            if (!$templateExists) {
                $this->logger->warning("Шаблона документа с ID {$templateId} не существует.");
                continue;
            }

            $document = new SpecialistDocument();
            $document->setCrmId($crmId);
            $document->setSpecialistId($data['user_id']);
            $document->setNumber(new DocumentNumber($data['document']));
            $document->setTypeDocument($data['typeDocument']);
            $document->setName($data['nameDocument']);
            $document->setDisciplinesName($data['namedischip']);
            $document->setTemplateId($templateId);
            $document->setDate(new DateTime($data['document_date']));
            $document->setEndDate(new DateTime($data['document_enddate']));
            $document->setEduDateStart(new DateTime($data['eduDateStart']));
            $document->setEduDateEnd(new DateTime($data['eduDateEnd']));
            $document->setHours((int) $data['hours']);

            $this->documentRepository->save($document);
        }

        return 0;
    }

    /**
     * @param $id
     *
     * @return string
     */
    private function getTemplateIdFromMapping($id): string
    {
        $mapping = [
            1 => '9b22911c-f260-e911-bb9f-00155d627f03',
            2 => '010983ce-d560-e911-bb9f-00155d627f03',
            3 => '89c850bb-f460-e911-bb9f-00155d627f03',
            4 => 'e95d3e2e-4c6a-e911-bba0-00155d627f03',
            5 => '51c005bf-4d6a-e911-bba0-00155d627f03',
            7 => '378ee27a-3676-e911-bba0-00155d627f03',
            8 => 'd47dcfaa-3676-e911-bba0-00155d627f03',
            9 => 'a01480db-3676-e911-bba0-00155d627f03',
            10 => '075cd8da-de76-e911-bba0-00155d627f03',
            11 => 'b3a66f79-df76-e911-bba0-00155d627f03',
            12 => 'b19106f7-5e9d-e911-bba2-00155d627f03',
            13 => '6659e6f9-a5bd-e911-bba3-00155d627f03',
            14 => '8cf9d391-a6bd-e911-bba3-00155d627f03',
            15 => 'f2cfdcc2-a6bd-e911-bba3-00155d627f03',
            16 => '135d0cf3-a6bd-e911-bba3-00155d627f03',
            17 => '9ac15c29-a7bd-e911-bba3-00155d627f03',
            18 => '4c723d7f-a7bd-e911-bba3-00155d627f03',
            19 => '4e2a2f60-a8bd-e911-bba3-00155d627f03',
            20 => '0d00ec96-a9bd-e911-bba3-00155d627f03',
            21 => 'af05d8fd-a9bd-e911-bba3-00155d627f03',
            22 => '5af0b7af-abbd-e911-bba3-00155d627f03',
            23 => '84279a74-89c9-e911-bba4-00155d627f03',
            24 => '95a7e956-39ca-e911-bba4-00155d627f03',
            25 => 'aee850bc-d8d2-e911-bba4-00155d627f03',
            26 => '231b3ebf-4726-ea11-bba4-00155d627f03',
            29 => '0',
        ];

        return $mapping[$id];
    }
}
