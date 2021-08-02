<?php

namespace App\Application\SpecialistDocument;

use App\Application\FileGenerator\Exception\FileGeneratorException;
use App\Application\SpecialistDocument\Assembler\SpecialistDocumentResultAssembler;
use App\Application\SpecialistDocument\Assembler\SpecialistDocumentShortAssembler;
use App\Application\SpecialistDocument\Dto\SpecialistDocumentShortDto;
use App\Domain\Entity\SpecialistDocument\SpecialistDocument;
use App\Domain\Repository\DocumentType\DocumentTypeRepositoryInterface;
use App\Domain\Repository\Product\ProductRepositoryInterface;
use App\Domain\Repository\Specialist\SpecialistRepositoryInterface;
use App\Domain\Repository\SpecialistDocument\SpecialistDocumentRepositoryInterface;
use App\Infrastructure\HttpClients\CrmApi\CrmApiInterface;
use DateTimeImmutable;
use Exception;

/**
 * Class SpecialistDocumentService.
 */
class SpecialistDocumentService
{
    /**
     * @var SpecialistDocumentResultAssembler
     */
    private SpecialistDocumentResultAssembler $assembler;

    /**
     * @var SpecialistDocumentShortAssembler
     */
    private SpecialistDocumentShortAssembler $assemblerShort;

    /**
     * @var CrmApiInterface
     */
    private CrmApiInterface $crmApi;

    /**
     * @var SpecialistDocumentRepositoryInterface
     */
    private SpecialistDocumentRepositoryInterface $repository;

    /**
     * @var ProductRepositoryInterface
     */
    private ProductRepositoryInterface $productRepository;

    /**
     * @var SpecialistRepositoryInterface
     */
    private SpecialistRepositoryInterface $specialistRepository;

    /**
     * @var DocumentTypeRepositoryInterface
     */
    private DocumentTypeRepositoryInterface $documentTypeRepository;

    /**
     * @var SpecialistDocumentPrintServiceInterface
     */
    private SpecialistDocumentPrintServiceInterface $printService;

    /**
     * SpecialistDocumentService constructor.
     *
     * @param SpecialistDocumentResultAssembler $assembler
     * @param SpecialistDocumentShortAssembler $assemblerShort
     * @param CrmApiInterface $crmApi
     * @param SpecialistDocumentRepositoryInterface $repository
     * @param ProductRepositoryInterface $productRepository
     * @param SpecialistRepositoryInterface $specialistRepository
     * @param DocumentTypeRepositoryInterface $documentTypeRepository
     * @param SpecialistDocumentPrintServiceInterface $printService
     */
    public function __construct(
        SpecialistDocumentResultAssembler $assembler,
        SpecialistDocumentShortAssembler $assemblerShort,
        CrmApiInterface $crmApi,
        SpecialistDocumentRepositoryInterface $repository,
        ProductRepositoryInterface $productRepository,
        SpecialistRepositoryInterface $specialistRepository,
        DocumentTypeRepositoryInterface $documentTypeRepository,
        SpecialistDocumentPrintServiceInterface $printService
    ) {
        $this->assembler = $assembler;
        $this->assemblerShort = $assemblerShort;
        $this->crmApi = $crmApi;
        $this->repository = $repository;
        $this->productRepository = $productRepository;
        $this->specialistRepository = $specialistRepository;
        $this->documentTypeRepository = $documentTypeRepository;
        $this->printService = $printService;
    }

    /**
     * @param int $specialistId
     *
     * @return array
     */
    public function getAllBySpecialistId(int $specialistId): array
    {
        $dtoObjects = [];
        $documents = $this->repository->findAllBySpecialistId($specialistId);
        foreach ($documents as $document) {
            $documentType = $this->documentTypeRepository->findOneBy(['documentTemplate' => $document->getTemplateId()]);

            if (!$documentType) {
                continue;
            }

            $dtoObjects[] = $this->assembler->assemble($document);
        }

        return $dtoObjects;
    }

    /**
     * @param int $specialistId
     *
     * @return SpecialistDocumentShortDto|null
     */
    public function getLastDocumentBySpecialistId(int $specialistId): ?SpecialistDocumentShortDto
    {
        /** @var SpecialistDocumentShortDto $resultDocument */
        $resultDocument = null;
        $documents = $this->repository->findAllBySpecialistId($specialistId);
        foreach ($documents as $document) {
            $dtoObject = $this->assemblerShort->assemble($document);
            if (!$resultDocument || $resultDocument->endDate < $dtoObject->endDate) {
                $resultDocument = $dtoObject;
            }
        }

        return $resultDocument;
    }

    /**
     * @param int $documentId
     *
     * @return \SplFileInfo
     *
     * @throws FileGeneratorException
     */
    public function getDocumentPictureById(int $documentId): \SplFileInfo
    {
        $document = $this->repository->get($documentId);
        $specialist = $this->specialistRepository->get($document->getSpecialistId());
        $documentType = $this->documentTypeRepository->findOneBy(['documentTemplate' => $document->getTemplateId()]);

        if (!$documentType) {
            throw new FileGeneratorException("DocumentType с documentTemplate = {$document->getTemplateId()} не найден.");
        }

        return $this->printService->getPicture($document, $documentType, $specialist);
    }

