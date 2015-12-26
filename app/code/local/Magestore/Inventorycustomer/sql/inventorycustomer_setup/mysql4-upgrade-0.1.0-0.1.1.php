<?php

$installer = $this;

$installer->startSetup();

$installer->run("
    --
    ALTER TABLE {$this->getTable('sales_flat_order')}
    ADD COLUMN `served_by_staff` INT(10) UNSIGNED;
  
    ALTER TABLE {$this->getTable('sales_flat_order')}
    ADD FOREIGN KEY (served_by_staff) REFERENCES {$this->getTable('admin_user')}(user_id);
");
$installer->endSetup();