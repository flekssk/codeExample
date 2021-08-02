<?php

declare(strict_types=1);

namespace App\Application\Specialist\Specialist\Resolver;

use App\Application\Specialist\Specialist\Dto\SpecialistUpdateDto;
use App\Domain\Entity\Specialist\Specialist;
use App\Domain\Repository\Specialist\SpecialistOccupationTypeRepositoryInterface;
use App\Domain\Repository\Specialist\SpecialistRepositoryInterface;
use App\Infrastructure\Persistence\Doctrine\Repository\Region\RegionRepository;
use App\Infrastructure\Persistence\Doctrine\Repository\SpecialistWorkSchedule\SpecialistWorkScheduleRepositoryInterface;

/**
 * Class SpecialistUpdateResolver.
 *
 * @package App\Application\Specialist\Specialist\Resolver
 */
class SpecialistUpdateResolver implements SpecialistUpdateResolverInterface
{
    /**
     * @var SpecialistRepositoryInterface
     */
    private SpecialistRepositoryInterface $specialistRepository;

    /**
     * @var RegionRepository
     */
    private RegionRepository $regionRepository;

    /**
     * @var SpecialistWorkScheduleRepositoryInterface
     */
    private SpecialistWorkScheduleRepositoryInterface $scheduleRepository;

    /**
     * @var SpecialistOccupationTypeRepositoryInterface
     */
    private SpecialistOccupationTypeRepositoryInterface $occupationTypeRepository;

    /**
     * SpecialistUpdateResolver constructor.
     *
     * @param SpecialistRepositoryInterface               $specialistRepository
     * @param RegionRepository                            $regionRepository
     * @param SpecialistWorkScheduleRepositoryInterface   $scheduleRepository
     * @param SpecialistOccupationTypeRepositoryInterface $occupationTypeRepository
     */
    public function __construct(
        SpecialistRepositoryInterface $specialistRepository,
        RegionRepository $regionRepository,
        SpecialistWorkScheduleRepositoryInterface $scheduleRepository,
        SpecialistOccupationTypeRepositoryInterface $occupationTypeRepository
    ) {
        $this->specialistRepository = $specialistRepository;
        $this->regionRepository = $regionRepository;
        $this->scheduleRepository = $scheduleRepository;
        $this->occupationTypeRepository = $occupationTypeRepository;
    }

    /**
     * @inheritDoc
     *
     * @psalm-suppress PossiblyNullArgument
     */
    public function resolve(SpecialistUpdateDto $dto): Specialist
    {
        $specialist = $this->specialistRepository->get($dto->id);

        return $specialist;
    }
}
