<?php

namespace App\Tests\unit\App\Domain\Entity\Specialist\ValueObject;

use App\Domain\Entity\Specialist\ValueObject\OrderType;
use Codeception\Test\Unit;
use DomainException;

/**
 * Class OrderTypeTest.
 *
 * @package App\Tests\unit\App\Domain\Entity\Specialist\ValueObject
 * @covers \App\Domain\Entity\Specialist\ValueObject\OrderType
 */
class OrderTypeTest extends Unit
{
    public function testCreateInclusionType()
    {
        $value = OrderType::INCLUSION;

        $orderType = new OrderType($value);

        $this->assertEquals($orderType->getValue(), $value);
    }

    public function testCreateIssueOfADocumentType()
    {
        $value = OrderType::ISSUE_OF_A_DOCUMENT;

        $orderType = new OrderType($value);

        $this->assertEquals($orderType->getValue(), $value);
    }

    public function testCreateFromIncorrectValueShouldRaiseTheException()
    {
        $this->expectException(DomainException::class);

        $value = 'test';

        $orderType = new OrderType($value);
    }

    public function testCreateFromEmptyValueShouldRaiseTheException()
    {
        $this->expectException(DomainException::class);

        $value = '';

        $orderType = new OrderType($value);
    }
}
