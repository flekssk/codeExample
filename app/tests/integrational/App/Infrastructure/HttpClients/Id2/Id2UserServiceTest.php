<?php

namespace App\Tests\integrational\App\Infrastructure\HttpClients\Id2;

use App\Infrastructure\HttpClients\Id2\Assembler\Id2UserAssembler;
use App\Infrastructure\HttpClients\Id2\Dto\Id2UserDto;
use App\Infrastructure\HttpClients\Id2\Id2ClientDummy;
use App\Infrastructure\HttpClients\Id2\Id2UserService;
use Codeception\TestCase\Test;

/**
 * Class Id2UserServiceTest.
 *
 * @package App\Tests\unit\App\Infrastructure\HttpClients\Id2
 *
 * @covers \App\Infrastructure\HttpClients\Id2\Id2UserService
 */
class Id2UserServiceTest extends Test
{
    /**
     * Test get user method.
     */
    public function testGetUser(): void
    {
        $client = new class () extends Id2ClientDummy {
        };

        $assembler = new Id2UserAssembler('https://test.ru/');
        $service = new Id2UserService($client, $assembler);

        $userDto = $service->getUserById(1);

        $this->assertInstanceOf(Id2UserDto::class, $userDto);
    }
}
