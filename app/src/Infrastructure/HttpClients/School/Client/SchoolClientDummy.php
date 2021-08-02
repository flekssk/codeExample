<?php

namespace App\Infrastructure\HttpClients\School\Client;

/**
 * Class SchoolClientDummy.
 *
 * @package App\Infrastructure\HttpClients\School
 */
class SchoolClientDummy implements SchoolClientInterface
{
    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        $firstSchool = new \stdClass();
        $firstSchool->id = 20;
        $firstSchool->name = 'Test 20';

        $secondSchool = new \stdClass();
        $secondSchool->id = 21;
        $secondSchool->name = 'Test 21';

        $thirdSchool = new \stdClass();
        $thirdSchool->id = 22;
        $thirdSchool->name = 'default';

        return [
            $firstSchool,
            $secondSchool,
            $thirdSchool,
        ];
    }
}
