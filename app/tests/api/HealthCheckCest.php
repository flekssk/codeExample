<?php

namespace App\Tests\api;

use App\Tests\ApiTester;
use Codeception\Util\HttpCode;

class HealthCheckCest
{
    public function requestShouldReturnStatusInfo(ApiTester $I): void
    {
        $I->sendGET('/_/status/');

        $I->seeResponseCodeIs(HttpCode::OK);
    }
}
