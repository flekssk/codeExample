<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\RabbitMq\Consumer\Score;

use Doctrine\ORM\EntityManagerInterface;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Skyeng\VimboxCoreRooms\API\Model\NodeParticipantResponse;
use Skyeng\VimboxCoreRooms\API\Model\NodeResponse;
use Skyeng\VimboxCoreRooms\ObjectSerializer as RoomsSerializer;
use TeachersTrainingCenterBundle\RabbitMq\Consumer\AbstractConsumer;
use TeachersTrainingCenterBundle\RabbitMq\Consumer\Score\Input\NodeScoreChangedMessage;
use TeachersTrainingCenterBundle\Service\ScoreService;

class NodeScoreChangedConsumer extends AbstractConsumer implements ConsumerInterface
{
    private EntityManagerInterface $entityManager;

    private ScoreService $scoreService;

    public function __construct(
        EntityManagerInterface $entityManager,
        ScoreService $scoreService
    ) {
        $this->entityManager = $entityManager;
        $this->scoreService = $scoreService;
    }

    public function execute(AMQPMessage $msg): void
    {
        $data = json_decode($msg->body);
        if ($this->isMessageDataFull($data)) {
            $this->updateScores($data);
        }

        $this->resetConnection($this->entityManager);
    }

    private function isMessageDataFull(\stdClass $data): bool
    {
        return isset($data->node) && isset($data->nodeParticipant);
    }

    private function updateScores(\stdClass $data): void
    {
        /** @var NodeResponse $nodeResponse */
        $nodeResponse = RoomsSerializer::deserialize($data->node, NodeResponse::class);
        /** @var NodeParticipantResponse $nodeParticipantResponse */
        $nodeParticipantResponse = RoomsSerializer::deserialize(
            $data->nodeParticipant,
            NodeParticipantResponse::class,
            []
        );

        $message = new NodeScoreChangedMessage($nodeResponse, $nodeParticipantResponse);
        $this->scoreService->updateScores($message);
    }
}
