<?php
namespace Ecommerce360\PriceHistory\Model\ResourceModel\PriceHistory;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            'Ecommerce360\PriceHistory\Model\PriceHistory',
            'Ecommerce360\PriceHistory\Model\ResourceModel\PriceHistory'
        );
    }
}
