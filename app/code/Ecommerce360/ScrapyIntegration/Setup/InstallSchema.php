<?php

namespace Ecommerce360\ScrapyIntegration\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        // Crear la tabla ecommerce360_scrapyintegration
        if (!$setup->tableExists('ecommerce360_scrapyintegration')) {
            $table = $setup->getConnection()->newTable($setup->getTable('ecommerce360_scrapyintegration'))
                ->addColumn(
                    'link_id',
                    Table::TYPE_INTEGER,
                    10,
                    ['unsigned' => true, 'nullable' => false, 'identity' => true, 'primary' => true],
                    'Link ID'
                )
                ->addColumn(
                    'store_domain',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Store Domain'
                )
                ->addColumn(
                    'sku_store',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'SKU Store'
                )
                ->addColumn(
                    'store_productname',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Store Product Name'
                )
                ->addColumn(
                    'store_brand',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true],
                    'Store Brand'
                )
                ->addColumn(
                    'link_url',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Product Link URL'
                )
                ->addColumn(
                    'min_price',
                    Table::TYPE_DECIMAL,
                    '12,4',
                    ['nullable' => false, 'default' => '0.0000'],
                    'Minimum Price'
                )
                ->addColumn(
                    'list_price',
                    Table::TYPE_DECIMAL,
                    '12,4',
                    ['nullable' => false, 'default' => '0.0000'],
                    'List Price'
                )
                ->addColumn(
                    'sku_magento',
                    Table::TYPE_TEXT,
                    64,
                    ['nullable' => true, 'default' => null],
                    'Magento SKU Associated'
                )
                ->addColumn(
                    'in_stock',
                    Table::TYPE_SMALLINT,
                    1,
                    ['nullable' => false, 'default' => '1'],
                    'In Stock'
                )
                ->addColumn(
                    'status',
                    Table::TYPE_SMALLINT,
                    6,
                    ['nullable' => false, 'default' => '1'],
                    'Status (1 = Active, 0 = Inactive)'
                )
                ->addColumn(
                    'image_url_01',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true],
                    'Image URL 1'
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
                ->addIndex(
                    $setup->getIdxName('ecommerce360_scrapyintegration', ['store_productname'], \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT),
                    ['store_productname'],
                    ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT]
                )
                ->setComment('Scrapy Integration Table for Ecommerce360');
            
            $setup->getConnection()->createTable($table);
        }

        $setup->endSetup();
    }
}
