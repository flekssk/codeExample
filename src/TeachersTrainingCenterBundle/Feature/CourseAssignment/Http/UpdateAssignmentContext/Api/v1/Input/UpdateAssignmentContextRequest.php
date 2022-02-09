<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseAssignment\Http\UpdateAssignmentContext\Api\v1\Input;

use TeachersCommonBundle\Feature\SmartJsonConverter\DTO\SmartJsonRequestDTO;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\DTO\CourseAssignmentRulesUpdateDTO;

class UpdateAssignmentContextRequest implements SmartJsonRequestDTO
{
    public int $id;

    public int $courseGroupId;

    public CourseAssignmentRulesUpdateDTO $rules;

    public ?int $deadlineInDays = null;

    public static function relativeSchemaPath(): string
    {
        return '/UpdateAssignmentContextRequest.json';
    }
}
