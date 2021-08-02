<?php

namespace App\Domain\Repository;

use App\Domain\Entity\SiteOption;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * Interface SiteOptionRepositoryInterface.
 *
 * @package App\Domain\Repository
 */
interface SiteOptionRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return SiteOption
     */
    public function get(int $id): SiteOption;

    /**
     * @param string $name
     *
     * @return SiteOption
     */
    public function findOneByName(string $name): SiteOption;

    /**
     * @return array
     */
    public function findAllOptions(): array;

    /**
     * @param SiteOption $option
     *
     * @throws OptimisticLockException|ORMException
     */
    public function save(SiteOption $option): void;
}
