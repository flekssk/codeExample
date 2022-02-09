<?php

namespace TeachersTrainingCenterBundle\Controller\ServerApi\User\Progress\Input;

use TeachersTrainingCenterBundle\Entity\Traits\SafeLoadFieldsTrait;
use Symfony\Component\Validator\Constraints as Assert;
use Swagger\Annotations as SWG;

final class ProgressItem
{
    use SafeLoadFieldsTrait;

    /**
     * @SWG\Property(type="string", description="Progress id (e.g. lessonId/courseId)")
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $progressId;

    /**
     * @SWG\Property(type="string", description="Type of progress (e.g. lesson/course)")
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $progressType;

    /**
     * @SWG\Property(type="float", description="Score for progress")
     * @Assert\GreaterThanOrEqual(0)
     * @Assert\Type(type="numeric")
     */
    private $score;

    /**
     * @SWG\Property(type="float", description="Completeness")
     * @Assert\GreaterThanOrEqual(0)
     * @Assert\Type(type="numeric")
     */
    private $completeness;

    private $safeFields = ['progressId', 'progressType', 'userId', 'score', 'completeness'];

    public function getProgressId(): string
    {
        return $this->progressId;
    }

    public function getProgressType(): string
    {
        return $this->progressType;
    }

    public function getScore(): float
    {
        return (float) $this->score;
    }

    public function getCompleteness(): float
    {
        return (float) $this->completeness;
    }
}
