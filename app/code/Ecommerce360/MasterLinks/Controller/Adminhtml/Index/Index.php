<?php
namespace Ecommerce360\MasterLinks\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{
    // Debe coincidir con tu resource de ACL (ver punto 3)
    const ADMIN_RESOURCE = 'Ecommerce360_MasterLinks::masterlinks_view';

    /**
     * Muestra la página principal del grid de MasterLinks
     */
    public function execute()
    {
        // Crear la página
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        // Ajustar el título
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Master Links'));

        // Si deseas que se resalte el menú
        $resultPage->setActiveMenu('Ecommerce360_MasterLinks::main_menu_masterlinks');

        return $resultPage;
    }
}
