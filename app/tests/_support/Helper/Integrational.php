<?php

namespace App\Tests\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I


use App\Domain\Entity\ValueObject\Id;
use Ramsey\Uuid\Uuid;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Integrational extends \Codeception\Module
{
    /**
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     * @throws \Codeception\Exception\ModuleException
     */
    public function getContainer(): ContainerInterface
    {
        /** @var \Codeception\Module\Symfony $module */
        $module = $this->getModule('Symfony');

        return $module->kernel->getContainer();
    }

    /**
     * @return \App\Domain\Entity\ValueObject\Id
     * @throws \Exception
     */
    public function generateId(): Id
    {
        $uuid = Uuid::uuid4();

        return new Id($uuid->toString());
    }
}
