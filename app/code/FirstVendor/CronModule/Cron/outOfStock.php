<?php

namespace FirstVendor\CronModule\Cron;

use Psr\Log\LoggerInterface;
use Magento\Zend\Log;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

class outOfStock
{
    private $logger;
    private $stockRegistry;
    private $productFactory;
    private $searchCriteriaBuilder;

    public function __construct(
        LoggerInterface $logger,
        StockRegistryInterface $stockRegistry,
        ProductRepositoryInterface $productFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
    ) {

        $this->logger = $logger;
        $this->stockRegistry = $stockRegistry;
        $this->productFactory = $productFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }


    public function execute()
    {

        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/cron.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);



        $products = $this->productFactory->getList($this->searchCriteriaBuilder->create());

        foreach ($products->getItems() as $product) {

            $stock = $this->stockRegistry->getStockItem($product->getId());
            if (!$stock->getIsInStock()) {

                $logger->info("Product " . $product->getName() . " is out of stock");
            }
        }
    }
}
