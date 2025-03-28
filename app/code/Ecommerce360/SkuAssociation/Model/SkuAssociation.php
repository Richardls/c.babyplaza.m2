<?php
namespace Ecommerce360\SkuAssociation\Model;

use Magento\Framework\Model\AbstractModel;
use Ecommerce360\SkuAssociation\Model\ResourceModel\SkuAssociation as SkuAssociationResourceModel;

class SkuAssociation extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(SkuAssociationResourceModel::class);
    }

}
