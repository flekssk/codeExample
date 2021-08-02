<?php

declare(strict_types=1);

namespace App\Tests\api\v1\Order;

use App\Tests\ApiTester;
use Codeception\Example;
use Codeception\Util\HttpCode;

/**
 * Class OrderGetPdfByIdCest.
 *
 * @package App\Tests\api\v1\Order
 * @covers \App\UI\Controller\Api\Order\OrderPdfGetByIdController
 */
class OrderGetPdfByIdCest
{
    private string $url = '/api/v1/specialist-order-pdf_get-by-id';

    public function requestWithNoIdShouldReturn400ResponseCode(ApiTester $I): void
    {
        $I->sendGET($this->url);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    public function requestWithGetParamsShouldReturn200ResponseCode(ApiTester $I): void
    {
        $I->sendGET($this->url, [
            'id' => '1',
        ]);

        $I->seeResponseCodeIs(HttpCode::OK);
    }

    /**
     * @param ApiTester $I
     * @param Example $example
     * @dataProvider invalidIdParamDataProvider
     */
    public function requestWithInvalidIdParamShouldReturn400ResponseCode(ApiTester $I, Example $example): void
    {
        $I->sendGET($this->url, ['id' => $example['invalidIdParam']]);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    private function invalidIdParamDataProvider(): array
    {
        return [
            ['invalidIdParam' => 'some_string'],
            ['invalidIdParam' => ''],
            ['invalidIdParam' => -1],
            ['invalidIdParam' => 0]
        ];
    }
}
