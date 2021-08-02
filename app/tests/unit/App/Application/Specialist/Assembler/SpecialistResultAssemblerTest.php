<?php

namespace App\Tests\unit\App\Application\Specialist\Assembler;

use App\Application\Position\Assembler\PositionResultAssembler;
use App\Application\Position\Dto\PositionResultDto;
use App\Application\Region\Assembler\RegionResultAssembler;
use App\Application\Specialist\Assembler\SpecialistResultAssembler;
use App\Application\Specialist\Dto\SpecialistResultDto;
use App\Application\Specialist\SpecialistOccupationType\Assembler\SpecialistOccupationTypeResultAssembler;
use App\Application\SpecialistWorkSchedule\Assembler\SpecialistWorkScheduleResultAssembler;
use App\Domain\Entity\Specialist\Specialist;
use App\Domain\Entity\Specialist\SpecialistOccupationType;
use App\Domain\Entity\Specialist\ValueObject\Status;
use App\Domain\Entity\SpecialistWorkSchedule\SpecialistWorkSchedule;
use App\Domain\Entity\ValueObject\Gender;
use Codeception\TestCase\Test;

/**
 * Class SpecialistResultAssemblerTest.
 *
 * @package App\Tests\unit\App\Application\Specialist\Assembler
 *
 * @covers  \App\Application\Specialist\Assembler\SpecialistResultAssembler
 */
class SpecialistResultAssemblerTest extends Test
{
    /**
     * @param int                      $id
     * @param string                   $firstName
     * @param string                   $secondName
     * @param string                   $middleName
     * @param string                   $company
     * @param Gender                   $gender
     * @param string                   $region
     * @param string                   $position
     * @param \DateTimeInterface       $dateOfBirth
     * @param Status                   $status
     *
     * @param SpecialistWorkSchedule   $schedule
     *
     * @param SpecialistOccupationType $employmentType
     *
     * @dataProvider specialistDataProvider
     */
    public function testAssemble(
        int $id,
        string $firstName,
        string $secondName,
        string $middleName,
        string $company,
        Gender $gender,
        string $region,
        string $position,
        \DateTimeInterface $dateOfBirth,
        Status $status,
        SpecialistWorkSchedule $schedule,
        SpecialistOccupationType $employmentType
    ): void {
        $regionResultAssembler = new RegionResultAssembler();
        $positionResultAssembler = new PositionResultAssembler();
        $scheduleResultAssembler = new SpecialistWorkScheduleResultAssembler();
        $employmentTypeAssembler = new SpecialistOccupationTypeResultAssembler();
        $specialistResultAssembler = new SpecialistResultAssembler(
            $regionResultAssembler,
            $positionResultAssembler,
            $scheduleResultAssembler,
            $employmentTypeAssembler
        );

        $specialist = $this->resolveSpecialist(
            $id,
            $firstName,
            $secondName,
            $middleName,
            $gender,
            $region,
            $dateOfBirth,
            $position,
            $status,
            $company,
            $schedule,
            $employmentType
        );

        $specialistResultDto = $specialistResultAssembler->assemble($specialist);

        $this->assertInstanceOf(SpecialistResultDto::class, $specialistResultDto);

        $this->assertEquals($id, $specialistResultDto->id);
        $this->assertEquals($firstName, $specialistResultDto->firstName);
        $this->assertEquals($secondName, $specialistResultDto->secondName);
        $this->assertEquals($middleName, $specialistResultDto->middleName);
        $this->assertEquals($region, $specialistResultDto->region);
        $this->assertEquals($status->getStatusId(), $specialistResultDto->status);
    }

    /**
     * @return array[]
     */
    public function specialistDataProvider(): array
    {
        $id = 1;
        $gender = new Gender(1);
        $dateOfBirth = new \DateTimeImmutable();

        $region = 'Москва';

        $position = 'test';

        $schedule = new SpecialistWorkSchedule();
        $schedule->setId(1);
        $schedule->setName('test');

        $status = new Status(1);

        $employmentType = new SpecialistOccupationType();
        $employmentType->setId(1);
        $employmentType->setName('test');

        return [
            [
                $id,
                'FirstName',
                'SecondName',
                'MiddleName',
                'company',
                $gender,
                $region,
                $position,
                $dateOfBirth,
                $status,
                $schedule,
                $employmentType,
            ],
        ];
    }

    /**
     * @param int                      $id
     * @param string                   $firstName
     * @param string                   $secondName
     * @param string                   $middleName
     * @param Gender                   $gender
     * @param string                   $region
     * @param \DateTimeInterface       $dateOfBirth
     * @param string                   $position
     * @param Status                   $status
     * @param string                   $company
     * @param SpecialistWorkSchedule   $schedule
     *
     * @param SpecialistOccupationType $employmentType
     *
     * @return Specialist
     */
    public function resolveSpecialist(
        int $id,
        string $firstName,
        string $secondName,
        string $middleName,
        Gender $gender,
        string $region,
        \DateTimeInterface $dateOfBirth,
        string $position,
        Status $status,
        string $company,
        SpecialistWorkSchedule $schedule,
        SpecialistOccupationType $employmentType
    ): Specialist {
        $specialist = new Specialist($id);
        $specialist->setFirstName($firstName);
        $specialist->setSecondName($secondName);
        $specialist->setMiddleName($middleName);
        $specialist->setGender($gender);
        $specialist->setRegion($region);
        $specialist->setDateOfBirth($dateOfBirth);
        $specialist->setPosition($position);
        $specialist->setStatus($status);
        $specialist->setCompany($company);
        $specialist->setSchedule($schedule);
        $specialist->setEmploymentType($employmentType);

        return $specialist;
    }
}
