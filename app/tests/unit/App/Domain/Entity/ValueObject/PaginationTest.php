<?php

declare(strict_types=1);

namespace App\Tests\unit\App\Domain\Entity\ValueObject;

use App\Domain\Entity\ValueObject\Limit;
use App\Domain\Entity\ValueObject\Pagination;
use Codeception\Test\Unit;

class PaginationTest extends Unit
{

    /**
     * @param $page
     * @param $perPage
     * @param $count
     * @dataProvider correctValueDataProvider
     */
    public function testCorrectValueShouldNotRaiseException($page, $perPage, $count): void
    {
        new Pagination($page, $perPage, $count);
    }

    public function correctValueDataProvider(): array
    {
        return [
            [1, 1, 1],
            [2, 1, 3],
            [3, 10, 23],
            [1, 1, 0],
        ];
    }

    /**
     * @param $currentPage
     * @param $perPage
     * @param $totalCount
     * @dataProvider incorrectValueDataProvider
     */
    public function testIncorrectValueShouldRaiseException($currentPage, $perPage, $totalCount): void
    {
        $this->expectException(\DomainException::class);

        new Pagination($currentPage, $perPage, $totalCount);
    }

    public function incorrectValueDataProvider(): array
    {
        return [
            'zero current page' => [0, 1, 1],
            'zero per page' => [1, 0, 1],
            'negative total count' => [1, 1, -1],
            'current page more than total pages count' => [4, 10, 23],
        ];
    }

    public function testGetCurrentPageShouldReturnCurrentPage()
    {
        $currentPage = 2;
        $pagination = new Pagination($currentPage, 20, 100);

        $result = $pagination->getCurrentPage();

        $this->assertEquals($currentPage, $result);
    }

    public function testGetPerPageShouldReturnPerPage()
    {
        $perPage = 20;
        $pagination = new Pagination(2, $perPage, 100);

        $result = $pagination->getPerPage();

        $this->assertEquals($perPage, $result);
    }

    public function testGetTotalCountShouldReturnTotalCount()
    {
        $totalCount = 100;
        $pagination = new Pagination(2, 20, $totalCount);

        $result = $pagination->getTotalCount();

        $this->assertEquals($totalCount, $result);
    }

    /**
     * @param Limit $limit
     * @param int $totalCount
     * @param Pagination $expectedPagination
     * @dataProvider paginationDataProvider
     */
    public function testCreateFromLimitAndCountShouldReturnValidPagination(
        Limit $limit,
        int $totalCount,
        Pagination $expectedPagination
    ) {
        $pagination = Pagination::createFromLimitAndCount($limit, $totalCount);

        $this->assertEquals($expectedPagination, $pagination);
    }

    public function paginationDataProvider()
    {
        return [
            [new Limit(10, 10), 100, new Pagination(2, 10, 100)],
            [new Limit(20, 10), 100, new Pagination(3, 10, 100)],
            [new Limit(5, 1), 40, new Pagination(6, 1, 40)],
        ];
    }

    public function testJsonEncodeShouldWorksCorrectWithPagination()
    {
        $currentPage = 5;
        $perPage = 1;
        $totalCount = 10;
        $pagination = new Pagination($currentPage, $perPage, $totalCount);

        $result = json_encode($pagination, JSON_THROW_ON_ERROR, 512);

        $expectedJson = sprintf('{"currentPage":%s,"perPage":%s,"totalCount":%s}', $currentPage, $perPage, $totalCount);
        $this->assertEquals($expectedJson, $result);
    }
}
