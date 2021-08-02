<?php

namespace App\Tests\integrational\App\Infrastructure\HttpClients\CrmApi;

use App\Domain\Entity\Product\Product;
use App\Domain\Entity\SpecialistDocument\SpecialistDocument;
use App\Infrastructure\HttpClients\CrmApi\CrmApi;
use App\Infrastructure\HttpClients\CrmApi\CrmApiClient;
use Codeception\Test\Unit;
use Monolog\Logger;

/**
 * Class CrmApiTest.
 *
 * @covers \App\Infrastructure\HttpClients\CrmApi\CrmApi
 */
class CrmApiTest extends Unit
{
    /**
     * Test get products.
     */
    public function testGetProductVersionForRegistry()
    {
        $module = $this->getModule('Symfony');
        $container = $module->kernel->getContainer();

        $client = $container->get('App\Infrastructure\HttpClients\CrmApi\CrmApiClient');

        $api = new CrmApi(
            $client,
            new Logger('test')
        );

        $products = $api->getProducts($container->getParameter('registryDomain'));
        $this->assertIsArray($products);
        $this->assertInstanceOf(Product::class, reset($products));
    }

    public function testGetDocumentsReturnSpecialistDocuments()
    {
        $module = $this->getModule('Symfony');
        $container = $module->kernel->getContainer();

        $client = $container->get('App\Infrastructure\HttpClients\CrmApi\CrmApiClient');

        $api = new CrmApi(
            $client,
            new Logger('test')
        );

        $documents = $api->getDocuments([4999], new \DateTimeImmutable('2019-12-01'));

        $this->assertInstanceOf(SpecialistDocument::class, reset($documents));
    }

    public function testGetDocumentsForSpecialistReturnSpecialistDocuments()
    {
        $module = $this->getModule('Symfony');
        $container = $module->kernel->getContainer();

        $client = $container->get('App\Infrastructure\HttpClients\CrmApi\CrmApiClient');

        $api = new CrmApi(
            $client,
            new Logger('test')
        );

        $documents = $api->getDocumentsForSpecialistId(72866);

        $this->assertInstanceOf(SpecialistDocument::class, reset($documents));
    }

    public function testGetDocumentsForSpecialistWithoutBaseUrlNotThrowException()
    {
        $module = $this->getModule('Symfony');
        $container = $module->kernel->getContainer();

        $client = $container->get('App\Infrastructure\HttpClients\CrmApi\CrmApiClient');

        $api = new CrmApi(
            $client,
            new Logger('test')
        );

        $documents = $api->getDocumentsForSpecialistId(72866);
    }
}
