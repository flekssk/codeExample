<?php

declare(strict_types=1);

namespace App\Tests\api\v1\Id2;

use App\Tests\ApiTester;
use Codeception\Util\HttpCode;

/**
 * Class Id2EventGetCest
 * @package App\Tests\api\v1\Id2Event
 */
class Id2EventGetCest
{
    /**
     * @var string
     */
    private string $url = '/api/v1/id2_event_get';

    /**
     * @param ApiTester $I
     */
    public function requestShouldReturn200ResponseCode(ApiTester $I): void
    {
        $I->sendGET($this->url);

        $I->seeResponseCodeIs(HttpCode::OK);
    }

    /**
     * @param ApiTester $I
     */
    public function requestShouldReturnCorrectStructure(ApiTester $I): void
    {
        $I->sendGET(
            $this->url,
            [
                'name' => 'search'
            ]
        );

        $I->seeResponseMatchesJsonType(
            [
                'data' => [
                    'result' => [
                        [
                            'name' => 'string',
                            'action' => 'string',
                            'category1' => 'string|null',
                            'category2' => 'string|null',
                        ]
                    ]
                ]
            ]
        );
    }
}
