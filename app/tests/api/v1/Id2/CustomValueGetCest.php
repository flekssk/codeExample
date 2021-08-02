<?php

declare(strict_types=1);

namespace App\Tests\api\v1\Id2;

use App\Tests\ApiTester;
use Codeception\Util\HttpCode;

/**
 * Class CustomValueGetCest
 * @package App\Tests\api\v1\CustomValue
 */
class CustomValueGetCest
{
    /**
     * @var string
     */
    private string $url = '/api/v1/id2_custom_property_get';

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
                            'key' => 'string|null',
                            'value' => 'string|null',
                        ]
                    ]
                ]
            ]
        );
    }
}