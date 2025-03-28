<?php
namespace Ecommerce360\Tiendas\Model\ResourceModel\Store;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Ecommerce360\Tiendas\Model\Store as StoreModel;
use Ecommerce360\Tiendas\Model\ResourceModel\Store as StoreResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            StoreModel::class,
            StoreResourceModel::class
        );
    }
}
