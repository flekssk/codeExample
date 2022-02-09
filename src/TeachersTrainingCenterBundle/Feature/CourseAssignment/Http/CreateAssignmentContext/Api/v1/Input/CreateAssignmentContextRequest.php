<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseAssignment\Http\CreateAssignmentContext\Api\v1\Input;

use TeachersCommonBundle\Feature\SmartJsonConverter\DTO\SmartJsonRequestDTO;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\DTO\CourseAssignmentRulesCreateDTO;

class CreateAssignmentContextRequest implements SmartJsonRequestDTO
{
    public int $courseGroupId;

    public CourseAssignmentRulesCreateDTO $rules;

    public ?int $deadlineInDays = null;

    public static function relativeSchemaPath(): string
    {
        return '/CreateAssignmentContextRequest.json';
    }
}
