<?php

$installer = $this;

$setup = new Mage_Eav_Model_Entity_Setup('customer_setup');

$installer->startSetup();

$setup->addAttribute('customer', 'number_of_orders', array(
        'type' => 'int',
        'input' => 'text',
        'label' => 'Number of Orders',
        'global' => 1,
        'visible' => 1,
        'required' => 0,
        'user_defined' => 1,
        'visible_on_front' => 1,
        'default' => '0'
));

Mage::getSingleton('eav/config')
        ->getAttribute('customer', 'number_of_orders')
        ->setData('used_in_forms', array('adminhtml_customer'))
        ->save();

$installer->endSetup();