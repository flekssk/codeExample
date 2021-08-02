<?php

declare(strict_types=1);

namespace App\Application\Specialist\Assembler;

use App\Application\Position\Assembler\PositionResultAssembler;
use App\Application\Region\Assembler\RegionResultAssemblerInterface;
use App\Application\Specialist\Dto\SpecialistResultDto;
use App\Application\Specialist\SpecialistOccupationType\Assembler\SpecialistOccupationTypeResultAssembler;
use App\Application\SpecialistWorkSchedule\Assembler\SpecialistWorkScheduleResultAssembler;
use App\Domain\Entity\Specialist\Specialist;

/**
 * Class SpecialistResultAssembler.
 *
 * @package App\Application\Specialist\Assembler
 */
class SpecialistResultAssembler implements SpecialistResultAssemblerInterface
{
    /**
     * @var RegionResultAssemblerInterface
     */
    private RegionResultAssemblerInterface $regionAssembler;

    /**
     * @var PositionResultAssembler
     */
    private PositionResultAssembler $positionAssembler;

    /**
     * @var SpecialistWorkScheduleResultAssembler
     */
    private SpecialistWorkScheduleResultAssembler $specialistWorkScheduleResultAssembler;

    /**
     * @var SpecialistOccupationTypeResultAssembler
     */
    private SpecialistOccupationTypeResultAssembler $occupationTypeResultAssembler;

    /**
     * SpecialistResultAssembler constructor.
     *
     * @param RegionResultAssemblerInterface          $regionAssembler
     * @param PositionResultAssembler                 $positionAssembler
     * @param SpecialistWorkScheduleResultAssembler   $specialistWorkScheduleResultAssembler
     * @param SpecialistOccupationTypeResultAssembler $occupationTypeResultAssembler
     */
    public function __construct(
        RegionResultAssemblerInterface $regionAssembler,
        PositionResultAssembler $positionAssembler,
        SpecialistWorkScheduleResultAssembler $specialistWorkScheduleResultAssembler,
        SpecialistOccupationTypeResultAssembler $occupationTypeResultAssembler
    ) {
        $this->regionAssembler = $regionAssembler;
        $this->positionAssembler = $positionAssembler;
        $this->specialistWorkScheduleResultAssembler = $specialistWorkScheduleResultAssembler;
        $this->occupationTypeResultAssembler = $occupationTypeResultAssembler;
    }

    /**
     * @inheritDoc
     */
    public function assemble(Specialist $specialist): SpecialistResultDto
    {
        $dto = new SpecialistResultDto();

        $dto->id = $specialist->getId();
        $dto->firstName = $specialist->getFirstName();
        $dto->secondName = $specialist->getSecondName();
        $dto->middleName = $specialist->getMiddleName();
        $dto->company = $specialist->getCompany();

        $specialistRegion = $specialist->getRegion();
        $region = null;
        if (!is_null($specialistRegion)) {
            $region = $specialistRegion;
        }
        $dto->region = $region;

        $dto->document = null;

        $dto->status = $specialist->getStatus()->getStatusId();

        // Если URL абсолютный - ничего не делать. Если относительный и без '/' в начале - добавить '/'.
        $imageUrl = $specialist->getAvatar();
        if ($imageUrl && !filter_var($imageUrl, FILTER_VALIDATE_URL) && strpos($imageUrl, '/') !== 0) {
            $imageUrl = '/' . $imageUrl;
        }

        $dto->imageUrl = $imageUrl;
        $dto->gender = $specialist->getGender();
        $dto->birthDate = $specialist->getDateOfBirth() ? $specialist->getDateOfBirth()->format('Y-m-d') : null;
        $dto->id2Position = (string) $specialist->getId2Position();
        $dto->workSchedule = $specialist->getSchedule() ? $this->specialistWorkScheduleResultAssembler->assemble(
            $specialist->getSchedule()
        ) : null;
        $dto->employmentType = $specialist->getEmploymentType() ? $this->occupationTypeResultAssembler->assemble(
            $specialist->getEmploymentType()
        ) : null;
        $dto->viewCount = $specialist->getViewCount();

        return $dto;
    }
}
