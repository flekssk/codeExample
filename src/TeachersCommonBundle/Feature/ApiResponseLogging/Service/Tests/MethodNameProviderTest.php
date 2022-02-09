<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ApiResponseLogging\Service\Tests;

use TeachersCommonBundle\Feature\ApiResponseLogging\Service\MethodNameProvider;
use TeachersCommonBundle\Tests\Service\KernelTestCase;

class MethodNameProviderTest extends KernelTestCase
{
    protected MethodNameProvider $provider;

    public function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        /** @var MethodNameProvider $provider */
        $provider = self::$container->get(MethodNameProvider::class);
        $this->provider = $provider;
    }

    /**
     * @dataProvider uriProvider
     */
    public function testProvider(string $uri, string $rootUri, string $expected): void
    {
        self::assertEquals($expected, $this->provider->getName($uri, $rootUri));
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingTraversableTypeHintSpecification
     */
    public function uriProvider(): array
    {
        return [
            [
                '/server-api/v1/teacher/getForBusinessRulesBulk',
                '/server-api/',
                'v1_teacher_getForBusinessRulesBulk',
            ],
            [
                '/server-api/v1/teacher/getForBusinessRulesBulk',
                '/api/',
                '_server-api_v1_teacher_getForBusinessRulesBulk',
            ],
            [
                '/api/v1/teacherMetadata/getJsonSchemaForWriting',
                '/api/',
                'v1_teacherMetadata_getJsonSchemaForWriting',
            ],
            [
                '/api/v1/teacherMetadata/getJsonSchemaForWriting',
                '',
                '_api_v1_teacherMetadata_getJsonSchemaForWriting',
            ],
        ];
    }
}
