<?php

declare(strict_types=1);

namespace App\Domain\Entity\Specialist\ValueObject;

/**
 * Class Status.
 *
 * @package App\Domain\Entity\Specialist\ValueObject
 */
class Status
{
    /**
     * Статус не зарегистрированного в реестре пользователя.
     */
    const STATUS_NOT_IN_REGISTRY = 0;

    /**
     * Название статуса не зарегистрированного в реестре пользователя.
     */
    const STATUS_NOT_IN_REGISTRY_NAME = 'Не в реестре';

    /**
     * Статус не аттестованного пользователя.
     */
    const STATUS_CERTIFICATION_REQUIRED = 1;

    /**
     * Название статуса не аттестованного пользователя.
     */
    const STATUS_CERTIFICATION_REQUIRED_NAME = 'Требуется аттестация';

    /**
     * Статус пользователя в процессе обучения.
     */
    const STATUS_STUDYING = 2;

    /**
     * Название статуса пользователя в процессе обучения.
     */
    const STATUS_STUDYING_NAME = 'Обучается';

    /**
     * Статус аттестованного пользователя.
     */
    const STATUS_CERTIFIED = 3;

    /**
     * Название статуса аттестованного пользователя.
     */
    const STATUS_CERTIFIED_NAME = 'Аттестованный';

    /**
     * Список доступных статусов.
     *
     * @var array|string[]
     */
    public const STATUS_LIST = [
        self::STATUS_NOT_IN_REGISTRY => self::STATUS_NOT_IN_REGISTRY_NAME,
        self::STATUS_CERTIFICATION_REQUIRED => self::STATUS_CERTIFICATION_REQUIRED_NAME,
        self::STATUS_STUDYING => self::STATUS_STUDYING_NAME,
        self::STATUS_CERTIFIED => self::STATUS_CERTIFIED_NAME,
    ];

    /**
     * @var int
     */
    private int $value;


    /**
     * Status constructor.
     *
     * @param int $value
     */
    public function __construct(int $value)
    {
        if (!isset(self::STATUS_LIST[$value])) {
            throw new \DomainException("Недопустимое значение для статуса {$value}.");
        }

        $this->value = $value;
    }

    /**
     * Получение названия статуса.
     *
     * @return string
     */
    public function getStatusName(): string
    {
        return self::STATUS_LIST[$this->value];
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getStatusId(): int
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) self::STATUS_LIST[$this->value];
    }

    /**
     * @param Status $status
     *
     * @return bool
     */
    public function isEqual(Status $status): bool
    {
        return $status->getStatusId() == $this->getStatusId();
    }
}
