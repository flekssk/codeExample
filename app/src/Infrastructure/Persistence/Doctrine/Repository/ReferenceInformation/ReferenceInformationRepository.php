<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\ReferenceInformation;

use App\Domain\Entity\ReferenceInformation\ReferenceInformation;
use App\Domain\Repository\ReferenceInformation\ReferenceInformationRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class ReferenceInformationRepository.
 *
 * @method ReferenceInformation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReferenceInformation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReferenceInformation[]    findAll()
 * @method ReferenceInformation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @package App\Infrastructure\Persistence\Doctrine\Repository\ReferenceInformation
 */
class ReferenceInformationRepository extends ServiceEntityRepository implements ReferenceInformationRepositoryInterface
{
    /**
     * Class constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReferenceInformation::class);
    }

    /**
     * @inheritdoc
     */
    public function findById(string $id): ?ReferenceInformation
    {
        return $this->find($id);
    }

    /**
     * @inheritdoc
     */
    public function findAllActiveInformation(): array
    {
        return $this->findBy(['active' => true]);
    }

    /**
     * @inheritdoc
     */
    public function save(ReferenceInformation $document): void
    {
        $this->getEntityManager()->persist($document);
        $this->getEntityManager()->flush();
    }

    /**
     * @inheritdoc
     */
    public function delete(ReferenceInformation $document): void
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
