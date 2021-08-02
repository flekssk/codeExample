<?php

namespace App\Application\SpecialistDocument\Assembler;

use App\Application\SpecialistDocument\Dto\SpecialistDocumentShortDto;
use App\Domain\Entity\SpecialistDocument\SpecialistDocument;

/**
 * Interface SpecialistDocumentShortAssemblerInterface.
 */
interface SpecialistDocumentShortAssemblerInterface
{

    /**
     * @param SpecialistDocument $document
     * @return SpecialistDocumentShortDto
     */
    public function assemble(SpecialistDocument $document): SpecialistDocumentShortDto;
}
