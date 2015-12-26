<?php

$installer = $this;

$installer->startSetup();

$installer->run("
    -- DROP TABLE IF EXISTS {$this->getTable('erp_inventory_customer_interaction')};
CREATE TABLE {$this->getTable('erp_inventory_customer_interaction')} (
  `customer_interaction_id` int(11) unsigned NOT NULL auto_increment,
  `customer_id` int(11) unsigned NOT NULL,
  `created_at` datetime NULL,
  `action` varchar(255) NOT NULL default '',
  `result` varchar(255) NOT NULL default '',
  PRIMARY KEY (`customer_interaction_id`),
  CONSTRAINT fk_InvetoryCustomerEnt FOREIGN KEY (`customer_id`) REFERENCES customer_entity(`entity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup();
