<?php
namespace Ecommerce360\Tiendas\Model;

use Ecommerce360\Tiendas\Model\ResourceModel\Store\CollectionFactory;

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
        CollectionFactory $storeCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $storeCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        foreach ($items as $store) {
            $data = $store->getData();

            // Convertir JSON a array para `payment_methods`
            if (isset($data['payment_methods']) && is_string($data['payment_methods'])) {
                $data['payment_methods'] = json_decode($data['payment_methods'], true);
            }

            // Convertir JSON a array para `delivery_options`
            if (isset($data['delivery_options']) && is_string($data['delivery_options'])) {
                $data['delivery_options'] = json_decode($data['delivery_options'], true);
            }

            $this->loadedData[$store->getId()] = $data;
        }

        return $this->loadedData;
    }
}
