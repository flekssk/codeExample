<?php

namespace App\Infrastructure\EntityRevisions\EventSubscriber;

use App\Domain\Entity\EntityRevision\Exception\EntityRevisionIncorrectOperationException;
use App\Domain\Entity\User;
use Doctrine\ORM\UnitOfWork;
use Exception;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\Events;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use App\Domain\Entity\EntityRevision\EntityRevision;
use App\Infrastructure\EntityRevisions\Serializer\RevisionsSerializer;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class EntityRevisionsEventSubscriber.
 *
 * @package App\Infrastructure\EventSubscriber
 */
class EntityRevisionsEventSubscriber implements EventSubscriber
{
    /**
     * @var TokenStorageInterface
     */
    private TokenStorageInterface $tokenStorage;

    /**
     * @var RevisionsSerializer
     */
    private RevisionsSerializer $serializer;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var array
     */
    private array $entityTypes;

    /**
     * EntityRevisionsEventSubscriber constructor.
     *
     * @param TokenStorageInterface $tokenStorage
     * @param RevisionsSerializer $serializer
     * @param LoggerInterface $logger
     * @param array $entityTypes
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        RevisionsSerializer $serializer,
        LoggerInterface $logger,
        array $entityTypes
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->serializer = $serializer;
        $this->logger = $logger;
        $this->entityTypes = $entityTypes;
    }

    /**
     * @inheritDoc
     */
    public function getSubscribedEvents(): array
    {
        return [
            Events::onFlush,
        ];
    }

    /**
     * @param OnFlushEventArgs $args
     *
     * @psalm-suppress InternalMethod
     */
    public function onFlush(OnFlushEventArgs $args): void
    {
        $entityManager = $args->getEntityManager();
        $unitOfWork = $entityManager->getUnitOfWork();
        $entitiesGroupedByOperation = $this->getEntitiesGroupedByOperation($unitOfWork);

        foreach ($entitiesGroupedByOperation as $operation => $entities) {
            foreach ($entities as $entity) {
                if ($this->checkEntity($entity)) {
                    try {
                        $revision = $this->createRevisionFromSourceEntity($entity, $operation);
                        $entityManager->persist($revision);

                        $classMetadata = $entityManager->getClassMetadata(EntityRevision::class);
                        $unitOfWork->computeChangeSet($classMetadata, $revision);
                    } catch (Exception $e) {
                        $this->logger->error("Не удалось создать EntityRevision для сущности с ID {$entity->getId()}: {$e->getMessage()}");
                    }
                }
            }
        }
    }

    /**
     * Получить сущности для работы путем сбора сущностей для изменения, создания и удаления.
     *
     * @param UnitOfWork $unitOfWork
     *
     * @return array
     */
    private function getEntitiesGroupedByOperation(UnitOfWork $unitOfWork)
    {
        $entitiesToUpdate = $unitOfWork->getScheduledEntityUpdates();
        $entitiesToInsert = $unitOfWork->getScheduledEntityInsertions();
        $entitiesToDelete = $unitOfWork->getScheduledEntityDeletions();

        return [
            EntityRevision::OPERATION_UPDATE => $entitiesToUpdate,
            EntityRevision::OPERATION_INSERT => $entitiesToInsert,
            EntityRevision::OPERATION_DELETE => $entitiesToDelete,
        ];
    }

    /**
     * Проверка относительно списка сущностей.
     *
     * @param object $entity
     * @return bool
     */
    private function checkEntity(object $entity): bool
    {
        if (in_array(get_class($entity), $this->entityTypes)) {
            return true;
        }

        return false;
    }

    /**
     * Создание сущности ревизии на основе измененной сущности.
     *
     * @param object $entity
     * @param string $operation
     *
     * @return EntityRevision
     *
     * @throws EntityRevisionIncorrectOperationException
     */
    private function createRevisionFromSourceEntity(object $entity, string $operation): EntityRevision
    {
        // Получить ID пользователя.
        $userId = null;
        $token = $this->tokenStorage->getToken();
        if ($token) {
            $user = $token->getUser();
            if ($user instanceof User) {
                $userId = (int) $user->getId();
            }
        }

        // Получить контент в JSON-формате.
        $content = $this->serializer->serialize($entity);

        // Получить тип сущности.
        $entityClass = get_class($entity);
        $parts = explode('\\', $entityClass);
        $entityType = end($parts);

        return new EntityRevision(
            $entity->getId(),
            $entityType,
            $content,
            $operation,
            $userId,
        );
    }
}
