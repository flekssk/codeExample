<?php

namespace App\Tests\unit\App\Application\Specialist\Assembler;

use App\Application\Position\Assembler\PositionResultAssembler;
use App\Application\Region\Assembler\RegionResultAssembler;
use App\Application\Specialist\Assembler\SpecialistPaginatedListResultAssembler;
use App\Application\Specialist\Assembler\SpecialistResultAssembler;
use App\Application\Specialist\Dto\SpecialistPaginatedListResultDto;
use App\Application\Specialist\SpecialistOccupationType\Assembler\SpecialistOccupationTypeResultAssembler;
use App\Application\SpecialistWorkSchedule\Assembler\SpecialistWorkScheduleResultAssembler;
use App\Domain\Entity\Region\Region;
use App\Domain\Entity\Specialist\Specialist;
use App\Domain\Entity\Specialist\SpecialistOccupationType;
use App\Domain\Entity\Specialist\ValueObject\Status;
use App\Domain\Entity\SpecialistWorkSchedule\SpecialistWorkSchedule;
use App\Domain\Entity\ValueObject\Gender;
use Codeception\TestCase\Test;

/**
 * Class SpecialistPaginatedListResultAssemblerTest
 *
 * @package App\Tests\unit\App\Application\Specialist\Assembler
 *
 * @covers \App\Application\Specialist\Assembler\SpecialistPaginatedListResultAssembler
 */
class SpecialistPaginatedListResultAssemblerTest extends Test
{
    /**
     * @param int                      $id
     *
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
        $assembler = new SpecialistPaginatedListResultAssembler($specialistResultAssembler);

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

        $specialists = [$specialist];
        $page = 1;
        $perPage = 1;
        $totalCount = 1;

        $specialistPaginatedResultDto = $assembler->assemble($specialists, $page, $perPage, $totalCount);

        $this->assertInstanceOf(SpecialistPaginatedListResultDto::class, $specialistPaginatedResultDto);

        $this->assertIsArray($specialistPaginatedResultDto->specialists);
        $this->assertArrayHasKey(0, $specialistPaginatedResultDto->specialists);
        $this->assertCount(1, $specialistPaginatedResultDto->specialists);
        $this->assertEquals($page, $specialistPaginatedResultDto->page);
        $this->assertEquals($perPage, $specialistPaginatedResultDto->perPage);
        $this->assertEquals($totalCount, $specialistPaginatedResultDto->totalCount);
    }

    /**
     * @return array[]
     */
    public function specialistDataProvider()
    {
        $id = 1;
        $gender = new Gender(1);
        $dateOfBirth = new \DateTimeImmutable();

        $region = 'Москва';

        $position = 'test';

        $schedule = new SpecialistWorkSchedule();
        $schedule->setId(1);
        $schedule->setName('test');

        $employmentType = new SpecialistOccupationType();
        $employmentType->setId(1);
        $employmentType->setName('test');

        $status = new Status(1);

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
