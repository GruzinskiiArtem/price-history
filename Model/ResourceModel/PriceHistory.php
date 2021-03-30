<?php

declare(strict_types=1);

namespace Test\PriceHistory\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class PriceHistory
 */
class PriceHistory extends AbstractDb
{
    /**
     * @var string
     */
    public const TABLE_NAME = 'price_history';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, 'id');
    }
}
