<?php

namespace App\Application\Specialist\Assembler;

use App\Domain\Entity\Specialist\Specialist;
use App\Application\Specialist\Dto\SpecialistAutocompleteDisplayDto;

/**
 * Interface SpecialistAutocompleteDisplayAssemblerInterface.
 */
interface SpecialistAutocompleteDisplayAssemblerInterface
{

    /**
     * @param Specialist $specialist
     * @return SpecialistAutocompleteDisplayDto
     */
    public function assemble(Specialist $specialist): SpecialistAutocompleteDisplayDto;
}
