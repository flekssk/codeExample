<?php

declare(strict_types=1);

namespace App\Tests\api\v1\SpecialistDocument;

use App\Tests\ApiTester;
use Codeception\Util\HttpCode;

/**
 * Class SpecialistDocumentGetHtmlCest
 * @package App\Tests\api\v1\SpecialistDocument
 */
class SpecialistDocumentGetHtmlCest
{
    /**
     * @var string
     */
    private string $url = '/api/v1/specialist-document-html_get-by-id';

    /**
     * @param ApiTester $I
     */
    public function requestWithExistingIdShouldReturn200ResponseCode(ApiTester $I): void
    {
        $I->sendGET($this->url, ['id' => 1]);

        $I->seeResponseCodeIs(HttpCode::OK);
    }

    /**
     * @param ApiTester $I
     */
    public function requestWithIncorrectIdIdShouldReturn400ResponseCode(ApiTester $I): void
    {
        $I->sendGET($this->url, ['id' => 0]);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    /**
     * @param ApiTester $I
     */
    public function requestShouldReturnResponseWithCorrectStructure(ApiTester $I): void
    {
        $I->sendGET($this->url, ['id' => 1]);

        $I->seeResponseMatchesJsonType([
           'data' => [
               'result' => 'string'
           ]
        ]);
    }
}
