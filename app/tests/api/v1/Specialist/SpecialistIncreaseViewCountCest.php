<?php

namespace App\Tests\api\v1\Specialist;

use App\Tests\ApiTester;
use Codeception\Example;
use Codeception\Util\HttpCode;

class SpecialistIncreaseViewCountCest
{
    private string $url = '/api/v1/specialist_increment-view-count';

    /**
     * @param ApiTester $I
     */
    public function requestWithValidIdParamShouldReturn200ResponseCode(ApiTester $I): void
    {
        $I->sendPOST($this->url, ['id' => 13]);

        $I->seeResponseCodeIs(HttpCode::OK);
    }

    /**
     * @param ApiTester $I
     * @param Example   $example
     *
     * @dataProvider invalidIdParamDataProvider
     */
    public function requestWithInvalidIdParamShouldReturn400ResponseCode(ApiTester $I, Example $example): void
    {
        $I->sendPOST($this->url, ['id' => $example['invalidIdParam']]);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    private function invalidIdParamDataProvider(): array
    {
        return [
            ['invalidIdParam' => 'string'],
            ['invalidIdParam' => ''],
            ['invalidIdParam' => '!'],
            ['invalidIdParam' => -1],
            ['invalidIdParam' => 0],
        ];
    }
}
