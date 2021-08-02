<?php

declare(strict_types=1);

namespace App\Tests\api\v1\Specialist;

use App\Tests\ApiTester;
use Codeception\Util\HttpCode;

/**
 * Class SpecialistUpdateCest.
 *
 * @package App\Tests\api\v1\specialist
 *
 * @covers \App\UI\Controller\Api\Specialist\SpecialistUpdateController
 */
class SpecialistUpdateCest
{
    /**
     * @var string
     */
    private string $url = '/api/v1/specialist_update';

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestWithMissingParametersShouldReturn400ResponseCode(ApiTester $I): void
    {
        $I->sendPOST($this->url, []);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestWithMissingRequiredParameterShouldReturn400ResponseCode(ApiTester $I): void
    {
        $I->sendPOST($this->url, ['firstName' => 'Test First Name']);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestWithInvalidParameterTypeShouldReturn400ResponseCode(ApiTester $I): void
    {
        $data = [
            'id' => 1,
            'position' => null,
            'employmentType' => 1,
            'workSchedule' => 1,
        ];
        $I->sendPOST($this->url, $data);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestWithUnknownParameterTypeShouldReturn400ResponseCode(ApiTester $I): void
    {
        $data = [
            'id' => 1,
            'position' => 1,
            'employmentType' => 1,
            'workSchedule' => 1,
            'testParam' => 'test',
        ];
        $I->sendPOST($this->url, $data);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestWithInvalidEmploymentTypeParameterShouldReturn400ResponseCode(ApiTester $I): void
    {
        $data = [
            'id' => 1,
            'position' => 1,
            'employmentType' => 0,
            'workSchedule' => 1,
        ];
        $I->sendPOST($this->url, $data);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestWithInvalidWorkScheduleParameterShouldReturn400ResponseCode(ApiTester $I): void
    {
        $data = [
            'id' => 1,
            'position' => 1,
            'employmentType' => 1,
            'workSchedule' => 0,
        ];
        $I->sendPOST($this->url, $data);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    public function requestShouldReturnResponseWithCorrectStructure(ApiTester $I): void
    {
        $data = [
            'id' => 13,
            'position' => 'test',
            'employmentType' => 1,
            'workSchedule' => 1,
        ];
        $I->sendPOST($this->url, $data);

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
                    ]
                ],
            ]
        );
    }
}
