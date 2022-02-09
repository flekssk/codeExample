<?php

namespace TeachersTrainingCenterBundle\Controller\Api\Lesson\Wordset\v1\Output;

use Symfony\Component\Validator\Constraints as Assert;
use Swagger\Annotations as SWG;

class LessonGetWordsetResponse
{
    /**
     * @var int
     * @SWG\Property(type="integer")
     * @Assert\NotNull()
     */
    public $studentId;

    /**
     * @var int
     * @SWG\Property(type="integer")
     * @Assert\NotNull()
     */
    public $lessonId;

    /**
     * @var int
     * @SWG\Property(type="integer")
     * @Assert\NotNull()
     */
    public $wordsetId;

    public function __construct(int $studentId, int $lessonId, int $wordsetId)
    {
        $this->studentId = $studentId;
        $this->lessonId = $lessonId;
        $this->wordsetId = $wordsetId;
    }
}
