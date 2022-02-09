<?php

namespace TeachersTrainingCenterBundle\Controller\ServerApi\Access\v1;

use TeachersTrainingCenterBundle\Controller\ServerApi\Access\v1\Input\AccessAction;
use TeachersTrainingCenterBundle\Controller\ServerApi\Access\v1\Input\AccessUser;
use TeachersTrainingCenterBundle\Service\TeacherStudentService;

class AuthorizationChecker
{
    /** @var TeacherStudentService */
    private $teacherStudentService;

    public function __construct(TeacherStudentService $teacherStudentService)
    {
        $this->teacherStudentService = $teacherStudentService;
    }

    public function authorize(AccessUser $user, AccessAction $action): bool
    {
        if ($user->getId() === $action->getUserId()) {
            return true;
        }

        if ($this->teacherStudentService->getCachedTeacherStudent($user->getId(), $action->getUserId()) !== null) {
            return true;
        }

        return false;
    }
}
