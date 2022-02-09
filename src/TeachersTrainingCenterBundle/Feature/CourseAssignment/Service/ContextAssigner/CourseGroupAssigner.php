<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseAssignment\Service\ContextAssigner;

use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\Entity\CourseAssignmentContext;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\ValueObject\CourseAssignmentContextId;
use TeachersTrainingCenterBundle\Feature\User\Contracts\UserInterface;
use TeachersTrainingCenterBundle\Feature\UserCourse\Model\DTO\UserCourseCreateDTO;
use TeachersTrainingCenterBundle\Feature\UserCourse\Service\UserCourseManager;

class CourseGroupAssigner
{
    private UserCourseManager $userCourseManager;

    public function __construct(UserCourseManager $userCourseManager)
    {
        $this->userCourseManager = $userCourseManager;
    }

    /**
     * @param UserInterface[] $users
     */
    public function assign(array $users, CourseAssignmentContext $context): void
    {
        $userCourseCreateDTOs = [];
        $userCoursesToDelete = [];

        foreach ($users as $user) {
            $userCourses = $this->userCourseManager->findByUserAndContext($user->getId(), $context->getId());

            $userCoursesToDelete = array_merge(
                $userCoursesToDelete,
                $userCourses->diffByCourseIds(
                    $context->getCourseGroup()->getCourses()->getCourseIds()
                )->toArray()
            );

            $needCreateCourseIds = array_filter(
                $context->getCourseGroup()->getCourses()->getCourseIds(),
                static fn (int $courseId) => !$userCourses->hasCourse($courseId)
            );

            foreach ($needCreateCourseIds as $courseId) {
                $userCourseCreateDTOs[] = new UserCourseCreateDTO(
                    $user->getId(),
                    $courseId,
                    $context
                );
            }
        }

        $this->userCourseManager->batchDelete($userCoursesToDelete);
        $this->userCourseManager->batchCreate($userCourseCreateDTOs);
    }

    public function unassign(CourseAssignmentContextId $contextId): void
    {
        $this->userCourseManager->deleteNotStartedByContextId($contextId);
    }
}
