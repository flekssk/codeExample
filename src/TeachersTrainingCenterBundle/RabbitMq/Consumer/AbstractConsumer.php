<?php

namespace TeachersTrainingCenterBundle\RabbitMq\Consumer;

use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractConsumer
{
    protected function resetConnection(EntityManagerInterface $entityManager)
    {
        $entityManager->clear();
        $entityManager->getConnection()->close();
    }
}
