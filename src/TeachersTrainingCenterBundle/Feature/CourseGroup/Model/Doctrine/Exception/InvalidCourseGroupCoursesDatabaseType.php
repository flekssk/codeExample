<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseGroup\Model\Doctrine\Exception;

use TeachersTrainingCenterBundle\Feature\CourseGroup\Model\Doctrine\Type\CourseGroupCoursesType;

class InvalidCourseGroupCoursesDatabaseType extends \Exception
{
    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint
     */
    public function __construct($value)
    {
        parent::__construct(
            sprintf(
                'The database value for type %s contains invalid data format %s',
                CourseGroupCoursesType::COURSE_GROUP_COURSES_TYPE_NAME,
                $value
            )
        );
    }
}
