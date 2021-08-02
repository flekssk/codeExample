<?php

namespace App\Infrastructure\HttpClients\CrmApi;

use App\Domain\Entity\DocumentTemplate\DocumentTemplate;
use App\Domain\Entity\Product\Product;
use App\Domain\Entity\SpecialistDocument\SpecialistDocument;
use App\Domain\Entity\SpecialistDocument\ValueObject\DocumentNumber;
use DateTimeImmutable;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class CrmApi.
 *
 * @package App\Infrastructure\HttpClients\CrmApi
 */
class CrmApi implements CrmApiInterface
{
    private const GET_PRODUCTS_URL = 'api/v1/Dictionary/GetProductVersionForRegistry';
    private const GET_DOCUMENTS_URL = 'api/v1/Document/GetUserDocumentsForRegistry?versionNumber=%s&onlyAfterDate=%s';
    private const GET_DOCUMENTS_FOR_SPECIALIST_URL = 'api/v1/Document/GetUserDocumentsForRegistry?userId=[%s]';
    private const GET_DOCUMENT_TEMPLATES_URL = 'api/v1/Document/GetTemplatesForRegistry';

    /**
     * @var CrmApiClientInterface
     */
    private CrmApiClientInterface $client;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * CrmApi constructor.
     *
     * @param CrmApiClientInterface $client
     * @param LoggerInterface $logger
     */
    public function __construct(CrmApiClientInterface $client, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getProducts(string $registryDomain): array
    {
        $crmData = $this->client->request(self::GET_PRODUCTS_URL);

        $products = [];
        foreach ($crmData as $item) {
            if ($item['registryDomain'] !== $registryDomain) {
                continue;
            }

            $product = new Product();
            $product->setId($item['versionNumber']);
            $product->setName($item['productVersion']['name']);
            $products[] = $product;
        }

        return $products;
    }

    /**
     * @inheritDoc
     */
    public function getDocuments(array $versionNumbers, \DateTimeImmutable $onlyAfterDate): array
    {
        $documents = [];
        $onlyAfterDateFormat = $onlyAfterDate->format('Y-m-d');

        foreach ($versionNumbers as $versionNumber) {
            $query = sprintf(self::GET_DOCUMENTS_URL, (string)$versionNumber, $onlyAfterDateFormat);
            $crmData = $this->client->request($query);
            $documents = array_merge($documents, $this->createDocumentsList($crmData));
        }

        return $documents;
    }

    /**
     * @inheritDoc
     */
    public function getDocumentsForSpecialistId(int $specialistId): array
    {
        $query = sprintf(self::GET_DOCUMENTS_FOR_SPECIALIST_URL, $specialistId);
        $crmData = $this->client->request($query);

        return $this->createDocumentsList($crmData);
    }

    /**
     * @inheritDoc
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getDocumentTemplates(): array
    {
        $documentTemplates = [];

        $crmData = $this->client->request(self::GET_DOCUMENT_TEMPLATES_URL);
        foreach ($crmData as $item) {
            if (!isset($item['name']) || empty($item['name'])) {
                continue;
            }

            $template = new DocumentTemplate(
                $item['id'],
                $item['name'],
                $item['documentType'],
                $item['disciplinesName'],
                new DateTimeImmutable($item['dyear'])
            );

            $documentTemplates[] = $template;
        }

        return $documentTemplates;
    }

    /**
     * @param array $data
     *
     * @return array
     *
     * @throws Exception
     */
    private function createDocumentsList(array $data): array
    {
        $documents = [];

        foreach ($data as $item) {
            if (empty($item['userId']) || empty($item['typeDocument'])) {
                continue;
            }

            try {
                $document = new SpecialistDocument();
                $document->setNumber(new DocumentNumber($item['number']));
                $document->setSpecialistId($item['userId']);
                $document->setName($item['nameDocument']);
                $document->setDisciplinesName($item['nameDisciplines']);
                $document->setTypeDocument($item['typeDocument']);
                $document->setCrmId($item['id']);
                $document->setTemplateId($item['templateId']);
                $document->setDate(new \DateTime($item['date']));
                $document->setEduDateStart(new \DateTime($item['eduDateStart']));
                if ($item['endDate']) {
                    $document->setEndDate(new \DateTime($item['endDate']));
                } else {
                    // Создаем значение с разницей в год от eduDateStart.
                    $endDate = new \DateTime($item['eduDateStart']);
                    $endDate->add(new \DateInterval('P1Y'));

                    $document->setEndDate($endDate);
                }
                $document->setEduDateEnd(new \DateTime($item['eduDateEnd']));
                $document->setHours((int)$item['hours']);

                $documents[] = $document;
            } catch (Exception $e) {
                $this->logger->info("Ошибка при создании документа на основе данных их CRM: {$e->getMessage()}");
                continue;
            }

        }

        return $documents;
    }
}
