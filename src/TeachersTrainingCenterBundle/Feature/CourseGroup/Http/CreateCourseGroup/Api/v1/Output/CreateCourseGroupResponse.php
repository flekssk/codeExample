<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseGroup\Http\CreateCourseGroup\Api\v1\Output;

use JMS\Serializer\Annotation as Serializer;
use TeachersCommonBundle\Feature\ConventionalResponse\DTO\ConventionalApiResponseDTO;
use TeachersTrainingCenterBundle\Feature\Course\Model\DTO\CourseDTO;

/** @psalm-immutable */
class CreateCourseGroupResponse extends ConventionalApiResponseDTO
{
    /**
     * @var CourseDTO[]
     *
     * @Serializer\Type("TeachersTrainingCenterBundle\Feature\CourseGroup\Model\DTO\CourseGroupDTO")
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     */
    public $data;
}
