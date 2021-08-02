<?php

namespace App\Tests\api\v1\SpecialistDocument;

use App\Tests\ApiTester;
use Codeception\Util\HttpCode;

/**
 * Class SpecialistDocumentGetBySpecialistIdCest.
 *
 * @package App\Tests\api\v1\SpecialistDocument
 * @covers \App\UI\Controller\Api\SpecialistDocument\SpecialistDocumentGetBySpecialistIdController
 */
class SpecialistDocumentGetBySpecialistIdCest
{

    /**
     * @var string
     */
    private string $url = '/api/v1/specialist-document_get-by-specialist-id';

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestShouldReturn200ResponseCode(ApiTester $I): void
    {
        $I->sendGET($this->url . '?id=1');
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    /**
     * @param ApiTester $I
     */
    public function requestShouldReturnResponseWithCorrectStructure(ApiTester $I): void
    {
        $id = 100666;

        $I->sendGET($this->url, ['id' => $id]);

        $I->seeResponseMatchesJsonType(
            [
                'data' => [
                    'result' => [
                        [
                            'id' => 'integer',
                            'name' => 'string',
                            'disciplinesName' => 'string',
                            'specialistId' => 'integer',
                            'imageUrl' => 'string',
                            'previewUrl' => 'string',
                            'pdfUrl' => 'string',
                        ],
                    ]
                ],
            ]
        );
    }
}
