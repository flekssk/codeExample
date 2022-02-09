<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\Enum\CourseAssignmentRulesTargetEnum;

class CourseAssignmentRulesTargetType extends Type
{
    public const COURSE_ASSIGNMENT_RULES_TARGET_TYPE = 'course_assignment_rules_target';

    /**
     * @inheritDoc
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): CourseAssignmentRulesTargetEnum
    {
        return parent::convertToPHPValue(new CourseAssignmentRulesTargetEnum($value), $platform);
    }

    /**
     * @inheritDoc
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!$value instanceof CourseAssignmentRulesTargetEnum) {
            throw ConversionException::conversionFailedInvalidType(
                $value,
                $this->getName(),
                [CourseAssignmentRulesTargetEnum::class]
            );
        }

        return parent::convertToDatabaseValue($value->getValue(), $platform);
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
        return self:: COURSE_ASSIGNMENT_RULES_TARGET_TYPE;
    }
}
