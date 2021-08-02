<?php

declare(strict_types=1);

namespace App\Tests\api\v1\Skill;

use App\Tests\ApiTester;
use Codeception\Util\HttpCode;

/**
 * Class SkillSortCest.
 *
 * @package App\Tests\api\v1\Skill
 *
 * @covers \App\UI\Controller\EasyAdmin\SkillSortController
 */
class SkillSortCest
{
    /**
     * @var string
     */
    private string $macroSkillSortUrl = 'admin/macro-skill-sort';

    /**
     * @var string
     */
    private string $skillSortUrl = 'admin/skill-sort';

    /**
     * @var string
     */
    private string $macroSkillSortSaveUrl = 'admin/macro-skill-sort/save';

    /**
     * @var string
     */
    private string $skillSortSaveUrl = 'admin/skill-sort/save';

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestMacroSkillSortShouldReturn200ResponseCode(ApiTester $I): void
    {
        $I->sendGET($this->macroSkillSortUrl);

        $I->seeResponseCodeIs(HttpCode::OK);
    }

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestSkillSortShouldReturn200ResponseCode(ApiTester $I): void
    {
        $I->sendGET($this->skillSortUrl);

        $I->seeResponseCodeIs(HttpCode::OK);
    }

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestMacroSkillSortSaveShouldReturn200ResponseCode(ApiTester $I): void
    {
        $params = [
            [
                'id' => 'a9251699-d500-465b-879d-9e1bd9936aee',
                'index' => 3,
            ],
            [
                'id' => '5e1df3df-b1a1-4ab0-8ad9-1677f7404f8a',
                'index' => 0,
            ],
            [
                'id' => 'cd3d6971-5335-4d67-9463-e4c4373aaa7e',
                'index' => 2,
            ],
            [
                'id' => '1da80835-8566-4f43-a722-fa83af8223ef',
                'index' => 0,
            ],
        ];

        $I->sendPOST($this->macroSkillSortSaveUrl, $params);

        $I->seeResponseCodeIs(HttpCode::OK);
    }

    /**
     * @param ApiTester $I
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function requestSkillSortSaveShouldReturn200ResponseCode(ApiTester $I): void
    {
        $params = [
            [
                'id' => '2',
                'index' => 1,
            ],
            [
                'id' => '3',
                'index' => 2,
            ],
            [
                'id' => '4',
                'index' => 3,
            ],
            [
                'id' => '5',
                'index' => 0,
            ],
            [
                'id' => '6',
                'index' => 1,
            ],
            [
                'id' => '7',
                'index' => 2,
            ],
            [
                'id' => '8',
                'index' => 0,
            ],
            [
                'id' => '9',
                'index' => 1,
            ],
            [
                'id' => '10',
                'index' => 0,
            ],
            [
                'id' => '11',
                'index' => 0,
            ],
        ];

        $I->sendPOST($this->skillSortSaveUrl, $params);

        $I->seeResponseCodeIs(HttpCode::OK);
    }
}
