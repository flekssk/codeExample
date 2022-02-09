<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\Course\Http\GetCourse\Api\v1\Output;

use JMS\Serializer\Annotation as Serializer;
use TeachersCommonBundle\Feature\ConventionalResponse\DTO\ConventionalApiResponseDTO;
use TeachersTrainingCenterBundle\Feature\Course\Model\DTO\CourseDTO;

/** @psalm-immutable */
class GetCourseResponse extends ConventionalApiResponseDTO
{
    /**
     * @var CourseDTO
     *
     * @Serializer\Type("array<TeachersTrainingCenterBundle\Feature\Course\Model\DTO\CourseDTO>")
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     */
    public $data;
}
