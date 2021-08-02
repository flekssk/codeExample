<?php

namespace App\Tests\api\v1\AttestationCommissionMember;

use App\Tests\ApiTester;
use Codeception\Util\HttpCode;

/**
 * Class AttestationCommissionMemberGetListCest.
 *
 * @package App\Tests\api\v1\AttestationCommissionMember
 *
 * @covers \App\UI\Controller\Api\AttestationCommissionMember\AttestationCommissionMemberGetListController
 */
class AttestationCommissionMemberGetListCest
{
    /**
     * @var string
     */
    private string $url = '/api/v1/attestation-commission-member_get-list';

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
    public function requestShouldReturnResponseWithCorrectStructure(ApiTester $I): void
    {
        $I->sendGET($this->url);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseMatchesJsonType([
            'message' => 'string',
            'data' => [
                'result' => [
                    [
                        'id' => 'integer',
                        'firstName' => 'string',
                        'secondName' => 'string',
                        'middleName' => 'string',
                        'imageUrl' => 'string',
                        'isLeader' => 'boolean',
                    ]
                ]
            ],
        ]);
    }
}
