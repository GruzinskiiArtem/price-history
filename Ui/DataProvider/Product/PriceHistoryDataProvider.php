<?php

declare(strict_types=1);

namespace Test\PriceHistory\Ui\DataProvider\Product;

use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Psr\Log\LoggerInterface;
use Test\PriceHistory\Api\Data\PriceHistoryInterface;
use Test\PriceHistory\Model\ResourceModel\PriceHistory\CollectionFactory;

/**
 * Class PriceHistoryDataProvider
 */
class PriceHistoryDataProvider extends AbstractDataProvider
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * PriceHistoryDataProvider constructor.
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param RequestInterface $request
     * @param ProductRepository $productRepository
     * @param LoggerInterface $logger
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        CollectionFactory $collectionFactory,
        RequestInterface $request,
        ProductRepository $productRepository,
        LoggerInterface $logger,
        array $meta = [],
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->request = $request;
        $this->productRepository = $productRepository;
        $this->logger = $logger;

        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array|array[]
     */
    public function getData(): array
    {
        $arrItems = [
            'items' => [],
        ];

        $currentProductId = $this->request->getParam('current_product_id');

        if (!$currentProductId) {
            return $arrItems;
        }

        try {
            $product = $this->productRepository->getById($currentProductId);
        } catch (NoSuchEntityException $exception) {
            $this->logger->critical($exception);

            return $arrItems;
        }

        $sku = $product->getSku();

        $priceHistoryCollection = $this->collectionFactory->create();
        $priceHistoryCollection->addFieldToFilter(PriceHistoryInterface::KEY_SKU, $sku);

        foreach ($priceHistoryCollection as $item) {
            $arrItems['items'][] = $item->toArray([]);
        }

        return $arrItems;
    }
}
