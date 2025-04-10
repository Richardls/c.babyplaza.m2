<?php

namespace Ecommerce360\Links\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        // Crear la tabla ecommerce360_productslinks
        if (!$setup->tableExists('ecommerce360_productslinks')) {
            $table = $setup->getConnection()->newTable($setup->getTable('ecommerce360_productslinks'))
                ->addColumn(
                    'link_id',
                    Table::TYPE_INTEGER,
                    10,
                    ['unsigned' => true, 'nullable' => false, 'identity' => true, 'primary' => true],
                    'Link ID'
                )

                ->addColumn(
                    'sku_magento',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true],
                    'Magento SKU'
                )
                
                ->addColumn(
                    'sku_store',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true],
                    'sku_store'
                )

                ->addColumn(
                    'store_domain',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true],
                    'Store Domain'
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
                    'store_brand'
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
                    'availability',
                    Table::TYPE_SMALLINT,
                    1,
                    ['nullable' => false, 'default' => '1'],
                    'Availability'
                )
                ->addColumn(
                    'list_price',
                    Table::TYPE_DECIMAL,
                    '12,4',
                    ['nullable' => false, 'default' => '0.0000'],
                    'List Price'
                )

                ->addColumn(
                    'image_url',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true],
                    'Product Image URL'
                )

                ->addColumn(
                    'is_discounted',
                    Table::TYPE_SMALLINT,
                    1,
                    ['nullable' => false, 'default' => '0'],
                    'Is Discounted'
                )
                ->addColumn(
                    'discount_percentage',
                    Table::TYPE_INTEGER,
                    11,
                    ['nullable' => false, 'default' => '0'],
                    'Discount Percentage'
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
                ->addIndex(
                    $setup->getIdxName('ecommerce360_productslinks', ['store_productname'], \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT),
                    ['store_productname'],
                    ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT]
                )
                ->setComment('Products Links Table for Ecommerce360');
            
            $setup->getConnection()->createTable($table);
        }

        $setup->endSetup();
    }
}
