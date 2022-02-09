<?php

namespace TeachersTrainingCenterBundle\Controller\Api\Lesson\Wordset\v1\Input;

use TeachersTrainingCenterBundle\Entity\Traits\SafeLoadFieldsTrait;
use Symfony\Component\Validator\Constraints as Assert;
use Swagger\Annotations as SWG;

class CreateWordsetRequest
{
    use SafeLoadFieldsTrait;

    /**
     * @SWG\Property(type="integer")
     * @Assert\NotNull()
     */
    private $studentId;

    /**
     * @SWG\Property(type="integer")
     * @Assert\NotNull()
     */
    private $lessonId;

    private $safeFields = ['studentId', 'lessonId'];

    public function getStudentId(): int
    {
        return $this->studentId;
    }

    public function getLessonId(): int
    {
        return $this->lessonId;
    }
}
