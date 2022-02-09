<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\UserCourse\Model\Collection;

use TeachersTrainingCenterBundle\Feature\Content\Model\Collection\StructureCollection;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\Collection\CourseAssignmentContextCollection;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Model\Entity\CourseGroup;
use TeachersTrainingCenterBundle\Feature\UserCourse\Model\DTO\UserCourseGroupWithStructureDTO;
use TeachersTrainingCenterBundle\Feature\UserCourse\Model\DTO\UserCourseWithStructureDTO;

class UserCourseGroupWithStructureCollection
{
    private UserCourseCollection $userCourseCollection;

    private CourseAssignmentContextCollection $courseAssignmentContextCollection;

    private StructureCollection $structure;

    public function __construct(
        UserCourseCollection $userCourseCollection,
        CourseAssignmentContextCollection $courseAssignmentContextCollection,
        StructureCollection $structure
    ) {
        $this->userCourseCollection = $userCourseCollection;
        $this->courseAssignmentContextCollection = $courseAssignmentContextCollection;
        $this->structure = $structure;
    }

    /**
     * @return UserCourseGroupWithStructureDTO[]
     */
    public function toDTOs(): array
    {
        $userCourseGroups = [];
        /** @var CourseGroup $item */
        foreach ($this->courseAssignmentContextCollection->getGroups() as $item) {
            $userCourses = $this->userCourseCollection->filterByContexts(
                $this->courseAssignmentContextCollection->filterByGroup($item)
            );

            $userCourseGroups[] = new UserCourseGroupWithStructureDTO(
                $item->getId(),
                $item->getTitle(),
                $item->getDescription(),
                $userCourses->toCourseAssignmentDTOFilledByStructure($this->structure)
            );
        }

        return $userCourseGroups;
    }

    /**
     * @return UserCourseWithStructureDTO[]
     */
    public function getCoursesWithoutGroupDTOs(): array
    {
        return $this->userCourseCollection->filterWithoutContext()
            ->toCourseAssignmentDTOFilledByStructure($this->structure);
    }
}
