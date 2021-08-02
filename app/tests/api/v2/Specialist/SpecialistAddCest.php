<?php

declare(strict_types=1);

namespace App\Tests\api\v2\Specialist;

use App\Tests\ApiTester;
use Codeception\Util\HttpCode;

/**
 * Class SpecialistAddCest.
 *
 * @package App\Tests\api\v2\specialist
 * @covers \App\UI\Controller\Api\Specialist\SpecialistAddController
 */
class SpecialistAddCest
{
    /**
     * @var string
     */
    private string $url = '/api/v2/specialist_add';

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
            'id' => null,
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
            'id' => mt_rand(),
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
    public function requestWithMinimumAmountOfValidParametersShouldReturn200ResponseCode(ApiTester $I): void
    {
        $data = [
            'id' => 158905,
        ];
        $I->sendPOST($this->url, $data);

        $I->seeResponseCodeIs(HttpCode::OK);
    }

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestToAddAlreadyExistingSpecialistShouldUpdateSpecialistAndReturn200ResponseCode(ApiTester $I): void
    {
        $data = [
            'id' => 1,
        ];
        $I->sendPOST($this->url, $data);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson(
            [
                'data' => [
                    'result' => [
                        'id' => 1,
                    ]
                ],
            ]
        );
    }

    public function requestShouldReturnResponseWithCorrectStructure(ApiTester $I): void
    {
        $data = [
            'id' => 158905,
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
