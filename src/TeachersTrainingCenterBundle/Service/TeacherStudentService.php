<?php

namespace TeachersTrainingCenterBundle\Service;

use TeachersTrainingCenterBundle\Api\Crm2Api\Crm2Api;
use TeachersTrainingCenterBundle\Api\Crm2Api\Model\GetStudentEducationServiceResponse;
use TeachersTrainingCenterBundle\Entity\TeacherStudent;
use TeachersTrainingCenterBundle\Entity\User;
use TeachersTrainingCenterBundle\Repository\TeacherStudentRepository;

class TeacherStudentService
{
    /** @var Crm2Api */
    private $crm2Api;

    /** @var TeacherStudentRepository */
    private $teacherStudentRepository;

    /** @var UserService */
    private $userService;

    public function __construct(
        Crm2Api $crm2Api,
        TeacherStudentRepository $teacherStudentRepository,
        UserService $userService
    ) {
        $this->crm2Api = $crm2Api;
        $this->teacherStudentRepository = $teacherStudentRepository;
        $this->userService = $userService;
    }

    /**
     * @param int $teacherId
     * @return TeacherStudent[]
     */
    public function getTeacherStudents(int $teacherId): array
    {
        $teacherStudents = $this->teacherStudentRepository->findTeacherStudents($teacherId);
        if (empty($teacherStudents)) {
            $studentIds = $this->getStudentIds($teacherId);
            $users = $this->userService->ensureUsersExistByIds(array_merge($studentIds, [$teacherId]));
            $teacherStudents = $this->createTeacherStudents($teacherId, $users);
        }

        return $teacherStudents;
    }

    public function changeTeacherForEducationService(int $educationServiceId)
    {
        // add additional checks here to make sure teacher is added/deleted in your subject and not in another
        $educationServiceResponse = $this->crm2Api->getEducationService($educationServiceId);
        if (empty($educationServiceResponse->getTeacherId())) {
            $this->deleteStudentTeachers($educationServiceResponse->getStudentId());
        } else {
            $this->createStudentTeacher(
                $educationServiceResponse->getStudentId(),
                $educationServiceResponse->getTeacherId(),
            );
        }
    }

    public function getCachedTeacherStudent(int $teacherId, int $studentId): ?TeacherStudent
    {
        return $this->teacherStudentRepository->findOneBy([
            'teacher' => $teacherId,
            'student' => $studentId,
            'deletedAt' => null,
        ]);
    }

    /**
     * @param int $teacherId
     * @return int[]
     */
    private function getStudentIds(int $teacherId): array
    {
        $studentsEducationServices = $this->crm2Api->getStudentsEducationServices($teacherId);

        return array_map(function (GetStudentEducationServiceResponse $studentEducationServiceResponse) {
            return $studentEducationServiceResponse->getStudentId();
        }, $studentsEducationServices);
    }

    /**
     * @param int $teacherId
     * @param User[] $users
     * @return TeacherStudent[]
     */
    private function createTeacherStudents(int $teacherId, array $users): array
    {
        $teacher = $this->findTeacherUser($teacherId, $users);
        if (!$teacher) {
            throw new \UnexpectedValueException("Teacher {$teacherId} was not found among passed users");
        }

        return $this->teacherStudentRepository->createTeacherStudents($teacher, $users);
    }

    /**
     * @param int $teacherId
     * @param User[] $users
     * @return User|null
     */
    private function findTeacherUser(int $teacherId, array $users): ?User
    {
        foreach ($users as $user) {
            if ($user->getId() === $teacherId) {
                return $user;
            }
        }

        return null;
    }

    private function deleteStudentTeachers(int $studentId): void
    {
        $studentTeachers = $this->teacherStudentRepository->findStudentTeachers($studentId);
        $this->teacherStudentRepository->deleteTeacherStudents($studentTeachers);
    }

    /**
     * @param int $studentId
     * @param int $teacherId
     * @return TeacherStudent[]
     */
    private function createStudentTeacher(int $studentId, int $teacherId): array
    {
        $users = $this->userService->ensureUsersExistByIds([$studentId, $teacherId]);

        return $this->createTeacherStudents($teacherId, $users);
    }
}
