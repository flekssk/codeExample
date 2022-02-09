<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Controller\Api\User\Progress\v1\Input;

use Swagger\Annotations as SWG;
use Symfony\Component\Validator\Constraints as Assert;
use TeachersTrainingCenterBundle\Entity\Traits\SafeLoadFieldsTrait;

final class GetProgressRequest
{
    use SafeLoadFieldsTrait;

    /**
     * @SWG\Property(type="integer", description="UserId whom progress we need to get")
     * @Assert\Type(type="numeric")
     */
    private ?string $userId;

    /**
     * @var array|string[]
     *
     * @phpcsSuppress SlevomatCodingStandard.Classes.UnusedPrivateElements.UnusedProperty
     */
    private array $safeFields = ['userId'];

    public function getUserId(): ?string
    {
        return $this->userId;
    }
}
