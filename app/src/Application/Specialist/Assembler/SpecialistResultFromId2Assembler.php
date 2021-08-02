<?php

namespace App\Application\Specialist\Assembler;

use App\Application\Specialist\Dto\SpecialistResultDto;
use App\Domain\Entity\Specialist\ValueObject\Status;
use App\Domain\Repository\Region\RegionRepositoryInterface;
use App\Infrastructure\HttpClients\Id2\Dto\Id2UserDto;

/**
 * Class SpecialistResultFromId2Assembler.
 *
 * @package App\Application\Specialist\Assembler
 */
class SpecialistResultFromId2Assembler implements SpecialistResultFromId2AssemblerInterface
{
    /**
     * @var RegionRepositoryInterface
     */
    private RegionRepositoryInterface $regionRepository;

    /**
     * SpecialistResultFromId2Assembler constructor.
     *
     * @param RegionRepositoryInterface $regionRepository
     */
    public function __construct(RegionRepositoryInterface $regionRepository)
    {
        $this->regionRepository = $regionRepository;
    }

    /**
     * @inheritDoc
     */
    public function assemble(Id2UserDto $userGetResponse): SpecialistResultDto
    {
        $dto = new SpecialistResultDto();

        $dto->firstName = $userGetResponse->firstName;
        $dto->middleName = $userGetResponse->middleName;
        $dto->secondName = $userGetResponse->secondName;
        $dto->id2Position = $userGetResponse->position;
        $dto->id = $userGetResponse->id;
        $dto->gender = $userGetResponse->gender;
        $dto->birthDate = $userGetResponse->birthDate ? $userGetResponse->birthDate->format('Y-m-d') : null;
        $dto->company = $userGetResponse->company;

        $region = null;
        if ($userGetResponse->region) {
            $regionEntity = $this->regionRepository->find($userGetResponse->region);

            if ($regionEntity) {
                $region = $regionEntity->getName();
            }
        }

        $dto->region = $region;
        $dto->document = null;
        $dto->status = Status::STATUS_NOT_IN_REGISTRY;
        $dto->imageUrl = $userGetResponse->avatar;
        $dto->workSchedule = null;
        $dto->employmentType = null;
        $dto->viewCount = 0;

        return $dto;
    }
}
