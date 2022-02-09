<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ApiResponseLogging\Service\Tests;

use TeachersCommonBundle\Feature\ApiResponseLogging\Service\RequestOriginBeautifier;
use TeachersCommonBundle\Tests\Service\KernelTestCase;

class RequestOriginBeautifierTest extends KernelTestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testExtractor(?string $origin, string $expected, string $baseDomain): void
    {
        $beautifier = new RequestOriginBeautifier($baseDomain);

        self::assertEquals(
            $expected,
            $beautifier->beautify($origin)
        );
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingTraversableTypeHintSpecification
     */
    public function dataProvider(): array
    {
        return [
            [
                '',
                'UNKNOWN',
                'test-y8.skyeng.link',
            ],
            [
                null,
                'UNKNOWN',
                'test-y8.skyeng.link',
            ],
            [
                'https://trm.test-y8.skyeng.link:4200',
                'trm',
                'test-y8.skyeng.link',
            ],
            [
                'http://trm.test-y8.skyeng.link:4200',
                'trm',
                'test-y8.skyeng.link',
            ],
            [
                'https://trm.skyeng.ru:433',
                'trm_skyeng_ru',
                'test-y8.skyeng.link',
            ],
            [
                'https://api.teachers-cabinet.skyeng.ru',
                'api_teachers-cabinet',
                'skyeng.ru',
            ],
            [
                'https://teacher.skyeng.ru',
                'teacher',
                'skyeng.ru',
            ],
        ];
    }
}
