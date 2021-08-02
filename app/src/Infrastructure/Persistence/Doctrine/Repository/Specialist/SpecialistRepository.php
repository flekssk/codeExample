<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Specialist;

use App\Domain\Entity\Specialist\Specialist;
use App\Domain\Repository\NotFoundException;
use App\Domain\Repository\Specialist\SpecialistRepositoryInterface;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use RuntimeException;

/**
 * Class SpecialistRepository.
 *
 * @method Specialist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Specialist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Specialist[]    findAll()
 * @method Specialist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @package App\Infrastructure\Persistence\Doctrine\Repository\Specialist
 */
class SpecialistRepository extends ServiceEntityRepository implements SpecialistRepositoryInterface
{
    /**
     * SpecialistRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Specialist::class);
    }

    /**
     * @inheritDoc
     */
    public function get(int $id): Specialist
    {
        /** @var Specialist $client */
        $client = $this->find($id);

        if ($client === null) {
            throw new NotFoundException(sprintf('Specialist with ID %s not found', (string) $id));
        }

        return $client;
    }

    /**
     * @inheritDoc
     */
    public function save(Specialist $specialist): void
    {
        try {
            $this->getEntityManager()->persist($specialist);
            $this->getEntityManager()->flush();
        } catch (OptimisticLockException|ORMException $e) {
            throw new RuntimeException($e->getMessage(), (int) $e->getCode(), $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function totalCount(): int
    {
        return $this->count([]);
    }

    /**
     * @inheritDoc
     */
    public function has(int $id): bool
    {
        return $this->count(['id' => $id]) > 0;
    }

    /**
     * @inheritDoc
     */
    public function findSpecialistsIDsByCreationDateRange(DateTimeInterface $from, DateTimeInterface $to = null): array
    {
        if ($to === null) {
            $to = new DateTimeImmutable();
        }

        return $this->getEntityManager()->createQueryBuilder()
            ->select('s.id')
            ->from(Specialist::class, 's')
            ->where('s.createdAt >= :from')
            ->andWhere('s.createdAt <= :to')
            ->setParameter('from', $from, Types::DATETIME_IMMUTABLE)
            ->setParameter('to', $to, Types::DATETIME_IMMUTABLE)
            ->getQuery()
            ->getResult(AbstractQuery::HYDRATE_SCALAR);
    }

    /**
     * @inheritDoc
     */
    public function findAllSpecialist(): array
    {
        return $this->findAll();
    }

    /**
     * @inheritDoc
     */
    public function findAllSpecialistsIDs(string $criteria = '', ?int $limit = null): array
    {
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('s.id')
            ->from(Specialist::class, 's');

        if (!empty($criteria)) {
            $query->where($criteria);
        }

        if (is_int($limit)) {
            $query->setMaxResults($limit);
        }

        return $query->getQuery()->getResult(AbstractQuery::HYDRATE_SCALAR);
    }
}
