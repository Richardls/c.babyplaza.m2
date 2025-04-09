<?php
namespace Ecommerce360\MasterLinks\Model;

use Magento\Framework\Model\AbstractModel;

class MasterLink extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Ecommerce360\MasterLinks\Model\ResourceModel\MasterLink::class);
    }
}
