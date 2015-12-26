<?php

$installer = $this;

$setup = new Mage_Eav_Model_Entity_Setup('customer_setup');

$installer->startSetup();

$setup->addAttribute('customer', 'customer_satisfaction_type', array(
        'type' => 'int',
        'input' => 'select',
        'source' => 'inventorycustomer/attribute_source_customer',
        'label' => 'Customer Type',
        'global' => 1,
        'visible' => 1,
        'required' => 0,
        'user_defined' => 1,
        'visible_on_front' => 1,
        'default' => '2'
));

Mage::getSingleton('eav/config')
        ->getAttribute('customer', 'customer_satisfaction_type')
        ->setData('used_in_forms', array(
                'customer_account_create', 'customer_account_edit', 'adminhtml_customer')
            )
        ->save();

$installer->endSetup();