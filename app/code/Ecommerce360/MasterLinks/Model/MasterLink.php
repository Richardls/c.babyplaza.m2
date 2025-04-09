<?php
namespace Ecommerce360\MasterLinks\Model;

use Magento\Framework\Model\AbstractModel;
use Ecommerce360\MasterLinks\Model\ResourceModel\MasterLink as MasterLinkResourceModel;

class MasterLink extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(MasterLinkResourceModel::class);
    }
}
