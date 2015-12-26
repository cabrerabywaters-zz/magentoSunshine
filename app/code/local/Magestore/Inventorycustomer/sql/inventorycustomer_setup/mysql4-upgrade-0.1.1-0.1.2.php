<?php

$installer = $this;

$setup = new Mage_Eav_Model_Entity_Setup('customer_setup');

$installer->startSetup();

$setup->addAttribute('customer', 'customer_notes', array(
        'type' => 'text',
        'input' => 'textarea',
        'label' => 'Notes',
        'global' => 1,
        'visible' => 1,
        'required' => 0,
        'user_defined' => 1,
        'visible_on_front' => 1
));

Mage::getSingleton('eav/config')
        ->getAttribute('customer', 'customer_notes')
        ->setData('used_in_forms', array('adminhtml_customer')
            )
        ->save();

$installer->endSetup();