<?php

declare(strict_types=1);

namespace App\Application\SpecialistExperience\Resolver;

use App\Application\SpecialistExperience\Dto\SpecialistExperienceAddDto;
use App\Domain\Entity\SpecialistExperience\SpecialistExperience;

/**
 * Class SpecialistExperienceAddResolver.
 *
 * @package App\Application\SpecialistExperience\Resolver
 */
class SpecialistExperienceAddResolver implements SpecialistExperienceAddResolverInterface
{
    /**
     * @inheritDoc
     *
     * @psalm-suppress PossiblyNullArgument
     * Аннотация "psalm-suppress" здесь добавлена, так как psalm не понимает что проверка на null аргументы происходит
     * в начале функции.
     */
    public function resolve(SpecialistExperienceAddDto $dto): SpecialistExperience
    {
        $specialistExperience = new SpecialistExperience();
        $specialistExperience->setSpecialistId($dto->specialistId);
        $specialistExperience->setCompany($dto->company);
        $specialistExperience->setStartDate($dto->startDate);
        $specialistExperience->setEndDate($dto->endDate);

        return $specialistExperience;
    }
}
