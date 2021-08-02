<?php

namespace App\Infrastructure\HttpClients\Crm;

/**
 * Interface CrmProxyInterface.
 */
interface CrmProxyInterface
{

    /**
     * @return array
     */
    public function getPositions(): array;
}
