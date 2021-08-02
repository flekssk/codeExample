<?php

declare(strict_types=1);

namespace App\Application\HealthCheck;

class CompositeHealthCheckService implements HealthCheckServiceInterface
{
    /**
     * @var HealthCheckServiceInterface[]
     */
    private array $checkers;

    /**
     * CompositeHealthCheckService constructor.
     * @param HealthCheckServiceInterface[] $checkers
     */
    public function __construct(array $checkers)
    {
        $this->checkers = $checkers;
    }


    /**
     * @inheritDoc
     */
    public function healthCheck(): void
    {
        foreach ($this->checkers as $checker) {
            $checker->healthCheck();
        }
    }
}
