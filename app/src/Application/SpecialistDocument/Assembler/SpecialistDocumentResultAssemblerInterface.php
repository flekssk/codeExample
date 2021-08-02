<?php

namespace App\Application\SpecialistDocument\Assembler;

use App\Application\SpecialistDocument\Dto\SpecialistDocumentResultDto;
use App\Domain\Entity\SpecialistDocument\SpecialistDocument;

/**
 * Interface SpecialistDocumentResultAssemblerInterface.
 */
interface SpecialistDocumentResultAssemblerInterface
{

    /**
     * @param SpecialistDocument $document
     * @return SpecialistDocumentResultDto
     */
    public function assemble(SpecialistDocument $document): SpecialistDocumentResultDto;
}
