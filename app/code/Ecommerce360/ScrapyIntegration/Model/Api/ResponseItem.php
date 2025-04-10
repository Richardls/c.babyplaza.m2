<?php
namespace Ecommerce360\ScrapyIntegration\Model\Api;

use Ecommerce360\ScrapyIntegration\Api\ResponseItemInterface;
use Magento\Framework\DataObject;

class ResponseItem extends DataObject implements ResponseItemInterface
{
    public function getLinkId(): int
    {
        return $this->_getData(self::DATA_LINK_ID);
    }

    public function getStoreDomain(): string
    {
        return $this->_getData(self::DATA_STORE_DOMAIN);
    }

    public function getSkuStore(): string
    {
        return $this->_getData(self::DATA_SKU_STORE);
    }

    public function getMagentoSku(): ?string
    {
        return $this->_getData(self::DATA_SKU_MAGENTO);
    }
    
    public function getStoreProductname(): string
    {
        return $this->_getData(self::DATA_STORE_PRODUCT_NAME);
    }

    public function getStoreBrand(): ?string
    {
        return $this->_getData(self::DATA_STORE_BRAND);
    }

    public function getLinkUrl(): string
    {
        return $this->_getData(self::DATA_LINK_URL);
    }

    public function getMinPrice(): float
    {
        return $this->_getData(self::DATA_MIN_PRICE);
    }

    public function getListPrice(): float
    {
        return $this->_getData(self::DATA_LIST_PRICE);
    }

    public function getInStock(): bool
    {
        return $this->_getData(self::DATA_IN_STOCK);
    }

    public function getStatus(): int
    {
        return $this->_getData(self::DATA_STATUS);
    }

    public function getImageUrl01(): string
    {
        return $this->_getData(self::DATA_IMAGE_URL_01);
    }

    public function getUpdatedAt(): ?string
    {
        return $this->_getData(self::DATA_UPDATED_AT);
    }

    public function setLinkId(int $id): self
    {
        return $this->setData(self::DATA_LINK_ID, $id);
    }

    public function setStoreDomain(string $domain): self
    {
        return $this->setData(self::DATA_STORE_DOMAIN, $domain);
    }

    public function setSkuStore(string $sku): self
    {
        return $this->setData(self::DATA_SKU_STORE, $sku);
    }

    public function setMagentoSku(string $magentoSku): self
    {
        return $this->setData(self::DATA_SKU_MAGENTO, $magentoSku);
    }

    public function setStoreProductname(string $name): self
    {
        return $this->setData(self::DATA_STORE_PRODUCT_NAME, $name);
    }

    public function setStoreBrand(?string $brand): self
    {
        return $this->setData(self::DATA_STORE_BRAND, $brand);
    }

    public function setLinkUrl(string $url): self
    {
        return $this->setData(self::DATA_LINK_URL, $url);
    }

    public function setMinPrice(float $price): self
    {
        return $this->setData(self::DATA_MIN_PRICE, $price);
    }

    public function setListPrice(float $price): self
    {
        return $this->setData(self::DATA_LIST_PRICE, $price);
    }

    public function setInStock(bool $inStock): self
    {
        return $this->setData(self::DATA_IN_STOCK, $inStock);
    }

    public function setStatus(int $status): self
    {
        return $this->setData(self::DATA_STATUS, $status);
    }

    public function setImageUrl01(string $url): self
    {
        return $this->setData(self::DATA_IMAGE_URL_01, $url);
    }

    public function setUpdatedAt(?string $updatedAt): self
    {
        return $this->setData(self::DATA_UPDATED_AT, $updatedAt);
    }

}
