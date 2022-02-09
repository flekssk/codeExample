<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseGroup\Http\GetCourseGroup\Api\v1\Output;

use JMS\Serializer\Annotation as Serializer;
use TeachersCommonBundle\Feature\ConventionalResponse\DTO\ConventionalApiResponseDTO;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Model\DTO\CourseGroupDTO;

/** @psalm-immutable */
class GetCourseGroupResponse extends ConventionalApiResponseDTO
{
    /**
     * @var CourseGroupDTO[]
     *
     * @Serializer\Type("array<TeachersTrainingCenterBundle\Feature\CourseGroup\Model\DTO\CourseGroupDTO>")
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     */
    public $data;
}
