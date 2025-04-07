<?php
namespace Ecommerce360\PriceHistory\Controller\Ajax;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

class GetHistory extends Action
{
    protected $resultJsonFactory;
    protected $resource;
    
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        \Magento\Framework\App\ResourceConnection $resource
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->resource = $resource;
    }
    
    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        
        $sku = $this->getRequest()->getParam('sku');
        $months = (int) $this->getRequest()->getParam('months', 3);
        
        if(!$sku) {
            return $result->setData(['error' => 'SKU requerido']);
        }
        
        // Definir rango de fechas
        $endDate = date('Y-m-d');
        $startDate = date('Y-m-d', strtotime("-{$months} months"));
        
        $connection = $this->resource->getConnection();
        $table = $this->resource->getTableName('ecommerce360_pricehistory');
        
        // Obtener, por cada día, el precio mínimo para el SKU
        $select = $connection->select()
            ->from($table, [
                'history_date',
                'min_price' => new \Zend_Db_Expr('MIN(price)')
            ])
            ->where('sku = ?', $sku)
            ->where('history_date BETWEEN ? AND ?', $startDate, $endDate)
            ->group('history_date')
            ->order('history_date ASC');
        
        $data = $connection->fetchAll($select);
        
        // Para cada día, obtener el nombre de la tienda con el precio mínimo
        foreach ($data as &$entry) {
            $subSelect = $connection->select()
                ->from($table, ['store_name'])
                ->where('sku = ?', $sku)
                ->where('history_date = ?', $entry['history_date'])
                ->where('price = ?', $entry['min_price'])
                ->limit(1);
            $storeName = $connection->fetchOne($subSelect);
            $entry['store_name'] = $storeName;
        }
        
        return $result->setData($data);
    }
}
