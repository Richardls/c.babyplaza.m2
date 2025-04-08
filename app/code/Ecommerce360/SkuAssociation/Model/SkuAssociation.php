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
        /**
     * Retrieve the Magento SKU associated.
     *
     * @return string|null
     */
    public function getSkuMagento()
    {
        return $this->getData('sku_magento');
    }

    /**
     * Set the Magento SKU associated.
     *
     * @param string $skuMagento
     * @return $this
     */
    public function setSkuMagento($skuMagento)
    {
        return $this->setData('sku_magento', $skuMagento);
    }

}
