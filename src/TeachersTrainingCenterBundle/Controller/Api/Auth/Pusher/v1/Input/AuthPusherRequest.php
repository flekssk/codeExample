<?php

namespace TeachersTrainingCenterBundle\Controller\Api\Auth\Pusher\v1\Input;

use TeachersTrainingCenterBundle\Entity\Traits\SafeLoadFieldsTrait;
use Symfony\Component\Validator\Constraints as Assert;
use Swagger\Annotations as SWG;

final class AuthPusherRequest
{
    use SafeLoadFieldsTrait;

    /**
     * @var string
     * @SWG\Property(type="string")
     * @Assert\NotNull()
     */
    public $channelName;

    /**
     * @var string
     * @SWG\Property(type="string")
     * @Assert\NotNull()
     */
    public $socketId;

    private $safeFields = ['channelName', 'socketId'];
}
