<?php

namespace App\Tests\api\v1\Skill;

use App\Tests\ApiTester;
use Codeception\Util\HttpCode;

/**
 * Class SkillGetAveragePercentageBySpecialistCest.
 *
 * @package App\Tests\api\v1\Skill
 * @covers \App\UI\Controller\Api\Skill\SkillGetAveragePercentageBySpecialistController
 */
class SkillGetAveragePercentageBySpecialistCest
{
    /**
     * @var string
     */
    private string $url = 'api/v1/specialist-skill-average-percentage_get-by-specialist-id';

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestShouldReturn200ResponseCode(ApiTester $I): void
    {
        $I->sendGET($this->url . '?id=1990299');

        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function requestShouldReturnResponseWithCorrectStructure(ApiTester $I): void
    {
        $I->sendGET($this->url . '?id=1990299');

        $I->seeResponseMatchesJsonType(
            [
                'data' => [
                    'result' => 'integer|float',
                ],
            ]
        );
    }

    public function requestNotFoundIdShouldReturn400ResponseCode(ApiTester $I): void
    {
        $I->sendGET($this->url . '?id=404');

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }
}
