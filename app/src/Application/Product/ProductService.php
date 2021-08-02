<?php

namespace App\Application\Product;

use App\Domain\Repository\Product\ProductRepositoryInterface;
use App\Infrastructure\HttpClients\CrmApi\CrmApiInterface;
use Exception;

/**
 * Class PositionService.
 */
class ProductService implements ProductServiceInterface
{
    /**
     * @var CrmApiInterface
     */
    private CrmApiInterface $crmApi;

    /**
     * @var ProductRepositoryInterface
     */
    private ProductRepositoryInterface $repository;

    /**
     * @var string
     */
    private string $registryDomain;

    /**
     * @param string $registryDomain
     * @param CrmApiInterface $crmApi
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        string $registryDomain,
        CrmApiInterface $crmApi,
        ProductRepositoryInterface $productRepository
    ) {
        $this->registryDomain = $registryDomain;
        $this->crmApi = $crmApi;
        $this->repository = $productRepository;
    }

    /**
     * @inheritdoc
     *
     * @throws Exception
     */
    public function update(): int
    {
        $products = $this->crmApi->getProducts($this->registryDomain);

        $this->repository->beginTransaction();

        $this->repository->deleteAll();

        foreach ($products as $product) {
            $this->repository->save($product);
        }

        $this->repository->commit();

        return count($products);
    }
}
