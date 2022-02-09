<?php

namespace TeachersTrainingCenterBundle\Controller\Api\Lesson\VideoConfig\v1\Output\Model;

use Skyeng\VideoBackend\API\Model\ICEServer;
use Swagger\Annotations as SWG;

final class VideoConfigIceServer
{
    /**
     * @var string
     * @SWG\Property(type="string")
     */
    public $urls;

    /**
     * @var string|null
     * @SWG\Property(type="string")
     */
    public $username;

    /**
     * @var string|null
     * @SWG\Property(type="string")
     */
    public $credential;

    public function __construct(ICEServer $config)
    {
        $this->urls = $config->getUrls();
        $this->username = $config->getUsername();
        $this->credential = $config->getCredential();
    }
}
