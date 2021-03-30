<?php

declare(strict_types=1);

namespace Test\PriceHistory\Api;

use Magento\Framework\Exception\CouldNotSaveException;
use Test\PriceHistory\Api\Data\PriceHistoryInterface;

/**
 * Interface PriceHistoryRepositoryInterface
 */
interface PriceHistoryRepositoryInterface
{
    /**
     * @param PriceHistoryInterface $priceHistory
     *
     * @return PriceHistoryInterface
     *
     * @throws CouldNotSaveException
     */
    public function save(PriceHistoryInterface $priceHistory): PriceHistoryInterface;
}
