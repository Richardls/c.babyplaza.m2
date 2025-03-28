<?php
namespace Ecommerce360\Links\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Link extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('ecommerce360_productslinks', 'link_id');
    }
}
