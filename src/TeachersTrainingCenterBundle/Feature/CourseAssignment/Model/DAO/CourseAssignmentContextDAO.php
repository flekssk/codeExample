<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\DAO;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\Collection\CourseAssignmentContextCollection;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\Entity\CourseAssignmentContext;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\ValueObject\CourseAssignmentContextId;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Model\ValueObject\CourseGroupId;

class CourseAssignmentContextDAO
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function nextId(): CourseAssignmentContextId
    {
        return new CourseAssignmentContextId(
            (int)$this->getConnection()
                ->executeQuery('SELECT nextval(\'course_assignment_context_id_seq\')')
                ->fetchOne()
        );
    }

    public function create(CourseAssignmentContext $context): void
    {
        $this->entityManager->persist($context);
        $this->entityManager->flush();
    }

    public function update(CourseAssignmentContext $context): void
    {
        $context->refreshUpdatedAt();

        $this->entityManager->persist($context);
        $this->entityManager->flush();
    }

    public function delete(CourseAssignmentContext $context): void
    {
        $this->entityManager->remove($context);
        $this->entityManager->flush();
    }

    public function findByCourseGroupId(CourseGroupId $id): CourseAssignmentContextCollection
    {
        return new CourseAssignmentContextCollection(
            ...$this->getRepository()->findBy(['courseGroup' => $id->value])
        );
    }

    /**
     * @param int[] $ids
     */
    public function findByIds(array $ids): CourseAssignmentContextCollection
    {
        return new CourseAssignmentContextCollection(
            ...$this->getRepository()->findBy(['id' => $ids])
        );
    }

    public function find(CourseAssignmentContextId $id): ?CourseAssignmentContext
    {
        return $this->getRepository()->find($id->value);
    }

    /**
     * @return EntityRepository<CourseAssignmentContext>
     */
    private function getRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(CourseAssignmentContext::class);
    }

    private function getConnection(): Connection
    {
        return $this->entityManager->getConnection();
    }
}
