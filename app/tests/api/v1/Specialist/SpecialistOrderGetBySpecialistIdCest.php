<?php

namespace App\Tests\api\v1\Specialist;

use App\Tests\ApiTester;
use Codeception\Util\HttpCode;

/**
 * Class SpecialistOrderGetBySpecialistIdCest
 *
 * @package App\Tests\api\v1\Specialist
 * @covers \App\UI\Controller\Api\Specialist\SpecialistOrderGetBySpecialistIdController
 */
class SpecialistOrderGetBySpecialistIdCest
{

    /**
     * @var string
     */
    private string $url = '/api/v1/specialist-order_get-by-specialist-id';

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestShouldReturn200ResponseCode(ApiTester $I): void
    {
        $I->sendGET($this->url . '?id=1');
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    /**
     * @param ApiTester $I
     */
    public function requestShouldReturnResponseWithCorrectStructure(ApiTester $I): void
    {
        $id = 1;

        $I->sendGET($this->url, ['id' => $id]);

        $I->seeResponseMatchesJsonType(
            [
                'data' => [
                    'result' => [
                        [
                            'id' => 'integer',
                            'number' => 'string',
                            'type' => 'string',
                            'date' => 'string',
                            'name' => 'string',
                            'pdfUrl' => 'string',
                        ],
                    ]
                ],
            ]
        );
    }
}
