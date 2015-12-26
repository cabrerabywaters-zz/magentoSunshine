<?php

$installer = $this;

$installer->startSetup();

$installer->run("
    --
    ALTER TABLE {$this->getTable('erp_inventory_customer_interaction')}
    ADD COLUMN `is_done` TINYINT(1) DEFAULT 0;
");
$installer->endSetup();