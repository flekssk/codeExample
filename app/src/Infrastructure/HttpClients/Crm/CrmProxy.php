<?php

namespace App\Infrastructure\HttpClients\Crm;

use App\Domain\Entity\Position\Position;
use App\Infrastructure\HttpClients\Crm\CrmProxyClientInterface;
use App\Infrastructure\HttpClients\Crm\CrmProxyInterface;

/**
 * Class CrmProxy.
 */
class CrmProxy implements CrmProxyInterface
{

    /**
     * @var CrmProxyClientInterface
     */
    private CrmProxyClientInterface $crmClient;

    /**
     * @param CrmProxyClientInterface $crmClient
     */
    public function __construct(CrmProxyClientInterface $crmClient)
    {
        $this->crmClient = $crmClient;
    }

   /**
    * @inheritdoc
    */
    public function getPositions(): array
    {
        $positions = [];
        $crmData = $this->crmClient->getJobtitlesWithProducts();
        foreach ($crmData as $item) {
            $position = new Position();
            $position->setGuid($item->Id);
            $position->setName($item->Name);
            $positions[] = $position;
        }

        return $positions;
    }
}
