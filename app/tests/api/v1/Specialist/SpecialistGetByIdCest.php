<?php

namespace App\Tests\api\v1\specialist_get_by_id;

use App\Tests\ApiTester;
use Codeception\Example;
use Codeception\Util\HttpCode;

class SpecialistGetByIdCest
{
    private string $url = '/api/v1/specialist_get-by-id';

    public function requestWithoutRequiredParamShouldReturn400ResponseCode(ApiTester $I): void
    {
        $I->sendGET($this->url);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    public function requestWithRequiredGetParamShouldReturn200ResponseCode(ApiTester $I): void
    {
        $userId = 13;

        $I->sendGET($this->url, ['id' => $userId]);

        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function requestWithNonexistentGetParamShouldReturn404ResponseCode(ApiTester $I): void
    {
        $userId = 1111;

        $I->sendGET($this->url, ['id' => $userId]);

        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
    }

    public function requestShouldReturnCorrectDataInResponse(ApiTester $I): void
    {
        $userId = 13;

        $I->sendGET($this->url, ['id' => $userId]);

        $I->seeResponseContainsJson(
            [
                'data' => [
                    'result' => [
                        'id' => 13,
                        'firstName' => 'Иван',
                        'secondName' => 'Иванов',
                        'middleName' => 'Иванович',
                        'status' => 3,
                        'imageUrl' => 'https://image.com/url.jpg',
                        'gender' => 1,
                        'region' => 'Москва',
                        'company' => 'Актион',
                        'birthDate' => '1991-12-03',
                        'id2Position' => 'test',
                        'employmentType' => [
                            'id' => 1,
                            'name' => 'Название',
                        ],
                        'workSchedule' => [
                            'id' => 1,
                            'name' => 'Название',
                        ],
                        'document' => null,
                        'viewCount' => 0,
                    ]
                ],
            ]
        );
    }

    public function requestShouldReturnResponseWithCorrectStructure(ApiTester $I): void
    {
        $userId = 13;

        $I->sendGET($this->url, ['id' => $userId]);

        $I->seeResponseMatchesJsonType(
            [
                'data' => [
                    'result' => [
                        'id' => 'integer',
                        'firstName' => 'string',
                        'secondName' => 'string',
                        'middleName' => 'string',
                        'status' => 'integer',
                        'imageUrl' => 'string|null',
                        'gender' => 'integer',
                        'region' => [],
                        'company' => 'string|null',
                        'birthDate' => 'string',
                        'id2Position' => 'string',
                        'employmentType' => [],
                        'workSchedule' => [],
                        'document' => 'null',
                        'viewCount' => 'integer',
                    ]
                ],
            ]
        );
    }

    /**
     * @param ApiTester $I
     * @param Example   $example
     *
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
            ['invalidIdParam' => 'string'],
            ['invalidIdParam' => ''],
            ['invalidIdParam' => '!'],
            ['invalidIdParam' => -1],
            ['invalidIdParam' => 0],
        ];
    }
}
