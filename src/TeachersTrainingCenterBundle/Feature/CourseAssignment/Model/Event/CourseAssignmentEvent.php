<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\Event;

use JMS\Serializer\Annotation as JMS;
use TeachersCommonBundle\Contracts\Event\EventInterface;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\ValueObject\CourseAssignmentContextId;
use TeachersTrainingCenterBundle\Service\RabbitMq\Events\AMQPEvent;

class CourseAssignmentEvent implements AMQPEvent, EventInterface
{
    public const CREATE_TYPE = 'create';
    public const UPDATE_TYPE = 'update';
    public const DELETE_TYPE = 'delete';
    public const EVENT_TYPES = [
      self::CREATE_TYPE,
      self::UPDATE_TYPE,
      self::DELETE_TYPE,
    ];

    private int $courseAssignmentId;

    private string $type;

    public function __construct(CourseAssignmentContextId $id, string $type)
    {
        $this->courseAssignmentId = $id->value;
        $this->type = $type;
    }

    public function getCourseAssignmentId(): int
    {
        return $this->courseAssignmentId;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public static function isValidType(string $type): bool
    {
        return in_array($type, self::EVENT_TYPES, true);
    }
}
