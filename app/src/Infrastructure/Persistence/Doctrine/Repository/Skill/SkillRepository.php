<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Skill;

use App\Domain\Entity\Skill\Skill;
use App\Domain\Repository\Skill\SkillRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class SkillRepository.
 *
 * @method Skill[]    findAll()
 * @method Skill|null find($id, $lockMode = null, $lockVersion = null)
 * @method Skill|null findOneBy(array $criteria, array $orderBy = null)
 * @method Skill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @package App\Infrastructure\Persistence\Doctrine\Repository
 */
class SkillRepository extends ServiceEntityRepository implements SkillRepositoryInterface
{
    /**
     * Class constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Skill::class);
    }

    /**
     * @inheritDoc
     */
    public function save(Skill $skill): void
    {
        $this->getEntityManager()->persist($skill);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Skill $skill
     *
     * @return Skill
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function replace(Skill $skill): Skill
    {
        /** @var Skill $record */
        $record = $this->findOneBy(['id' => $skill->getId(), 'macroSkillId' => $skill->getMacroSkillId()]);

        if ($record) {
            $record->setName($skill->getName());
            $record->setMacroSkillId($skill->getMacroSkillId());
            $record->setMacroSkillName($skill->getMacroSkillName());
            $record->setMacroTypeId($skill->getMacroTypeId());
            $record->setMacroTypeName($skill->getMacroTypeName());
            $record->setReestrId($skill->getReestrId());
            $record->setReestrName($skill->getReestrName());
        } else {
            $record = $skill;
        }

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        return $record;
    }

    /**
     * @inheritdoc
     */
    public function findById(string $id): ?Skill
    {
        return $this->findOneBy(['id' => $id]);
    }

    /**
     * @inheritDoc
     */
    public function getSkillsWithMacroSkillId(): array
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('s')
            ->from(Skill::class, 's')
            ->andWhere('s.macroSkillId IS NOT NULL')
            ->getQuery()
            ->getResult();
    }

    /**
     * @inheritDoc
     */
    public function getMacroSkills(): array
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('s.macroSkillId, s.macroSkillName, s.macroWeight, s.macroTypeName')
            ->distinct()
            ->from(Skill::class, 's')
            ->andWhere('s.macroSkillId IS NOT NULL')
            ->orderBy('s.macroWeight, s.macroTypeName')
            ->getQuery()
            ->getResult();
    }

    /**
     * @inheritDoc
     */
    public function getAllSkillsByMacroSkillId(string $id): array
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('s.id, s.name, s.weight')
            ->from(Skill::class, 's')
            ->andWhere('s.macroSkillId IS NOT NULL')
            ->andWhere('s.macroSkillId = :id')
            ->setParameter('id', $id)
            ->orderBy('s.weight')
            ->getQuery()
            ->getResult();
    }
}
