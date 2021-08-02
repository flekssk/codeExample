<?php

declare(strict_types=1);

namespace App\Application\SpecialistExperience\Assembler;

use App\Application\SpecialistExperience\Dto\SpecialistExperienceUpdateDto;

/**
 * Interface SpecialistExperienceUpdateAssemblerInterface.
 *
 * @package App\Application\SpecialistExperience\Assembler
 */
interface SpecialistExperienceUpdateAssemblerInterface
{
    /**
     * @param array $options
     *
     * @return SpecialistExperienceUpdateDto
     */
    public function assemble(array $options): SpecialistExperienceUpdateDto;
}
