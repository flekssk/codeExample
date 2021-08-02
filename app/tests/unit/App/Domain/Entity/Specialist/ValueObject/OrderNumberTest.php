<?php

namespace App\Tests\unit\App\Domain\Entity\Specialist\ValueObject;

use App\Domain\Entity\Specialist\ValueObject\OrderNumber;
use Codeception\Test\Unit;
use DateTimeImmutable;
use DomainException;

/**
 * Class OrderNumberTest.
 *
 * @package App\Tests\unit\App\Domain\Entity\Specialist\ValueObject
 * @covers \App\Domain\Entity\Specialist\ValueObject\OrderNumber
 */
class OrderNumberTest extends Unit
{
    public function testCreateFromValue()
    {
        $value = 'Р-2020-01-01-12345';

        $orderNumber = new OrderNumber($value);

        $this->assertEquals($orderNumber->getValue(), $value);
    }

    public function testCreateFromDateAndId(): void
    {
        $date = new DateTimeImmutable();
        $id = '12345';

        $orderNumber = OrderNumber::createFromDateAndSpecialistId($date, $id);

        $this->assertEquals("Р-{$date->format('Y-m-d')}-{$id}", $orderNumber->getValue());
    }

    public function testCreateFromEmptyValueShouldRaiseTheException(): void
    {
        $this->expectException(DomainException::class);

        $value = '';

        $orderNumber = new OrderNumber($value);
    }
}
