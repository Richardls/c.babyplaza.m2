<?php
namespace Ecommerce360\ScrapyIntegration\Model;

use Magento\Framework\Model\AbstractModel;
use Ecommerce360\ScrapyIntegration\Model\ResourceModel\Link as LinkResourceModel;

class Link extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(LinkResourceModel::class);
    }

    public function beforeSave()
    {
        $listPrice = (float)$this->getData('list_price');
        $minPrice = (float)$this->getData('min_price');

        // Calcular el porcentaje de descuento si list_price es mayor que 0
        if ($listPrice > 0 && $minPrice < $listPrice) {
            $discountPercentage = (($listPrice - $minPrice) / $listPrice) * 100;
            $this->setData('discount_percentage', $discountPercentage);
            $this->setData('is_discounted', 1);
        } else {
            $this->setData('discount_percentage', 0);
            $this->setData('is_discounted', 0);
        }

        return parent::beforeSave();
    }
}
