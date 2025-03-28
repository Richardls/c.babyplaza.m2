<?php
namespace Ecommerce360\Tiendas\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Ecommerce360\Tiendas\Model\ResourceModel\Store\CollectionFactory;
use Ecommerce360\Tiendas\Model\Store;

class MassDelete extends \Magento\Backend\App\Action
{
    protected $filter;
    protected $collectionFactory;
    protected $storeModel;

    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        Store $storeModel
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->storeModel = $storeModel;
        parent::__construct($context);
    }

    public function execute()
    {
        $storeData = $this->collectionFactory->create();

        foreach ($storeData as $value) {
            $templateId[] = $value['store_id'];
        }

        $parameterData = $this->getRequest()->getParams('store_id');
        $selectedIds = $this->getRequest()->getParams('store_id');

        if (array_key_exists("selected", $parameterData)) {
            $selectedIds = $parameterData['selected'];
        }
        
        if (array_key_exists("excluded", $parameterData)) {
            if ($parameterData['excluded'] == 'false') {
                $selectedIds = $templateId;
            } else {
                $selectedIds = array_diff($templateId, $parameterData['excluded']);
            }
        }

        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('store_id', ['in' => $selectedIds]);
        $deleteCount = 0;
        $model=[];
        foreach ($collection as $item) {
            $this->deleteById($item->getStoreId());
            $deleteCount++;
        }

        $this->messageManager->addSuccess(__('A total of %1 Records have been deleted.', $deleteCount));
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Delete a store record by ID
     *
     * @param int $id
     * @return void
     */
    public function deleteById($id)
    {
        $item = $this->storeModel->load($id);
        $item->delete();
        return;
    }
}
