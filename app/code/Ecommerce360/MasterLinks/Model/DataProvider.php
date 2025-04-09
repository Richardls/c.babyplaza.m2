<?php
namespace Ecommerce360\MasterLinks\Model;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Ecommerce360\MasterLinks\Model\ResourceModel\MasterLink\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    protected $loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $masterlinkCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $masterlinkCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        foreach ($items as $item) {
            $this->loadedData[$item->getId()] = $item->getData();
        }
        return $this->loadedData;
    }
}
