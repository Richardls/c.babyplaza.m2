<?php
namespace Ecommerce360\MasterLinks\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $resultPageFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        PageFactory $resultPageFactory = null
    ) {
        parent::__construct($context);
        // Si no se inyecta el PageFactory, se obtiene mediante el ObjectManager
        $this->resultPageFactory = $resultPageFactory ?: \Magento\Framework\App\ObjectManager::getInstance()->get(PageFactory::class);
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Master Links'));
        return $resultPage;
    }
}
