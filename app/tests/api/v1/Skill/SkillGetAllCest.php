<?php

declare(strict_types=1);

namespace App\Tests\api\v1\Skill;

use App\Tests\ApiTester;
use Codeception\Util\HttpCode;

/**
 * Class SiteOptionGetCest.
 *
 * @package App\Tests\api\v1\SiteOption
 * @covers \App\UI\Controller\Api\Skill\SkillGetAllController
 */
class SkillGetAllCest
{
    /**
     * @var string
     */
    private string $url = 'api/v1/skill_get-all';

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestShouldReturn200ResponseCode(ApiTester $I): void
    {
        $I->sendGET($this->url . '?id=100666');

        $I->seeResponseCodeIs(HttpCode::OK);
    }

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestShouldReturnResponseWithCorrectData(ApiTester $I): void
    {
        $I->sendGET($this->url . '?id=100666');

        $I->seeResponseContainsJson(
            [
                'data' => [
                    'result' => [
                        [
                            'id' => '1',
                            'name' => 'test',
                        ],
                    ],
                ],
            ]
        );
    }

    public function requestShouldReturnResponseWithCorrectStructure(ApiTester $I): void
    {
        $I->sendGET($this->url . '?id=100666');

        $I->seeResponseMatchesJsonType(
            [
                'data' => [
                    'result' => [
                        [
                            'id' => 'string',
                            'name' => 'string',
                        ],
                    ],
                ],
            ]
        );
    }
}
