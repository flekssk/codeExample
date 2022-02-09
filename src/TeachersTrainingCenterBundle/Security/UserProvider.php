<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Security;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

final class UserProvider
{
    private TokenStorageInterface $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function getUser(): User
    {
        if (!$this->hasAuthenticatedUser()) {
            throw new AccessDeniedException();
        }

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        return $user;
    }

    private function hasAuthenticatedUser(): bool
    {
        return $this->tokenStorage->getToken() && $this->tokenStorage->getToken()->getUser() instanceof User;
    }
}
