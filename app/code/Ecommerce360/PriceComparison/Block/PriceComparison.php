<?php
namespace Ecommerce360\PriceComparison\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\App\ResourceConnection;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\UrlInterface;

class PriceComparison extends Template
{
    /**
     * @var Registry
     */
    protected $_registry;

    /**
     * @var ResourceConnection
     */
    protected $resource;

    /**
     * @var \Magento\Framework\DB\Adapter\AdapterInterface
     */
    protected $connection;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    public function __construct(
        Context $context,
        Registry $registry, // Inyectamos el registry
        ResourceConnection $resource,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->_registry = $registry; // Asignamos el registry a la propiedad
        $this->resource = $resource;
        $this->connection = $resource->getConnection();
        $this->storeManager = $storeManager; // Asignamos el store manager a la propiedad
        parent::__construct($context, $data);
    }

    /**
     * Retorna la URL base de la carpeta pub/media/
     *
     * @return string
     */
    public function getMediaBaseUrl()
    {
        return $this->storeManager
            ->getStore()
            ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
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
