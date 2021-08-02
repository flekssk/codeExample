<?php

namespace App\Infrastructure\EventSubscriber;

use DateTimeImmutable;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

/**
 * Class EntityEventSubscriber.
 *
 * @package App\Infrastructure\EventSubscriber
 */
class EntityEventSubscriber implements EventSubscriber
{
    /**
     * Список проверяемых сущностей.
     *
     * @var array|string[]
     */
    private array $entitiesToCheck = [
        'App\Domain\Entity\SiteOption',
        'App\Domain\Entity\DocumentType\DocumentType',
        'App\Domain\Entity\Specialist\Specialist',
        'App\Domain\Entity\Id2\Id2Event',
        'App\Domain\Entity\Event\CustomValue',
        'App\Domain\Entity\Skill\Skill',
    ];

    /**
     * @inheritDoc
     */
    public function getSubscribedEvents()
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($this->checkEntity($entity)) {
            $entity->setCreatedAt(new DateTimeImmutable());
        }
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($this->checkEntity($entity)) {
            $entity->setUpdatedAt(new DateTimeImmutable());
        }
    }

    /**
     * Проверка относительно списка сущностей.
     *
     * @param object $entity
     * @return bool
     */
    private function checkEntity(object $entity): bool
    {
        if (in_array(get_class($entity), $this->entitiesToCheck)) {
            return true;
        }

        return false;
    }
}
