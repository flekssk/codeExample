<?php

declare(strict_types=1);

namespace App\Application\Specialist\Specialist\Resolver;

use App\Application\Specialist\Specialist\Dto\SpecialistAddDto;
use App\Domain\Entity\Specialist\Specialist;
use App\Domain\Entity\Specialist\ValueObject\Status;
use App\Domain\Repository\Position\PositionRepositoryInterface;
use App\Domain\Repository\Region\RegionRepositoryInterface;
use App\Domain\Repository\Specialist\SpecialistOccupationTypeRepositoryInterface;
use App\Infrastructure\HttpClients\Id2\Id2UserServiceInterface;
use App\Infrastructure\Persistence\Doctrine\Repository\SpecialistWorkSchedule\SpecialistWorkScheduleRepositoryInterface;
use DateTimeImmutable;

/**
 * Class SpecialistAddResolver.
 *
 * @package App\Application\Specialist\Specialist\Resolver
 */
class SpecialistAddResolver implements SpecialistAddResolverInterface
{
    /**
     * @var SpecialistWorkScheduleRepositoryInterface
     */
    private SpecialistWorkScheduleRepositoryInterface $scheduleRepository;

    /**
     * @var SpecialistOccupationTypeRepositoryInterface
     */
    private SpecialistOccupationTypeRepositoryInterface $occupationTypeRepository;

    /** @var Id2UserServiceInterface */
    private Id2UserServiceInterface $id2UserService;

    /** @var PositionRepositoryInterface */
    private PositionRepositoryInterface $positionRepository;

    /**
     * @var RegionRepositoryInterface
     */
    private RegionRepositoryInterface $regionRepository;

    /**
     * SpecialistAddResolver constructor.
     *
     * @param SpecialistWorkScheduleRepositoryInterface   $scheduleRepository
     * @param SpecialistOccupationTypeRepositoryInterface $occupationTypeRepository
     * @param Id2UserServiceInterface                     $id2UserService
     * @param PositionRepositoryInterface                 $positionRepository
     * @param RegionRepositoryInterface                   $regionRepository
     */
    public function __construct(
        SpecialistWorkScheduleRepositoryInterface $scheduleRepository,
        SpecialistOccupationTypeRepositoryInterface $occupationTypeRepository,
        Id2UserServiceInterface $id2UserService,
        PositionRepositoryInterface $positionRepository,
        RegionRepositoryInterface $regionRepository
    ) {
        $this->id2UserService = $id2UserService;
        $this->regionRepository = $regionRepository;
    }

    /**
     * @inheritDoc
     */
    public function resolve(SpecialistAddDto $dto): Specialist
    {
        $id2UserDto = $this->id2UserService->getUserById($dto->id);

        $specialist = new Specialist($dto->id);
        $specialist->setFirstName($id2UserDto->firstName);
        $specialist->setMiddleName($id2UserDto->middleName);
        $specialist->setSecondName($id2UserDto->secondName);
        $specialist->setGender($id2UserDto->gender);

        $region = null;
        if ($id2UserDto->region) {
            $regionEntity = $this->regionRepository->find($id2UserDto->region);

            if ($regionEntity) {
                $region = $regionEntity->getName();
            }
        }

        $specialist->setRegion($region);
        $specialist->setDateOfBirth($id2UserDto->birthDate);
        $specialist->setId2Position($id2UserDto->position);
        $specialist->setAvatar($id2UserDto->avatar);
        $specialist->setCreatedAt(new DateTimeImmutable());
        $specialist->setStatus(new Status(Status::STATUS_CERTIFICATION_REQUIRED));
        $specialist->setCompany($id2UserDto->company);
        $specialist->setDateCheckAccess(null);

        return $specialist;
    }
}
