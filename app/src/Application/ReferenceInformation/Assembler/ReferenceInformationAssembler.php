<?php

declare(strict_types=1);

namespace App\Application\ReferenceInformation\Assembler;

use App\Domain\Entity\ReferenceInformation\ReferenceInformation;
use App\Application\ReferenceInformation\Dto\ReferenceInformationDto;

/**
 * Class ReferenceInformationAssembler.
 *
 * @package \App\Application\ReferenceInformation\Assembler
 */
class ReferenceInformationAssembler
{

    /**
     * @param ReferenceInformation $regulatoryDocument
     * @return ReferenceInformationDto
     */
    public function assemble(ReferenceInformation $regulatoryDocument): ReferenceInformationDto
    {
        $dto = new ReferenceInformationDto();
        $dto->title = $regulatoryDocument->getTitle();
        $dto->url = $regulatoryDocument->getUrl();

        return $dto;
    }
}
