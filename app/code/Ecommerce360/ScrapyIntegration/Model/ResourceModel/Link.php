<?php
namespace Ecommerce360\ScrapyIntegration\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Link extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('ecommerce360_scrapyintegration', 'link_id'); // Cambiado a la nueva tabla
    }
}
