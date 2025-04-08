<?php
namespace Ecommerce360\ScrapyIntegration\Cron;

use Magento\Framework\App\ResourceConnection;
use Psr\Log\LoggerInterface;
use Ecommerce360\SkuAssociation\Model\AssociationService;

class UpdateMagentoSku
{
    protected $resource;
    protected $logger;
    protected $associationService;

    public function __construct(
        ResourceConnection $resource,
        LoggerInterface $logger,
        AssociationService $associationService
    ) {
        $this->resource = $resource;
        $this->logger = $logger;
        $this->associationService = $associationService;
    }

    public function execute()
    {
        try {
            $connection = $this->resource->getConnection();
            $tableName = $this->resource->getTableName('ecommerce360_scrapyintegration');
            
            // Seleccionar los registros donde el campo magento_sku es nulo o vacío.
            $select = $connection->select()
                ->from($tableName)
                ->where('magento_sku IS NULL OR magento_sku = ""');
            
            $records = $connection->fetchAll($select);
            
            if (!empty($records)) {
                foreach ($records as $record) {
                    $skuStore = $record['sku_store'];
                    // Usa el servicio de SKU Association para obtener el SKU de Magento
                    $magentoSku = $this->associationService->getMagentoSkuByStoreSku($skuStore);
                    
                    if ($magentoSku) {
                        $connection->update(
                            $tableName,
                            ['magento_sku' => $magentoSku],
                            ['link_id = ?' => $record['link_id']]
                        );
                        $this->logger->info(sprintf(
                            'Updated link_id %s with Magento SKU %s for store SKU %s.',
                            $record['link_id'],
                            $magentoSku,
                            $skuStore
                        ));
                    }
                }
            }
        } catch (\Exception $e) {
            $this->logger->critical('Error updating Magento SKU in ScrapyIntegration: ' . $e->getMessage());
        }
        
        return $this;
    }
}
