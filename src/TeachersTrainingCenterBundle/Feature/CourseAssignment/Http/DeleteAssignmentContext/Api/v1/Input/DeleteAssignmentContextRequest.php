<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseAssignment\Http\DeleteAssignmentContext\Api\v1\Input;

use TeachersCommonBundle\Feature\SmartJsonConverter\DTO\SmartJsonRequestDTO;

class DeleteAssignmentContextRequest implements SmartJsonRequestDTO
{
    public int $contextId;

    public static function relativeSchemaPath(): string
    {
        return '/DeleteAssignmentContextRequest.json';
    }
}
