<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseGroup\Model\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Model\Doctrine\Exception\InvalidCourseGroupCoursesDatabaseType;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Model\Doctrine\Exception\InvalidCourseGroupCoursesEntityType;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Model\ValueObject\CourseGroupCourses;

class CourseGroupCoursesType extends JsonType
{
    public const COURSE_GROUP_COURSES_TYPE_NAME = 'course_group_courses';

    /**
     * @inheritDoc
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): CourseGroupCourses
    {
        $coursesDecoded = parent::convertToPHPValue($value, $platform);

        if (!is_array($coursesDecoded) || !isset($coursesDecoded['courses']) || !is_array($coursesDecoded['courses'])) {
            throw new InvalidCourseGroupCoursesDatabaseType($value);
        }

        return new CourseGroupCourses(...$coursesDecoded['courses']);
    }

    /**
     * @inheritDoc
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!$value instanceof CourseGroupCourses) {
            throw new InvalidCourseGroupCoursesEntityType($value);
        }

        return parent::convertToDatabaseValue($value, $platform);
    }

    /**
     * @inheritDoc
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getClobTypeDeclarationSQL($column);
    }

    public function getName(): string
    {
        return self::COURSE_GROUP_COURSES_TYPE_NAME;
    }
}
