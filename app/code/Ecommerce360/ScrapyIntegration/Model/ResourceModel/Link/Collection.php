<?php
namespace Ecommerce360\ScrapyIntegration\Model\ResourceModel\Link;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Ecommerce360\ScrapyIntegration\Model\Link as LinkModel;
use Ecommerce360\ScrapyIntegration\Model\ResourceModel\Link as LinkResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            LinkModel::class,
            LinkResourceModel::class
        );
    }
}
