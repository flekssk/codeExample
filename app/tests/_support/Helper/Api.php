<?php

namespace App\Tests\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use App\Domain\Entity\ValueObject\Email;
use App\Domain\Repository\Client\ClientRepositoryInterface;
use App\Infrastructure\AuthToken\AuthTokenGeneratorInterface;

class Api extends \Codeception\Module
{
    /**
     * @param string $email
     * @return mixed
     */
    public function amAuthenticatedByEmail(string $email)
    {
        return $this->getModule('REST')->amBearerAuthenticated($this->createJwtTokenForUserByEmail($email));
    }

    /**
     * @param string $email
     * @return string
     * @throws \Codeception\Exception\ModuleException
     */
    public function createJwtTokenForUserByEmail(string $email): string
    {
        $module = $this->getModule('Symfony');
        $container = $module->kernel->getContainer();

        /** @var AuthTokenGeneratorInterface $generator */
        $generator = $container->get(AuthTokenGeneratorInterface::class);

        /** @var ClientRepositoryInterface $clientRepository */
        $clientRepository = $container->get(ClientRepositoryInterface::class);

        $token = $generator->generateToken($clientRepository->getByEmail(new Email($email)));

        return (string)$token;
    }

    public function amFromPublic()
    {
        return $this->getModule('REST')->haveHttpHeader('x-pub', 1);
    }
}
