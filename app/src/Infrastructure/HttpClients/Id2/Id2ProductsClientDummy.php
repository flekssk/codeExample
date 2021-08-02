<?php

namespace App\Infrastructure\HttpClients\Id2;

use App\Domain\Entity\SpecialistAccess\SpecialistAccess;
use App\Domain\Repository\NotFoundException;
use App\Infrastructure\HttpClients\Id2\Assembler\Id2UserAssembler;
use App\Infrastructure\HttpClients\Id2\Response\UserGetResponse;

/**
 * Class Id2ProductsClientDummy.
 *
 * @package App\Infrastructure\HttpClients\Id2
 */
class Id2ProductsClientDummy implements Id2ProductsClientInterface
{
    /**
     * @var int[]
     */
    private array $existedUserId = [
        1,
        1001,
    ];

    /**
     * @inheritDoc
     */
    public function getAccesses(int $id): array
    {
        $accesses = [];
        $access = new SpecialistAccess();
        $access->setSpecialistId($id);
        $access->setProductId(4999);
        $access->setDateStart(new \DateTimeImmutable('2020-01-01'));
        $access->setDateEnd(new \DateTimeImmutable('2020-12-01'));
        $accesses[] = $access;

        return $accesses;
    }
}
