<?php

declare(strict_types=1);

namespace App\Application\RegulatoryDocuments\Assembler;

use App\Domain\Entity\RegulatoryDocuments\RegulatoryDocuments;
use App\Application\RegulatoryDocuments\Dto\RegulatoryDocumentsDto;

/**
 * Class RegulatoryDocumentsAssembler.
 *
 * @package \App\Application\RegulatoryDocuments\Assembler
 */
class RegulatoryDocumentsAssembler
{

    /**
     * @param RegulatoryDocuments $regulatoryDocument
     * @return RegulatoryDocumentsDto
     */
    public function assemble(RegulatoryDocuments $regulatoryDocument): RegulatoryDocumentsDto
    {
        $dto = new RegulatoryDocumentsDto();
        $dto->title = $regulatoryDocument->getTitle();
        $dto->url = $regulatoryDocument->getUrl();

        return $dto;
    }
}
