<?php
namespace Ecommerce360\Tiendas\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Ecommerce360\Tiendas\Model\StoreFactory;

class View extends Action
{
    protected $jsonFactory;
    protected $storeFactory;

    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        StoreFactory $storeFactory
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->storeFactory = $storeFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $result = $this->jsonFactory->create();
        $id = $this->getRequest()->getParam('id');

        if ($id) {
            $store = $this->storeFactory->create()->load($id);
            if ($store->getId()) {
                return $result->setData($store->getData());
            } else {
                return $result->setData(['error' => 'Store not found']);
            }
        }

        return $result->setData(['error' => 'ID not provided']);
    }
}
