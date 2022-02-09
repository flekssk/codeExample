<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseAssignment\Http\DeleteAssignmentContext\Api\v1\Output;

use JMS\Serializer\Annotation as Serializer;
use TeachersCommonBundle\Feature\ConventionalResponse\DTO\ConventionalApiResponseDTO;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\DTO\CourseAssignmentContextDeletedDTO;

/** @psalm-immutable */
class DeleteAssignmentContextResponse extends ConventionalApiResponseDTO
{
    /**
     * @var CourseAssignmentContextDeletedDTO
     *
     * @Serializer\Type(
     *     "TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\DTO\CourseAssignmentContextDeletedDTO"
     * )
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     */
    public $data;
}
