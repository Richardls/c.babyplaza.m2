<?php
namespace Ecommerce360\MasterLinks\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * Instala el esquema (tabla) para el módulo MasterLinks.
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (!$setup->tableExists('ecommerce360_masterlinks')) {
            $table = $setup->getConnection()->newTable(
                $setup->getTable('ecommerce360_masterlinks')
            )
            ->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary'  => true
                ],
                'Primary Key'
            )
            ->addColumn(
                'magento_sku',
                Table::TYPE_TEXT,
                64,
                ['nullable' => true],
                'Magento SKU'
            )
            ->addColumn(
                'sku_store',
                Table::TYPE_TEXT,
                255,
                ['nullable' => true],
                'Store SKU'
            )
            ->addColumn(
                'link_url',
                Table::TYPE_TEXT,
                '64k',
                ['nullable' => true],
                'Product Link URL'
            )
            ->addColumn(
                'min_price',
                Table::TYPE_DECIMAL,
                '12,4',
                ['nullable' => true, 'default' => '0.0000'],
                'Minimum Price'
            )
            ->addColumn(
                'list_price',
                Table::TYPE_DECIMAL,
                '12,4',
                ['nullable' => true, 'default' => '0.0000'],
                'List Price'
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
                ['nullable' => true],
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
                'availability',
                Table::TYPE_SMALLINT,
                null,
                ['nullable' => true, 'default' => '0'],
                'Availability / In Stock'
            )
            ->addColumn(
                'image_url',
                Table::TYPE_TEXT,
                '64k',
                ['nullable' => true],
                'Image URL'
            )
            ->addColumn(
                'created_at',
                Table::TYPE_TIMESTAMP,
                null,
                [
                    'nullable' => true,
                    'default' => Table::TIMESTAMP_INIT
                ],
                'Created At'
            )
            ->addColumn(
                'used_in_product_links',
                Table::TYPE_SMALLINT,
                null,
                ['nullable' => false, 'default' => '0'],
                'Used in Product Links?'
            )
            ->addColumn(
                'used_in_price_history',
                Table::TYPE_SMALLINT,
                null,
                ['nullable' => false, 'default' => '0'],
                'Used in Price History?'
            )
            ->setComment('Master Links Table');

            $setup->getConnection()->createTable($table);
        }

        $setup->endSetup();
    }
}
