<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\RegulatoryDocuments;

use App\Domain\Entity\RegulatoryDocuments\RegulatoryDocuments;
use App\Domain\Repository\RegulatoryDocuments\RegulatoryDocumentsRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class RegulatoryDocumentsRepository.
 *
 * @method RegulatoryDocuments|null find($id, $lockMode = null, $lockVersion = null)
 * @method RegulatoryDocuments|null findOneBy(array $criteria, array $orderBy = null)
 * @method RegulatoryDocuments[]    findAll()
 * @method RegulatoryDocuments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @package App\Infrastructure\Persistence\Doctrine\Repository\RegulatoryDocuments
 */
class RegulatoryDocumentsRepository extends ServiceEntityRepository implements RegulatoryDocumentsRepositoryInterface
{
    /**
     * Class constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RegulatoryDocuments::class);
    }

    /**
     * @inheritdoc
     */
    public function findById(string $id): ?RegulatoryDocuments
    {
        return $this->find($id);
    }

    /**
     * @inheritdoc
     */
    public function findAllActiveDocuments(): array
    {
        return $this->findBy(['active' => true]);
    }

    /**
     * @inheritdoc
     */
    public function save(RegulatoryDocuments $document): void
    {
        $this->getEntityManager()->persist($document);
        $this->getEntityManager()->flush();
    }

    /**
     * @inheritdoc
     */
    public function delete(RegulatoryDocuments $document): void
    {
        $this->getEntityManager()->remove($document);
        $this->getEntityManager()->flush();
    }

    /**
     * @inheritdoc
     */
    public function deleteAll(): void
    {
        $templates = $this->findAll();
        foreach ($templates as $template) {
            $this->delete($template);
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
