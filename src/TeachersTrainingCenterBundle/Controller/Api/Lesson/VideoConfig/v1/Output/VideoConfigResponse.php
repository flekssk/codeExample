<?php

namespace TeachersTrainingCenterBundle\Controller\Api\Lesson\VideoConfig\v1\Output;

use TeachersTrainingCenterBundle\Controller\Api\Lesson\VideoConfig\v1\Output\Model\VideoConfigIceServer;
use Nelmio\ApiDocBundle\Annotation\Model;
use Skyeng\VideoBackend\API\Model\JanusClientConfig;
use Swagger\Annotations as SWG;

final class VideoConfigResponse
{
    /**
     * @SWG\Property(type="integer")
     */
    public $janusRoomId;

    /**
     * @SWG\Property(type="string")
     */
    public $janusRoomPin;

    /**
     * @SWG\Property(type="string")
     */
    public $janusEndpoint;

    /**
     * @var array|null
     * @SWG\Property(type="array", @Model(type=VideoConfigIceServer::class))
     */
    public $iceServers = [];

    public function __construct(JanusClientConfig $config)
    {
        $this->janusRoomId = $config->getJanusRoomId();
        $this->janusRoomPin = $config->getJanusRoomPin();
        $this->janusEndpoint = $config->getJanusEndpoint();

        foreach ($config->getIceServers() as $iceServer) {
            $this->iceServers[] = new VideoConfigIceServer($iceServer);
        }
    }
}
