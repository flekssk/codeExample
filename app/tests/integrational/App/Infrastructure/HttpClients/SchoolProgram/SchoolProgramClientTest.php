<?php

namespace App\Tests\integrational\App\Infrastructure\HttpClients\SchoolProgram;

use App\Infrastructure\HttpClients\SchoolProgram\SchoolProgramClient;
use Codeception\Test\Unit;

/**
 * Class SchoolProgramClientTest.
 *
 * @package App\Tests\integrational\App\Infrastructure\HttpClients\SchoolProgram
 */
class SchoolProgramClientTest extends Unit
{
    /**
     * @var int
     */
    private int $userId = 1708717;

    /**
     * @var array|int[]
     */
    private array $versions = [
        1102,
        7412,
        7423,
    ];

    /**
     * Test get user programs by user ID and versions.
     */
    public function testGetUserProgramsByUserIdAndVersions()
    {
        $module = $this->getModule('Symfony');
        $container = $module->kernel->getContainer();

        $client = $container->get('App\Infrastructure\HttpClients\SchoolProgram\SchoolProgramClient');

        $result = $client->getUserProgramsByUserIdAndVersions($this->userId, $this->versions);

        $this->assertIsArray($result);

        $object = reset($result);

        $this->assertIsObject($object);
        $this->assertObjectHasAttribute('mainProduct', $object);
        $this->assertObjectHasAttribute('programId', $object);
        $this->assertObjectHasAttribute('productVersion', $object);
        $this->assertObjectHasAttribute('programTitle', $object);
        $this->assertObjectHasAttribute('programPost', $object);
        $this->assertObjectHasAttribute('programDateStart', $object);
        $this->assertObjectHasAttribute('programDateEnd', $object);
        $this->assertObjectHasAttribute('programProgress', $object);
    }

    /**
     * Test get programs by versions.
     */
    public function testGetProgramsByVersions()
    {
        $module = $this->getModule('Symfony');
        $container = $module->kernel->getContainer();

        $client = $container->get('App\Infrastructure\HttpClients\SchoolProgram\SchoolProgramClient');

        $result = $client->getProgramsByVersions($this->versions);

        $this->assertIsArray($result);

        $object = reset($result);

        $this->assertIsObject($object);
        $this->assertObjectHasAttribute('mainProduct', $object);
        $this->assertObjectHasAttribute('programId', $object);
        $this->assertObjectHasAttribute('productVersion', $object);
        $this->assertObjectHasAttribute('programTitle', $object);
        $this->assertObjectHasAttribute('programPost', $object);
        $this->assertObjectHasAttribute('defaultDurationInDays', $object);
        $this->assertObjectHasAttribute('defaultDurationInHours', $object);
        $this->assertObjectHasAttribute('documentType', $object);
        $this->assertObjectHasAttribute('programLink', $object);
    }
}
