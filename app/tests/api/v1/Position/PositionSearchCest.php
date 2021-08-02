<?php

declare(strict_types=1);

namespace App\Tests\api\v1\position;

use App\Tests\ApiTester;
use Codeception\Example;
use Codeception\Util\HttpCode;

class PositionSearchCest
{
    private string $url = '/api/v1/position_search';

    public function requestShouldReturn200ResponseCode(ApiTester $I): void
    {
        $I->sendGET($this->url);

        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function requestWithGetParamsShouldReturn200ResponseCode(ApiTester $I): void
    {
        $I->sendGET($this->url, [
            'name' => 'тес',
            'count' => 10
        ]);

        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function requestShouldReturnResponseWithCorrectStructure(ApiTester $I): void
    {
        $I->sendGET($this->url);

        $I->seeResponseMatchesJsonType([
            'data' => [
                'result' => [
                    [
                        'id' => 'integer',
                        'name' => 'string'
                    ]
                ]
            ]
        ]);
    }

    public function requestWithSearchParamNameShouldReturnCorrectDataInResponse(ApiTester $I): void
    {
        $I->sendGET($this->url, ['name' => 'маши']);

        $I->seeResponseContainsJson([
            'data' => [
                'result' => [
                    [
                        'name' => 'Машинист'
                    ]
                ]
            ]
        ]);
    }

    public function requestWithCountParamShouldReturnCorrectItemsCountInResponse(ApiTester $I): void
    {
        $countParam = 1;
        $I->sendGET($this->url, ['count' => $countParam]);

        $response = json_decode($I->grabResponse(), true, 512, JSON_THROW_ON_ERROR);
        $I->assertCount($countParam, $response['data']);
    }

    public function requestShouldReturnEmptyArrayInResponseIfThereAreNoSearchResult(ApiTester $I): void
    {
        $I->sendGET($this->url, ['name' => 'сложный поисковый запрос']);

        $response = json_decode($I->grabResponse(), true, 512, JSON_THROW_ON_ERROR);
        $I->assertEmpty($response['data']['result']);
    }

    /**
     * @param ApiTester $I
     * @param Example $example
     * @dataProvider invalidCountParamDataProvider
     */
    public function requestWithInvalidCountParamShouldReturn400ResponseCode(ApiTester $I, Example $example): void
    {
        $I->sendGET($this->url, ['count' => $example['invalidCountParam']]);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    private function invalidCountParamDataProvider(): array
    {
        // Не проверяется пустое значение так как параметр count необязателен.
        // Не проверяется дробное значение так как IntegerType отбрасывает дробную часть.
        return [
            ['invalidCountParam' => 'some_string'],
            ['invalidCountParam' => -1],
            ['invalidCountParam' => 0],
        ];
    }
}
