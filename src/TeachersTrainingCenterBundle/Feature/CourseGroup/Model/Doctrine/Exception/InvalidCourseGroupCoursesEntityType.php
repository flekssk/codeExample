<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseGroup\Model\Doctrine\Exception;

use TeachersTrainingCenterBundle\Feature\CourseGroup\Model\Doctrine\Type\CourseGroupCoursesType;

class InvalidCourseGroupCoursesEntityType extends \Exception
{
    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint
     */
    public function __construct($value)
    {
        parent::__construct(
            sprintf(
                'The doctrine type %s value must be an instance of %s, but %s provided',
                CourseGroupCoursesType::COURSE_GROUP_COURSES_TYPE_NAME,
                CourseGroupCoursesType::class,
                gettype($value)
            )
        );
    }
}
