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
$installer = $this;

$installer->startSetup();

$installer->updateAttribute('catalog_product', 'created_by', 'is_visible', '1'); 
$installer->updateAttribute('catalog_product', 'created_by', 'source_model', 'aitpermissions/source_admins'); 
$installer->updateAttribute('catalog_product', 'created_by', 'frontend_label', 'Product owner'); 
$installer->updateAttribute('catalog_product', 'created_by', 'frontend_input', 'select'); 

$installer->endSetup();