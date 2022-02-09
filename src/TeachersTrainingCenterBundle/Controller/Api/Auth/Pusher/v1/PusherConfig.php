<?php

namespace TeachersTrainingCenterBundle\Controller\Api\Auth\Pusher\v1;

class PusherConfig
{
    /** @var string */
    private $key;

    /** @var string */
    private $cluster;

    /** @var array */
    private $mainHosts;

    /** @var array */
    private $additionalHosts;

    public function __construct(string $key, string $cluster, array $mainHosts = [], array $additionalHosts = [])
    {
        $this->key = $key;
        $this->cluster = $cluster;
        $this->mainHosts = $mainHosts;
        $this->additionalHosts = $additionalHosts;
    }

    public function getConfig(): array
    {
        return [
            'key' => $this->key,
            'cluster' => $this->cluster,
            'mainHosts' => $this->mainHosts,
            'additionalHosts' => $this->additionalHosts,
        ];
    }
}
