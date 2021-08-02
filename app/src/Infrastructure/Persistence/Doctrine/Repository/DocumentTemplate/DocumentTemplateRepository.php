<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\DocumentTemplate;

use App\Domain\Entity\DocumentTemplate\DocumentTemplate;
use App\Domain\Entity\SpecialistDocument\SpecialistDocument;
use App\Domain\Repository\DocumentTemplate\DocumentTemplateRepositoryInterface;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class DocumentTemplateRepository.
 *
 * @method DocumentTemplate|null find($id, $lockMode = null, $lockVersion = null)
 * @method DocumentTemplate|null findOneBy(array $criteria, array $orderBy = null)
 * @method DocumentTemplate[]    findAll()
 * @method DocumentTemplate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @package App\Infrastructure\Persistence\Doctrine\Repository\DocumentTemplate
 */
class DocumentTemplateRepository extends ServiceEntityRepository implements DocumentTemplateRepositoryInterface
{
    /**
     * Class constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DocumentTemplate::class);
    }

    /**
     * @param string $id
     *
     * @return DocumentTemplate|null
     */
    public function findById(string $id)
    {
        return $this->find($id);
    }

    /**
     * @inheritdoc
     */
    public function findByDateNotEqualTo(DateTimeInterface $date): array
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('dt')
            ->from(DocumentTemplate::class, 'dt')
            ->andWhere('dt.updatedAt != :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult();
    }

    /**
     * @inheritdoc
     */
    public function save(DocumentTemplate $document): void
    {
        $this->getEntityManager()->persist($document);
        $this->getEntityManager()->flush();
    }

    /**
     * @inheritdoc
     */
    public function delete(DocumentTemplate $document): void
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
