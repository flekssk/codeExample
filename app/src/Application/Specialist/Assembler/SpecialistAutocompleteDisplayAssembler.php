<?php

namespace App\Application\Specialist\Assembler;

use App\Domain\Entity\Specialist\Specialist;
use App\Application\Specialist\Dto\SpecialistAutocompleteDisplayDto;
use App\Application\Specialist\Assembler\SpecialistAutocompleteDisplayAssemblerInterface;

/**
 * Class SpecialistAutocompleteDisplayAssembler.
 */
class SpecialistAutocompleteDisplayAssembler implements SpecialistAutocompleteDisplayAssemblerInterface
{

    /**
     * @inheritdoc
     */
    public function assemble(Specialist $specialist): SpecialistAutocompleteDisplayDto
    {
        $dto = new SpecialistAutocompleteDisplayDto();

        $dto->id = $specialist->getId();
        $dto->firstName = $specialist->getFirstName();
        $dto->secondName = $specialist->getSecondName();
        $dto->middleName = $specialist->getMiddleName();
        $dto->status = $specialist->getStatus()->getStatusId();

        return $dto;
    }
}
