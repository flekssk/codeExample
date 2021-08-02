<?php

namespace App\Tests\api\v1\Specialist;

use App\Tests\ApiTester;
use Codeception\Util\HttpCode;

/**
 * Class SpecialistSearchCest.
 *
 * @package App\Tests\api\v1\Specialist
 * @covers \App\UI\Controller\Api\Specialist\SpecialistSearchController
 */
class SpecialistSearchCest
{
    /**
     * @var string
     */
    private string $url = '/api/v1/specialist_search';

    private array $correctSpecialistsFirstNames = [
        'First name',
    ];

    private array $incorrectSpecialistsFirstNames = [
        'First name',
    ];

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestShouldReturn200ResponseCode(ApiTester $I): void
    {
        $I->sendGET($this->url, ['page' => 1, 'perPage' => 1]);

        $I->seeResponseCodeIs(HttpCode::OK);
    }

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestShouldReturnCorrectJsonSchema(ApiTester $I): void
    {
        foreach ($this->correctSpecialistsFirstNames as $correctSpecialistsFirstName) {
            $I->sendGET(
                $this->url,
                [
                    'page' => 1,
                    'perPage' => 1,
                    'searchString' => $correctSpecialistsFirstName
                ]
            );

            $I->seeResponseCodeIs(HttpCode::OK);
            $I->seeResponseContainsJson(
                [
                    'data' => [
                        'result' => [],
                    ]
                ]
            );
        }
    }

    /**
     * @param ApiTester $I
     */
    public function requestWithoutParamsShouldReturnCorrectJsonSchema(ApiTester $I): void
    {
        $I->sendGET($this->url, ['page' => 1, 'perPage' => 1]);

        $I->seeResponseMatchesJsonType(
            [
                'data' => [
                    'result' => [
                        [
                            'id' => 'integer',
                            'firstName' => 'string|null',
                            'secondName' => 'string|null',
                            'middleName' => 'string|null',
                            'id2Position' => 'string|null',
                            'region' => 'string|null',
                            'status' => 'integer',
                            'company' => 'string|null',
                        ]
                    ]
                ],
            ]
        );
    }
}
