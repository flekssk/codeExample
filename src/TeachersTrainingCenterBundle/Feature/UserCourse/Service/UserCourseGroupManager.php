<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\UserCourse\Service;

use TeachersTrainingCenterBundle\Feature\Content\Service\Manager\StructureManager;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\DAO\CourseAssignmentContextDAO;
use TeachersTrainingCenterBundle\Feature\UserCourse\Model\Collection\UserCourseGroupWithStructureCollection;
use TeachersTrainingCenterBundle\Feature\UserCourse\Model\DAO\UserCourseDAO;
use TeachersTrainingCenterBundle\Feature\UserCourse\Model\DTO\UserCourseGroupsWithStructureDTO;

class UserCourseGroupManager
{
    private UserCourseDAO $userCourseDAO;

    private StructureManager $structureManager;

    private CourseAssignmentContextDAO $assignmentContextDAO;

    public function __construct(
        UserCourseDAO $userCourseDAO,
        StructureManager $structureManager,
        CourseAssignmentContextDAO $assignmentContextDAO
    ) {
        $this->userCourseDAO = $userCourseDAO;
        $this->structureManager = $structureManager;
        $this->assignmentContextDAO = $assignmentContextDAO;
    }

    public function getUserCourseGroupWithStructure(int $userId): UserCourseGroupsWithStructureDTO
    {
        $userCourseCollection = $this->userCourseDAO->findByUser($userId);
        $userCourseGroupWithProgressCollection = new UserCourseGroupWithStructureCollection(
            $userCourseCollection,
            $this->assignmentContextDAO->findByIds($userCourseCollection->getContextsIds()),
            $this->structureManager->getStructure($userId)
        );
        return new UserCourseGroupsWithStructureDTO(
            $userCourseGroupWithProgressCollection->toDTOs(),
            $userCourseGroupWithProgressCollection->getCoursesWithoutGroupDTOs()
        );
    }
}
