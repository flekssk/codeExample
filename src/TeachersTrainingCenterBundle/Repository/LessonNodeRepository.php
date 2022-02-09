<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use TeachersTrainingCenterBundle\Entity\LessonNode;
use TeachersTrainingCenterBundle\Entity\User;

class LessonNodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LessonNode::class);
    }

    public function create(User $student, int $lessonId, int $nodeId): LessonNode
    {
        $lessonNode = (new LessonNode())
            ->setLessonId($lessonId)
            ->setStudent($student)
            ->setNodeId($nodeId);
        $this->getEntityManager()->persist($lessonNode);
        $this->getEntityManager()->flush();

        return $lessonNode;
    }
}
