<?php
namespace Ecommerce360\MasterLinks\Cron;

use Magento\Framework\App\ResourceConnection;
use Psr\Log\LoggerInterface;

class ProcessMasterLinks
{
    protected $resource;
    protected $logger;

    public function __construct(
        ResourceConnection $resource,
        LoggerInterface $logger
    ) {
        $this->resource = $resource;
        $this->logger = $logger;
    }

    public function execute()
    {
        $this->logger->info('MasterLinks CRON: Inicia procesamiento de registros.');
        try {
            $connection     = $this->resource->getConnection();
            $stagingTable   = $this->resource->getTableName('ecommerce360_scrapyintegration');
            $masterTable    = $this->resource->getTableName('ecommerce360_masterlinks');

            // Seleccionar registros en staging donde sku_magento no sea nulo ni vacío.
            $select = $connection->select()
                ->from($stagingTable)
                ->where('sku_magento IS NOT NULL')
                ->where("TRIM(sku_magento) <> ''");

            $records = $connection->fetchAll($select);

            foreach ($records as $record) {
                // Prepara los datos a insertar en MasterLinks.
                $data = [
                    'sku_magento'         => $record['sku_magento'],
                    'sku_store'           => $record['sku_store'],
                    'link_url'            => $record['link_url'],
                    'min_price'           => $record['min_price'],
                    'list_price'          => $record['list_price'],
                    'store_domain'        => $record['store_domain'],
                    'store_productname'   => $record['store_productname'],
                    'store_brand'         => $record['store_brand'],
                    'availability'        => $record['in_stock'], // Ajusta si es 'in_stock' o 'availability'
                    'image_url'           => $record['image_url_01'], // o el campo correspondiente
                    'created_at'          => $record['created_at'],
                    // Si utilizas los flags para saber si ya se usó en otros módulos, puedes dejarlos en 0
                    'used_in_product_links' => 0,
                    'used_in_price_history' => 0,
                ];

                // Aquí podrías implementar una lógica de upsert: 
                // Por simplicidad, se hace un insert.
                $connection->insert($masterTable, $data);

                // Una vez transferido, eliminamos el registro de staging.
                $connection->delete($stagingTable, ['link_id = ?' => $record['link_id']]);
            }

            $this->logger->info('MasterLinks CRON: Procesados ' . count($records) . ' registros.');
        } catch (\Exception $e) {
            $this->logger->error('MasterLinks CRON: Error - ' . $e->getMessage());
        }
        return $this;
    }
}
