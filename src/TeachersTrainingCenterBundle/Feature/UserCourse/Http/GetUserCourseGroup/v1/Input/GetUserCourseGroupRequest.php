<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\UserCourse\Http\GetUserCourseGroup\v1\Input;

use TeachersCommonBundle\Feature\SmartJsonConverter\DTO\SmartJsonRequestDTO;

class GetUserCourseGroupRequest implements SmartJsonRequestDTO
{
    public int $userId;

    public static function relativeSchemaPath(): string
    {
        return '/GetUserCourseGroupRequest.json';
    }
}
