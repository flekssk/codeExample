<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseGroup\Http\CreateCourseGroup\Api\v1\Input;

use JMS\Serializer\Annotation as Serializer;
use TeachersCommonBundle\Feature\SmartJsonConverter\DTO\SmartJsonRequestDTO;

class CreateCourseGroupRequest implements SmartJsonRequestDTO
{
    public string $title;

    public ?string $description = null;

    /**
     * @var string[]
     *
     * @Serializer\Type("array<string>")
     */
    public array $courses;

    public static function relativeSchemaPath(): string
    {
        return '/request/CreateCourseGroupRequest.json';
    }
}
