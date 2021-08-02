<?php

namespace App\Tests\unit\App\Infrastructure\HttpClients\SchoolProgram\Assembler;

use App\Infrastructure\HttpClients\SchoolProgram\Assembler\SchoolProgramResponseAssembler;
use App\Infrastructure\HttpClients\SchoolProgram\Dto\SchoolProgramResponseDto;
use Codeception\TestCase\Test;
use Exception;
use stdClass;

/**
 * Class SchoolProgramResponseAssemblerTest.
 *
 * @package App\Tests\unit\App\Infrastructure\HttpClients\SchoolProgram\Assembler
 *
 * @covers \App\Infrastructure\HttpClients\SchoolProgram\Assembler\SchoolProgramResponseAssembler
 */
class SchoolProgramResponseAssemblerTest extends Test
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
        $assembler = new SchoolProgramResponseAssembler();

        $dto = $assembler->assemble($object);

        $this->assertInstanceOf(SchoolProgramResponseDto::class, $dto);
        $this->assertEquals($object->programId, $dto->programId);
        $this->assertEquals($object->programTitle, $dto->programTitle);
        $this->assertEquals($object->programPost, $dto->programPost);
        $this->assertEquals(intdiv($object->defaultDurationInDays, 30), $dto->defaultDurationInMonths);
        $this->assertEquals($object->defaultDurationInHours, $dto->defaultDurationInHours);

        $documentType = $assembler::RU_DEFAULT_DOCUMENT_TYPE;
        if (isset($assembler->ruDocumentTypes[$object->documentType])) {
            $documentType = $assembler->ruDocumentTypes[$object->documentType];
        }

        $this->assertEquals($documentType, $dto->documentType);
        $this->assertEquals($object->programLink, $dto->programLink);
    }

    /**
     * @return array
     */
    public function defaultDataProvider(): array
    {
        $object1 = new stdClass();
        $object1->programId = 199736;
        $object1->programTitle = 'Ключевые функции, роли и KPI современного HR в компании';
        $object1->programPost = 'HR-специалисту';
        $object1->defaultDurationInDays = 60;
        $object1->defaultDurationInHours = 30;
        $object1->documentType = 'Diplom';
        $object1->programLink = 'https://shkola.action360.ru/programs/199736';

        $object2 = new stdClass();
        $object2->programId = 199738;
        $object2->programTitle = 'Сбор, анализ и инструменты визуализации HR-данных';
        $object2->programPost = 'HR-специалисту';
        $object2->defaultDurationInDays = 60;
        $object2->defaultDurationInHours = 35;
        $object2->documentType = 'Certificate';
        $object2->programLink = 'https://shkola.action360.ru/programs/199738';

        $object3 = new stdClass();
        $object3->programId = 196455;
        $object3->programTitle = 'Техники НЛП';
        $object3->programPost = '';
        $object3->defaultDurationInDays = 30;
        $object3->defaultDurationInHours = 15;
        $object3->documentType = 'CourseCertificate';
        $object3->programLink = 'https://shkola.action360.ru/programs/196455';

        return [
            [
                $object1
            ],
            [
                $object2
            ],
            [
                $object3
            ],
        ];
    }
}
