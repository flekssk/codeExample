<?php

namespace App\Tests\api\v1\specialist;

use App\Tests\ApiTester;
use Codeception\Util\HttpCode;

/**
 * Class SpecialistSearchSimpleCests.
 *
 * @package App\Tests\api\v1\specialist
 * @covers \App\UI\Controller\Api\Specialist\SpecialistSearchSimpleController
 */
class SpecialistSearchSimpleCest
{

    /**
     * @var string
     */
    private string $url = '/api/v1/specialist_search-simple';

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestShouldReturn200ResponseCode(ApiTester $I): void
    {
        $I->sendGET($this->url . '?count=1&searchString=Иванов');
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    /**
     * @param ApiTester $I
     */
    public function requestShouldReturnResponseWithCorrectStructure(ApiTester $I): void
    {
        $I->sendGET(
            $this->url,
            [
                'count' => 1,
                'searchString' => 'Иванов',
            ]
        );

        $I->seeResponseMatchesJsonType(
            [
                'data' => [
                    'result' => [
                        [
                            'id' => 'integer',
                            'firstName' => 'string|null',
                            'secondName' => 'string|null',
                            'middleName' => 'string|null',
                            'status' => 'integer',
                        ]
                    ]
                ]
            ]
        );
    }
}
