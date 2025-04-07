<?php
namespace Ecommerce360\ScrapyIntegration\Model\Api;

use Ecommerce360\ScrapyIntegration\Api\LinkUpdateDataInterface;
use Magento\Framework\DataObject;

class LinkUpdateData extends DataObject implements LinkUpdateDataInterface
{
    public function getStoreDomain()
    {
        return $this->getData('store_domain');
    }

    public function setStoreDomain($storeDomain)
    {
        return $this->setData('store_domain', $storeDomain);
    }

    public function getSkuStore()
    {
        return $this->getData('sku_store');
    }

    public function setSkuStore($skuStore)
    {
        return $this->setData('sku_store', $skuStore);
    }

    public function getMagentoSku()
    {
        return $this->getData('magento_sku');
    }

    public function setMagentoSku($magentoSku)
    {
        return $this->setData('magento_sku', $magentoSku);
    }


    public function getStoreProductname()
    {
        return $this->getData('store_productname');
    }

    public function setStoreProductname($storeProductname)
    {
        return $this->setData('store_productname', $storeProductname);
    }

    public function getStoreBrand()
    {
        return $this->getData('store_brand');
    }

    public function setStoreBrand($storeBrand)
    {
        return $this->setData('store_brand', $storeBrand);
    }

    public function getLinkUrl()
    {
        return $this->getData('link_url');
    }

    public function setLinkUrl($linkUrl)
    {
        return $this->setData('link_url', $linkUrl);
    }

    public function getMinPrice()
    {
        return $this->getData('min_price');
    }

    public function setMinPrice($minPrice)
    {
        return $this->setData('min_price', $minPrice);
    }

    public function getListPrice()
    {
        return $this->getData('list_price');
    }

    public function setListPrice($listPrice)
    {
        return $this->setData('list_price', $listPrice);
    }

    public function getInStock()
    {
        return $this->getData('in_stock');
    }

    public function setInStock($inStock)
    {
        return $this->setData('in_stock', $inStock);
    }

    public function getStatus()
    {
        return $this->getData('status');
    }

    public function setStatus($status)
    {
        return $this->setData('status', $status);
    }

    public function getImageUrl01()
    {
        return $this->getData('image_url_01');
    }

    public function setImageUrl01($imageUrl01)
    {
        return $this->setData('image_url_01', $imageUrl01);
    }

    public function getUpdatedAt()
    {
        return $this->getData('updated_at');
    }
    
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData('updated_at', $updatedAt);
    }    

}
