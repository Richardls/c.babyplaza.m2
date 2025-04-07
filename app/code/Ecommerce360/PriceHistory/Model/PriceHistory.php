<?php
namespace Ecommerce360\PriceHistory\Model;

use Magento\Framework\Model\AbstractModel;

class PriceHistory extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('Ecommerce360\PriceHistory\Model\ResourceModel\PriceHistory');
    }
}
