<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Controller\Api\Lesson\Create\v1\Input;

use Swagger\Annotations as SWG;
use Symfony\Component\Validator\Constraints as Assert;
use TeachersTrainingCenterBundle\Entity\Traits\SafeLoadFieldsTrait;

final class LessonCreateRequest
{
    use SafeLoadFieldsTrait;

    /**
     * @SWG\Property(type="int")
     * @Assert\NotNull()
     */
    public string $lessonId;

    /**
     * @var string[]
     *
     * @phpcsSuppress SlevomatCodingStandard.Classes.UnusedPrivateElements.UnusedProperty
     */
    private array $safeFields = ['lessonId'];
}
