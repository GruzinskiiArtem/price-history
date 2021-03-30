<?php

declare(strict_types=1);

namespace Test\PriceHistory\Model;

use Exception;
use Magento\Framework\Exception\CouldNotSaveException;
use Psr\Log\LoggerInterface;
use Test\PriceHistory\Api\Data\PriceHistoryInterface;
use Test\PriceHistory\Api\PriceHistoryRepositoryInterface;
use Test\PriceHistory\Model\ResourceModel\PriceHistory;

/**
 * Class PriceHistoryRepository
 */
class PriceHistoryRepository implements PriceHistoryRepositoryInterface
{
    /**
     * @var PriceHistory
     */
    private $priceHistoryResourceModel;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * PriceHistoryRepository constructor.
     *
     * @param PriceHistory $priceHistoryResourceModel
     * @param LoggerInterface $logger
     */
    public function __construct(PriceHistory $priceHistoryResourceModel, LoggerInterface $logger)
    {
        $this->priceHistoryResourceModel = $priceHistoryResourceModel;
        $this->logger = $logger;
    }

    /**
     * @param PriceHistoryInterface $priceHistory
     *
     * @return PriceHistoryInterface
     *
     * @throws CouldNotSaveException
     */
    public function save(PriceHistoryInterface $priceHistory): PriceHistoryInterface
    {
        try {
            $this->priceHistoryResourceModel->save($priceHistory);

            return $priceHistory;
        } catch (Exception $exception) {
            $this->logger->critical($exception);

            throw new CouldNotSaveException(
                __('Could not save the PriceHistory: %1', $exception->getMessage()),
                $exception
            );
        }
    }
}
