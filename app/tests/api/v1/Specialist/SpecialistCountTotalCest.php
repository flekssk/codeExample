<?php

declare(strict_types=1);

namespace App\Tests\api\v1\Specialist;

use App\Tests\ApiTester;
use Codeception\Util\HttpCode;

/**
 * Class SpecialistCountTotalCest.
 *
 * @package App\Tests\api\v1\Specialist
 * @covers \App\UI\Controller\Api\Specialist\SpecialistCountTotalController
 */
class SpecialistCountTotalCest
{
    private string $url = '/api/v1/specialist_count-total';

    public function requestShouldReturn200ResponseCode(ApiTester $I): void
    {
        $I->sendGET($this->url);

        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function requestShouldCountAllRowsFromDb(ApiTester $I): void
    {
        $I->sendGET($this->url);

        $count = $I->grabNumRecords('specialist');
        $response = json_decode($I->grabResponse(), true);

        $I->assertEquals($response['data']['result']['count'], $count);
    }

    public function requestShouldReturnCorrectStructureInResponse(ApiTester $I): void
    {
        $I->sendGET($this->url);

        $I->seeResponseMatchesJsonType([
            'data' => [
                'result' => [
                    'count' => 'integer',
                ]
            ],
        ]);
    }
}
