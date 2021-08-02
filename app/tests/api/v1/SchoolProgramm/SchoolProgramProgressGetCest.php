<?php

declare(strict_types=1);

namespace App\Tests\api\v1\RegulatoryDocuments;

use App\Tests\ApiTester;
use Codeception\Util\HttpCode;

/**
 * Class SchoolProgramProgressGetCest
 * @package App\Tests\api\v1\RegulatoryDocuments
 */
class SchoolProgramProgressGetCest
{
    /**
     * @var string
     */
    private string $url = '/api/v1/school-program_progress_get-by-specialist-id';

    /**
     * @param ApiTester $I
     */
    public function requestShouldReturn200ResponseCode(ApiTester $I): void
    {
        $I->sendGET($this->url, [
            'id' => '4468312',
        ]);

        $I->seeResponseCodeIs(HttpCode::OK);
    }

    /**
     * @param ApiTester $I
     */
    public function requestShouldReturn404ResponseCode(ApiTester $I): void
    {
        $I->sendGET($this->url, [
            'id' => '5',
        ]);

        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
    }

    /**
     * @param ApiTester $I
     */
    public function requestShouldReturn400ResponseCode(ApiTester $I): void
    {
        $I->sendGET($this->url);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    /**
     * @param ApiTester $I
     */
    public function requestShouldReturnCorrectStructure(ApiTester $I): void
    {
        $I->sendGET($this->url, [
            'id' => '4468312',
        ]);

        $I->seeResponseMatchesJsonType(
            [
                'data' => [
                    'result' => 'integer'
                ]
            ]
        );
    }
}
