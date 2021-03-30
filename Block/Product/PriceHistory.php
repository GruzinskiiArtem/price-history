<?php

declare(strict_types=1);

namespace Test\PriceHistory\Block\Product;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Template;

/**
 * Class PriceHistory
 */
class PriceHistory extends Template
{
    /**
     * @var string
     */
    private const XML_PATH_PRICE_HISTORY_SETTING_ENABLE = 'price_history/setting/enable';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * PriceHistory constructor.
     *
     * @param Template\Context $context
     * @param ScopeConfigInterface $scopeConfig
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        $this->scopeConfig = $scopeConfig;

        parent::__construct($context, $data);
    }

    /**
     * @return bool
     */
    public function isShow(): bool
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_PRICE_HISTORY_SETTING_ENABLE
        );
    }
}
