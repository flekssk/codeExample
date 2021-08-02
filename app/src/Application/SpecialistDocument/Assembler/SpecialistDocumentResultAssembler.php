<?php

namespace App\Application\SpecialistDocument\Assembler;

use App\Domain\Entity\DocumentType\DocumentType;
use App\Domain\Entity\SpecialistDocument\SpecialistDocument;
use App\Application\SpecialistDocument\Dto\SpecialistDocumentResultDto;
use App\Domain\Repository\DocumentType\DocumentTypeRepositoryInterface;

/**
 * Class SpecialistDocumentResultAssembler.
 */
class SpecialistDocumentResultAssembler implements SpecialistDocumentResultAssemblerInterface
{

    /**
     * @var DocumentTypeRepositoryInterface
     */
    private DocumentTypeRepositoryInterface $documentTypeRepository;

    /**
     * SpecialistDocumentResultAssembler constructor.
     *
     * @param DocumentTypeRepositoryInterface $documentTypeRepository
     */
    public function __construct(DocumentTypeRepositoryInterface $documentTypeRepository)
    {
        $this->documentTypeRepository = $documentTypeRepository;
    }

    /**
     * @inheritDoc
     */
    public function assemble(SpecialistDocument $document): SpecialistDocumentResultDto
    {
        /** @var DocumentType $documentType */
        $documentType = $this->documentTypeRepository->findOneBy(['documentTemplate' => $document->getTemplateId()]);

        $previewUrl = '';
        if ($documentType->getImagePreview()) {
            $previewUrl = $documentType->getImagePreview();
        }

        $trimmedPreviewUrl = trim($previewUrl, '/');

        $dto = new SpecialistDocumentResultDto();
        $dto->id = $document->getId();
        $dto->name = $document->getName();
        $dto->disciplinesName = $document->getDisciplinesName();
        $dto->number = $document->getNumber()->getValue();
        $dto->specialistId = $document->getSpecialistId();
        $dto->pdfUrl = '';
        $dto->imageUrl = "/document/{$document->getId()}.png";
        $dto->previewUrl = $trimmedPreviewUrl ? "/{$trimmedPreviewUrl}" : '';

        return $dto;
    }
}
