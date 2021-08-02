<?php

namespace App\Tests\unit\App\Application\School\SchoolSync\Resolver;

use App\Application\School\SchoolSync\Resolver\SchoolSyncResolver;
use App\Domain\Entity\School\School;
use App\Infrastructure\HttpClients\School\Dto\SchoolResponseDto;
use Codeception\TestCase\Test;

/**
 * Class SchoolSyncResolverTest.
 *
 * @package App\Tests\unit\App\Application\School\SchoolSync\Resolver
 *
 * @covers \App\Application\School\SchoolSync\Resolver\SchoolSyncResolver
 */
class SchoolSyncResolverTest extends Test
{
    /**
     * @dataProvider schoolDataProvider
     *
     * @param int $schoolId
     * @param     $schoolName
     */
    public function testAssemble(int $schoolId, string $schoolName)
    {
        $resolver = new SchoolSyncResolver();

        $dto = new SchoolResponseDto();
        $dto->id = $schoolId;
        $dto->name = $schoolName;

        $school = $resolver->resolve($dto);

        $this->assertInstanceOf(School::class, $school);

        $this->assertEquals($schoolId, $school->getId());
        $this->assertEquals($schoolName, $school->getName());
    }

    /**
     * @return array[]
     */
    public function schoolDataProvider()
    {
        return [
            [
                1,
                'test',
            ],
        ];
    }
}
