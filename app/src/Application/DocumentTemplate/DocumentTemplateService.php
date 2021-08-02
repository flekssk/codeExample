<?php

namespace App\Application\DocumentTemplate;

use App\Domain\Repository\DocumentTemplate\DocumentTemplateRepositoryInterface;
use App\Infrastructure\HttpClients\CrmApi\CrmApi;
use DateTimeImmutable;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class DocumentTemplateService.
 *
 * @package App\Application\DocumentTemplate
 */
class DocumentTemplateService
{
    /**
     * @var CrmApi
     */
    private CrmApi $crmApi;

    /**
     * @var DocumentTemplateRepositoryInterface
     */
    private DocumentTemplateRepositoryInterface $repository;

    /**
     * DocumentTemplateService constructor.
     *
     * @param CrmApi $crmApi
     * @param DocumentTemplateRepositoryInterface $repository
     */
    public function __construct(CrmApi $crmApi, DocumentTemplateRepositoryInterface $repository)
    {
        $this->crmApi = $crmApi;
        $this->repository = $repository;
    }

    /**
     * Функция обновления шаблонов документов, вернет количество обработанных документов.
     *
     * @return int
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function update(): int
    {
        $this->repository->beginTransaction();

        // Дата изменения задается заранее, что бы она была одинакова для всех обновленных/добавленных шаблонов.
        $updatedAt = new DateTimeImmutable();

        // Получить шаблоны документов из CRM.
        $documentTemplates = $this->crmApi->getDocumentTemplates();

        // Для каждого полученного шаблона производится поиск уже имеющегося в базе шаблона.
        // Если шаблон найден - обновить его поля данными из полученного шаблона.
        // Если шаблон не найден - задать новому шаблону дату обновления и сохранить его.
        foreach ($documentTemplates as $documentTemplate) {
            $existingDocumentTemplate = $this->repository->find($documentTemplate->getId());

            if ($existingDocumentTemplate) {
                $existingDocumentTemplate->setName($documentTemplate->getName());
                $existingDocumentTemplate->setDocumentType($documentTemplate->getDocumentType());
                $existingDocumentTemplate->setDisciplinesName($documentTemplate->getDisciplinesName());
                $existingDocumentTemplate->setYear($documentTemplate->getYear());
                $existingDocumentTemplate->setUpdatedAt($updatedAt);

                $this->repository->save($existingDocumentTemplate);
            } else {
                $documentTemplate->setUpdatedAt($updatedAt);
                $this->repository->save($documentTemplate);
            }
        }

        // Производится поиск устаревших шаблонов.
        // Если шаблон не был добавлен или обновлен при последнем обновлении (определяется параметром updatedAt) -
        // удалить этот шаблон.
        $oldDocumentTemplates = $this->repository->findByDateNotEqualTo($updatedAt);
        foreach ($oldDocumentTemplates as $oldDocumentTemplate) {
            $this->repository->delete($oldDocumentTemplate);
        }

        $this->repository->commit();

        return count($documentTemplates);
    }
}
