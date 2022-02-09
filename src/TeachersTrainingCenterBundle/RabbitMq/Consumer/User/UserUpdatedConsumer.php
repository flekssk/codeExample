<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\RabbitMq\Consumer\User;

use Doctrine\ORM\EntityManagerInterface;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use TeachersTrainingCenterBundle\RabbitMq\Consumer\AbstractConsumer;
use TeachersTrainingCenterBundle\RabbitMq\Consumer\User\Input\UserUpdatedMessage;
use TeachersTrainingCenterBundle\Service\UserService;

class UserUpdatedConsumer extends AbstractConsumer implements ConsumerInterface
{
    private UserService $userService;

    private LoggerInterface $logger;

    private ValidatorInterface $validator;

    private EntityManagerInterface $entityManager;

    public function __construct(
        UserService $userService,
        LoggerInterface $logger,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager
    ) {
        $this->userService = $userService;
        $this->logger = $logger;
        $this->validator = $validator;
        $this->entityManager = $entityManager;
    }

    public function execute(AMQPMessage $msg): void
    {
        $idUserData = json_decode($msg->body, true);

        if (is_array($idUserData) && isset($idUserData['id']) && is_array($idUserData['fields'])) {
            $userDataToUpdate = array_merge(['id' => $idUserData['id']], $idUserData['fields']);
            $updatedUserData = new UserUpdatedMessage();
            $updatedUserData->loadFromArray($userDataToUpdate);
            $errors = $this->validator->validate($updatedUserData);

            if ($errors->count() === 0) {
                try {
                    $this->userService->updateUserFromMessage($updatedUserData);
                } catch (\Throwable $e) {
                    $this->logger->error('Could not update user data: ' . $e->getMessage(), $idUserData);
                }
            } else {
                $this->logger->error('Incorrect update user data: ' . $errors->get(0)->getMessage(), $idUserData);
            }
        }

        $this->resetConnection($this->entityManager);
    }
}
