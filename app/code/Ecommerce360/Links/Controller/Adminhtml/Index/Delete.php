<?php
namespace Ecommerce360\Links\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;

class Delete extends Action
{
    protected $modelLink;

    /**
     * @param Action\Context $context
     * @param \Ecommerce360\Links\Model\Link $model
     */
    public function __construct(
        Action\Context $context,
        \Ecommerce360\Links\Model\Link $model
    ) {
        parent::__construct($context);
        $this->modelLink = $model;
    }

    /**
     * Check if the user is allowed to access this controller
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Ecommerce360_Links::manage_links');
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('link_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->modelLink;
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('Product link deleted successfully.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        $this->messageManager->addError(__('Product link does not exist.'));
        return $resultRedirect->setPath('*/*/');
    }
}
