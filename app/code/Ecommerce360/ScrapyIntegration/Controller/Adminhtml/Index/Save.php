<?php
namespace Ecommerce360\ScrapyIntegration\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Ecommerce360\ScrapyIntegration\Model\Link;
use Magento\Backend\Model\Session;

class Save extends \Magento\Backend\App\Action
{
    protected $linkModel;
    protected $adminsession;

    public function __construct(
        Action\Context $context,
        Link $linkModel,
        Session $adminsession
    ) {
        parent::__construct($context);
        $this->linkModel = $linkModel;
        $this->adminsession = $adminsession;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $link_id = $this->getRequest()->getParam('link_id');

            // Cargar el modelo si el ID ya existe
            if ($link_id) {
                $this->linkModel->load($link_id);
            }

            $this->linkModel->setData($data);

            try {
                $this->linkModel->save();
                $this->messageManager->addSuccess(__('The Scrapy Integration link has been saved.'));
                $this->adminsession->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    if ($this->getRequest()->getParam('back') == 'add') {
                        return $resultRedirect->setPath('*/*/add');
                    } else {
                        return $resultRedirect->setPath(
                            '*/*/edit',
                            [
                                'link_id' => $this->linkModel->getLinkId(),
                                '_current' => true
                            ]
                        );
                    }
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the data.'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['link_id' => $link_id]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
