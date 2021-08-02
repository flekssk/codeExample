<?php

declare(strict_types=1);

namespace App\Tests\api\v1\RegulatoryDocuments;

use App\Tests\ApiTester;
use Codeception\Util\HttpCode;

/**
 * Class RegulatoryDocumentsGetCest
 * @package App\Tests\api\v1\RegulatoryDocuments
 */
class RegulatoryDocumentsGetCest
{
    /**
     * @var string
     */
    private string $url = '/api/v1/regulatory-documents_get-list';

    /**
     * @param ApiTester $I
     */
    public function requestShouldReturn200ResponseCode(ApiTester $I): void
    {
        $I->sendGET($this->url);

        $I->seeResponseCodeIs(HttpCode::OK);
    }

    /**
     * @param ApiTester $I
     */
    public function requestShouldReturnCorrectStructure(ApiTester $I): void
    {
        $I->sendGET($this->url);

        $I->seeResponseMatchesJsonType(
            [
                'data' => [
                    'result' => [
                        [
                            'title' => 'string',
                            'url' => 'string'
                        ]
                    ]
                ]
            ]
        );
    }
}
