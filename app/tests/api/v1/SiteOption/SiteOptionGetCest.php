<?php

declare(strict_types=1);

namespace App\Tests\api\v1\SiteOption;

use App\Tests\ApiTester;
use Codeception\Example;
use Codeception\Util\HttpCode;

/**
 * Class SiteOptionGetCest.
 *
 * @package App\Tests\api\v1\SiteOption
 * @covers \App\UI\Controller\Api\SiteOption\SiteOptionGetController
 */
class SiteOptionGetCest
{
    private string $url = 'api/v1/option/site-option_get';

    private array $correctSingleOptionsName = [
        'mainPageWidget'
    ];

    private array $correctMultipleOptionsNames = [
        'mainPageText',
        'mainPageWidget'
    ];

    public function requestWithSingleParameterShouldReturn200ResponseCode(ApiTester $I): void
    {
        $I->sendGET($this->url, ['name' => $this->correctSingleOptionsName]);

        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function requestWithMultipleParameterShouldReturnCorrectDataInResponse(ApiTester $I): void
    {
        $I->sendGET($this->url, ['name' => $this->correctMultipleOptionsNames]);

        $I->seeResponseContainsJson(
            [
                'data' => [
                    'result' => [
                        [
                            'name' => 'mainPageText',
                            'value' => 'mainPageText',
                        ],
                        [
                            'name' => 'mainPageWidget',
                            'value' => 'mainPageWidgetText',
                        ],
                    ],
                ]
            ]
        );
    }

    public function requestWithoutParameterShouldReturnCorrectDataInResponse(ApiTester $I): void
    {
        $I->sendGET($this->url);

        $I->seeResponseContainsJson(
            [
                'data' => [
                    'result' => [
                        [
                            'name' => 'mainPageText',
                            'value' => 'mainPageText',
                        ],
                        [
                            'name' => 'mainPageWidget',
                            'value' => 'mainPageWidgetText',
                        ],
                    ],
                ]
            ]
        );
    }

    public function requestShouldReturnCorrectStructureInResponse(ApiTester $I): void
    {
        $I->sendGET($this->url, ['name' => $this->correctMultipleOptionsNames]);

        $I->seeResponseMatchesJsonType(
            [
                'data' => [
                    'result' => [
                        [
                            'name' => 'string',
                            'value' => 'string',
                        ],
                        [
                            'name' => 'string',
                            'value' => 'string',
                        ]
                    ],
                ]
            ]
        );
    }

    /**
     * @param ApiTester $I
     * @param Example $example
     * @dataProvider invalidParamsDataProvider
     */
    public function requestWithInvalidParameterShouldReturnEmptyArrayInResponse(ApiTester $I, Example $example): void
    {
        $I->sendGET($this->url, [
            'name' => $example['invalidParam']
        ]);

        $response = json_decode($I->grabResponse(), true);

        $I->assertEmpty($response['data']['result']);
    }

    private function invalidParamsDataProvider(): array
    {
        return [
            ['invalidParam' => ['asdfassd'],
            ],
            ['invalidParam' => [''],
            ]
        ];
    }
}
