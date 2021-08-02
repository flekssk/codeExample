<?php

declare(strict_types=1);

namespace App\Application\SpecialistExperience\Resolver;

use App\Application\Exception\ValidationException;
use App\Application\SpecialistExperience\Dto\SpecialistExperienceUpdateDto;
use App\Domain\Entity\SpecialistExperience\SpecialistExperience;

/**
 * Interface SpecialistExperienceUpdateResolverInterface.
 *
 * @package App\Application\SpecialistExperience\Resolver
 */
interface SpecialistExperienceUpdateResolverInterface
{
    /**
     * @param SpecialistExperienceUpdateDto $dto
     *
     * @return SpecialistExperience
     *
     * @throws ValidationException
     */
    public function resolve(SpecialistExperienceUpdateDto $dto): SpecialistExperience;
}
