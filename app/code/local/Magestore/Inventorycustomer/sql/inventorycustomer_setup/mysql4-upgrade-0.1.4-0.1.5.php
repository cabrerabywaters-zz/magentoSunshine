<?php

$installer = $this;

$installer->startSetup();

$installer->run("
    --
    ALTER TABLE {$this->getTable('erp_inventory_customer_interaction')}
    ADD COLUMN `next_action` TEXT;
  
    ALTER TABLE {$this->getTable('erp_inventory_customer_interaction')}
    ADD COLUMN `remind_at` DATE;
");
$installer->endSetup();