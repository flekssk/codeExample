<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Controller\Api\User\Progress\v1\Output;

use Swagger\Annotations as SWG;
use TeachersTrainingCenterBundle\Entity\Progress;

final class GetProgressResponse
{
    /**
     * @SWG\Property(type="string", description="Progress id (e.g. lessonId/courseId)")
     */
    public string $progressId;

    /**
     * @SWG\Property(type="float", description="Score for progress")
     */
    public float $score;

    /**
     * @SWG\Property(type="float", description="Completeness")
     */
    public float $completeness;

    public function __construct(Progress $progress)
    {
        $this->progressId = $progress->getProgressId();
        $this->score = (float)($progress->getValue()['score'] ?? 0);
        $this->completeness = (float)($progress->getValue()['completeness'] ?? 0);
    }
}
