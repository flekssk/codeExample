<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseAssignment\Service;

use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\Event\CourseAssignmentEvent;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\ValueObject\CourseAssignmentContextId;

class CourseAssignmentEventHandler
{
    private CourseAssignService $assigner;

    public function __construct(CourseAssignService $assigner)
    {
        $this->assigner = $assigner;
    }

    public function handleMessage(CourseAssignmentEvent $message): void
    {
        $this->assigner->assign(new CourseAssignmentContextId($message->getCourseAssignmentId()), $message->getType());
    }
}
