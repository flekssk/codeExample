<?php

namespace TeachersTrainingCenterBundle\Controller\Api\Lesson\VideoConfig\v1;

use TeachersTrainingCenterBundle\Controller\Api\Lesson\VideoConfig\v1\Input\VideoConfigRequest;
use Skyeng\VideoBackend\API\Model\JanusClientConfig;
use Skyeng\VideoBackend\API\VideoConfigApi;

class VideoConfigManager
{
    private $videoConfigApi;

    public function __construct(VideoConfigApi $videoConfigApi)
    {
        $this->videoConfigApi = $videoConfigApi;
    }

    public function getConfig(int $userId, VideoConfigRequest $videoConfigRequest): JanusClientConfig
    {
        return $this->videoConfigApi->getVideoConfig($videoConfigRequest->roomHash, $userId);
    }
}
