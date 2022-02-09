<?php

namespace TeachersTrainingCenterBundle\RabbitMq\Consumer\Score\Input;

use Skyeng\VimboxCoreRooms\API\Model\NodeParticipantResponse;
use Skyeng\VimboxCoreRooms\API\Model\NodeResponse;

class NodeScoreChangedMessage
{
    /**
     * @var NodeResponse
     */
    private $node;

    /**
     * @var NodeParticipantResponse
     */
    private $nodeParticipant;

    public function __construct(NodeResponse $node, NodeParticipantResponse $nodeParticipant)
    {
        $this->node = $node;
        $this->nodeParticipant = $nodeParticipant;
    }

    /**
     * @return NodeResponse
     */
    public function getNode(): NodeResponse
    {
        return $this->node;
    }

    /**
     * @return NodeParticipantResponse
     */
    public function getNodeParticipant(): NodeParticipantResponse
    {
        return $this->nodeParticipant;
    }
}
