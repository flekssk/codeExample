<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\UserCourse\Model\ValueObject;

class UserCourseId
{
    public int $value;

    public function __construct(int $id)
    {
        $this->value = $id;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