    /**
     * @param int $documentId
     *
     * @return string
     *
     * @throws FileGeneratorException
     */
    public function getDocumentHtmlById(int $documentId): string
    {
        $document = $this->repository->get($documentId);
        $specialist = $this->specialistRepository->get($document->getSpecialistId());
        $documentType = $this->documentTypeRepository->findOneBy(['documentTemplate' => $document->getTemplateId()]);

        if (!$documentType) {
            throw new FileGeneratorException("DocumentType с documentTemplate = {$document->getTemplateId()} не найден.");
        }

        return $this->printService->getHtml($document, $documentType, $specialist);
    }

    /**
     * @param DateTimeImmutable $date
     *
     * @return int
     */
    public function update(DateTimeImmutable $date): int
    {
        $versionNumbers = $this->productRepository->findAllIds();

        $this->repository->beginTransaction();

        $this->repository->deleteFromDate($date->setTime(0, 0));

        $processedDocumentsCount = 0;
        foreach ($versionNumbers as $versionNumber) {
            $documents = $this->crmApi->getDocuments([$versionNumber], $date);
            foreach ($documents as $document) {
                // Проверка на существование такого же документа.
                $existingDocument = $this->repository->findOneBy(['number' => $document->getNumber()->getValue()]);
                if ($existingDocument) {
                    continue;
                }

                $this->repository->save($document);
            }
            $processedDocumentsCount += count($documents);
        }

        $this->repository->commit();

        return $processedDocumentsCount;
    }

    /**
     * @param int $specialistId
     *
     * @throws Exception
     */
    public function updateForSpecialistId(int $specialistId): void
    {
        $specialist = $this->specialistRepository->find($specialistId);
        if (!$specialist) {
            throw new Exception("Специалист с ID {$specialistId} не найден в данном реестре.");
        }

        $documentsFromCrm = $this->crmApi->getDocumentsForSpecialistId($specialistId);
        $newDocuments = [];

        foreach ($documentsFromCrm as $documentFromCrm) {
            $existingDocument = $this->repository->findOneBy(['crmId' => $documentFromCrm->getCrmId()]);

            if (!$existingDocument) {
                $newDocuments[] = $documentFromCrm;
            }
        }

        if (!empty($newDocuments)) {
            $this->repository->beginTransaction();
            foreach ($newDocuments as $document) {
                $this->repository->save($document);
            }
            $this->repository->commit();
        }
    }

    /**
     * @param string $criteria
     *
     * @throws Exception
     */
    public function updateByCriteria(string $criteria): int
    {
        $documents = $this->repository->findIdsByCriteria($criteria);

        $this->repository->beginTransaction();

        foreach ($documents as $document) {
            $document = $this->repository->get($document['id']);
            $documentNumber = $document->getNumber()->getValue();
            $specialistId = $document->getSpecialistId();

            // Получаются все документы по специалисту, так как в CRM нет эндпоинта для получения документа по номеру.
            // После получения всех документов по специалисту, происходит поиск необходимого для обновления документа.
            $documentsFromCrm = $this->crmApi->getDocumentsForSpecialistId($specialistId);
            foreach ($documentsFromCrm as $documentFromCrm) {
                if ($documentFromCrm->getNumber()->getValue() != $documentNumber) {
                    continue;
                }

                // Заменяем существующий документ на обновленный и сохраняем.
                $updatedDocument = $this->updateDocumentsFields($document, $documentFromCrm);
                $this->repository->save($updatedDocument);
            }
        }

        $this->repository->commit();

        return count($documents);
    }

    /**
     * @param SpecialistDocument $documentToUpdate
     * @param SpecialistDocument $documentToGetValuesFrom
     *
     * @return SpecialistDocument
     */
    private function updateDocumentsFields(SpecialistDocument $documentToUpdate, SpecialistDocument $documentToGetValuesFrom): SpecialistDocument
    {
        $documentToUpdate->setName($documentToGetValuesFrom->getName());
        $documentToUpdate->setDisciplinesName($documentToGetValuesFrom->getDisciplinesName());
        $documentToUpdate->setTypeDocument($documentToGetValuesFrom->getTypeDocument());
        $documentToUpdate->setCrmId($documentToGetValuesFrom->getCrmId());
        $documentToUpdate->setTemplateId($documentToGetValuesFrom->getTemplateId());
        $documentToUpdate->setDate($documentToGetValuesFrom->getDate());
        $documentToUpdate->setEndDate($documentToGetValuesFrom->getEndDate());
        $documentToUpdate->setEduDateStart($documentToGetValuesFrom->getEduDateStart());
        $documentToUpdate->setEduDateEnd($documentToGetValuesFrom->getEduDateEnd());
        $documentToUpdate->setHours($documentToGetValuesFrom->getHours());

        return $documentToUpdate;
    }
}
