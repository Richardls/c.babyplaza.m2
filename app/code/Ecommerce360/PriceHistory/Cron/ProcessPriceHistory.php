<?php
namespace Ecommerce360\PriceHistory\Cron;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Stdlib\DateTime\DateTime;

class ProcessPriceHistory
{
    protected $resource;
    protected $dateTime;
    protected $logger;

    public function __construct(
        ResourceConnection $resource,
        DateTime $dateTime,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->resource = $resource;
        $this->dateTime = $dateTime;
        $this->logger = $logger;
    }

    public function execute()
    {
        try {
            $connection = $this->resource->getConnection();
            $currentDate = date('Y-m-d'); // Fecha actual para el historial

            // Subconsulta: Último link por SKU y tienda que esté en stock
            $subSelect = $connection->select()
                ->from(
                    ['l' => $this->resource->getTableName('ecommerce360_links')],
                    [
                        'sku',
                        'store_id',
                        'max_scraped' => new \Zend_Db_Expr('MAX(scraped_at)')
                    ]
                )
                ->where('in_stock = ?', 1)
                ->group(['sku', 'store_id']);

            // Unir la subconsulta con la tabla de links para obtener el registro completo
            $select = $connection->select()
                ->from(['l' => $this->resource->getTableName('ecommerce360_links')])
                ->join(
                    ['sub' => $subSelect],
                    'l.sku = sub.sku AND l.store_id = sub.store_id AND l.scraped_at = sub.max_scraped',
                    ['price', 'store_name', 'scraped_at']
                );
            
            $results = $connection->fetchAll($select);
            
            foreach ($results as $row) {
                $sku = $row['sku'];
                $storeId = $row['store_id'];
                $storeName = $row['store_name'];
                $price = $row['price'];
                
                // Verificar si ya existe un registro para este SKU, tienda y fecha
                $checkSelect = $connection->select()
                    ->from($this->resource->getTableName('ecommerce360_pricehistory'))
                    ->where('sku = ?', $sku)
                    ->where('store_id = ?', $storeId)
                    ->where('history_date = ?', $currentDate);
                    
                $exists = $connection->fetchOne($checkSelect);
                if (!$exists) {
                    $data = [
                        'sku'           => $sku,
                        'history_date'  => $currentDate,
                        'store_id'      => $storeId,
                        'store_name'    => $storeName,
                        'price'         => $price,
                        'created_at'    => date('Y-m-d H:i:s')
                    ];
                    $connection->insert($this->resource->getTableName('ecommerce360_pricehistory'), $data);
                }
            }
        } catch (\Exception $e) {
            $this->logger->error('Error procesando historial de precios: ' . $e->getMessage());
        }
        return $this;
    }
}
