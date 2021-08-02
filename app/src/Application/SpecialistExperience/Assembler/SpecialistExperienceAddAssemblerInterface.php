<?php

declare(strict_types=1);

namespace App\Application\SpecialistExperience\Assembler;

use App\Application\SpecialistExperience\Dto\SpecialistExperienceAddDto;

/**
 * Interface SpecialistExperienceAddAssemblerInterface.
 *
 * @package App\Application\SpecialistExperience\Assembler
 */
interface SpecialistExperienceAddAssemblerInterface
{
    /**
     * @param array $options
     *
     * @return SpecialistExperienceAddDto
     */
    public function assemble(array $options): SpecialistExperienceAddDto;
}
