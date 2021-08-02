<?php

declare(strict_types=1);

namespace App\Tests\api\v1\Swagger;

use App\Tests\ApiTester;
use Codeception\Util\HttpCode;

/**
 * Class SwaggerHealthCheckTest.
 *
 * @package App\Tests\api\v1\Swagger
 */
class SwaggerHealthCheckCest
{
    /**
     * @var string
     */
    private string $url = '/_/swaggerui';

    /**
     * @param ApiTester $I
     */
    public function requestToSwaggerShouldReturn200ResponseCode(ApiTester $I): void
    {
        $I->sendGET($this->url);

        $I->seeResponseCodeIs(HttpCode::OK);
    }
}
