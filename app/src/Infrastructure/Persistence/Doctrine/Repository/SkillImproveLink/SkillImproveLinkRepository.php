<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\SkillImproveLink;

use App\Domain\Entity\SkillImproveLink\SkillImproveLink;
use App\Domain\Repository\SkillImproveLink\SkillImproveLinkRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class SkillImproveLinkRepository.
 *
 * @method SkillImproveLink[]    findAll()
 * @method SkillImproveLink|null find($id, $lockMode = null, $lockVersion = null)
 * @method SkillImproveLink|null findOneBy(array $criteria, array $orderBy = null)
 * @method SkillImproveLink[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @package App\Infrastructure\Persistence\Doctrine\Repository
 */
class SkillImproveLinkRepository extends ServiceEntityRepository implements SkillImproveLinkRepositoryInterface
{
    /**
     * Class constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SkillImproveLink::class);
    }

    /**
     * @inheritDoc
     */
    public function save(SkillImproveLink $skillImproveLink): void
    {
        $this->getEntityManager()->persist($skillImproveLink);
        $this->getEntityManager()->flush();
    }

    /**
     * @inheritdoc
     */
    public function delete(SkillImproveLink $skillImproveLink): void
    {
        $this->getEntityManager()->remove($skillImproveLink);
        $this->getEntityManager()->flush();
    }

    /**
     * @inheritdoc
     */
    public function deleteBy(array $criteria): void
    {
        $skillImproveLinks = $this->findBy($criteria);
        foreach ($skillImproveLinks as $skillImproveLink) {
            $this->delete($skillImproveLink);
        }
    }

    /**
     * @inheritdoc
     */
    public function findById(string $id): ?SkillImproveLink
    {
        return $this->findOneBy(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public function findBySkillId(string $id): array
    {
        return $this->findBy(['skillId' => $id]);
    }

    /**
     * @inheritdoc
     */
    public function findBySchoolId(int $id): array
    {
        return $this->findBy(['schoolId' => $id]);
    }

    /**
     * @inheritdoc
     */
    public function findBySkillIdAndSchoolId(string $skillId, int $schoolId): ?SkillImproveLink
    {
        return $this->findOneBy(['skillId' => $skillId, 'schoolId' => $schoolId]);
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

    /**
     * @inheritdoc
     */
    public function rollback(): void
    {
        $entityManager = $this->getEntityManager();
        $dbConnection = $entityManager->getConnection();
        $dbConnection->rollBack();
    }
}
