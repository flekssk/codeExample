<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\UserCourse\Model\DTO;

class UserCourseGroupsWithStructureDTO
{
    /**
     * @var UserCourseGroupWithStructureDTO[]
     */
    public array $withGroup;

    /**
     * @var UserCourseWithStructureDTO[]
     */
    public array $withoutGroup;

    /**
     * @param UserCourseGroupWithStructureDTO[] $withGroup
     * @param UserCourseWithStructureDTO[] $withoutGroup
     */
    public function __construct(array $withGroup, array $withoutGroup)
    {
        $this->withGroup = $withGroup;
        $this->withoutGroup = $withoutGroup;
    }
}
