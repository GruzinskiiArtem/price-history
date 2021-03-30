<?php

declare(strict_types=1);

namespace Test\PriceHistory\Api\Data;

/**
 * Interface PriceHistoryInterface
 */
interface PriceHistoryInterface
{
    /**
     * @var string
     */
    public const KEY_SKU = 'sku';

    /**
     * @var string
     */
    public const KEY_PRICE = 'price';

    /**
     * @var string
     */
    public const KEY_CREATED_AT = 'created_at';

    /**
     * Set sku
     *
     * @param string $sku
     *
     * @return PriceHistoryInterface
     */
    public function setSku(string $sku): PriceHistoryInterface;

    /**
     * Set price
     *
     * @param float $price
     *
     * @return PriceHistoryInterface
     */
    public function setPrice(float $price): PriceHistoryInterface;

    /**
     * Set created date
     *
     * @param string $createdAt
     *
     * @return PriceHistoryInterface
     */
    public function setCreatedAt(string $createdAt): PriceHistoryInterface;

    /**
     * Get sku
     *
     * @return string|null
     */
    public function getSku(): ?string;

    /**
     * Get price
     *
     * @return float|null
     */
    public function getPrice(): ?float;

    /**
     * Get created date
     *
     * @return string|null
     */
    public function getCreatedAt(): ?string;
}
