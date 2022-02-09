<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseGroup\Http\UpdateCourseGroup\Api\v1\Input;

use JMS\Serializer\Annotation as Serializer;
use TeachersCommonBundle\Feature\SmartJsonConverter\DTO\SmartJsonRequestDTO;

class UpdateCourseGroupRequest implements SmartJsonRequestDTO
{
    public int $id;

    public string $title;

    public string $description;

    /**
     * @var int[]
     *
     * @Serializer\Type("array<int>")
     */
    public ?array $courses = null;

    public static function relativeSchemaPath(): string
    {
        return '/request/UpdateCourseGroupRequest.json';
    }
}
