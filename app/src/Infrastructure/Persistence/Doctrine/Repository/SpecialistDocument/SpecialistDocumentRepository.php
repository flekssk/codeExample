<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\SpecialistDocument;

use App\Domain\Repository\NotFoundException;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Domain\Repository\SpecialistDocument\SpecialistDocumentRepositoryInterface;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Entity\SpecialistDocument\SpecialistDocument;

/**
 * Class SpecialistDocumentRepository.
 *
 * @method SpecialistDocument|null find($id, $lockMode = null, $lockVersion = null)
 * @method SpecialistDocument|null findOneBy(array $criteria, array $orderBy = null)
 * @method SpecialistDocument[]    findAll()
 * @method SpecialistDocument[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpecialistDocumentRepository extends ServiceEntityRepository implements SpecialistDocumentRepositoryInterface
{

    /**
     * Class constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SpecialistDocument::class);
    }

    /**
     * @inheritDoc
     */
    public function get(int $id): SpecialistDocument
    {
        /** @var SpecialistDocument $document */
        $document = $this->find($id);

        if ($document === null) {
            throw new NotFoundException(sprintf('SpecialistDocument with ID %s not found', (string) $id));
        }

        return $document;
    }

    /**
     * @inheritDoc
     */
    public function findAllBySpecialistId(int $specialistId): array
    {
        return $this->findBy([
            'specialistId' => $specialistId
        ]);
    }

    /**
     * @inheritdoc
     */
    public function findFromDate(DateTimeInterface $date): array
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('s')
            ->from(SpecialistDocument::class, 's')
            ->andWhere('s.date >= :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult();
    }

    /**
     * @inheritdoc
     */
    public function findSpecialistsIDsFromDateAndByTemplate(DateTimeInterface $date, string $template): array
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('s.id')
            ->from(SpecialistDocument::class, 's')
            ->andWhere('s.date >= :date')
            ->setParameter('date', $date)
            ->andWhere('s.templateId = :template')
            ->setParameter('template', $template)
            ->getQuery()
            ->getResult(AbstractQuery::HYDRATE_SCALAR);
    }

    /**
     * @inheritdoc
     */
    public function findIdsByCriteria(string $criteria): array
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('sd.id')
            ->from(SpecialistDocument::class, 'sd')
            ->andWhere($criteria)
            ->getQuery()
            ->getResult(AbstractQuery::HYDRATE_SCALAR);
    }

    /**
     * @inheritdoc
     */
    public function save(SpecialistDocument $document): void
    {
        try {
            $this->getEntityManager()->persist($document);
            $this->getEntityManager()->flush();
        } catch (OptimisticLockException | ORMException $e) {
            throw new \RuntimeException($e->getMessage(), (int) $e->getCode(), $e);
        }
    }

    /**
     * @inheritdoc
     */
    public function delete(SpecialistDocument $document): void
    {
        try {
            $this->getEntityManager()->remove($document);
            $this->getEntityManager()->flush();
        } catch (OptimisticLockException | ORMException $e) {
            throw new \RuntimeException($e->getMessage(), (int) $e->getCode(), $e);
        }
    }

    /**
     * @inheritdoc
     */
    public function deleteFromDate(DateTimeInterface $date): void
    {
        $documents = $this->findFromDate($date);
        foreach ($documents as $document) {
            $this->delete($document);
        }
    }

    /**
     * @inheritdoc
     */
    public function beginTransaction(): void
    {
        $entityManager = $this->getEntityManager();
        $dbConnection = $entityManager->getConnection();
        $dbConnection->beginTransaction();
    }

    /**
     * @inheritdoc
     */
    public function commit(): void
    {
        $entityManager = $this->getEntityManager();
        $dbConnection = $entityManager->getConnection();
        $entityManager->flush();
        $dbConnection->commit();
    }
}
