<?php


$installer = $this;
$installer->startSetup();

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');


$setup->addAttribute('catalog_category', 'fabia_custom_image', array(
    'group'              => 'Fabia Menu Settings',
    'type'               => 'varchar',
    'input'              => 'image',
    'backend'            => 'catalog/category_attribute_backend_image',  
    'label'              => 'Custom Category Image',
    'note'               => 'This settings will be available only for version 6.',
    'visible'            => 1,
    'required'           => 0,
    'user_defined'       => 1,
    'frontend_input'     =>'',
    'global'             => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible_on_front'   => 1,
));



$installer->endSetup();