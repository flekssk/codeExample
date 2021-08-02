<?php

namespace App\Tests\api\v1\specialist_after_sign_in;

use App\Tests\ApiTester;
use Codeception\Util\HttpCode;

class SpecialistAfterSignInCest
{
    private string $url = '/api/v1/specialist_after-sign-in';

    public function requestWithoutRequiredParamShouldReturn400ResponseCode(ApiTester $I): void
    {
        $I->sendPOST($this->url);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    public function requestWithRequiredParamShouldReturn200ResponseCode(ApiTester $I): void
    {
        $userId = 100666;

        $I->sendPOST($this->url, ['userId' => $userId]);

        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function requestWithNonexistentGetParamShouldReturn404ResponseCode(ApiTester $I): void
    {
        $userId = 1111;

        $I->sendPOST($this->url, ['userId' => $userId]);

        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
    }
}
