<?php
namespace Ecommerce360\SkuAssociation\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;

class Delete extends Action
{
    protected $modelSkuAssociation;

    /**
     * @param Action\Context $context
     * @param \Ecommerce360\SkuAssociation\Model\SkuAssociation $model
     */
    public function __construct(
        Action\Context $context,
        \Ecommerce360\SkuAssociation\Model\SkuAssociation $model
    ) {
        parent::__construct($context);
        $this->modelSkuAssociation = $model;
    }

    /**
     * Check if the user is allowed to access this controller
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Ecommerce360_SkuAssociation::manage_sku_associations');
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('sku_associated_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->modelSkuAssociation;
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('SKU association deleted successfully.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['sku_associated_id' => $id]);
            }
        }
        $this->messageManager->addError(__('SKU association does not exist.'));
        return $resultRedirect->setPath('*/*/');
    }
}
