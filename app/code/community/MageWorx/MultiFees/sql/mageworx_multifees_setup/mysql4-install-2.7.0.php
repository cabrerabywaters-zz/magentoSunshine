<?php
/**
 * MageWorx
 * Multi Fees Extension
 *
 * @category   MageWorx
 * @package    MageWorx_MultiFees
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

$installer = $this;
$installer->startSetup();

// 2.7.0 renaming tables
if ($installer->tableExists($this->getTable('multifees_fee')) && !$installer->tableExists($this->getTable('mageworx_multifees_fee'))) {
    $installer->run("RENAME TABLE {$this->getTable('multifees_fee')} TO {$this->getTable('mageworx_multifees_fee')};");
}
if ($installer->tableExists($this->getTable('multifees_fee_language')) && !$installer->tableExists($this->getTable('mageworx_multifees_fee_language'))) {
    $installer->run("RENAME TABLE {$this->getTable('multifees_fee_language')} TO {$this->getTable('mageworx_multifees_fee_language')};");
}
if ($installer->tableExists($this->getTable('multifees_fee_option')) && !$installer->tableExists($this->getTable('mageworx_multifees_fee_option'))) {
    $installer->run("RENAME TABLE {$this->getTable('multifees_fee_option')} TO {$this->getTable('mageworx_multifees_fee_option')};");
}
if ($installer->tableExists($this->getTable('multifees_fee_option_language')) && !$installer->tableExists($this->getTable('mageworx_multifees_fee_option_language'))) {
    $installer->run("RENAME TABLE {$this->getTable('multifees_fee_option_language')} TO {$this->getTable('mageworx_multifees_fee_option_language')};");
}
if ($installer->tableExists($this->getTable('multifees_fee_store')) && !$installer->tableExists($this->getTable('mageworx_multifees_fee_store'))) {
    $installer->run("RENAME TABLE {$this->getTable('multifees_fee_store')} TO {$this->getTable('mageworx_multifees_fee_store')};");
}

$pathLike = 'mageworx_sales/multifees/%';
$configCollection = Mage::getModel('core/config_data')->getCollection();
$configCollection->getSelect()->where('path like ?', $pathLike);

foreach ($configCollection as $conf) {
    $path = $conf->getPath();
    $path = str_replace('multifees', 'main', $path);
    $path = str_replace('mageworx_sales', 'mageworx_multifees', $path);
    $conf->setPath($path)->save();
}

$installer->run("
CREATE TABLE IF NOT EXISTS {$this->getTable('mageworx_multifees_fee')} (
  `fee_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-Cart Fee,2-Payment Fee,3-Shipping Fee',
  `input_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-Drop-Down,2-Radio Button,3-Checkbox,4-Hidden,5-Notice',
  `is_onetime` tinyint(1) NOT NULL DEFAULT '1',
  `required` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-No,1-Yes',
  `sort_order` smallint(6) unsigned DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0-Disabled,1-Active',
  `sales_methods` mediumtext NOT NULL,
  `customer_group_ids` varchar(255) NOT NULL,
  `applied_totals` varchar(255) NOT NULL DEFAULT 'subtotal',
  `tax_class_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '0-None,1-default',
  `conditions_serialized` mediumtext NOT NULL,
  `enable_customer_message` tinyint(1) NOT NULL DEFAULT '0',
  `enable_date_field` tinyint(1) NOT NULL DEFAULT '0',
  `total_ordered` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `total_base_amount` decimal(12,4) unsigned NOT NULL DEFAULT '0.0000',
  PRIMARY KEY (`fee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS {$this->getTable('mageworx_multifees_fee_language')} (
  `fee_lang_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fee_id` int(10) unsigned NOT NULL,
  `store_id` smallint(5) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `customer_message_title` varchar(255) NOT NULL,
  `date_field_title` varchar(255) NOT NULL,
  PRIMARY KEY (`fee_lang_id`),
  UNIQUE KEY `fee_id+store_id` (`fee_id`,`store_id`),
  CONSTRAINT `FK_MULTIFEES_FEE_LANGUAGE` FOREIGN KEY (`fee_id`) REFERENCES `{$this->getTable('mageworx_multifees_fee')}` (`fee_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$this->getTable('mageworx_multifees_fee_option')}` (
  `fee_option_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fee_id` int(10) unsigned NOT NULL,
  `price` decimal(12,4) DEFAULT NULL,
  `price_type` enum('fixed','percent') DEFAULT NULL,
  `is_default` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `position` smallint(6) unsigned DEFAULT NULL,
  PRIMARY KEY (`fee_option_id`),
  KEY `fee_id` (`fee_id`),
  CONSTRAINT `FK_MULTIFEES_FEE_OPTION` FOREIGN KEY (`fee_id`) REFERENCES `{$this->getTable('mageworx_multifees_fee')}` (`fee_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS {$this->getTable('mageworx_multifees_fee_option_language')} (
  `fee_option_lang_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fee_option_id` int(10) unsigned NOT NULL,
  `store_id` smallint(5) unsigned DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`fee_option_lang_id`),
  UNIQUE KEY `fee_option_id+store_id` (`fee_option_id`,`store_id`),
  CONSTRAINT `FK_MULTIFEES_FEE_OPTION_LANGUAGE` FOREIGN KEY (`fee_option_id`) REFERENCES `{$this->getTable('mageworx_multifees_fee_option')}` (`fee_option_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS {$this->getTable('mageworx_multifees_fee_store')} (
  `fee_store_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fee_id` int(10) unsigned NOT NULL,
  `store_id` smallint(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`fee_store_id`),
  UNIQUE KEY `fee_id+store_id` (`fee_id`,`store_id`),
  CONSTRAINT `FK_MULTIFEES_FEE_STORE` FOREIGN KEY (`fee_id`) REFERENCES `{$this->getTable('mageworx_multifees_fee')}` (`fee_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

// 1.9.9-2.0.0
if (!$installer->getConnection()->tableColumnExists($installer->getTable('mageworx_multifees_fee_language'), 'fee_lang_id')) {
    $installer->run("ALTER TABLE `{$this->getTable('mageworx_multifees_fee_language')}`
            DROP INDEX `mfl_fee_id`,
            DROP FOREIGN KEY `multifees_fee_language_fk`,
            CHANGE `mfl_id` `fee_lang_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
            CHANGE `mfl_fee_id` `fee_id` INT(10) UNSIGNED NOT NULL,
            CHANGE `title` `title` VARCHAR(255) NOT NULL,
            ADD `description` TEXT NOT NULL,
            ADD `customer_message_title` VARCHAR(255) NOT NULL,
            ADD `date_field_title` VARCHAR(255) NOT NULL;");
    $installer->getConnection()->addKey($installer->getTable('mageworx_multifees_fee_language'), 'fee_id+store_id', array('fee_id', 'store_id'), 'unique');
    $installer->getConnection()->addConstraint('FK_MULTIFEES_FEE_LANGUAGE', $installer->getTable('mageworx_multifees_fee_language'), 'fee_id', $installer->getTable('mageworx_multifees_fee'), 'fee_id', 'CASCADE', 'CASCADE', true);
}

// multifees_fee_store
if (!$installer->getConnection()->tableColumnExists($installer->getTable('mageworx_multifees_fee_store'), 'fee_store_id')) {
    $installer->run("ALTER TABLE `{$this->getTable('mageworx_multifees_fee_store')}`
            DROP INDEX `mfs_fee_id`,
            DROP FOREIGN KEY `multifees_fee_store_fk`,
            CHANGE `mfs_id` `fee_store_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
            CHANGE `mfs_fee_id` `fee_id` INT(10) UNSIGNED NOT NULL;");
    $installer->getConnection()->addKey($installer->getTable('mageworx_multifees_fee_store'), 'fee_id+store_id', array('fee_id', 'store_id'), 'unique');
    $installer->getConnection()->addConstraint('FK_MULTIFEES_FEE_STORE', $installer->getTable('mageworx_multifees_fee_store'), 'fee_id', $installer->getTable('mageworx_multifees_fee'), 'fee_id', 'CASCADE', 'CASCADE', true);
}

// multifees_fee_option
if (!$installer->getConnection()->tableColumnExists($installer->getTable('mageworx_multifees_fee_option'), 'fee_id')) {
    $installer->run("ALTER TABLE `{$this->getTable('mageworx_multifees_fee_option')}`         
            DROP INDEX `mfo_fee_id`,
            DROP FOREIGN KEY `multifees_fee_option_fk`,
            CHANGE `mfo_fee_id` `fee_id` INT(10) UNSIGNED NOT NULL,
            CHANGE `is_default` `is_default` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
            ADD INDEX (`fee_id`);");
    $installer->getConnection()->addConstraint('FK_MULTIFEES_FEE_OPTION', $installer->getTable('mageworx_multifees_fee_option'), 'fee_id', $installer->getTable('mageworx_multifees_fee'), 'fee_id', 'CASCADE', 'CASCADE', true);
}
// multifees_fee_option_language
if (!$installer->getConnection()->tableColumnExists($installer->getTable('mageworx_multifees_fee_option_language'), 'fee_option_lang_id')) {
    $installer->run("ALTER TABLE `{$this->getTable('mageworx_multifees_fee_option_language')}`
            CHANGE `mfol_id` `fee_option_lang_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            DROP FOREIGN KEY `multifees_fee_option_language_fk`,
            DROP INDEX `fee_option_id`;");
    $installer->getConnection()->addKey($installer->getTable('mageworx_multifees_fee_option_language'), 'fee_option_id+store_id', array('fee_option_id', 'store_id'), 'unique');
    $installer->getConnection()->addConstraint('FK_MULTIFEES_FEE_OPTION_LANGUAGE', $installer->getTable('mageworx_multifees_fee_option_language'), 'fee_option_id', $installer->getTable('mageworx_multifees_fee_option'), 'fee_option_id', 'CASCADE', 'CASCADE', true);
}

// multifees_fee
if ($installer->getConnection()->tableColumnExists($installer->getTable('mageworx_multifees_fee'), 'apply_to')) {
    $installer->run("ALTER TABLE `{$this->getTable('mageworx_multifees_fee')}` DROP `apply_to`;");
}
if ($installer->getConnection()->tableColumnExists($installer->getTable('mageworx_multifees_fee'), 'checkout_type')) {
    $installer->run("ALTER TABLE `{$this->getTable('mageworx_multifees_fee')}` DROP `checkout_type`;");
}
if ($installer->getConnection()->tableColumnExists($installer->getTable('mageworx_multifees_fee'), 'checkout_method')) {
    if (!$installer->getConnection()->tableColumnExists($installer->getTable('mageworx_multifees_fee'), 'sales_methods')) {
        $installer->run("ALTER TABLE `{$this->getTable('mageworx_multifees_fee')}` CHANGE `checkout_method` `sales_methods` VARCHAR(255) NOT NULL DEFAULT '';");
    } else {
        $installer->run("ALTER TABLE `{$this->getTable('mageworx_multifees_fee')}` DROP `checkout_method`;");
    }
}
if (!$installer->getConnection()->tableColumnExists($installer->getTable('mageworx_multifees_fee'), 'sales_methods')) {
    $installer->run("ALTER TABLE `{$this->getTable('mageworx_multifees_fee')}` ADD `sales_methods` VARCHAR(255) NOT NULL DEFAULT '' AFTER `status`;");
}
if (!$installer->getConnection()->tableColumnExists($installer->getTable('mageworx_multifees_fee'), 'type')) {
    $installer->run("
        ALTER TABLE `{$this->getTable('mageworx_multifees_fee')}` 
            ADD `type` TINYINT( 1 ) NOT NULL DEFAULT '1' COMMENT '1-Cart Fee,2-Payment Fee,3-Shipping Fee' AFTER `fee_id`, 
            CHANGE `input_type` `input_type` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '1-Drop-Down,2-Radio Button,3-Checkbox,4-Hidden,5-Notice',
            CHANGE `status` `status` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '0-Disabled,1-Active',
            CHANGE `required` `required` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0-No,1-Yes',                        
            ADD `customer_group_ids` VARCHAR(255) NOT NULL AFTER `sales_methods`,
            ADD `applied_totals` VARCHAR(255) NOT NULL DEFAULT 'subtotal',
            ADD `tax_class_id` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '0-None,1-default',
            ADD `conditions_serialized` MEDIUMTEXT NOT NULL,
            ADD `enable_customer_message` TINYINT(1) NOT NULL DEFAULT '0',
            ADD `enable_date_field` TINYINT(1) NOT NULL DEFAULT '0',
            ADD `total_ordered` MEDIUMINT UNSIGNED NOT NULL DEFAULT '0', 
            ADD `total_base_amount` decimal(12,4) UNSIGNED NOT NULL DEFAULT '0';
        
        UPDATE `{$this->getTable('mageworx_multifees_fee')}` SET `type` = 2, `input_type` = 3 WHERE `input_type` = 4;
        UPDATE `{$this->getTable('mageworx_multifees_fee')}` SET `type` = 3, `input_type` = 3 WHERE `input_type` = 5;
        UPDATE `{$this->getTable('mageworx_multifees_fee')}` SET `status` = 0 WHERE `status` = 2;
        UPDATE `{$this->getTable('mageworx_multifees_fee')}` SET `required` = 0 WHERE `required` = 2;
        
    ");
}

// sales/quote_address
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/quote_address'), 'base_multifees_amount')) {
    if ($installer->getConnection()->tableColumnExists($installer->getTable('sales/quote_address'), 'base_multifees')) {
        $installer->run("ALTER TABLE `{$this->getTable('sales/quote_address')}`
                CHANGE `multifees` `multifees_amount` DECIMAL( 12, 4 ) NOT NULL DEFAULT '0.0000',
                CHANGE `base_multifees` `base_multifees_amount` DECIMAL( 12, 4 ) NOT NULL DEFAULT '0.0000';
        ");
    } else {
        $installer->run("ALTER TABLE `{$this->getTable('sales/quote_address')}` 
            ADD `multifees_amount` DECIMAL( 12, 4 ) NOT NULL DEFAULT '0.0000',
            ADD `base_multifees_amount` DECIMAL( 12, 4 ) NOT NULL DEFAULT '0.0000',
            ADD `details_multifees` text NOT NULL;
        ");
    }
}
if ($installer->getConnection()->tableColumnExists($installer->getTable('sales/quote_address'), 'multifees')) {
    $installer->run("ALTER TABLE `{$this->getTable('sales/quote_address')}` DROP `multifees`;");
}
if ($installer->getConnection()->tableColumnExists($installer->getTable('sales/quote_address'), 'base_multifees')) {
    $installer->run("ALTER TABLE `{$this->getTable('sales/quote_address')}` DROP `base_multifees`;");
}
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/quote_address'), 'multifees_tax_amount')) {
    $installer->run("ALTER TABLE `{$installer->getTable('sales/quote_address')}` 
        ADD `multifees_tax_amount` DECIMAL(12, 4) NOT NULL DEFAULT '0' AFTER `base_multifees_amount` ,
        ADD `base_multifees_tax_amount` DECIMAL(12, 4) NOT NULL DEFAULT '0' AFTER `multifees_tax_amount`;");
}


// sales/order
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order'), 'multifees_amount')) {
    if ($installer->getConnection()->tableColumnExists($installer->getTable('sales/order'), 'base_multifees_amount')) {
        $installer->run("ALTER TABLE `{$installer->getTable('sales/order')}` DROP  `base_multifees_amount`;");
    }

    if ($installer->getConnection()->tableColumnExists($installer->getTable('sales/order'), 'multifees')) {
        $installer->run("ALTER TABLE `{$installer->getTable('sales/order')}` 
            CHANGE `multifees` `multifees_amount` DECIMAL( 12, 4 ) NOT NULL DEFAULT '0.0000',
            CHANGE `base_multifees` `base_multifees_amount` DECIMAL( 12, 4 ) NOT NULL DEFAULT '0.0000';");
    } else {
        $installer->run("ALTER TABLE `{$this->getTable('sales/order')}` 
            ADD `multifees_amount` DECIMAL(12, 4) NOT NULL DEFAULT '0.0000',
            ADD `base_multifees_amount` DECIMAL(12, 4) NOT NULL DEFAULT '0.0000',
            ADD `details_multifees` text NOT NULL;");
    }
}
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order'), 'multifees_tax_amount')) {
    $installer->run("ALTER TABLE `{$installer->getTable('sales/order')}` 
        ADD `multifees_tax_amount` DECIMAL(12, 4) NOT NULL DEFAULT '0' AFTER `base_multifees_amount` ,
        ADD `base_multifees_tax_amount` DECIMAL(12, 4) NOT NULL DEFAULT '0' AFTER `multifees_tax_amount`;");
}
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order'), 'multifees_invoiced')) {
    $installer->run("ALTER TABLE `{$installer->getTable('sales/order')}` 
        ADD `multifees_invoiced` DECIMAL(12, 4) NOT NULL DEFAULT '0' AFTER `details_multifees`,
        ADD `base_multifees_invoiced` DECIMAL(12, 4) NOT NULL DEFAULT '0' AFTER `multifees_invoiced`,
        ADD `multifees_refunded` DECIMAL(12, 4) NOT NULL DEFAULT '0' AFTER `base_multifees_invoiced`,
        ADD `base_multifees_refunded` DECIMAL(12, 4) NOT NULL DEFAULT '0' AFTER `multifees_refunded`,
        ADD `multifees_canceled` DECIMAL(12, 4) NOT NULL DEFAULT '0' AFTER `base_multifees_refunded`,
        ADD `base_multifees_canceled` DECIMAL(12, 4) NOT NULL DEFAULT '0' AFTER `multifees_canceled`;");
}

// sales/invoice
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/invoice'), 'multifees_amount')) {
    if ($installer->getConnection()->tableColumnExists($installer->getTable('sales/invoice'), 'multifees')) {
        $installer->run("ALTER TABLE `{$installer->getTable('sales/invoice')}` 
            CHANGE `multifees` `multifees_amount` DECIMAL( 12, 4 ) NOT NULL DEFAULT '0.0000',
            CHANGE `base_multifees` `base_multifees_amount` DECIMAL( 12, 4 ) NOT NULL DEFAULT '0.0000';");
    } else {
        $installer->run("ALTER TABLE `{$this->getTable('sales/invoice')}` 
            ADD `multifees_amount` DECIMAL(12, 4) NOT NULL DEFAULT '0.0000',
            ADD `base_multifees_amount` DECIMAL(12, 4) NOT NULL DEFAULT '0.0000',
            ADD `details_multifees` text NOT NULL;");
    }
}
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/invoice'), 'multifees_tax_amount')) {
    $installer->run("ALTER TABLE `{$installer->getTable('sales/invoice')}` 
        ADD `multifees_tax_amount` DECIMAL(12, 4) NOT NULL DEFAULT '0' AFTER `base_multifees_amount` ,
        ADD `base_multifees_tax_amount` DECIMAL(12, 4) NOT NULL DEFAULT '0' AFTER `multifees_tax_amount`;");
}

// sales/creditmemo
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/creditmemo'), 'multifees_amount')) {
    if ($installer->getConnection()->tableColumnExists($installer->getTable('sales/creditmemo'), 'multifees')) {
        $installer->run("ALTER TABLE `{$installer->getTable('sales/creditmemo')}` 
            CHANGE `multifees` `multifees_amount` DECIMAL( 12, 4 ) NOT NULL DEFAULT '0.0000',
            CHANGE `base_multifees` `base_multifees_amount` DECIMAL( 12, 4 ) NOT NULL DEFAULT '0.0000';");
    } else {
        $installer->run("ALTER TABLE `{$this->getTable('sales/creditmemo')}` 
            ADD `multifees_amount` DECIMAL(12, 4) NOT NULL DEFAULT '0.0000',
            ADD `base_multifees_amount` DECIMAL(12, 4) NOT NULL DEFAULT '0.0000',
            ADD `details_multifees` text NOT NULL;");
    }
}
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/creditmemo'), 'multifees_tax_amount')) {
    $installer->run("ALTER TABLE `{$installer->getTable('sales/creditmemo')}` 
        ADD `multifees_tax_amount` DECIMAL(12, 4) NOT NULL DEFAULT '0' AFTER `base_multifees_amount` ,
        ADD `base_multifees_tax_amount` DECIMAL(12, 4) NOT NULL DEFAULT '0' AFTER `multifees_tax_amount`;");
}

// uninstall old attribute
$installer->run("DELETE FROM `{$installer->getTable('eav_attribute')}` WHERE `attribute_code` = 'additional_fees';");

// 2.0.0-2.1.0
if (!$installer->getConnection()->tableColumnExists($installer->getTable('mageworx_multifees_fee'), 'is_onetime')) {
    $installer->getConnection()->addColumn(
        $installer->getTable('mageworx_multifees_fee'),
        'is_onetime',
        "TINYINT(1) NOT NULL DEFAULT '1' AFTER `input_type`"
    );
}

// 2.3.0-2.3.1
$installer->run("ALTER TABLE `{$installer->getTable('mageworx_multifees_fee')}` CHANGE `sales_methods` `sales_methods` MEDIUMTEXT NOT NULL DEFAULT ''");

// 2.7.0
function recursiveArrayReplace($find, $replace, $array) {
    if (!is_array($array)) {
        return str_replace($find, $replace, $array);
    }
    $newArray = array();
    foreach ($array as $key => $value) {
        $newArray[$key] = recursiveArrayReplace($find, $replace, $value);
    }
    return $newArray;
}

if ($installer->getConnection()->tableColumnExists($installer->getTable('mageworx_multifees_fee'), 'conditions_serialized')) {
    $query = $installer->getConnection()->select()->from($installer->getTable('mageworx_multifees_fee'));
    $fees = $installer->getConnection()->fetchAll($query);
    foreach ($fees as $fee) {
        $conditions = unserialize($fee['conditions_serialized']);
        if ($conditions) {
            $conditions = recursiveArrayReplace('"multifees/fee', '"mageworx_multifees/fee', $conditions);
            $installer->getConnection()->update(
                $installer->getTable('mageworx_multifees_fee'),
                array('conditions_serialized' => serialize($conditions)),
                'fee_id = '.$fee['fee_id']
            );
        }
    }
    
}

$installer->endSetup();