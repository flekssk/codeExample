<?php

namespace App\Tests\unit\App\Infrastructure\HttpClients\SchoolProgram\Assembler;

use App\Infrastructure\HttpClients\SchoolProgram\Assembler\SchoolProgramFinishedResponseAssembler;
use App\Infrastructure\HttpClients\SchoolProgram\Dto\SchoolProgramFinishedResponseDto;
use Codeception\TestCase\Test;
use DateTimeImmutable;
use Exception;
use stdClass;

/**
 * Class SchoolProgramFinishedResponseAssemblerTest.
 *
 * @package App\Tests\unit\App\Infrastructure\HttpClients\SchoolProgram\Assembler
 *
 * @covers \App\Infrastructure\HttpClients\SchoolProgram\Assembler\SchoolProgramFinishedResponseAssembler
 */
class SchoolProgramFinishedResponseAssemblerTest extends Test
{
    /**
     * @param object $object
     *
     * @dataProvider defaultDataProvider
     *
     * @throws Exception
     */
    public function testAssemble(object $object): void
    {
        $assembler = new SchoolProgramFinishedResponseAssembler();

        $dto = $assembler->assemble($object);

        $this->assertInstanceOf(SchoolProgramFinishedResponseDto::class, $dto);
        $this->assertEquals($object->programId, $dto->programId);
        $this->assertEquals($object->programTitle, $dto->programTitle);
        $this->assertEquals($object->programPost, $dto->programPost);
        $this->assertEquals(new DateTimeImmutable($object->programDateStart), new DateTimeImmutable($dto->programDateStart));
        $this->assertEquals(new DateTimeImmutable($object->programDateEnd), new DateTimeImmutable($dto->programDateEnd));
        $this->assertEquals($object->programProgress, $dto->programProgress);
    }

    /**
     * @return array
     */
    public function defaultDataProvider(): array
    {
        $object1 = new stdClass();
        $object1->programId = 183456;
        $object1->programTitle = 'Ведение учета на малом предприятии';
        $object1->programPost = 'Актуально сейчас';
        $object1->programDateStart = '2017-12-01T00:00:00';
        $object1->programDateEnd = '2018-02-28T00:00:00';
        $object1->programProgress = 1;

        $object2 = new stdClass();
        $object2->programId = 197891;
        $object2->programTitle = 'Всероссийская аттестация главбухов на УСН-2021';
        $object2->programPost = 'Актуально сейчас';
        $object2->programDateStart = '2021-02-15T00:00:00';
        $object2->programDateEnd = '2021-05-14T00:00:00';
        $object2->programProgress = 0.4;

        return [
            [
                $object1
            ],
            [
                $object2
            ],
        ];
    }
}
