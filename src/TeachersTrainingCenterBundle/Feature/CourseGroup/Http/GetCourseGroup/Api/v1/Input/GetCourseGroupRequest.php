<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseGroup\Http\GetCourseGroup\Api\v1\Input;

use JMS\Serializer\Annotation as Serializer;
use TeachersCommonBundle\Feature\SmartJsonConverter\DTO\SmartJsonRequestDTO;

class GetCourseGroupRequest implements SmartJsonRequestDTO
{
    /**
     * @var int[]
     *
     * @Serializer\Type("array<int>")
     */
    public array $ids;

    public static function relativeSchemaPath(): string
    {
        return '/request/GetCourseGroupRequest.json';
    }
}
