<?php
namespace Ecommerce360\PriceHistory\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class PriceHistory extends AbstractDb
{
    protected function _construct()
    {
        // 'ecommerce360_pricehistory' es el nombre de la tabla y 'entity_id' es la clave primaria.
        $this->_init('ecommerce360_pricehistory', 'entity_id');
    }
}
