<?php
namespace Ecommerce360\Tiendas\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;

class Delete extends Action
{
    protected $modelStore;

    /**
     * @param Action\Context $context
     * @param Store $model
     */
    public function __construct(
        Action\Context $context,
        \Ecommerce360\Tiendas\Model\Store $model
    ) {
        parent::__construct($context);
        $this->modelStore = $model;
    }

    /**
     * Check if the user is allowed to access this controller
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Ecommerce360_Tiendas::manage_stores');
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('store_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->modelStore;
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('Store record deleted successfully.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        $this->messageManager->addError(__('Store record does not exist.'));
        return $resultRedirect->setPath('*/*/');
    }
}
