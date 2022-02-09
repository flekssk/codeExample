<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\Security\Service;

class MockJwtGenerator
{
    private string $privateKeyPath;

    public function __construct(string $privateKeyPath)
    {
        $this->privateKeyPath = $privateKeyPath;
    }

    /**
     * @param string[] $roles
     */
    public function generateWithRoles(array $roles): string
    {
        $header = json_encode(
            [
                'typ' => 'JWT',
                'alg' => 'RS256',
            ],
            \JSON_THROW_ON_ERROR
        );

        $token = $this->base64UrlEncode($header)
            . '.' . $this->base64UrlEncode($this->getPayload($roles));

        $privateKey = openssl_pkey_get_private(file_get_contents($this->privateKeyPath));
        $signature = '';

        openssl_sign($token, $signature, $privateKey, \OPENSSL_ALGO_SHA256);

        return $token
            . '.' . $this->base64UrlEncode($signature);
    }

    /**
     * @param string[] $roles
     */
    private function getPayload(array $roles): string
    {
        $data = json_decode(
            <<<'JSON'
                {
                  "userId": 12345,
                  "identity": "test@skyeng.ru",
                  "identityLogin": null,
                  "identityEmail": "test@skyeng.ru",
                  "identityPhone": "+79211234567",
                  "roles": [],
                  "name": "Test",
                  "surname": "User",
                  "email": "test@skyeng.ru",
                  "uiLanguage": "en",
                  "locale": "en",
                  "jwtType": 1,
                  "exp": 2054808551,
                  "avatarUrl": "https://auth-avatars-dev-skyeng.imgix.net/12345",
                  "birthday": "2001-01-01",
                  "aType": "USERNAME_PASSWORD",
                  "aTime": 1612958933
                }
            JSON,
            false,
            512,
            \JSON_THROW_ON_ERROR
        );

        $data->roles = $roles;

        return json_encode($data, \JSON_THROW_ON_ERROR);
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint
     */
    private function base64UrlEncode($data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}
