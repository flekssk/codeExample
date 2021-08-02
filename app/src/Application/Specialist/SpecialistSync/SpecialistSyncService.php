<?php

namespace App\Application\Specialist\SpecialistSync;

use App\Domain\Repository\NotFoundException;
use App\Domain\Repository\Region\RegionRepositoryInterface;
use App\Domain\Repository\Specialist\SpecialistRepositoryInterface;
use App\Domain\Service\Specialist\SpecialistStatusCalcService;
use App\Infrastructure\HttpClients\Id2\Id2UserServiceInterface;

/**
 * Class SpecialistSyncService.
 *
 * @package App\Application\Specialist\SpecialistSync
 */
class SpecialistSyncService
{
    /**
     * @var Id2UserServiceInterface
     */
    private Id2UserServiceInterface $id2ApiClient;

    /**
     * @var SpecialistRepositoryInterface
     */
    private SpecialistRepositoryInterface $specialistRepository;

    /**
     * @var SpecialistStatusCalcService
     */
    private SpecialistStatusCalcService $calcService;

    /**
     * @var RegionRepositoryInterface
     */
    private RegionRepositoryInterface $regionRepository;

    /**
     * SpecialistSyncService constructor.
     *
     * @param Id2UserServiceInterface $id2UserService
     * @param SpecialistRepositoryInterface $specialistRepository
     * @param SpecialistStatusCalcService $calcService
     * @param RegionRepositoryInterface $regionRepository
     */
    public function __construct(
        Id2UserServiceInterface $id2UserService,
        SpecialistRepositoryInterface $specialistRepository,
        SpecialistStatusCalcService $calcService,
        RegionRepositoryInterface $regionRepository
    ) {
        $this->id2ApiClient = $id2UserService;
        $this->specialistRepository = $specialistRepository;
        $this->calcService = $calcService;
        $this->regionRepository = $regionRepository;
    }

    /**
     * Синхронизирует специалиста с пользователем id2.
     *
     * @param int $id
     */
    public function syncUserWithId2ById(int $id): void
    {
        if (!$this->specialistRepository->has($id)) {
            throw new NotFoundException("Пользователь с id {$id} не найден", 404);
        }

        $id2UserDto = $this->id2ApiClient->getUserById($id);

        $specialist = $this->specialistRepository->get($id2UserDto->id);

        $specialist->setFirstName($id2UserDto->firstName);
        $specialist->setSecondName($id2UserDto->secondName);
        $specialist->setMiddleName($id2UserDto->middleName);
        $specialist->setGender($id2UserDto->gender);
        $specialist->setDateOfBirth($id2UserDto->birthDate);
        $specialist->setId2Position($id2UserDto->position);

        $originalPosition = $specialist->getPosition();
        if (!$originalPosition) {
            $specialist->setPosition($id2UserDto->position);
        }

        $specialist->setAvatar($id2UserDto->avatar);
        $specialist->setCompany($id2UserDto->company);

        $region = null;
        if ($id2UserDto->region) {
            $regionEntity = $this->regionRepository->find($id2UserDto->region);

            if ($regionEntity) {
                $region = $regionEntity->getName();
            }
        }
        $specialist->setRegion($region);

        $this->specialistRepository->save($specialist);

        $this->calcService->calcStatus($specialist);
    }
}
