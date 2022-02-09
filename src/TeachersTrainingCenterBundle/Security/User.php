<?php

namespace TeachersTrainingCenterBundle\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;

class User implements JWTUserInterface
{
    private $userId;

    private $roles;

    private $name;

    private $surname;

    private $identity;

    private $email;

    private $uiLanguage;

    private $avatarUrl;

    private $birthday;

    private $age;

    public function __construct(
        int $userId,
        array $roles,
        string $identity,
        ?string $name = null,
        ?string $surname = null,
        ?string $email = null,
        ?string $uiLanguage = null,
        ?string $avatarUrl = null,
        ?string $birthday = null,
        ?int $age = null
    ) {
        $this->userId = $userId;
        $this->roles = $roles;
        $this->name = $name;
        $this->surname = $surname;
        $this->identity = $identity;
        $this->email = $email;
        $this->uiLanguage = $uiLanguage;
        $this->avatarUrl = $avatarUrl;
        $this->birthday = $birthday;
        $this->age = $age;
    }

    /**
     * {@inheritdoc}
     */
    public static function createFromPayload($username, array $payload): JWTUserInterface
    {
        $object = new static(
            $payload['userId'],
            $payload['roles'],
            $payload['identity'],
            $payload['name'] ?? null,
            $payload['surname'] ?? null,
            $payload['email'] ?? null,
            $payload['uiLanguage'] ?? null,
            $payload['avatarUrl'] ?? null,
            $payload['birthday'] ?? null,
            $payload['age'] ?? null,
        );

        return $object;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getPayload(): array
    {
        $result = [];
        foreach ($this as $key => $value) {
            $result[$key] = $value;
        }

        return $result;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getUsername(): string
    {
        return $this->identity;
    }

    public function getPassword(): ?string
    {
        return null;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
    }

    public function hasRole($role)
    {
        return in_array($role, $this->getRoles(), true);
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
