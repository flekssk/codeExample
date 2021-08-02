<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\DocumentType;

use App\Domain\Entity\DocumentType\DocumentType;
use App\Domain\Repository\DocumentType\DocumentTypeRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class DocumentTypeRepository.
 *
 * @method DocumentType|null find($id, $lockMode = null, $lockVersion = null)
 * @method DocumentType|null findOneBy(array $criteria, array $orderBy = null)
 * @method DocumentType[]    findAll()
 * @method DocumentType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @package App\Infrastructure\Persistence\Doctrine\Repository\DocumentType
 */
class DocumentTypeRepository extends ServiceEntityRepository implements DocumentTypeRepositoryInterface
{
    /**
     * Class constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DocumentType::class);
    }

    /**
     * @param string $id
     *
     * @return DocumentType|null
     */
    public function findById(string $id)
    {
        return $this->find($id);
    }

    /**
     * @inheritdoc
     */
    public function save(DocumentType $documentType): void
    {
        $this->getEntityManager()->persist($documentType);
        $this->getEntityManager()->flush();
    }

    /**
     * @inheritdoc
     */
    public function delete(DocumentType $documentType): void
    {
        $this->getEntityManager()->remove($documentType);
        $this->getEntityManager()->flush();
    }
}
