<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseGroup\Http\GetCourseGroupList\Api\v1\Input;

use TeachersCommonBundle\Feature\SmartJsonConverter\DTO\SmartJsonRequestDTO;

class GetCourseGroupListRequest implements SmartJsonRequestDTO
{
    public ?string $orderBy = null;

    public ?string $orderDirection = null;

    public static function relativeSchemaPath(): string
    {
        return '/GetCourseGroupListRequest.json';
    }
}
