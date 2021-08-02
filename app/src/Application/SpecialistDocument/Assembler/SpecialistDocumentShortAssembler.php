<?php

namespace App\Application\SpecialistDocument\Assembler;

use App\Domain\Entity\SpecialistDocument\SpecialistDocument;
use App\Application\SpecialistDocument\Dto\SpecialistDocumentShortDto;

/**
 * Class SpecialistDocumentShortAssembler.
 */
class SpecialistDocumentShortAssembler implements SpecialistDocumentShortAssemblerInterface
{
    /**
     * @inheritDoc
     */
    public function assemble(SpecialistDocument $document): SpecialistDocumentShortDto
    {
        $dto = new SpecialistDocumentShortDto();
        $dto->id = $document->getId();
        $dto->name = $document->getName();
        $dto->number = $document->getNumber()->getValue();
        $dto->endDate = $document->getEndDate()->format('Y-m-d');

        return $dto;
    }
}
