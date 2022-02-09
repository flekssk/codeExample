<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseAssignment\Http\GetAssignmentContextByGroupId\Api\v1\Output;

use JMS\Serializer\Annotation as Serializer;
use TeachersCommonBundle\Feature\ConventionalResponse\DTO\ConventionalApiResponseDTO;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\DTO\CourseAssignmentContextDTO;

/** @psalm-immutable */
class GetAssignmentContextByGroupIdResponse extends ConventionalApiResponseDTO
{
    /**
     * @var CourseAssignmentContextDTO
     *
     * @Serializer\Type(
     *     "array<TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\DTO\CourseAssignmentContextDTO>"
     * )
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     */
    public $data;
}
