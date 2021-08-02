<?php

declare(strict_types=1);

namespace App\Application\SpecialistExperience\Assembler;

use App\Domain\Entity\SpecialistExperience\SpecialistExperience;
use App\Infrastructure\Persistence\Doctrine\Repository\SpecialistExperience\SpecialistExperienceRepository;
use App\Application\SpecialistExperience\Dto\SpecialistExperienceResultDto;

/**
 * Class SpecialistExperienceResponseAssembler.
 *
 * @package \App\Application\SpecialistExperience\Assembler
 */
class SpecialistExperienceResultAssembler
{
    /**
     * @var SpecialistExperienceRepository
     */
    private SpecialistExperienceRepository $specialistExperienceRepository;

    public function __construct(SpecialistExperienceRepository $specialistExperienceRepository)
    {
        $this->specialistExperienceRepository = $specialistExperienceRepository;
    }

    /**
     * @param SpecialistExperience $specialistExperience
     *
     * @return SpecialistExperienceResultDto
     */
    public function assemble(SpecialistExperience $specialistExperience): SpecialistExperienceResultDto
    {
        $dto = new SpecialistExperienceResultDto();
        $dto->id = $specialistExperience->getId();
        $dto->specialistId = $specialistExperience->getSpecialistId();
        $dto->company = $specialistExperience->getCompany();
        $dto->startDate = $specialistExperience->getStartDate()->format('Y-m-d');
        $dto->endDate = $specialistExperience->getEndDate() ? $specialistExperience->getEndDate()->format('Y-m-d') : null;

        return $dto;
    }
}
