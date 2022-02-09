<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\RabbitMq\Consumer\User;

use Doctrine\ORM\EntityManagerInterface;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;
use Skyeng\IdClient\Model\API\UserBasic;
use TeachersTrainingCenterBundle\RabbitMq\Consumer\AbstractConsumer;
use TeachersTrainingCenterBundle\Repository\UserRepository;

class UserCreatedConsumer extends AbstractConsumer implements ConsumerInterface
{
    private UserRepository $userRepository;

    private LoggerInterface $logger;

    private EntityManagerInterface $entityManager;

    public function __construct(
        UserRepository $userRepository,
        LoggerInterface $logger,
        EntityManagerInterface $entityManager
    ) {
        $this->userRepository = $userRepository;
        $this->logger = $logger;
        $this->entityManager = $entityManager;
    }

    public function execute(AMQPMessage $msg): void
    {
        $idUserData = json_decode($msg->body);

        if ($idUserData && !is_null($idUserData->id)) {
            try {
                $user = new UserBasic($idUserData->id, $idUserData);
                $this->userRepository->createUsersFromIdModel([$user]);
            } catch (\Throwable $e) {
                $this->logger->error('Could not create user: ' . $e->getMessage(), (array)$idUserData);
            }
        }

        $this->resetConnection($this->entityManager);
    }
}
