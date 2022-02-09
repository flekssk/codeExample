<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\RabbitMq\Consumer\TeacherStudent;

use Doctrine\ORM\EntityManagerInterface;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;
use TeachersTrainingCenterBundle\RabbitMq\Consumer\AbstractConsumer;
use TeachersTrainingCenterBundle\Service\TeacherStudentService;

class TeacherChangedConsumer extends AbstractConsumer implements ConsumerInterface
{
    private TeacherStudentService $teacherStudentService;

    private LoggerInterface $logger;

    private EntityManagerInterface $entityManager;

    public function __construct(
        TeacherStudentService $teacherStudentService,
        LoggerInterface $logger,
        EntityManagerInterface $entityManager
    ) {
        $this->teacherStudentService = $teacherStudentService;
        $this->logger = $logger;
        $this->entityManager = $entityManager;
    }

    public function execute(AMQPMessage $msg): void
    {
        $teacherChangedData = json_decode($msg->body, true);

        if (is_array($teacherChangedData) && isset($teacherChangedData['educationServiceId'])) {
            try {
                $this->teacherStudentService->changeTeacherForEducationService(
                    (int) $teacherChangedData['educationServiceId'],
                );
            } catch (\Throwable $e) {
                $this->logger->error('Could not change teacher: ' . $e->getMessage(), $teacherChangedData);
            }
        }

        $this->resetConnection($this->entityManager);
    }
}
