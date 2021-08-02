<?php

namespace App\Domain\Entity\EntityRevision;

use App\Domain\Entity\EntityRevision\Exception\EntityRevisionIncorrectOperationException;
use DateTimeImmutable;
use DateTimeInterface;

/**
 * Class EntityRevision.
 *
 * @package App\Domain\Entity\EntityRevision
 */
class EntityRevision
{
    /**
     * Операция создания сущности.
     */
    public const OPERATION_INSERT = 'insert';

    /**
     * Операция обновления сущности.
     */
    public const OPERATION_UPDATE =  'update';

    /**
     * Операция удаления сущности.
     */
    public const OPERATION_DELETE = 'delete';

    /**
     * Список доступных операций.
     *
     * @var string[]
     */
    private array $operationsList = [
        self::OPERATION_INSERT,
        self::OPERATION_UPDATE,
        self::OPERATION_DELETE
    ];

    /**
     * @var int
     */
    private int $id;

    /**
     * @var int
     */
    private int $entityId;

    /**
     * @var string
     */
    private string $entityType;

    /**
     * @var string
     */
    private string $content;

    /**
     * @var int|null
     */
    private ?int $userId;

    /**
     * @var string|null
     */
    private ?string $operation;

    /**
     * @var DateTimeInterface
     */
    private DateTimeInterface $createdAt;

    /**
     * EntityRevision constructor.
     *
     * @param int $entityId
     * @param string $entityType
     * @param string $content
     * @param int|null $userId
     * @param string $operation
     *
     * @throws EntityRevisionIncorrectOperationException
     */
    public function __construct(
        int $entityId,
        string $entityType,
        string $content,
        string $operation,
        ?int $userId = null
    ) {
        if (!in_array($operation, $this->operationsList)) {
            throw new EntityRevisionIncorrectOperationException("Некорректный тип операции: {$operation}");
        }

        $this->entityId = $entityId;
        $this->entityType = $entityType;
        $this->content = $content;
        $this->userId = $userId;
        $this->createdAt = new DateTimeImmutable();
        $this->operation = $operation;
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getEntityId(): int
    {
        return $this->entityId;
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getEntityType(): string
    {
        return $this->entityType;
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getPrettyContent(): string
    {
        return json_encode(json_decode($this->content), JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
    }

    /**
     * @return int|null
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @return string|null
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getOperation(): ?string
    {
        return $this->operation;
    }

    /**
     * @return DateTimeInterface
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }
}
