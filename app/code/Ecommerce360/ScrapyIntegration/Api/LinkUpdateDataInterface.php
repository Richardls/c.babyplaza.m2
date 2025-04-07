<?php
namespace Ecommerce360\ScrapyIntegration\Api;

interface LinkUpdateDataInterface
{
    /**
     * @return string|null
     */
    public function getStoreDomain();

    /**
     * @param string $storeDomain
     * @return $this
     */
    public function setStoreDomain($storeDomain);

    /**
     * @return string|null
     */
    public function getSkuStore();

    /**
     * @param string $skuStore
     * @return $this
     */
    public function setSkuStore($skuStore);

        /**
     * @return string|null
     */
    public function getMagentoSku();

    /**
     * @param string $magentoSku
     * @return $this
     */
    public function setMagentoSku($magentoSku);

    /**
     * @return string|null
     */
    public function getStoreProductname();

    /**
     * @param string $storeProductname
     * @return $this
     */
    public function setStoreProductname($storeProductname);

    /**
     * @return string|null
     */
    public function getStoreBrand();

    /**
     * @param string $storeBrand
     * @return $this
     */
    public function setStoreBrand($storeBrand);

    /**
     * @return string|null
     */
    public function getLinkUrl();

    /**
     * @param string $linkUrl
     * @return $this
     */
    public function setLinkUrl($linkUrl);

    /**
     * @return float|null
     */
    public function getMinPrice();

    /**
     * @param float $minPrice
     * @return $this
     */
    public function setMinPrice($minPrice);

    /**
     * @return float|null
     */
    public function getListPrice();

    /**
     * @param float $listPrice
     * @return $this
     */
    public function setListPrice($listPrice);

    /**
     * @return bool|null
     */
    public function getInStock();

    /**
     * @param bool $inStock
     * @return $this
     */
    public function setInStock($inStock);

    /**
     * @return int|null
     */
    public function getStatus();

    /**
     * @param int $status
     * @return $this
     */
    public function setStatus($status);

    /**
     * @return string|null
     */
    public function getImageUrl01();

    /**
     * @param string $imageUrl01
     * @return $this
     */
    public function setImageUrl01($imageUrl01);

    /**
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt);

}
