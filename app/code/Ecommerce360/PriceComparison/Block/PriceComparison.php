<?php
namespace Ecommerce360\PriceComparison\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;

class PriceComparison extends Template
{
    /**
     * @var Registry
     */
    protected $_registry;

    protected $resource;
    protected $connection;

    public function __construct(
        Context $context,
        Registry $registry, // Inyectamos el registry
        \Magento\Framework\App\ResourceConnection $resource,
        array $data = []
    ) {
        $this->_registry = $registry; // Asignamos a la propiedad
        $this->resource = $resource;
        $this->connection = $resource->getConnection();
        parent::__construct($context, $data);
    }

    /**
     * Get price comparison data for the current product SKU.
     *
     * @return array
     */
	public function getComparisonData()
{
    // Obtener el producto actual desde el registry
    $product = $this->_registry->registry('current_product');
    if (!$product || !$product->getSku()) {
        return [];
    }
    // Definir la variable $skuMagento
    $skuMagento = $product->getSku();

    $tableName = $this->resource->getTableName('ecommerce360_productslinks');
    $select = $this->connection->select()
        ->from(['main_table' => $tableName])
        ->joinLeft(
            ['tienda' => $this->resource->getTableName('ecommerce360_tiendas')],
            'main_table.store_domain = tienda.store_url',
            [
                'store_id',
                'store_name',
                'store_url',
                'store_logo',
                'shipping_info',
                'payment_methods',
                'delivery_options',
                'rating',
                'rating_count',
                'store_description'
            ]
        )
        ->where('main_table.sku_magento = ?', $skuMagento)
        ->order('min_price ASC');

    return $this->connection->fetchAll($select);
}

}
