<?php
namespace Ecommerce360\Processing\Cron;

use Magento\Framework\App\ResourceConnection;
use Psr\Log\LoggerInterface;

class ProcessMasterLinks
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var \Magento\Framework\DB\Adapter\AdapterInterface
     */
    protected $connection;

    public function __construct(
        LoggerInterface $logger,
        ResourceConnection $resource
    ) {
        $this->logger = $logger;
        $this->connection = $resource->getConnection();
    }

    public function execute()
    {
        $this->logger->info('Processing MasterLinks CRON: Started.');
        
        try {
            // Nombres de las tablas
            $masterTable = $this->connection->getTableName('ecommerce360_masterlinks');
            $productsLinksTable = $this->connection->getTableName('ecommerce360_productslinks');

            // Seleccionar el link más reciente para cada combinación (sku_magento, store_domain)
            // Usamos un subquery para obtener el máximo created_at para cada grupo.
            $subQuery = $this->connection->select()
                ->from($masterTable, ['sku_magento', 'store_domain', 'latest_created' => new \Zend_Db_Expr('MAX(created_at)')])
                ->group(['sku_magento', 'store_domain']);

            $select = $this->connection->select()
                ->from(['m1' => $masterTable])
                ->joinInner(
                    ['m2' => $subQuery],
                    'm1.sku_magento = m2.sku_magento AND m1.store_domain = m2.store_domain AND m1.created_at = m2.latest_created',
                    []
                );

            $records = $this->connection->fetchAll($select);
            $this->logger->info('Processing MasterLinks CRON: Found ' . count($records) . ' groups.');

            foreach ($records as $record) {
                $magentoSku = $record['sku_magento'];
                $storeDomain = $record['store_domain'];

                // Verificar si ya existe un registro para este producto en ProductsLinks
                $existing = (int)$this->connection->fetchOne(
                    "SELECT COUNT(*) FROM {$productsLinksTable} WHERE sku_magento = ? AND store_domain = ?",
                    [$magentoSku, $storeDomain]
                );

                if ($existing > 0) {
                    // Si ya existe un registro, lo borramos para actualizarlo (o se podría actualizar)
                    $this->connection->delete(
                        $productsLinksTable,
                        ['sku_magento = ?' => $magentoSku, 'store_domain = ?' => $storeDomain]
                    );
                }

                // Insertar el link más reciente en ProductsLinks
                $data = [
                    'sku_magento'       => $magentoSku,
                    'sku_store'         => $record['sku_store'],
                    'link_url'          => $record['link_url'],
                    'min_price'         => $record['min_price'],
                    'list_price'        => $record['list_price'],
                    'store_domain'      => $storeDomain,
                    'store_productname' => $record['store_productname'],
                    'store_brand'       => $record['store_brand'],
                    'availability'      => $record['availability'], // Asegúrate de usar el campo correcto (puede ser in_stock)
                    'image_url'         => $record['image_url'],
                    'created_at'        => $record['created_at'],
                    'status'            => 1,
                ];

                $this->connection->insert($productsLinksTable, $data);
                $this->logger->info("Processing MasterLinks CRON: Inserted record for SKU '{$magentoSku}' and Store Domain '{$storeDomain}'.");

                // Marcar el registro en MasterLinks como usado en Product Links
                $this->connection->update(
                    $masterTable,
                    ['used_in_product_links' => 1],
                    ['entity_id = ?' => $record['entity_id']]
                );
            }
            
            $this->logger->info('Processing MasterLinks CRON: Finished.');
        } catch (\Exception $e) {
            $this->logger->error('Processing MasterLinks CRON ERROR: ' . $e->getMessage());
        }
        return $this;
    }
}
