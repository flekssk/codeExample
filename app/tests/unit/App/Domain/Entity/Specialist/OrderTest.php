<?php

namespace App\Tests\unit\App\Domain\Entity\Specialist;

use App\Domain\Entity\Specialist\Order;
use App\Domain\Entity\Specialist\Specialist;
use App\Domain\Entity\Specialist\ValueObject\OrderNumber;
use App\Domain\Entity\Specialist\ValueObject\OrderType;
use Codeception\Test\Unit;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class OrderTest.
 *
 * @package App\Tests\unit\App\Domain\Entity\Specialist
 * @covers \App\Domain\Entity\Specialist\Order
 */
class OrderTest extends Unit
{
    /**
     * Test get specialists.
     *
     * @dataProvider specialistsDataProvider
     *
     * @param array $specialists
     */
    public function testGetSpecialists(array $specialists)
    {
        $number = 'Р-2020-01-01-12345';

        $entity = new Order(
            new OrderNumber($number),
            new OrderType(OrderType::INCLUSION),
            new DateTimeImmutable(),
            new ArrayCollection($specialists)
        );

        $this->assertCount(count($specialists), $entity->getSpecialists()->toArray());
        $this->assertIsArray($entity->getSpecialists()->toArray());
    }

    /**
     * Test create entity.
     *
     * @dataProvider specialistsDataProvider
     *
     * @param array $specialists
     */
    public function testCreateEntity(array $specialists)
    {
        $number = 'Р-2020-01-01-12345';

        $entity = new Order(
            new OrderNumber($number),
            new OrderType(OrderType::INCLUSION),
            new DateTimeImmutable(),
            new ArrayCollection($specialists)
        );

        $this->assertEquals($number, $entity->getNumber());
    }

    /**
     * @return array
     */
    public function specialistsDataProvider()
    {
        $specialist = new Specialist(1);

        return [
            [
                [
                    $specialist,
                ],
            ],
        ];
    }
}
