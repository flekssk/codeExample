<?php

namespace App\Domain\Repository\EntityRevision;

use App\Domain\Entity\EntityRevision\EntityRevision;

/**
 * Interface EntityRevisionRepositoryInterface.
 *
 * @method EntityRevision|null find($id, $lockMode = null, $lockVersion = null)
 * @method EntityRevision|null findOneBy(array $criteria, array $orderBy = null)
 * @method EntityRevision[]    findAll()
 * @method EntityRevision[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @package App\Domain\Repository\EntityRevision
 */
interface EntityRevisionRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function save(EntityRevision $entityRevision): void;

    /**
     * @inheritdoc
     */
    public function delete(EntityRevision $entityRevision): void;
}
