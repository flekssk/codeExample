<?php

declare(strict_types=1);

namespace App\Application\HealthCheck;

use App\Application\HealthCheck\Exception\HealthCheckErrorException;

interface HealthCheckServiceInterface
{
    /**
     * @throws HealthCheckErrorException
     */
    public function healthCheck(): void;
}
