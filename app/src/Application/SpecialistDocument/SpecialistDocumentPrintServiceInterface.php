<?php

namespace App\Application\SpecialistDocument;

use App\Application\FileGenerator\Exception\FileGeneratorException;
use App\Domain\Entity\DocumentType\DocumentType;
use App\Domain\Entity\Specialist\Specialist;
use App\Domain\Entity\SpecialistDocument\SpecialistDocument;

interface SpecialistDocumentPrintServiceInterface
{
    /**
     * @param SpecialistDocument $document
     * @param DocumentType $documentType
     * @param Specialist $specialist
     *
     * @return \SplFileInfo
     *
     * @throws FileGeneratorException
     */
    public function getPicture(SpecialistDocument $document, DocumentType $documentType, Specialist $specialist): \SplFileInfo;

    /**
     * @param SpecialistDocument $document
     * @param DocumentType $documentType
     * @param Specialist $specialist
     * @return string
     */
    public function getHtml(SpecialistDocument $document, DocumentType $documentType, Specialist $specialist): string;
}
