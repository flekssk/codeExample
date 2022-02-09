<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\Enum;

use TeachersTrainingCenterBundle\Model\Enum\AbstractStringEnum;

/**
 * Enum target`ов для получения списка пользователей по правилам из разных систем
 */
class CourseAssignmentRulesTargetEnum extends AbstractStringEnum
{
    public const ALL = [
        self::TRM_TARGET,
        self::TTC_TARGET,
    ];

    /**
     * Target для вычисления правил на стороне trm
     */
    public const TRM_TARGET = 'trm';

    /**
     * Target для вычисления правил на стороне ttc
     */
    public const TTC_TARGET = 'ttc';

    protected function fallbackValue(): ?string
    {
        return null;
    }

    /**
     * @return string[]
     */
    protected static function allValues(): array
    {
        return self::ALL;
    }
}
