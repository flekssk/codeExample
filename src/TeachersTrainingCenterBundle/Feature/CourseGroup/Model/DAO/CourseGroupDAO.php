<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseGroup\Model\DAO;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Model\Collection\CourseGroupCollection;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Model\DTO\CourseGroupCreateDTO;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Model\Entity\CourseGroup;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Model\ValueObject\CourseGroupId;

class CourseGroupDAO
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function find(CourseGroupId $id): ?CourseGroup
    {
        return $this->getRepository()->find($id->value);
    }

    /**
     * @param int[] $ids
     */
    public function findByIds(array $ids): CourseGroupCollection
    {
        $courseGroups = $this->getRepository()
            ->createQueryBuilder('cg')
            ->where('cg.id IN (:ids)')
            ->setParameter('ids', $ids)
            ->getQuery()
            ->getResult();

        return new CourseGroupCollection(...$courseGroups);
    }

    public function create(CourseGroupCreateDTO $dto): CourseGroup
    {
        return $this->save(CourseGroup::create($this->nextId(), $dto));
    }

    public function save(CourseGroup $courseGroup): CourseGroup
    {
        $this->entityManager->persist($courseGroup);
        $this->entityManager->flush();

        return $courseGroup;
    }

    public function nextId(): CourseGroupId
    {
        return new CourseGroupId(
            (int)$this->getConnection()
                ->executeQuery('SELECT nextval(\'course_group_id_seq\')')
                ->fetchOne()
        );
    }

    public function delete(int $courseListId): bool
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->delete()
            ->from(CourseGroup::class, 'cl')
            ->where('cl.id = :id')
            ->setParameter('id', $courseListId)
            ->getQuery()
            ->execute();
    }

    /**
     * @psalm-param array<string, string>|null $orderBy
     */
    public function findAll(?array $orderBy = null): CourseGroupCollection
    {
        return new CourseGroupCollection(...$this->getRepository()->findBy([], $orderBy));
    }

    /**
     * @return EntityRepository<CourseGroup>
     */
    private function getRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(CourseGroup::class);
    }

    private function getConnection(): Connection
    {
        return $this->entityManager->getConnection();
    }
}
