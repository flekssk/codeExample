<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\UserCourse\Http\GetUserCourseGroup\v1\Output;

use JMS\Serializer\Annotation as Serializer;
use TeachersCommonBundle\Feature\ConventionalResponse\DTO\ConventionalApiResponseDTO;
use TeachersTrainingCenterBundle\Feature\UserCourse\Model\DTO\UserCourseGroupsWithStructureDTO;

/** @psalm-immutable */
class GetUserCourseGroupResponse extends ConventionalApiResponseDTO
{
    /**
     * @var UserCourseGroupsWithStructureDTO
     *
     * @Serializer\Type("TeachersTrainingCenterBundle\Feature\UserCourse\Model\DTO\UserCourseGroupsWithStructureDTO")
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     */
    public $data;
}
