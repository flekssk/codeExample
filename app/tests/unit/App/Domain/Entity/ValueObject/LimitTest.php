<?php

declare(strict_types=1);

namespace App\Tests\unit\App\Domain\Entity\ValueObject;

use App\Domain\Entity\ValueObject\Limit;
use Codeception\Test\Unit;

class LimitTest extends Unit
{
    /**
     * @param $offset
     * @param $limit
     * @dataProvider correctValueDataProvider
     */
    public function testCorrectValueShouldNotRaiseException($offset, $limit): void
    {
        new Limit($offset, $limit);
    }

    /**
     * @param $offset
     * @param $limit
     * @dataProvider incorrectValueDataProvider
     */
    public function testIncorrectValueShouldRaiseException($offset, $limit): void
    {
        $this->expectException(\DomainException::class);

        new Limit($offset, $limit);
    }

    /**
     * @param $offset
     * @param $limit
     * @dataProvider correctValueDataProvider
     */
    public function testGetOffsetShouldReturnCorrectValue($offset, $limit): void
    {
        $limitDto = new Limit($offset, $limit);
        $this->assertEquals($offset, $limitDto->getOffset());
    }

    /**
     * @param $offset
     * @param $limit
     * @dataProvider correctValueDataProvider
     */
    public function testGetLimitShouldReturnCorrectValue($offset, $limit): void
    {
        $limitDto = new Limit($offset, $limit);
        $this->assertEquals($limit, $limitDto->getLimit());
    }

    /**
     * @param $page
     * @param $perPage
     * @dataProvider pageAndPerPageDataProvider
     */
    public function testLimitShouldReturnCorrectOffsetFromPageAndPerPageParams($page, $perPage): void
    {
        $limitDto =  Limit::createFromPageNumberAndSize($page, $perPage);
        $this->assertEquals(($page - 1) * $perPage, $limitDto->getOffset());
    }

    public function correctValueDataProvider(): array
    {
        return [
            [0, 1],
            [10, 100],
            [777, 2],
        ];
    }

    public function incorrectValueDataProvider(): array
    {
        return [
            [-1, 10],
            [0, 0],
            [10, 0],
        ];
    }

    public function pageAndPerPageDataProvider(): array
    {
        return [
            [1, 20],
            [2, 20],
            [3, 20],
        ];
    }
}
