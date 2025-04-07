<?php
namespace Ecommerce360\ScrapyIntegration\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * Upgrade the schema for the module.
     *
     * @param SchemaSetupInterface   $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        // Verificar si la versión del módulo es menor a 1.0.1
        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            $connection = $setup->getConnection();
            $tableName = $setup->getTable('ecommerce360_scrapyintegration');

            if ($connection->isTableExists($tableName)) {
                // Agregar la columna 'magento_sku'
                $connection->addColumn(
                    $tableName,
                    'magento_sku',
                    [
                        'type' => Table::TYPE_TEXT,
                        'length' => 64,
                        'nullable' => true,
                        'default' => null,
                        'comment' => 'Magento SKU Associated'
                    ]
                );
            }
        }

        $setup->endSetup();
    }
}
