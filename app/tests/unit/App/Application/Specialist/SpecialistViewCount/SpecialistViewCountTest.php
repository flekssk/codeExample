<?php

namespace App\Tests\unit\App\Application\Specialist\SpecialistViewCount;

use App\Application\Specialist\SpecialistViewCount\SpecialistViewCount;
use App\Domain\Entity\Specialist\Specialist;
use App\Domain\Repository\Specialist\SpecialistRepositoryInterface;
use App\Infrastructure\Persistence\Doctrine\Repository\Specialist\SpecialistRepository;
use Codeception\Stub;
use Codeception\TestCase\Test;

/**
 * Class SpecialistViewCountTest.
 *
 * @package App\Tests\unit\App\Application\Specialist\SpecialistViewCount
 */
class SpecialistViewCountTest extends Test
{
    /**
     * Test increment() function.
     */
    public function testIncrement(): void
    {
        $specialist = new Specialist(1);

        /** @var SpecialistRepositoryInterface $repository */
        $repository = Stub::make(
            SpecialistRepository::class,
            ['get' => $specialist, 'save' => null]
        );

        $service = new SpecialistViewCount($repository);

        $countIncrement = rand(1, 10);
        for ($i = 0; $i < $countIncrement; $i++) {
            $service->increment(1);
        }

        $this->assertEquals($countIncrement, $specialist->getViewCount());
    }
}
