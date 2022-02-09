<?php

namespace TeachersTrainingCenterBundle\Controller\Api\Auth\Pusher\v1\Output;

use Swagger\Annotations as SWG;

final class AuthPusherResponse
{
    /**
     * @var string
     * @SWG\Property(type="string", description="Pusher auth token")
     */
    public $auth;

    /**
     * @var string
     * @SWG\Property(type="string", description="Any data you passed into socket_auth pusher method")
     */
    public $channel_data;

    public function __construct(array $pusherResponse)
    {
        $this->auth = $pusherResponse['auth'];
        $this->channel_data = $pusherResponse['channel_data'];
    }
}
