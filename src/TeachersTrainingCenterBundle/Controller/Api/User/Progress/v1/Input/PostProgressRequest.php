<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Controller\Api\User\Progress\v1\Input;

use Swagger\Annotations as SWG;
use Symfony\Component\Validator\Constraints as Assert;
use TeachersTrainingCenterBundle\Entity\Traits\SafeLoadFieldsTrait;

final class PostProgressRequest
{
    use SafeLoadFieldsTrait;

    /**
     * @SWG\Property(type="string", description="Progress id (e.g. lessonId/courseId)")
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private string $progressId;

    /**
     * @SWG\Property(type="string", description="Type of progress (e.g. lesson/course)")
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private string $progressType;

    /**
     * @SWG\Property(type="integer", description="UserId whom progress we need to set")
     * @Assert\Type(type="numeric")
     */
    private ?int $userId;

    /**
     * @SWG\Property(type="float", description="Score for progress")
     * @Assert\GreaterThanOrEqual(0)
     * @Assert\Type(type="numeric")
     */
    private float $score;

    /**
     * @SWG\Property(type="float", description="Completeness")
     * @Assert\GreaterThanOrEqual(0)
     * @Assert\Type(type="numeric")
     */
    private float $completeness;

    /**
     * @var array|string[]
     *
     * @phpcsSuppress SlevomatCodingStandard.Classes.UnusedPrivateElements.UnusedProperty
     */
    private array $safeFields = ['userId', 'progressId', 'progressType', 'userId', 'score', 'completeness'];

    public function getProgressId(): string
    {
        return $this->progressId;
    }

    public function getProgressType(): string
    {
        return $this->progressType;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function getScore(): float
    {
        return $this->score;
    }

    public function getCompleteness(): float
    {
        return $this->completeness;
    }
}
