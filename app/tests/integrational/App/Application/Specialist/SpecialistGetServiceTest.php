<?php

namespace App\Tests\integrational\App\Application\Specialist;

use App\Application\Position\Assembler\PositionResultAssembler;
use App\Application\Region\Assembler\RegionResultAssembler;
use App\Application\Specialist\Assembler\SpecialistResultAssembler;
use App\Application\Specialist\Assembler\SpecialistResultFromId2Assembler;
use App\Application\Specialist\SpecialistGet\SpecialistGetService;
use App\Application\Specialist\SpecialistOccupationType\Assembler\SpecialistOccupationTypeResultAssembler;
use App\Application\SpecialistDocument\SpecialistDocumentService;
use App\Application\SpecialistWorkSchedule\Assembler\SpecialistWorkScheduleResultAssembler;
use App\Domain\Repository\NotFoundException;
use App\Infrastructure\HttpClients\Id2\Assembler\Id2UserAssembler;
use App\Infrastructure\HttpClients\Id2\Id2ClientDummy;
use App\Infrastructure\HttpClients\Id2\Id2UserService;
use App\Infrastructure\Persistence\Doctrine\Repository\Specialist\SpecialistRepository;
use Codeception\TestCase\Test;

class SpecialistGetServiceTest extends Test
{

    /**
     * @dataProvider correctIdDataProvider
     *
     * @param int $id
     * @skip
     */
    public function testGetUserWithCorrectId(int $id): void
    {
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
        $id2Client = new Id2ClientDummy();
        $id2UserResponseAssembler = new Id2UserAssembler('https://test.ru/');
        $id2Service = new Id2UserService($id2Client, $id2UserResponseAssembler);
        $specialistResultForId2Assembler = new SpecialistResultFromId2Assembler();
        $service = new SpecialistGetService(
            $this->getRepository(),
            $specialistResultAssembler,
            $id2Service,
            $specialistResultForId2Assembler
        );

        $resultDto = $service->get($id);

        $this->assertEquals($id, $resultDto->id);
    }

    /**
     * @dataProvider incorrectIdDataProvider
     *
     * @param int $id
     * @skip
     */
    public function testGetUserWithIncorrectIdShouldThrow404(int $id): void
    {
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
        $id2Client = new Id2ClientDummy();
        $id2UserResponseAssembler = new Id2UserAssembler('https://test.ru/');
        $id2Service = new Id2UserService($id2Client, $id2UserResponseAssembler);
        $specialistResultForId2Assembler = new SpecialistResultFromId2Assembler();
        $service = new SpecialistGetService(
            $this->getRepository(),
            $specialistResultAssembler,
            $id2Service,
            $specialistResultForId2Assembler
        );

        $this->expectException(NotFoundException::class);

        $service->get($id);
    }

    public function getRepository(): SpecialistRepository
    {
        /** @var \Codeception\Module\Symfony $module */
        /** @noinspection PhpUnhandledExceptionInspection */
        $module = $this->getModule('Symfony');
        $container = $module->kernel->getContainer();

        return $container->get(SpecialistRepository::class);
    }


    /**
     * @return array|int[][]
     */
    public function correctIdDataProvider(): array
    {
        return [
            [
                1,
            ],
        ];
    }

    /**
     * @return array|int[][]
     */
    public function incorrectIdDataProvider(): array
    {
        return [
            [
                11111,
            ],
        ];
    }
}
