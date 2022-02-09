<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use TeachersTrainingCenterBundle\Entity\TeacherStudent;
use TeachersTrainingCenterBundle\Entity\User;

class TeacherStudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TeacherStudent::class);
    }

    /**
     * @return TeacherStudent[]
     */
    public function findTeacherStudents(int $teacherId): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
            ->select('ts')
            ->from($this->getClassName(), 'ts')
            ->join('ts.student', 's')
            ->where($qb->expr()->eq('IDENTITY(ts.teacher)', ':teacherId'))
            ->andWhere($qb->expr()->isNull('ts.deletedAt'))
            ->setParameter('teacherId', $teacherId);

        return $qb->getQuery()->getResult();
    }

    /**
     * @return TeacherStudent[]
     */
    public function findStudentTeachers(int $studentId): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
            ->select('ts')
            ->from($this->getClassName(), 'ts')
            ->where($qb->expr()->eq('IDENTITY(ts.student)', ':studentId'))
            ->andWhere($qb->expr()->isNull('ts.deletedAt'))
            ->setParameter('studentId', $studentId);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param User[] $users
     *
     * @return TeacherStudent[]
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function createTeacherStudents(User $teacher, array $users): array
    {
        $teacherStudents = [];
        foreach ($users as $user) {
            if ($user->getId() !== $teacher->getId()) {
                $teacherStudents[] = $this->createTeacherStudent($teacher, $user);
            }
        }

        $this->getEntityManager()->flush();

        return $teacherStudents;
    }

    /**
     * @param TeacherStudent[] $teacherStudents
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function deleteTeacherStudents(array $teacherStudents): void
    {
        foreach ($teacherStudents as $teacherStudent) {
            $teacherStudent->setDeletedAt(new \DateTime());
            $this->getEntityManager()->persist($teacherStudent);
        }

        $this->getEntityManager()->flush();
    }

    private function createTeacherStudent(User $teacher, User $student): TeacherStudent
    {
        $teacherStudent = (new TeacherStudent())->setTeacher($teacher)->setStudent($student);
        $this->getEntityManager()->persist($teacherStudent);

        return $teacherStudent;
    }
}
