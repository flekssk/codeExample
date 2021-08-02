<?php

namespace App\Tests\unit\App\Infrastructure\HttpClients\School\Assembler;

use App\Infrastructure\HttpClients\Id2\Assembler\Id2UserAssembler;
use App\Infrastructure\HttpClients\Id2\Dto\Id2UserDto;
use App\Infrastructure\HttpClients\Id2\Response\UserGetResponse;
use App\Infrastructure\HttpClients\School\Assembler\SchoolResponseAssembler;
use App\Infrastructure\HttpClients\School\Dto\SchoolResponseDto;
use Codeception\TestCase\Test;
use DateTimeImmutable;

/**
 * Class SchoolResponseAssemblerTest.
 *
 * @package App\Tests\unit\App\Infrastructure\HttpClients\School\Assembler
 *
 * @covers \App\Infrastructure\HttpClients\School\Assembler\SchoolResponseAssembler
 */
class SchoolResponseAssemblerTest extends Test
{
    /**
     * @param int $id
     * @param string $name
     *
     * @dataProvider defaultDataProvider
     */
    public function testAssemble(int $id, string $name): void
    {
        $assembler = new SchoolResponseAssembler();

        $dto = $assembler->assemble($id, $name);

        $this->assertInstanceOf(SchoolResponseDto::class, $dto);
        $this->assertEquals($id, $dto->id);

        // Проверить что название у школы по умолчанию заменяется на 'По умолчанию'.
        if ($name == 'default') {
            $this->assertEquals('По умолчанию', $dto->name);
        } else {
            $this->assertEquals($name, $dto->name);
        }
    }

    /**
     * @return array
     */
    public function defaultDataProvider(): array
    {
        return [
            [
                1,
                'test'
            ],
            [
                1,
                'default'
            ],
        ];
    }
}
