<?php

declare(strict_types=1);

namespace Test\PriceHistory\Model\ResourceModel\PriceHistory;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * @var string
     */
    protected $_eventPrefix = 'price_history_collection';

    /**
     * @var string
     */
    protected $_eventObject = 'price_history_collection';

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(
            \Test\PriceHistory\Model\PriceHistory::class,
            \Test\PriceHistory\Model\ResourceModel\PriceHistory::class
        );
    }
}
