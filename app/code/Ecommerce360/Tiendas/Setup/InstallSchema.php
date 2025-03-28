<?php

namespace Ecommerce360\Tiendas\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (!$setup->tableExists('ecommerce360_tiendas')) {
            $table = $setup->getConnection()->newTable($setup->getTable('ecommerce360_tiendas'))
                ->addColumn(
                    'store_id',
                    Table::TYPE_INTEGER,
                    10,
                    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                    'Store ID'
                )
                ->addColumn(
                    'store_name',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Store Name'
                )
                ->addColumn(
                    'store_url',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Store URL'
                )
                ->addColumn(
                    'store_logo',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true, 'default' => null],
                    'Store Logo'
                )
                ->addColumn(
                    'shipping_info',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true, 'default' => null],
                    'Shipping Information'
                )
                ->addColumn(
                    'payment_methods',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true, 'default' => null],
                    'Payment Methods'
                )
                ->addColumn(
                    'delivery_options',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true, 'default' => null],
                    'Delivery Options'
                )
                ->addColumn(
                    'rating',
                    Table::TYPE_DECIMAL,
                    '3,2',
                    ['nullable' => false, 'default' => '0.00'],
                    'Store Rating'
                )
                ->addColumn(
                    'rating_count',
                    Table::TYPE_INTEGER,
                    11,
                    ['nullable' => false, 'default' => '0'],
                    'Rating Count'
                )
                ->addColumn(
                    'store_description',
                    Table::TYPE_TEXT,
                    '64k',
                    ['nullable' => true, 'default' => null],
                    'Store Description'
                )
                ->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                    'Creation Time'
                )
                ->addColumn(
                    'updated_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
                    'Update Time'
                )
                ->addColumn(
                    'status',
                    Table::TYPE_SMALLINT,
                    6,
                    ['nullable' => true, 'default' => null],
                    'Status'
                )
                ->addIndex(
                    $setup->getIdxName(
                        'ecommerce360_tiendas',
                        ['store_name'],
                        \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
                    ),
                    ['store_name'],
                    ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT]
                )
                ->setComment('Stores Table');

            $setup->getConnection()->createTable($table);
        }

        $setup->endSetup();
    }
}
