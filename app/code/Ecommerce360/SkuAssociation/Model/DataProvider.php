<?php
namespace Ecommerce360\SkuAssociation\Model;

use Ecommerce360\SkuAssociation\Model\ResourceModel\SkuAssociation\CollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var array
     */
    protected $loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $skuAssociationCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $skuAssociationCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $skuAssociation) {
            $this->loadedData[$skuAssociation->getId()] = $skuAssociation->getData();
        }
        return $this->loadedData;
    }
}
