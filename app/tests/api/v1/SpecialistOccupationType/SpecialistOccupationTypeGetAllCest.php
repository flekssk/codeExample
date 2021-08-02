<?php

namespace App\Tests\api\v1\SpecialistOccupationType;

use App\Tests\ApiTester;
use Codeception\Util\HttpCode;

/**
 * Class SpecialistOccupationTypeGetAllCest.
 *
 * @package App\Tests\api\v1\SpecialistOccupationType
 * @covers \App\UI\Controller\Api\SpecialistOccupationType\SpecialistOccupationTypeGetAllController
 */
class SpecialistOccupationTypeGetAllCest
{

    /**
     * @var string
     */
    private string $url = '/api/v1/specialist-occupation-type_get-all';

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestShouldReturn200ResponseCode(ApiTester $I): void
    {
        $I->sendGET($this->url);
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    /**
     * @param ApiTester $I
     */
    public function requestShouldReturnResponseWithCorrectStructure(ApiTester $I): void
    {
        $I->sendGET($this->url);

        $I->seeResponseMatchesJsonType(
            [
                'data' => [
                    'result' => [
                        [
                            'id' => 'integer',
                            'name' => 'string',
                        ],
                    ]
                ],
            ]
        );
    }
}
