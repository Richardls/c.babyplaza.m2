<?php
namespace Ecommerce360\MasterLinks\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class MasterLink extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('ecommerce360_masterlinks', 'entity_id');
    }
}
