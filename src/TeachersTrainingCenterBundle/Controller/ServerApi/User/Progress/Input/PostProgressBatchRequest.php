<?php

namespace TeachersTrainingCenterBundle\Controller\ServerApi\User\Progress\Input;

use TeachersTrainingCenterBundle\Entity\Traits\SafeLoadFieldsTrait;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\Validator\Constraints as Assert;

class PostProgressBatchRequest
{
    use SafeLoadFieldsTrait;

    /**
     * @SWG\Property(type="integer", description="UserId whom progress we need to set")
     * @Assert\Type(type="numeric")
     */
    private $userId;

    /**
     * @SWG\Property(type="array", @Model(type=ProgressItem::class))
     */
    private $items;

    private $safeFields = ['userId', 'items'];

    private $safeFieldsTypes = [
        'items' => [
            'type' => 'array',
            'class' => ProgressItem::class,
        ],
    ];

    public function getUserId(): int
    {
        return (int) $this->userId;
    }

    /**
     * @return ProgressItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
