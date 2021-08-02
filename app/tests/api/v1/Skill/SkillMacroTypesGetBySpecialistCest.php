<?php

namespace App\Tests\api\v1\Skill;

use App\Tests\ApiTester;
use Codeception\Util\HttpCode;

/**
 * Class SkillMacroTypesGetBySpecialistCest.
 *
 * @package App\Tests\api\v1\Skill
 * @covers \App\UI\Controller\Api\Skill\SkillMacroTypesGetBySpecialistController
 */
class SkillMacroTypesGetBySpecialistCest
{
    /**
     * @var string
     */
    private string $url = 'api/v1/skill-macro-types_get-by-specialist-id';

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
                    'result' => [
                        [
                            'id' => 'string',
                            'name' => 'string',
                            'macros' => [
                                [
                                    'id' => 'string',
                                    'name' => 'string',
                                    'skills' => [
                                        [
                                            'percent' => 'integer|float',
                                            'id' => 'string',
                                            'name' => 'string',
                                            'degradation' => 'integer',
                                            'improveLink' => 'string|null',
                                        ]
                                    ]
                                ]
                            ],
                            'description' => 'string'
                        ]
                    ],
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
