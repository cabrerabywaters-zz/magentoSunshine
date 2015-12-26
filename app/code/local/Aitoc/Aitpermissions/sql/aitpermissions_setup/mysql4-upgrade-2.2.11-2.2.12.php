<?php
/**
 * Advanced Permissions
 *
 * @category:    Aitoc
 * @package:     Aitoc_Aitpermissions
 * @version      2.10.9
 * @license:     9DAcmpHmKm5MrRdfs5lugvpF2c0A7dPjtx5lj0JMEV
 * @copyright:   Copyright (c) 2015 AITOC, Inc. (http://www.aitoc.com)
 */
/**
* @copyright  Copyright (c) 2012 AITOC, Inc. 
*/

$installer = $this;

$installer->startSetup();

$installer->run($sql = '
ALTER TABLE `' . $this->getTable('aitoc_aitpermissions_advancedrole') . '` ADD COLUMN `can_edit_own_products_only` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1;
');

$catalogInstaller = Mage::getResourceModel('catalog/setup', 'catalog_setup');
$catalogInstaller->addAttribute('catalog_product', 'created_by', array(
    'type'     => 'int',
    'visible'  => false,
    'required' => false
));

$installer->endSetup();