<?php
namespace Ecommerce360\SkuAssociation\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Ecommerce360\SkuAssociation\Model\SkuAssociation;
use Magento\Backend\Model\Session;

class Save extends \Magento\Backend\App\Action
{
    protected $skuAssociationModel;
    protected $adminsession;

    public function __construct(
        Action\Context $context,
        SkuAssociation $skuAssociationModel,
        Session $adminsession
    ) {
        parent::__construct($context);
        $this->skuAssociationModel = $skuAssociationModel;
        $this->adminsession = $adminsession;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $sku_associated_id = $this->getRequest()->getParam('sku_associated_id');

            // Cargar el modelo si el ID ya existe
            if ($sku_associated_id) {
                $this->skuAssociationModel->load($sku_associated_id);
            }

            // Verificar y asignar `sku_magento` si está presente en los datos
            if (isset($data['sku_magento']) && !empty($data['sku_magento'])) {
                $this->skuAssociationModel->setSkuMagento($data['sku_magento']);
            } else {
                $this->messageManager->addError(__('Magento SKU is required.'));
                return $resultRedirect->setPath('*/*/edit', ['sku_associated_id' => $sku_associated_id]);
            }

            $this->skuAssociationModel->setData($data);

            try {
                $this->skuAssociationModel->save();
                $this->messageManager->addSuccess(__('The SKU association has been saved.'));
                $this->adminsession->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    if ($this->getRequest()->getParam('back') == 'add') {
                        return $resultRedirect->setPath('*/*/add');
                    } else {
                        return $resultRedirect->setPath(
                            '*/*/edit',
                            [
                                'sku_associated_id' => $this->skuAssociationModel->getSkuAssociatedId(),
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
            return $resultRedirect->setPath('*/*/edit', ['sku_associated_id' => $sku_associated_id]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
