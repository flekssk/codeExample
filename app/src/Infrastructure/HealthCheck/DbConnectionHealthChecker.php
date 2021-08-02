<?php

declare(strict_types=1);

namespace App\Infrastructure\HealthCheck;

use App\Application\HealthCheck\Exception\HealthCheckErrorException;
use App\Application\HealthCheck\HealthCheckServiceInterface;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver\Connection;

class DbConnectionHealthChecker implements HealthCheckServiceInterface
{
    /** @var Connection */
    private Connection $connection;

    /** @var string */
    private string $query;

    /**
     * DbConnectionHealthChecker constructor.
     * @param Connection $pdo
     * @param string|null $query
     */
    public function __construct(Connection $pdo, string $query = null)
    {
        $this->connection = $pdo;
        $this->query = $query ?: 'SELECT 1;';
    }

    /**
     * @inheritDoc
     */
    public function healthCheck(): void
    {
        try {
            $this->connection->exec($this->query);
        } catch (DBALException $exception) {
            throw new HealthCheckErrorException($exception->getMessage(), (int)$exception->getCode(), $exception);
        }
    }

}
