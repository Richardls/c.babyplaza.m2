<?php
namespace Ecommerce360\MasterLinks\Model\ResourceModel\MasterLink;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Ecommerce360\MasterLinks\Model\MasterLink as MasterLinkModel;
use Ecommerce360\MasterLinks\Model\ResourceModel\MasterLink as MasterLinkResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            MasterLinkModel::class,
            MasterLinkResourceModel::class);
    }
}
