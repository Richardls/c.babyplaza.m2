<?php
namespace Ecommerce360\SkuAssociation\Model;

use Ecommerce360\SkuAssociation\Model\ResourceModel\SkuAssociation\CollectionFactory;
use Magento\Framework\Exception\NoSuchEntityException;

class AssociationService
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * Constructor
     *
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Retorna el SKU de Magento asociado a partir del SKU de la tienda.
     *
     * @param string $skuStore
     * @return string|null
     */
    public function getMagentoSkuByStoreSku($skuStore)
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('sku_store', $skuStore);
        $item = $collection->getFirstItem();
        if ($item && $item->getId()) {
            return $item->getSkuMagento();
        }
        return null;
    }
}
