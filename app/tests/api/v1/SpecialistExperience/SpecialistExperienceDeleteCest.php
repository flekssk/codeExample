<?php

declare(strict_types=1);

namespace App\Tests\api\v1\SpecialistExperience;

use App\Tests\ApiTester;
use Codeception\Util\HttpCode;

/**
 * Class SpecialistExperienceDeleteCest.
 *
 * @package App\Tests\api\v1\SpecialistExperience
 * @covers \App\UI\Controller\Api\SpecialistExperience\SpecialistExperienceDeleteController
 */
class SpecialistExperienceDeleteCest
{
    /**
     * @var string
     */
    private string $url = '/api/v1/specialist-experience_delete';

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
    public function requestWithZeroAsIdParameterShouldReturn400ResponseCode(ApiTester $I): void
    {
        $data = [
            'id' => 0,
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
        ];
        $I->sendPOST($this->url, $data);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestWithIdParameterForNotExistingUserShouldReturn404ResponseCode(ApiTester $I): void
    {
        $data = [
            'id' => 9999,
        ];
        $I->sendPOST($this->url, $data);

        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
    }

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestWithCorrectParametersShouldReturn200ResponseCode(ApiTester $I): void
    {
        $data = [
            'id' => 1000000,
        ];
        $I->sendPOST($this->url, $data);

        $I->seeResponseCodeIs(HttpCode::OK);
    }
}
