<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\DAO;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\Entity\CourseAssignmentRules;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\ValueObject\CourseAssignmentRulesId;

class CourseAssignmentRulesDAO
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function nextId(): CourseAssignmentRulesId
    {
        return new CourseAssignmentRulesId(
            (int)$this->getConnection()
                ->executeQuery('SELECT nextval(\'course_assignment_rules_id_seq\')')
                ->fetchOne()
        );
    }

    public function create(CourseAssignmentRules $rules): void
    {
        $this->entityManager->persist($rules);
        $this->entityManager->flush();
    }

    public function update(CourseAssignmentRules $rules): void
    {
        $this->entityManager->persist($rules);
        $this->entityManager->flush();
    }

    public function delete(CourseAssignmentRules $rules): void
    {
        $this->entityManager->remove($rules);
        $this->entityManager->flush();
    }

    private function getConnection(): Connection
    {
        return $this->entityManager->getConnection();
    }
}
