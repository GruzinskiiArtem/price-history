<?php

declare(strict_types=1);

namespace Test\PriceHistory\Observer;

use Magento\Catalog\Model\Product;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Psr\Log\LoggerInterface;
use Test\PriceHistory\Api\Data\PriceHistoryInterface;
use Test\PriceHistory\Model\PriceHistoryFactory;
use Test\PriceHistory\Model\PriceHistoryRepository;
use Test\PriceHistory\Model\ResourceModel\PriceHistory\CollectionFactory;

/**
 * Class AddPriceHistory
 */
class AddPriceHistory implements ObserverInterface
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var PriceHistoryRepository
     */
    private $priceHistoryRepository;

    /**
     * @var PriceHistoryFactory
     */
    private $priceHistoryFactory;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * AddPriceHistory constructor.
     *
     * @param CollectionFactory $collectionFactory
     * @param PriceHistoryRepository $priceHistoryRepository
     * @param PriceHistoryFactory $priceHistoryFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        PriceHistoryRepository $priceHistoryRepository,
        PriceHistoryFactory $priceHistoryFactory,
        LoggerInterface $logger
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->priceHistoryRepository = $priceHistoryRepository;
        $this->priceHistoryFactory = $priceHistoryFactory;
        $this->logger = $logger;
    }

    public function execute(Observer $observer): void
    {
        /** @var  $product Product */
        $product = $observer->getEvent()->getProduct();

        $priceHistoryCollection = $this->collectionFactory->create();

        $priceHistoryCollection->addFieldToFilter(PriceHistoryInterface::KEY_SKU, $product->getSku())
            ->setOrder(PriceHistoryInterface::KEY_CREATED_AT, AbstractDb::SORT_ORDER_ASC);

        if (!$priceHistoryCollection->getSize()) {
            $this->addPrice($product);

            return;
        }

        $price = (float) $product->getPrice();

        if ($price === $priceHistoryCollection->getLastItem()->getPrice()) {
            return;
        }

        $this->addPrice($product);
    }

    /**
     * Add price history
     *
     * @param Product $product
     */
    private function addPrice(Product $product): void
    {
        $priceHistory = $this->priceHistoryFactory->create();
        $priceHistory->setSku($product->getSku())
            ->setPrice((float)$product->getPrice());

        try {
            $this->priceHistoryRepository->save($priceHistory);
        } catch (CouldNotSaveException $exception) {
            $this->logger->critical($exception);
        }
    }
}
