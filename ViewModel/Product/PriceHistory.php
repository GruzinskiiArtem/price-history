<?php

declare(strict_types=1);

namespace Test\PriceHistory\ViewModel\Product;

use Magento\Catalog\Block\Product\View;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Test\PriceHistory\Api\Data\PriceHistoryInterface;
use Test\PriceHistory\Model\ResourceModel\PriceHistory\CollectionFactory;

/**
 * Class PriceHistory
 */
class PriceHistory implements ArgumentInterface
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var View
     */
    private $view;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * PriceHistory constructor.
     *
     * @param SerializerInterface $serializer
     * @param View $view
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        SerializerInterface $serializer,
        View $view,
        CollectionFactory $collectionFactory
    ) {
        $this->serializer = $serializer;
        $this->view = $view;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @return bool|string
     */
    public function getDataPoints()
    {
        $priceHistoryCollection = $this->collectionFactory->create();

        $priceHistoryCollection->addFieldToFilter(PriceHistoryInterface::KEY_SKU, $this->view->getProduct()->getSku())
            ->setOrder(PriceHistoryInterface::KEY_CREATED_AT, AbstractDb::SORT_ORDER_ASC);

        $dataPoints = array_map(
            static function ($priceHistory) {
                return [
                    'x' => date("d-M-Y", strtotime($priceHistory->getCreatedAt())),
                    'y' => $priceHistory->getPrice(),
                ];
            },
            $priceHistoryCollection->getItems()
        );

        return $this->serializer->serialize($dataPoints);
    }
}
