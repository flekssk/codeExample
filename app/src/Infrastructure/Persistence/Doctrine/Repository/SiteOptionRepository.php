<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Entity\SiteOption;
use App\Domain\Repository\NotFoundException;
use App\Domain\Repository\SiteOptionRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class SiteOptionRepository.
 *
 * @package App\Infrastructure\Persistence\Doctrine\Repository
 */
class SiteOptionRepository extends ServiceEntityRepository implements SiteOptionRepositoryInterface
{
    /**
     * SiteOptionRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SiteOption::class);
    }

    /**
     * @inheritDoc
     */
    public function get(int $id): SiteOption
    {
        /** @var SiteOption $option */
        $option = $this->find($id);

        if ($option === null) {
            throw new NotFoundException(sprintf('Опция с id %s не найдена', (string) $id));
        }

        return $option;
    }

    /**
     * @inheritDoc
     */
    public function save(SiteOption $option): void
    {
        try {
            $this->getEntityManager()->persist($option);
            $this->getEntityManager()->flush();
        } catch (OptimisticLockException | ORMException $e) {
            throw new \RuntimeException($e->getMessage(), (int) $e->getCode(), $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function findOneByName(string $name): SiteOption
    {
        /** @var SiteOption $option */
        $option = $this->findOneBy(['name' => $name]);

        if ($option === null) {
            throw new NotFoundException(sprintf('Опция с именем %s не существует.', $name));
        }

        return $option;
    }

    /**
     * @inheritDoc
     */
    public function findAllOptions(): array
    {
        return $this->findAll();
    }
}
