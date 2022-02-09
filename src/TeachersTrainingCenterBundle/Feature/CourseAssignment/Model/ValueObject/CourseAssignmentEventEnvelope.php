<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\ValueObject;

use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Producers\CourseAssignmentProducer;
use TeachersTrainingCenterBundle\Model\ValueObject\AbstractEventEnvelope;

class CourseAssignmentEventEnvelope extends AbstractEventEnvelope
{
    public function supports(ProducerInterface $producer): bool
    {
        return $producer instanceof CourseAssignmentProducer;
    }

    public function getRoutingKey(): string
    {
        return 'assign_course_group';
    }
}
