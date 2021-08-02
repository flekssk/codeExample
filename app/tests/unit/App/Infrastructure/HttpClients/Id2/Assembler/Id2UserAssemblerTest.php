<?php

namespace App\Tests\unit\App\Infrastructure\HttpClients\Id2\Assembler;

use App\Infrastructure\HttpClients\Id2\Assembler\Id2UserAssembler;
use App\Infrastructure\HttpClients\Id2\Dto\Id2UserDto;
use App\Infrastructure\HttpClients\Id2\Response\UserGetResponse;
use Codeception\TestCase\Test;
use DateTimeImmutable;

/**
 * Class Id2UserAssemblerTest.
 *
 * @package App\Tests\unit\App\Infrastructure\HttpClients\Id2\Assembler
 *
 * @covers \App\Infrastructure\HttpClients\Id2\Assembler\Id2UserAssembler
 */
class Id2UserAssemblerTest extends Test
{
    /**
     * @param UserGetResponse $userGetResponse
     *
     * @dataProvider correctValuesDataProvider
     */
    public function testAssembleWithCorrectValues(UserGetResponse $userGetResponse): void
    {
        $assembler = new Id2UserAssembler('https://test.ru/');

        $dto = $assembler->assemble($userGetResponse);

        $this->assertInstanceOf(Id2UserDto::class, $dto);
        $this->assertEquals($userGetResponse->gender, $dto->gender->getValue());
        $this->assertEquals($userGetResponse->firstName, $dto->firstName);
        $this->assertEquals($userGetResponse->lastName, $dto->secondName);
        $this->assertEquals($userGetResponse->middleName, $dto->middleName);
        $this->assertEquals($userGetResponse->birthDate, $dto->birthDate);
    }

    /**
     * @return UserGetResponse[]|array
     */
    public function correctValuesDataProvider(): array
    {
        $userGetResponse = new UserGetResponse();

        $userGetResponse->id = 1;
        $userGetResponse->firstName = 'firstName';
        $userGetResponse->lastName = 'lastName';
        $userGetResponse->middleName = 'middleName';
        $userGetResponse->gender = 1;
        $userGetResponse->birthDate = new DateTimeImmutable();
        $userGetResponse->email = 'test@yandex.ru';
        $userGetResponse->phone = '+79999999999';
        $userGetResponse->properties = [
            [
                'key' => Id2UserAssembler::REGION_GUID_PROPERTY_NAME,
                'value' => 'testregion',
            ],
        ];

        return [
            [
                $userGetResponse,
            ],
        ];
    }
}
