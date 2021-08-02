<?php

declare(strict_types=1);

namespace App\Tests\api\v1\ReferenceInformation;

use App\Tests\ApiTester;
use Codeception\Util\HttpCode;

/**
 * Class ReferenceInformationGetCest
 * @package App\Tests\api\v1\ReferenceInformation
 */
class ReferenceInformationGetCest
{
    /**
     * @var string
     */
    private string $url = '/api/v1/reference-information_get-list';

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
        $I->sendGET($this->url);

        $I->seeResponseMatchesJsonType(
            [
                'data' => [
                    'result' => [
                        [
                            'title' => 'string',
                            'url' => 'string'
                        ]
                    ]
                ]
            ]
        );
    }
}
