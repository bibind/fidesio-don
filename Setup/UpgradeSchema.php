<?php

namespace Fidesio\Donation\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * Upgrades DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $quote = 'quote';
        $orderTable = 'sales_order';
        $invoice = 'sales_invoice';
        $orderGridTable = 'sales_order_grid';

        $setup->getConnection()
            ->addColumn(
                $setup->getTable($quote),
                'donation_amount',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'Montant de la donation'
                ]
            );
        //Order table
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($orderTable),
                'donation_amount',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'Montant de la donation'
                ]
            );

        //invoice table
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($invoice),
                'donation_amount',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'Montant de la donation'
                ]
            );
        //Order Grid table
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($orderGridTable),
                'donation_amount',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'Montant de la donation'
                ]
            );


        $setup->endSetup();
    }
}