<?php

$installer = $this;

$installer->startSetup();

$installer->run("
    --
  ALTER TABLE {$this->getTable('sales_flat_order')}
  ADD COLUMN `warranty_date` DATE,
  ADD COLUMN `warranty_result` TEXT;
");
$installer->endSetup();