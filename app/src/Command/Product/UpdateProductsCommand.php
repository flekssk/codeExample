<?php

namespace App\Command\Product;

use App\Application\Product\ProductServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Psr\Log\LoggerInterface;

/**
 * Class UpdateProductsCommand.
 *
 * Команда для обновления продуктов из CRM.
 */
class UpdateProductsCommand extends Command
{
    /**
     * @var ProductServiceInterface
     */
    private ProductServiceInterface $productService;
    
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * UpdatePostCatalogCommand constructor.
     *
     * @param ProductServiceInterface $productService
     * @param LoggerInterface $logger
     */
    public function __construct(ProductServiceInterface $productService, LoggerInterface $logger)
    {
        parent::__construct();
        $this->productService = $productService;
        $this->logger = $logger;
    }

    /**
     * Configuration.
     */
    protected function configure(): void
    {
        $this->setName('app:product:update')
                ->setDescription('Обновляет продукты из CRM');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->write('begin update...');
        $this->logger->info('Update products from CRM - begin update...');

        $processedCount = $this->productService->update();

        $output->writeln('done.');
        $this->logger->warning("[CMD] Update products from CRM - done, processed {$processedCount} item(s).");
        
        return 0;
    }
}
