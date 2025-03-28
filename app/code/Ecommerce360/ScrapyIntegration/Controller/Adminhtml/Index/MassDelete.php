<?php
namespace Ecommerce360\ScrapyIntegration\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Ecommerce360\ScrapyIntegration\Model\ResourceModel\Link\CollectionFactory;
use Ecommerce360\ScrapyIntegration\Model\Link;

class MassDelete extends \Magento\Backend\App\Action
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

        $parameterData = $this->getRequest()->getParams('link_id');
        $selectedIds = $this->getRequest()->getParams('link_id');

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
        $deleteCount = 0;
        $model = [];
        foreach ($collection as $item) {
            $this->deleteById($item->getLinkId());
            $deleteCount++;
        }

        $this->messageManager->addSuccess(__('A total of %1 Scrapy Integration Links have been deleted.', $deleteCount));
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Delete a link record by ID
     *
     * @param int $id
     * @return void
     */
    public function deleteById($id)
    {
        $item = $this->linkModel->load($id);
        $item->delete();
        return;
    }
}
