<?php
namespace Ecommerce360\Tiendas\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Store extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('ecommerce360_tiendas', 'store_id');
    }
}
