<?php

namespace Ecommerce360\Processing\Cron;

use Psr\Log\LoggerInterface;
use Magento\Framework\App\ResourceConnection;

class ProcessUrls
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var \Magento\Framework\DB\Adapter\AdapterInterface
     */
    private $connection;

    /**
     * Constructor
     *
     * @param LoggerInterface $logger
     * @param ResourceConnection $resource
     */
    public function __construct(LoggerInterface $logger, ResourceConnection $resource)
    {
        $this->logger = $logger;
        $this->connection = $resource->getConnection();
    }

    /**
     * Execute the cron job
     */
    public function execute()
    {
        $this->logger->info('Ecommerce360 Processing: Cron job started.');

        try {
            // Paso 1: Nombres de las tablas
            $scrapyTable = $this->connection->getTableName('ecommerce360_scrapyintegration');
            $skuAssocTable = $this->connection->getTableName('ecommerce360_skuassociation');
            $productsLinksTable = $this->connection->getTableName('ecommerce360_productslinks');
            $pendingUrlsTable = $this->connection->getTableName('ecommerce360_pending_urls');

            // Paso 2: Consultar URLs desde ScrapyIntegration
            $urls = $this->connection->fetchAll("SELECT * FROM $scrapyTable");

            foreach ($urls as $url) {
                $skuStore = $url['sku_store'];
            
                // Paso 3: Buscar coincidencias en SkuAssociation
                $skuMagento = $this->connection->fetchOne(
                    "SELECT sku_magento FROM $skuAssocTable WHERE sku_store = ?",
                    [$skuStore]
                );
            
                if ($skuMagento) {
                    // Paso 4: Mover a ProductsLinks si hay coincidencia
                    $this->connection->insert($productsLinksTable, [
                        'sku_magento' => $skuMagento,
                        'sku_store' => $url['sku_store'],
                        'link_url' => $url['link_url'],
                        'min_price' => $url['min_price'],
                        'list_price' => $url['list_price'],
                        'store_domain' => $url['store_domain'],
                        'store_productname' => $url['store_productname'],
                        'brand' => $url['store_brand'],
                        'availability' => $url['in_stock'],
                        'image_url' => $url['image_url_01'],
                        'status' => 1,
                        'created_at' => (new \DateTime())->format('Y-m-d H:i:s'),
                    ]);
                } else {
                    // Paso 5: Mover a PendingUrls si no hay coincidencia
                    $this->connection->insert($pendingUrlsTable, [
                        'sku_store' => $skuStore,
                        'link_url' => $url['link_url'],
                        'min_price' => $url['min_price'],
                        'list_price' => $url['list_price'],
                        'store_domain' => $url['store_domain'],
                        'store_productname' => $url['store_productname'],
                        'store_brand' => $url['store_brand'],
                        'in_stock' => $url['in_stock'],
                        'status' => $url['status'],
                        'image_url_01' => $url['image_url_01'],
                        'image_url_02' => $url['image_url_02'],
                        'created_at' => (new \DateTime())->format('Y-m-d H:i:s'),
                    ]);
                }
            
                // Paso 6: Eliminar el registro de ScrapyIntegration después de procesarlo
                $this->connection->delete($scrapyTable, ['link_id = ?' => $url['link_id']]);
            }
            

            $this->logger->info('Ecommerce360 Processing: Cron job finished.');
        } catch (\Exception $e) {
            $this->logger->error('Ecommerce360 Processing: ' . $e->getMessage());
        }
    }
}
