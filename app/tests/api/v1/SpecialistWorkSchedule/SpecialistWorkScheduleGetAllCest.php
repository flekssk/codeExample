<?php

namespace App\Tests\api\v1\SpecialistWorkSchedule;

use App\Tests\ApiTester;
use Codeception\Util\HttpCode;

/**
 * Class SpecialistWorkScheduleGetAllCest.
 *
 * @package App\Tests\api\v1\SpecialistWorkSchedule
 * @covers \App\UI\Controller\Api\SpecialistWorkSchedule\SpecialistWorkScheduleGetAllController
 */
class SpecialistWorkScheduleGetAllCest
{

    /**
     * @var string
     */
    private string $url = '/api/v1/specialist-work-schedule_get-all';

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
