<?php

declare(strict_types=1);

namespace App\Application\SpecialistExperience\Resolver;

use App\Application\Exception\ValidationException;
use App\Application\SpecialistExperience\Dto\SpecialistExperienceAddDto;
use App\Domain\Entity\SpecialistExperience\SpecialistExperience;

/**
 * Interface SpecialistExperienceAddResolverInterface.
 *
 * @package App\Application\SpecialistExperience\Resolver
 */
interface SpecialistExperienceAddResolverInterface
{
    /**
     * @param SpecialistExperienceAddDto $dto
     *
     * @return SpecialistExperience
     *
     * @throws ValidationException
     */
    public function resolve(SpecialistExperienceAddDto $dto): SpecialistExperience;
}
