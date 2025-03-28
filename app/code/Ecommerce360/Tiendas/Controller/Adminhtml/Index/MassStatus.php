<?php
namespace Ecommerce360\Tiendas\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Ecommerce360\Tiendas\Model\ResourceModel\Store\CollectionFactory;
use Ecommerce360\Tiendas\Model\Store;

class MassStatus extends \Magento\Backend\App\Action
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

        $parameterData = $this->getRequest()->getParams('status');
        $selectedIds = $this->getRequest()->getParams('status');

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
        $statusCount = 0;
        $model=[];
        foreach ($collection as $item) {
            $this->setStatus($item->getStoreId(), $this->getRequest()->getParam('status'));
            $statusCount++;
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) were updated.', $statusCount));
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Set the status for a store record
     *
     * @param int $id
     * @param int $Param
     * @return void
     */
    public function setStatus($id, $Param)
    {
        $item = $this->storeModel->load($id);
        $item->setStatus($Param)->save();
        return;
    }
}
