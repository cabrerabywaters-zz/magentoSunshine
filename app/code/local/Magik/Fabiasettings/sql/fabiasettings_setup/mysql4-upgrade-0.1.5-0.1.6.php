<?php


$installer = $this;
$installer->startSetup();

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');


$setup->addAttribute('catalog_category', 'fabia_custom_cat_desc5', array(
        'group'                         => 'Fabia Menu Settings',
        'label'                         => 'Custom Category Description For Version 5',
        'note'                          => 'All fields will be showed for only top-level categories and mega menu type. This settings will be available only for version 5.',
        'type'                          => 'text',
        'input'                         => 'textarea',
        'visible'                       => true,
        'required'                      => false,
        'backend'                       => '',
        'frontend'                      => '',
        'searchable'                    => false,
        'filterable'                    => false,
        'comparable'                    => false,
        'user_defined'                  => true,
        'visible_on_front'              => true,
        'wysiwyg_enabled'               => true,
        'is_html_allowed_on_front'      => true,
        'global'                        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
));



$installer->endSetup();