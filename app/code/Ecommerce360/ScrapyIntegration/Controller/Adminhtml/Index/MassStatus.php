<?php
namespace Ecommerce360\ScrapyIntegration\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Ecommerce360\ScrapyIntegration\Model\ResourceModel\Link\CollectionFactory;
use Ecommerce360\ScrapyIntegration\Model\Link;

class MassStatus extends \Magento\Backend\App\Action
{
    protected $filter;
    protected $collectionFactory;
    protected $linkModel;

    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        Link $linkModel
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->linkModel = $linkModel;
        parent::__construct($context);
    }

    public function execute()
    {
        $linkData = $this->collectionFactory->create();

        foreach ($linkData as $value) {
            $templateId[] = $value['link_id'];
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
        $collection->addFieldToFilter('link_id', ['in' => $selectedIds]);
        $statusCount = 0;
        foreach ($collection as $item) {
            $this->setStatus($item->getLinkId(), $this->getRequest()->getParam('status'));
            $statusCount++;
        }

        $this->messageManager->addSuccess(__('A total of %1 Scrapy Integration Link(s) were updated.', $statusCount));
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Set the status for a link record
     *
     * @param int $id
     * @param int $status
     * @return void
     */
    public function setStatus($id, $status)
    {
        $item = $this->linkModel->load($id);
        $item->setStatus($status)->save();
        return;
    }
}
