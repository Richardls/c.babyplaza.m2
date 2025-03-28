<?php
/**
 * Copyright © Emipro Technologies Pvt Ltd. All rights reserved.
 * @license http://shop.emiprotechnologies.com/license-agreement/
 */
namespace Ecommerce360\Tiendas\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Ecommerce360\Tiendas\Model\Store;
use Magento\Backend\Model\Session;

class Save extends \Magento\Backend\App\Action
{
    protected $Storemodel;
    protected $adminsession;

    public function __construct(
        Action\Context $context,
        Store $Storemodel,
        Session $adminsession
    ) {
        parent::__construct($context);
        $this->Storemodel = $Storemodel;
        $this->adminsession = $adminsession;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $store_id = $this->getRequest()->getParam('store_id');

            if ($store_id) {
                $this->Storemodel->load($store_id);
            }

            $this->Storemodel->setData($data);

            try {
                $this->Storemodel->save();
                $this->messageManager->addSuccess(__('The data has been saved.'));
                $this->adminsession->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    if ($this->getRequest()->getParam('back') == 'add') {
                        return $resultRedirect->setPath('*/*/add');
                    } else {
                        return $resultRedirect->setPath(
                            '*/*/edit',
                            [
                                'store_id' => $this->Storemodel->getStoreId(),
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
            return $resultRedirect->setPath('*/*/edit', ['store_id' => $this->getRequest()->getParam('store_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
