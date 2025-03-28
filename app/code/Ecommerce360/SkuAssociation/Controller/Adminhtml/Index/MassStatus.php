<?php
namespace Ecommerce360\SkuAssociation\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Ecommerce360\SkuAssociation\Model\ResourceModel\SkuAssociation\CollectionFactory;
use Ecommerce360\SkuAssociation\Model\SkuAssociation;

class MassStatus extends \Magento\Backend\App\Action
{
    protected $filter;
    protected $collectionFactory;
    protected $skuAssociationModel;

    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        SkuAssociation $skuAssociationModel
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->skuAssociationModel = $skuAssociationModel;
        parent::__construct($context);
    }

    public function execute()
    {
        $skuData = $this->collectionFactory->create();

        foreach ($skuData as $value) {
            $templateId[] = $value['sku_associated_id'];
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
        $collection->addFieldToFilter('sku_associated_id', ['in' => $selectedIds]);
        $statusCount = 0;

        foreach ($collection as $item) {
            $this->setStatus($item->getSkuAssociatedId(), $this->getRequest()->getParam('status'));
            $statusCount++;
        }

        $this->messageManager->addSuccess(__('A total of %1 SKU association(s) were updated.', $statusCount));
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Set the status for an SKU association record
     *
     * @param int $id
     * @param int $status
     * @return void
     */
    public function setStatus($id, $status)
    {
        $item = $this->skuAssociationModel->load($id);
        $item->setStatus($status)->save();
        return;
    }
}
