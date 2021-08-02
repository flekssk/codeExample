<?php

namespace App\Tests\integrational\App\Infrastructure\HttpClients\Crm;

use App\Infrastructure\HttpClients\Crm\CrmProxy;
use Codeception\Test\Unit;
use App\Infrastructure\HttpClients\Crm\CrmProxyClientInterface;

/**
 * Class CrmProxyTest.
 *
 * @covers \App\Infrastructure\HttpClients\Crm\CrmProxy
 */
class CrmProxyTest extends Unit
{

    /**
     * Check get positions from DB.
     */
    public function testCheckGetPositions()
    {
        $client = new class () implements CrmProxyClientInterface {

            public function getJobTitlesWithProducts(): array
            {
                $result = [];
                for ($i = 0; $i < 5; $i++) {
                    $position = new \stdClass();
                    $position->Id = 'ID';
                    $position->Name = 'Name';
                    $position->TypeId = 1;
                    $position->TypeName = 'Type name';
                    $result[] = $position;
                }
                return $result;
            }
        };

        $proxy = new CrmProxy($client);
        $positions = $proxy->getPositions();
        $this->assertCount(5, $positions);
    }
}
