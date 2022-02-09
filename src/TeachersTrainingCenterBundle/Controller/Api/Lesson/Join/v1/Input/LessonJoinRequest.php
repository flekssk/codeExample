<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Controller\Api\Lesson\Join\v1\Input;

use Swagger\Annotations as SWG;
use Symfony\Component\Validator\Constraints as Assert;
use TeachersTrainingCenterBundle\Entity\Traits\SafeLoadFieldsTrait;

final class LessonJoinRequest
{
    use SafeLoadFieldsTrait;

    /**
     * @SWG\Property(type="string")
     * @Assert\NotNull()
     */
    public string $roomHash;

    /**
     * @SWG\Property(type="object", description="Room join meta")
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingAnyTypeHint
     */
    public $meta;

    /**
     * @var array|string[]
     *
     * @phpcsSuppress SlevomatCodingStandard.Classes.UnusedPrivateElements.UnusedProperty
     */
    private array $safeFields = ['roomHash', 'meta'];
}
