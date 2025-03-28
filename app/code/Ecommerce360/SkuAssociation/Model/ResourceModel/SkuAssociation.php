<?php
namespace Ecommerce360\SkuAssociation\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class SkuAssociation extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('ecommerce360_skuassociation', 'sku_associated_id');
    }
}
