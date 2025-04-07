<?php
namespace Ecommerce360\ScrapyIntegration\Api;

interface ResponseItemInterface
{
    const DATA_LINK_ID = 'link_id';
    const DATA_STORE_DOMAIN = 'store_domain';
    const DATA_SKU_STORE = 'sku_store';
    const DATA_MAGENTO_SKU = 'magento_sku';
    const DATA_STORE_PRODUCT_NAME = 'store_productname';
    const DATA_STORE_BRAND = 'store_brand';
    const DATA_LINK_URL = 'link_url';
    const DATA_MIN_PRICE = 'min_price';
    const DATA_LIST_PRICE = 'list_price';
    const DATA_IN_STOCK = 'in_stock';
    const DATA_STATUS = 'status';
    const DATA_IMAGE_URL_01 = 'image_url_01';
    const DATA_UPDATED_AT = 'updated_at';

    /**
     * @return int
     */
    public function getLinkId();

    /**
     * @return string
     */
    public function getStoreDomain();

    /**
     * @return string
     */
    public function getSkuStore();

     /**
     * @return string|null
     */
    public function getMagentoSku();

    /**
     * @param string $magentoSku
     * @return $this
     */
    public function setMagentoSku(string $magentoSku);

    /**
     * @return string
     */
    public function getStoreProductname();

    /**
     * @return string
     */
    public function getStoreBrand();

    /**
     * @return string
     */
    public function getLinkUrl();

    /**
     * @return float|null
     */
    public function getMinPrice();

    /**
     * @return float|null
     */
    public function getListPrice();

    /**
     * @return bool|null
     */
    public function getInStock();

    /**
     * @return int|null
     */
    public function getStatus();

    /**
     * @return string|null
     */
    public function getImageUrl01();


    /**
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * @param int $linkId
     * @return $this
     */
    public function setLinkId(int $linkId);

    /**
     * @param string $storeDomain
     * @return $this
     */
    public function setStoreDomain(string $storeDomain);

    /**
     * @param string $skuStore
     * @return $this
     */
    public function setSkuStore(string $skuStore);

    /**
     * @param string $storeProductname
     * @return $this
     */
    public function setStoreProductname(string $storeProductname);

    /**
     * @param string $storeBrand
     * @return $this
     */
    public function setStoreBrand(string $storeBrand);

    /**
     * @param string $linkUrl
     * @return $this
     */
    public function setLinkUrl(string $linkUrl);

    /**
     * @param float $minPrice
     * @return $this
     */
    public function setMinPrice(float $minPrice);

    /**
     * @param float $listPrice
     * @return $this
     */
    public function setListPrice(float $listPrice);

    /**
     * @param bool $inStock
     * @return $this
     */
    public function setInStock(bool $inStock);

    /**
     * @param int $status
     * @return $this
     */
    public function setStatus(int $status);

    /**
     * @param string $imageUrl01
     * @return $this
     */
    public function setImageUrl01(string $imageUrl01);

    /**
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt(string $updatedAt);
    
}
