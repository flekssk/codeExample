<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    /**
     * @var array
     */
    const ROLE_REAL_NAME = [
        'ROLE_GUEST' => 'Гость',
        'ROLE_MARKETER' => 'Редактор',
        'ROLE_SUPERVISOR' => 'Руководитель',
        'ROLE_ADMIN' => 'Администратор',
    ];

    private const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $roles;

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var string
     */
    private $email = '';

    /**
     * @var boolean
     */
    private $isActive;

    /**
     * @var \DateTimeInterface
     */
    private $createdAt;

    /**
     * @var \DateTimeInterface|null
     */
    private $deletedAt;

    /**
     * User constructor.
     * @param string $role
     * @throws \Exception
     *
     * @codeCoverageIgnore
     */
    public function __construct(
        string $role = 'ROLE_GUEST'
    ) {
        $this->roles = $role;
        $this->isActive = true;
        $this->createdAt = new \DateTimeImmutable();
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getId(): string
    {
        return (string)$this->uuid;
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getUuid(): string
    {
        return (string)$this->uuid;
    }


    /**
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return bool
     *
     * @codeCoverageIgnore
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @return \DateTimeInterface
     *
     * @codeCoverageIgnore
     */
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getRole(): string
    {
        return static::ROLE_REAL_NAME[$this->roles];
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getRoleRealName(): string
    {
        return $this->roles;
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getRoleRealNameByAdmin(): string
    {
        return $this->roles;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     *
     * @codeCoverageIgnore
     */
    public function getUsername(): string
    {
        return $this->name;
    }

    /**
     * @see UserInterface
     *
     * @psalm-suppress DeprecatedClass
     *
     * @codeCoverageIgnore
     */
    public function getRoles(): array
    {
        return (array)$this->roles;
    }

    /**
     * @return \DateTimeInterface|null
     *
     * @codeCoverageIgnore
     */
    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    /**
     * @param \DateTimeInterface|null $deletedAt
     *
     * @codeCoverageIgnore
     */
    public function setDeletedAt(?\DateTimeInterface $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    /**
     * @param string $uuid
     *
     * @codeCoverageIgnore
     */
    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @param string $name
     *
     * @codeCoverageIgnore
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $email
     *
     * @codeCoverageIgnore
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param string $roles
     *
     * @codeCoverageIgnore
     */
    public function setRoles(string $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @param string $role
     *
     * @codeCoverageIgnore
     */
    public function setRoleRealName(string $role): void
    {
        if ($this->roles !== self::ROLE_ADMIN && $role !== self::ROLE_ADMIN) {
            $this->roles = $role;
        }
    }

    /**
     * @param string $role
     *
     * @codeCoverageIgnore
     */
    public function setRoleRealNameByAdmin(string $role): void
    {
        $this->roles = $role;
    }

    /**
     * @param bool $isActive
     *
     * @codeCoverageIgnore
     */
    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    /**
     * @see UserInterface
     *
     * @codeCoverageIgnore
     */
    public function getPassword()
    {
        // not needed for apps that do not check user passwords
    }

    /**
     * @see UserInterface
     *
     * @codeCoverageIgnore
     */
    public function getSalt()
    {
        // not needed for apps that do not check user passwords
    }

    /**
     * @see UserInterface
     *
     * @codeCoverageIgnore
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
