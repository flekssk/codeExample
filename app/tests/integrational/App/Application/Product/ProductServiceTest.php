<?php

namespace App\Tests\integrational\App\Application\Product;

use App\Application\Product\ProductService;
use App\Domain\Entity\Product\Product;
use App\Infrastructure\HttpClients\CrmApi\CrmApiInterface;
use App\Infrastructure\Persistence\Doctrine\Repository\Product\ProductRepository;
use Codeception\TestCase\Test;

/**
 * Class ProductServiceTest.
 *
 * @covers \App\Application\Product\ProductService
 */
class ProductServiceTest extends Test
{

    /**
     * Check update data in DB.
     */
    public function testCheckUpdateDataInDB()
    {
        $crmProxy = new class () implements CrmApiInterface {
            public function getProducts(string $registryDomain): array
            {
                $result = [];
                for ($i = 10; $i < 15; $i++) {
                    $product = new Product();
                    $product->setId($i);
                    $product->setName('Name');
                    $result[] = $product;
                }

                return $result;
            }

            public function getDocuments(array $versionNumbers, \DateTimeImmutable $onlyAfterDate): array
            {
                return [];
            }

            public function getDocumentsForSpecialistId(int $specialistId): array
            {
                return [];
            }

            public function getDocumentTemplates(): array
            {
                return [];
            }
        };

        $repository = $this->getRepository();
        $productService = new ProductService(getenv('REGISTRY_DOMAIN'), $crmProxy, $repository);
        $productService->update();

        $this->assertEquals(5, $repository->count([]));
    }

    /**
     * @return ProductRepository
     *
     * @throws \Codeception\Exception\ModuleException
     */
    private function getRepository(): ProductRepository
    {
        /** @var \Codeception\Module\Symfony $module */
        $module = $this->getModule('Symfony');
        $container = $module->kernel->getContainer();

        return $container->get(ProductRepository::class);
    }
}
