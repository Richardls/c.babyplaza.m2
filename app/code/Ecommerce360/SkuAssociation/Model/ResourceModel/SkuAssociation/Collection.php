<?php
namespace Ecommerce360\SkuAssociation\Model\ResourceModel\SkuAssociation;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Ecommerce360\SkuAssociation\Model\SkuAssociation as SkuAssociationModel;
use Ecommerce360\SkuAssociation\Model\ResourceModel\SkuAssociation as SkuAssociationResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            SkuAssociationModel::class,
            SkuAssociationResourceModel::class
        );
    }
}
