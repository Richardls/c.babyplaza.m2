<?php
namespace Ecommerce360\ScrapyIntegration\Model\Api;

use Ecommerce360\ScrapyIntegration\Api\LinkRepositoryInterface;
use Ecommerce360\ScrapyIntegration\Api\LinkUpdateDataInterface;
use Ecommerce360\ScrapyIntegration\Api\ResponseItemInterfaceFactory;
use Ecommerce360\ScrapyIntegration\Api\ResponseItemInterface;
use Ecommerce360\ScrapyIntegration\Model\ResourceModel\Link\CollectionFactory;
use Magento\Framework\Exception\NoSuchEntityException;

class LinkRepository implements LinkRepositoryInterface
{
    private $linkCollectionFactory;
    private $responseItemFactory;

    public function __construct(
        CollectionFactory $linkCollectionFactory,
        ResponseItemInterfaceFactory $responseItemFactory
    ) {
        $this->linkCollectionFactory = $linkCollectionFactory;
        $this->responseItemFactory = $responseItemFactory;
    }

    public function getItem(int $id): ResponseItemInterface
    {
        $collection = $this->getLinkCollection()->addFieldToFilter('link_id', ['eq' => $id]);
        $link = $collection->getFirstItem();
        if (!$link->getId()) {
            throw new NoSuchEntityException(__('Link not found'));
        }
        return $this->getResponseItemFromLink($link);
    }

    public function update(int $id, LinkUpdateDataInterface $data): bool
    {
        $link = $this->linkCollectionFactory->create()->getItemById($id);
        if (!$link) {
            throw new NoSuchEntityException(__('Link with ID %1 does not exist.', $id));
        }

        $link->setData('store_domain', $data->getStoreDomain());
        $link->setData('sku_store', $data->getSkuStore());
        $link->setData('magento_sku', $data->getMagentoSku());
        $link->setData('store_productname', $data->getStoreProductname());
        $link->setData('store_brand', $data->getStoreBrand());
        $link->setData('link_url', $data->getLinkUrl());
        $link->setData('min_price', $data->getMinPrice());
        $link->setData('list_price', $data->getListPrice());
        $link->setData('in_stock', $data->getInStock());
        $link->setData('status', $data->getStatus());
        $link->setData('image_url_01', $data->getImageUrl01());
        $link->setData('updated_at', $data->getUpdatedAt());

        try {
            $link->save();
            return true;
        } catch (\Exception $e) {
            throw new \Exception(__('Failed to update the link: %1', $e->getMessage()));
        }
    }

    private function getLinkCollection()
    {
        $collection = $this->linkCollectionFactory->create();
        $collection->addFieldToSelect([
            'link_id',
            'store_domain',
            'sku_store',
            'magento_sku',
            'store_productname',
            'store_brand',
            'link_url',
            'min_price',
            'list_price',
            'in_stock',
            'status',
            'image_url_01',
            'updated_at'
        ]);
        return $collection;
    }

    private function getResponseItemFromLink($link): ResponseItemInterface
    {
        $responseItem = $this->responseItemFactory->create();
        $responseItem->setLinkId($link->getId())
            ->setStoreDomain($link->getData('store_domain'))
            ->setSkuStore($link->getData('sku_store'))
            ->setMagentoSku($link->getData('sku_store'))
            ->setStoreProductname($link->getData('store_productname'))
            ->setStoreBrand($link->getData('store_brand'))
            ->setLinkUrl($link->getData('link_url'))
            ->setMinPrice($link->getData('min_price'))
            ->setListPrice($link->getData('list_price'))
            ->setInStock($link->getData('in_stock'))
            ->setStatus($link->getData('status'))
            ->setImageUrl01($link->getData('image_url_01'))
            ->setUpdatedAt($link->getData('updated_at'));
        return $responseItem;
    }

    public function create(LinkUpdateDataInterface $data): int
    {
        $link = $this->linkCollectionFactory->create()->getNewEmptyItem();
    
        // Set the data from the input
        $link->setData('store_domain', $data->getStoreDomain());
        $link->setData('sku_store', $data->getSkuStore());
        $link->setData('magento_sku', $data->getMagentoSku());
        $link->setData('store_productname', $data->getStoreProductname());
        $link->setData('store_brand', $data->getStoreBrand());
        $link->setData('link_url', $data->getLinkUrl());
        $link->setData('min_price', $data->getMinPrice());
        $link->setData('list_price', $data->getListPrice());
        $link->setData('in_stock', $data->getInStock());
        $link->setData('status', $data->getStatus());
        $link->setData('image_url_01', $data->getImageUrl01());
        $link->setData('updated_at', $data->getUpdatedAt());
        $link->setData('created_at', date('Y-m-d H:i:s'));
    
        try {
            $link->save();
            return $link->getId();
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('Failed to create the link: %1', $e->getMessage())
            );
        }
    }
    

}
