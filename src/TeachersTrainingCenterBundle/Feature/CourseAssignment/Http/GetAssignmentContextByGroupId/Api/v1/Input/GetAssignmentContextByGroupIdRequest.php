<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseAssignment\Http\GetAssignmentContextByGroupId\Api\v1\Input;

use TeachersCommonBundle\Feature\SmartJsonConverter\DTO\SmartJsonRequestDTO;

class GetAssignmentContextByGroupIdRequest implements SmartJsonRequestDTO
{
    public int $courseGroupId;

    public static function relativeSchemaPath(): string
    {
        return '/GetAssignmentContextByGroupIdRequest.json';
    }
}
