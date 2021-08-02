<?php

declare(strict_types=1);

namespace App\Tests\api\v1\SpecialistExperience;

use App\Tests\ApiTester;
use Codeception\Util\HttpCode;

/**
 * Class SpecialistExperienceAddCest.
 *
 * @package App\Tests\api\v1\SpecialistExperience
 * @covers \App\UI\Controller\Api\SpecialistExperience\SpecialistExperienceAddController
 */
class SpecialistExperienceGetCest
{
    /**
     * @var string
     */
    private string $url = '/api/v1/specialist-experience_get-by-specialist-id';

    /**
     * @param ApiTester $I
     */
    public function requestWithExistingIdShouldReturn200ResponseCode(ApiTester $I): void
    {
        $I->sendGET($this->url, ['id' => 1000000]);

        $I->seeResponseCodeIs(HttpCode::OK);
    }

    /**
     * @param ApiTester $I
     */
    public function requestWithIncorrectIdIdShouldReturn400ResponseCode(ApiTester $I): void
    {
        $I->sendGET($this->url, ['id' => 0]);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
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
                            'specialistId' => 'integer',
                            'company' => 'string',
                            'startDate' => 'string',
                            'endDate' => 'string|null',
                        ],
                    ]
                ],
            ]
        );
    }
}
