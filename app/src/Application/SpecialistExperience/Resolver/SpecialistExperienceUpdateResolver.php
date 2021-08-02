<?php

declare(strict_types=1);

namespace App\Application\SpecialistExperience\Resolver;

use App\Application\SpecialistExperience\Dto\SpecialistExperienceUpdateDto;
use App\Domain\Entity\SpecialistExperience\SpecialistExperience;
use App\Domain\Repository\SpecialistExperience\SpecialistExperienceRepositoryInterface;

/**
 * Class SpecialistExperienceUpdateResolver.
 *
 * @package App\Application\SpecialistExperience\Resolver
 */
class SpecialistExperienceUpdateResolver implements SpecialistExperienceUpdateResolverInterface
{
    /**
     * @var SpecialistExperienceRepositoryInterface
     */
    private SpecialistExperienceRepositoryInterface $specialistExperienceRepository;

    /**
     * SpecialistExperienceUpdateResolver constructor.
     *
     * @param SpecialistExperienceRepositoryInterface $specialistExperienceRepository
     */
    public function __construct(SpecialistExperienceRepositoryInterface $specialistExperienceRepository)
    {
        $this->specialistExperienceRepository = $specialistExperienceRepository;
    }

    /**
     * @inheritDoc
     *
     * @psalm-suppress PossiblyNullArgument
     */
    public function resolve(SpecialistExperienceUpdateDto $dto): SpecialistExperience
    {
        $specialistExperience = $this->specialistExperienceRepository->get($dto->id);
        $specialistExperience->setCompany($dto->company);
        $specialistExperience->setStartDate($dto->startDate);
        $specialistExperience->setEndDate($dto->endDate);

        return $specialistExperience;
    }
}
