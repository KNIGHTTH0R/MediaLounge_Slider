<?php

namespace MediaLounge\Slider\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        /**
         * Create table medialounge_slider_banner
         */
        if (!$installer->tableExists('medialounge_slider_banner')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('medialounge_slider_banner')
            )
                ->addColumn(
                    'banner_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary' => true,
                        'unsigned' => true,
                    ],
                    'Banner ID'
                )
                ->addColumn(
                    'name',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Banner Name'
                )
                ->addColumn(
                    'content',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    null,
                    ['nullable' => false],
                    'Banner Content'
                )
                ->addColumn(
                    'created_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => true],
                    'Banner Created At'
                )
                ->addColumn(
                    'updated_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => true],
                    'Banner Updated At'
                )
                ->setComment('Banner Table');
            $installer->getConnection()->createTable($table);
        }

        /**
         * Create table medialounge_slider_slider
         */
        if (!$installer->tableExists('medialounge_slider_slider')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('medialounge_slider_slider')
            )
                ->addColumn(
                    'slider_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary' => true,
                        'unsigned' => true,
                    ],
                    'Slider ID'
                )
                ->addColumn(
                    'name',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Slider Name'
                )
                ->addColumn(
                    'store_ids',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    ['nullable' => false, 'default' => '0'],
                    'Slider Stores'
                )
                ->addColumn(
                    'animation_type',
                    \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    2,
                    [],
                    'Slider Animation Type'
                )
                ->addColumn(
                    'speed',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    10,
                    [],
                    'Slider Speed of animation'
                )
                ->addColumn(
                    'fade',
                    \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    1,
                    [],
                    'Slider Fade'
                )
                ->addColumn(
                    'pause_on_hover',
                    \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    1,
                    [],
                    'Slider Pause On Hover'
                )
                ->addColumn(
                    'status',
                    \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    1,
                    [],
                    'Slider Status'
                )
                ->addColumn(
                    'created_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => true],
                    'Slider Created At'
                )
                ->addColumn(
                    'updated_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => true],
                    'Slider Updated At'
                )
                ->setComment('Slider Table');
            $installer->getConnection()->createTable($table);
        }

        /**
         * Create table medialounge_slider_banner_slider
         */
        if (!$installer->tableExists('medialounge_slider_banner_slider')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('medialounge_slider_banner_slider'));
            $table->addColumn(
                'slider_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true,
                ],
                'Slider ID'
            )
                ->addColumn(
                    'banner_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true,
                    ],
                    'Banner ID'
                )
                ->addColumn(
                    'position',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'nullable' => false,
                        'default' => '0'
                    ],
                    'Position'
                )
                ->addIndex(
                    $installer->getIdxName('medialounge_slider_banner_slider', ['slider_id']),
                    ['slider_id']
                )
                ->addIndex(
                    $installer->getIdxName('medialounge_slider_banner_slider', ['banner_id']),
                    ['banner_id']
                )
                ->addForeignKey(
                    $installer->getFkName(
                        'medialounge_slider_banner_slider',
                        'slider_id',
                        'medialounge_slider_slider',
                        'slider_id'
                    ),
                    'slider_id',
                    $installer->getTable('medialounge_slider_slider'),
                    'slider_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE,
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )
                ->addForeignKey(
                    $installer->getFkName(
                        'medialounge_slider_banner_slider',
                        'banner_id',
                        'medialounge_slider_banner',
                        'banner_id'
                    ),
                    'banner_id',
                    $installer->getTable('medialounge_slider_banner'),
                    'banner_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE,
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )
                ->addIndex(
                    $installer->getIdxName(
                        'medialounge_slider_banner_slider',
                        [
                            'slider_id',
                            'banner_id'
                        ],
                        \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                    ),
                    [
                        'slider_id',
                        'banner_id'
                    ],
                    [
                        'type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                    ]
                )
                ->setComment('Slider To Banner Link Table');
            $installer->getConnection()->createTable($table);
        }

        $installer->endSetup();
    }
}
