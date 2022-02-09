<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Tests\Service;

use JMS\Serializer\SerializerInterface;
use Opis\JsonSchema\ISchemaLoader;
use Opis\JsonSchema\IValidator;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use TeachersCommonBundle\Feature\ConventionalResponse\DTO\ConventionalResponseErrorDTO;

abstract class WebTestCase extends BaseWebTestCase
{
    use MemoryLeakingPreventTrait;

    protected const TEST_USERNAME = 'test_user';
    protected const TEST_PASSWORD = 'test_user_password';

    protected const AUTH_NONE = 'none';
    protected const AUTH_BASIC = 'basic';
    protected const AUTH_JWT = 'jwt';

    protected KernelBrowser $client;

    protected ISchemaLoader $jsonSchemaLoader;

    protected IValidator $jsonSchemaValidator;

    protected SerializerInterface $serializer;

    abstract protected function getUri(): string;

    public function setUp(): void
    {
        $this->client = static::createClient();

        self::bootKernel();

        /** @var SerializerInterface $serializer */
        $serializer = self::$container->get(SerializerInterface::class);
        $this->serializer = $serializer;
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingAnyTypeHint
     */
    protected function makeSuccessfulRequest(
        ?string $content = null,
        ?string $uri = null,
        ?string $method = null,
        ?string $authScheme = null,
        ?string $jwtToken = null
    ) {
        $response = $this->makeAuthorizedRequest($content, $uri, $method, $authScheme, $jwtToken);

        self::assertNull($response->errors);

        return $response->data;
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingAnyTypeHint
     */
    protected function makeRequestWithErrors(
        ?string $content = null,
        ?string $uri = null,
        ?string $method = null,
        ?string $authScheme = null,
        ?string $jwtToken = null
    ) {
        $response = $this->makeAuthorizedRequest($content, $uri, $method, $authScheme, $jwtToken);

        self::assertNull($response->data);
        self::assertNotNull($response->errors);
        self::assertIsArray($response->errors);

        foreach ($response->errors as $error) {
            $this->assertCorrespondsToJsonSchema($error, '/response/ConventionalApiError.json');
        }

        return $response->errors;
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingAnyTypeHint
     */
    protected function makeAuthorizedRequest(
        ?string $content = null,
        ?string $uri = null,
        ?string $method = null,
        ?string $authScheme = null,
        ?string $jwtToken = null
    ) {
        $this->makeRequest($content, $uri, $method, $authScheme, $jwtToken);
        self::assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );

        self::assertJson($this->client->getResponse()->getContent());

        $response = json_decode($this->client->getResponse()->getContent(), false, 512, \JSON_THROW_ON_ERROR);

        self::assertObjectHasAttribute('data', $response);
        self::assertObjectHasAttribute('errors', $response);

        return $response;
    }

    protected function makeRequest(
        ?string $content = null,
        ?string $uri = null,
        ?string $method = null,
        ?string $authScheme = null,
        ?string $jwtToken = null
    ): void {
        $headers = [
            'CONTENT_TYPE' => 'application/json',
        ];

        switch ($authScheme ?? $this->getAuthScheme()) {
            case self::AUTH_BASIC:
                $headers['PHP_AUTH_USER'] = self::TEST_USERNAME;
                $headers['PHP_AUTH_PW'] = self::TEST_PASSWORD;

                break;
            case self::AUTH_JWT:
                $this->client->getCookieJar()->set(new Cookie(
                    'token_global',
                    $jwtToken ?? $this->getJwtToken()
                ));

                break;
        }

        $this->client->request(
            $method ?? $this->getMethod(),
            $uri ?? $this->getUri(),
            [],
            [],
            $headers,
            $content
        );
    }

    protected function assertUnauthorizedAccessForbidden(
        string $authScheme = self::AUTH_NONE,
        ?string $jwtToken = null
    ): void {
        $this->makeRequest(null, $this->getUri(), $this->getMethod(), $authScheme, $jwtToken);

        self::assertEquals(
            Response::HTTP_UNAUTHORIZED,
            $this->client->getResponse()->getStatusCode()
        );
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint
     */
    protected function assertCorrespondsToJsonSchema($data, string $schemaUri): void
    {
        $schema = $this->jsonSchemaLoader->loadSchema($schemaUri);

        self::assertNotNull($schema, 'Fail to load JSON schema ' . $schemaUri);

        $result = $this->jsonSchemaValidator->schemaValidation($data, $schema, 1, $this->jsonSchemaLoader);

        self::assertTrue($result->isValid(), 'Fail to check against JSON schema');
    }

    /**
     * @param ConventionalResponseErrorDTO[] $expectedErrors
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint
     */
    protected function assertExactErrors(array $expectedErrors, $errors): void
    {
        self::assertIsArray($errors);
        self::assertCount(
            count($expectedErrors),
            $errors,
            'Number of ConventionalResponseError differs from expected'
        );

        foreach ($errors as $error) {
            $this->assertErrorExists($error, $expectedErrors);
        }
    }

    /**
     * @param ConventionalResponseErrorDTO[] $expectedErrors
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint
     */
    protected function assertErrorExists($error, array $expectedErrors): void
    {
        $matchesFound = 0;

        foreach ($expectedErrors as $expectedError) {
            if ($this->errorEquals($expectedError, $error)) {
                $matchesFound += 1;
            }
        }

        self::assertEquals(
            1,
            $matchesFound,
            'Fail to found exact ConventionalResponseError' . \PHP_EOL . var_export($error, true)
        );
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint
     */
    protected function errorEquals(ConventionalResponseErrorDTO $expectedError, $error): bool
    {
        return $expectedError->property() === $error->property
            && $expectedError->error()->code() === $error->error->code
            && $expectedError->error()->message() === $error->error->message;
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingAnyTypeHint
     */
    protected function deserializeResponse($data, string $type)
    {
        return $this->serializer->deserialize(
            json_encode($data, \JSON_THROW_ON_ERROR),
            $type,
            'json'
        );
    }

    protected function getMethod(): string
    {
        return 'POST';
    }

    protected function getAuthScheme(): string
    {
        return self::AUTH_BASIC;
    }

    protected function getJwtToken(): string
    {
        // phpcs:ignore SlevomatCodingStandard.Files.LineLength.LineTooLong
        return 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJ1c2VySWQiOjEyMzQ1LCJpZGVudGl0eSI6InRlc3RAc2t5ZW5nLnJ1IiwiaWRlbnRpdHlMb2dpbiI6bnVsbCwiaWRlbnRpdHlFbWFpbCI6InRlc3RAc2t5ZW5nLnJ1IiwiaWRlbnRpdHlQaG9uZSI6Iis3OTIxMTIzNDU2NyIsInJvbGVzIjpbIlJPTEVfRFVNTVkiXSwibmFtZSI6IlRlc3QiLCJzdXJuYW1lIjoiVXNlciIsImVtYWlsIjoidGVzdEBza3llbmcucnUiLCJ1aUxhbmd1YWdlIjoiZW4iLCJsb2NhbGUiOiJlbiIsImp3dFR5cGUiOjEsImV4cCI6MjA1NDgwODU1MSwiYXZhdGFyVXJsIjoiaHR0cHM6XC9cL2F1dGgtYXZhdGFycy1kZXYtc2t5ZW5nLmltZ2l4Lm5ldFwvMTIzNDUiLCJiaXJ0aGRheSI6IjIwMDEtMDEtMDEiLCJhVHlwZSI6IlVTRVJOQU1FX1BBU1NXT1JEIiwiYVRpbWUiOjE2MTI5NTg5MzN9.G3uujkX9hG1KXWz3N3GLnIfe9x7hsEpACjVqUneipfD3Wzwk9v8cveJShpLvw8Tk0MuspQv3xeCctAIhm6iI_wnB3oX1OLxmJfa49aIyhJhuwTIO43sRQ9QPctw0PkdtKytThnlU1zDJG7zZbMtz-dvUOEqUtcmlYMw2U9AZPKNlWMI-yL3wXxke4-f52RKHsWwN8iMplzqXbHa_hOhjOUl_Jr-VYaxgbUZ3KZVzhiambV71u-s0e1qHfpIbxOScDjSukb0SSPbB8y26BK1qr1zuvQPUGrU6irFxxbVa-moMj-IwUocvtO3tpypSPgJN6kfLGvWaJ3bEsOVKNS5kRA';
    }
}
