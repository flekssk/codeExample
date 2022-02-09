<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\Course\Http\GetCourse\Api\v1\Input;

use JMS\Serializer\Annotation as JMS;
use TeachersCommonBundle\Feature\SmartJsonConverter\DTO\SmartJsonRequestDTO;

class GetCourseRequest implements SmartJsonRequestDTO
{
    /**
     * @var int[]
     *
     * @JMS\Type("array<int>")
     */
    public array $ids;

    public static function relativeSchemaPath(): string
    {
        return '/GetCourseRequest.json';
    }
}
