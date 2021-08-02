<?php

namespace App\Infrastructure\HttpClients\Crm;

/**
 * Interface CrmProxyClientInterface.
 */
interface CrmProxyClientInterface
{

    /**
     * @return array
     */
    public function getJobTitlesWithProducts(): array;
}
