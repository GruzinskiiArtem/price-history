<?php

declare(strict_types=1);

namespace Test\PriceHistory\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Framework\UrlInterface;
use Magento\Ui\Component\Form;

/**
 * Class PriceHistory
 */
class PriceHistory extends AbstractModifier
{
    /**
     * @var string
     */
    private const GROUP_PRICE_HISTORY = 'price_history';

    /**
     * @var string
     */
    private const GROUP_CONTENT = 'content';

    /**
     * @var string
     */
    private const SORT_ORDER = 20;

    /**
     * @var LocatorInterface
     */
    private $locator;

    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * PriceHistory constructor.
     *
     * @param LocatorInterface $locator
     * @param UrlInterface $urlBuilder
     */
    public function __construct(LocatorInterface $locator, UrlInterface $urlBuilder)
    {
        $this->locator = $locator;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @inheritdoc
     */
    public function modifyMeta(array $meta)
    {
        if (!$this->locator->getProduct()->getId()) {
            return $meta;
        }

        $meta[static::GROUP_PRICE_HISTORY] = [
            'children' => [
                'price_history_listing' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'autoRender' => true,
                                'componentType' => 'insertListing',
                                'dataScope' => 'price_history_listing',
                                'externalProvider' => 'price_history_listing.price_history_listing_data_source',
                                'selectionsProvider' => 'price_history_listing.price_history_listing.product_columns.ids',
                                'ns' => 'price_history_listing',
                                'render_url' => $this->urlBuilder->getUrl('mui/index/render'),
                                'realTimeLink' => false,
                                'behaviourType' => 'simple',
                                'externalFilterMode' => true,
                                'imports' => [
                                    'productId' => '${ $.provider }:data.product.current_product_id',
                                ],
                                'exports' => [
                                    'productId' => '${ $.externalProvider }:params.current_product_id',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Price History'),
                        'collapsible' => true,
                        'opened' => false,
                        'componentType' => Form\Fieldset::NAME,
                        'sortOrder' =>
                            $this->getNextGroupSortOrder(
                                $meta,
                                static::GROUP_CONTENT,
                                static::SORT_ORDER
                            ),
                    ],
                ],
            ],
        ];

        return $meta;
    }

    /**
     * @inheritdoc
     */
    public function modifyData(array $data)
    {
        $productId = $this->locator->getProduct()->getId();

        $data[$productId][self::DATA_SOURCE_DEFAULT]['current_product_id'] = $productId;

        return $data;
    }
}
