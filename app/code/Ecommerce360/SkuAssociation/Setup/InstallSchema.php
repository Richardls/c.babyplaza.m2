<?php

namespace Ecommerce360\SkuAssociation\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        // Crear la tabla ecommerce360_skuassociation
        if (!$setup->tableExists('ecommerce360_skuassociation')) {
            $table = $setup->getConnection()->newTable($setup->getTable('ecommerce360_skuassociation'))
                ->addColumn(
                    'sku_associated_id',
                    Table::TYPE_INTEGER,
                    10,
                    ['unsigned' => true, 'nullable' => false, 'identity' => true, 'primary' => true],
                    'SKU Association ID'
                )
                ->addColumn(
                    'sku_magento',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Magento SKU'
                )
                ->addColumn(
                    'sku_store',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'SKU Store'
                )
                ->addColumn(
                    'status',
                    Table::TYPE_SMALLINT,
                    6,
                    ['nullable' => false, 'default' => '1'],
                    'Status (1 = Active, 0 = Inactive)'
                )
                ->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                    'Created At'
                )
                ->addColumn(
                    'updated_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
                    'Last Updated Timestamp'
                )
                ->setComment('SKU Association Table for Ecommerce360');
            
            $setup->getConnection()->createTable($table);
        }

        $setup->endSetup();
    }
}
