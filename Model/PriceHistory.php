<?php

declare(strict_types=1);

namespace Test\PriceHistory\Model;

use Magento\Framework\Model\AbstractModel;
use Test\PriceHistory\Api\Data\PriceHistoryInterface;

/**
 * Class PriceHistory
 */
class PriceHistory extends AbstractModel implements PriceHistoryInterface
{
    /**
     * @inheritDoc
     */
    protected $_eventPrefix = 'price_history';

    /**
     * @inheritDoc
     */
    public function setSku(string $sku): PriceHistoryInterface
    {
        $this->setData(self::KEY_SKU, $sku);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setPrice(float $price): PriceHistoryInterface
    {
        $this->setData(self::KEY_PRICE, $price);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setCreatedAt(string $createdAt): PriceHistoryInterface
    {
        $this->setData(self::KEY_CREATED_AT, $createdAt);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getSku(): ?string
    {
        return $this->getData(self::KEY_SKU);
    }

    /**
     * @inheritDoc
     */
    public function getPrice(): ?float
    {
        return (float)$this->getData(self::KEY_PRICE);
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt(): ?string
    {
        return $this->getData(self::KEY_CREATED_AT);
    }

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\PriceHistory::class);
    }
}
