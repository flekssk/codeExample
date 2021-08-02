<?php

declare(strict_types=1);

namespace App\Tests\api\v1\SpecialistExperience;

use App\Tests\ApiTester;
use Codeception\Util\HttpCode;

/**
 * Class SpecialistExperienceUpdateCest.
 *
 * @package App\Tests\api\v1\SpecialistExperience
 * @covers \App\UI\Controller\Api\SpecialistExperience\SpecialistExperienceUpdateController
 */
class SpecialistExperienceUpdateCest
{
    /**
     * @var string
     */
    private string $url = '/api/v1/specialist-experience_update';

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
        $I->sendPOST($this->url, ['endDate' => '2020-02-01']);

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
            'id' => 1000000,
            'company' => null,
            'startDate' => '2020-01-01',
        ];
        $I->sendPOST($this->url, $data);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestWithUnknownParameterShouldReturn400ResponseCode(ApiTester $I): void
    {
        $data = [
            'id' => 1000000,
            'company' => 'Test Company',
            'startDate' => '2020-01-01',
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
    public function requestWithZeroAsIdParameterShouldReturn400ResponseCode(ApiTester $I): void
    {
        $data = [
            'id' => 0,
            'company' => 'Test Company',
            'startDate' => '2020-01-01',
        ];
        $I->sendPOST($this->url, $data);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestWithNegativeValueAsIdParameterShouldReturn400ResponseCode(ApiTester $I): void
    {
        $data = [
            'id' => -1,
            'company' => 'Test Company',
            'startDate' => '2020-01-01',
        ];
        $I->sendPOST($this->url, $data);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestWithTextAsIdParameterShouldReturn400ResponseCode(ApiTester $I): void
    {
        $data = [
            'id' => 'test',
            'company' => 'Test Company',
            'startDate' => '2020-01-01',
        ];
        $I->sendPOST($this->url, $data);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestWithIdParameterForNotExistingUserShouldReturn400ResponseCode(ApiTester $I): void
    {
        $data = [
            'id' => 9999,
            'company' => 'Test Company',
            'startDate' => '2020-01-01',
        ];
        $I->sendPOST($this->url, $data);

        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
    }

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestWithStartDateParameterSetInFutureShouldReturn400ResponseCode(ApiTester $I): void
    {
        $time = new \DateTime();
        $data = [
            'id' => 1000000,
            'company' => 'Test Company',
            'startDate' => $time->add(new \DateInterval('P1D'))->format('Y-m-d'),
        ];
        $I->sendPOST($this->url, $data);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestWithEndDateParameterSetInFutureShouldReturn400ResponseCode(ApiTester $I): void
    {
        $time = new \DateTime();
        $data = [
            'id' => 1000000,
            'company' => 'Test Company',
            'startDate' => $time->format('Y-m-d'),
            'endDate' => $time->add(new \DateInterval('P1D'))->format('Y-m-d'),
        ];
        $I->sendPOST($this->url, $data);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestWithStartDateParameterGreaterThanEndDateParameterShouldReturn400ResponseCode(ApiTester $I): void
    {
        $time = new \DateTime();
        $data = [
            'id' => 1000000,
            'company' => 'Test Company',
            'startDate' => $time->add(new \DateInterval('P1D'))->format('Y-m-d'),
            'endDate' => $time->sub(new \DateInterval('P1D'))->format('Y-m-d'),
        ];
        $I->sendPOST($this->url, $data);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestWithStartDateParameterSetAsTextShouldReturn400ResponseCode(ApiTester $I): void
    {
        $data = [
            'id' => 1000000,
            'company' => 'Test Company',
            'startDate' => 'test',
        ];
        $I->sendPOST($this->url, $data);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestWithEndDateParameterSetAsTextShouldReturn400ResponseCode(ApiTester $I): void
    {
        $data = [
            'id' => 1000000,
            'company' => 'Test Company',
            'startDate' => '2020-01-01',
            'endDate' => 'test',
        ];
        $I->sendPOST($this->url, $data);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestWithCompanyParameterSetAsEmptyStringShouldReturn400ResponseCode(ApiTester $I): void
    {
        $data = [
            'id' => 1000000,
            'company' => '',
            'startDate' => '2020-01-01',
            'endDate' => '2020-01-01',
        ];
        $I->sendPOST($this->url, $data);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestWithCompanyParameterSetAsStringWithLengthMoreThan256ShouldReturn400ResponseCode(ApiTester $I): void
    {
        $data = [
            'id' => 1000000,
            'company' => bin2hex(random_bytes(128)),
            'startDate' => '2020-01-01',
            'endDate' => '2020-01-01',
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
            'id' => 1000000,
            'company' => 'Test Company',
            'startDate' => '2020-01-01',
        ];
        $I->sendPOST($this->url, $data);

        $I->seeResponseCodeIs(HttpCode::OK);
    }

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestWithMaximumAmountOfValidParametersShouldReturn200ResponseCode(ApiTester $I): void
    {
        $data = [
            'id' => 1000000,
            'company' => 'Test Company',
            'startDate' => '2020-01-01',
            'endDate' => '2020-02-01',
        ];
        $I->sendPOST($this->url, $data);

        $I->seeResponseCodeIs(HttpCode::OK);
    }

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestWithEndDateParameterSetAsEmptyStringShouldReturn200ResponseCode(ApiTester $I): void
    {
        $data = [
            'id' => 1000000,
            'company' => 'Test Company',
            'startDate' => '2020-01-01',
            'endDate' => '',
        ];
        $I->sendPOST($this->url, $data);

        $I->seeResponseCodeIs(HttpCode::OK);
    }

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestWithDateParametersSetInShortFormShouldReturn200ResponseCode(ApiTester $I): void
    {
        $data = [
            'id' => 1000000,
            'company' => 'Test Company',
            'startDate' => '2020-01',
            'endDate' => '2020-01',
        ];
        $I->sendPOST($this->url, $data);

        $I->seeResponseCodeIs(HttpCode::OK);
    }

    /**
     * @param ApiTester $I
     */
    public function requestShouldReturnResponseWithCorrectStructure(ApiTester $I): void
    {
        $data = [
            'id' => 1000000,
            'company' => 'Test Company',
            'startDate' => '2020-01',
            'endDate' => '2020-01',
        ];

        $I->sendPOST($this->url, $data);

        $I->seeResponseMatchesJsonType(
            [
                'data' => [
                    'result' => [
                        'id' => 'integer',
                        'specialistId' => 'integer',
                        'company' => 'string',
                        'startDate' => 'string',
                        'endDate' => 'string|null',
                    ]
                ],
            ]
        );
    }
}
