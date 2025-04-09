<?php
namespace Ecommerce360\Links\Model;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Ecommerce360\Links\Model\ResourceModel\Link\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var array
     */
    protected $loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $linkCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $linkCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $link) {
            $this->loadedData[$link->getId()] = $link->getData();
        }
        return $this->loadedData;
    }
}
