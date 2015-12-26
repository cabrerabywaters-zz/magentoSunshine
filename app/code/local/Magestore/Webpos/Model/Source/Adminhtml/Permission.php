<?php

class Magestore_Webpos_Model_Source_Adminhtml_Permission extends Varien_Object {

    const ALL_PERMISSION = 1;
    const CREATE_ORDER = 2;
    const VIEW_ORDER_THIS_USER = 3;
    const VIEW_ORDER_OTHER_STAFF = 4;
    const VIEW_ORDER_ALL_ORDER = 5;
    const MANAGE_ORDER_THIS_USER = 6;
    const MANAGE_ORDER_OTHER_STAFF = 7;
    const MANAGE_ORDER_ALL_ORDER = 8;


    static public function getOptionArray()
    {

        return array(
            '1'    => Mage::helper('webpos')->__('All Permissions'),
            '2'    => Mage::helper('webpos')->__('Create Orders'),
            '3'    => Mage::helper('webpos')->__('View orders created by this user'),
            '4'    => Mage::helper('webpos')->__('View orders created by other users'),
            '5'    => Mage::helper('webpos')->__('View all orders'),
            '6'    => Mage::helper('webpos')->__('Manage orders created by this user'),
            '7'    => Mage::helper('webpos')->__('Manage orders created by other users'),
            '8'    => Mage::helper('webpos')->__('Manage all orders')
        );
    }
    static public function toOptionArray() {
        $options = array(
            array('value' => '1', 'label' => Mage::helper('webpos')->__('All Permissions')),
            array('value' => '2', 'label' => Mage::helper('webpos')->__('Create Orders')),
            array('value' => '3', 'label' => Mage::helper('webpos')->__('View orders created by this user')),
            array('value' => '4', 'label' => Mage::helper('webpos')->__('View orders created by other users')),
            array('value' => '5', 'label' => Mage::helper('webpos')->__('View all orders')),
            array('value' => '6', 'label' => Mage::helper('webpos')->__('Manage orders created by this user')),
            array('value' => '7', 'label' => Mage::helper('webpos')->__('Manage orders created by other users')),
            array('value' => '8', 'label' => Mage::helper('webpos')->__('Manage all orders'))

        );
        return $options;
    }
    static public function getStoreValuesForForm() {
        $options = array(
            array('value' => '1', 'label' => Mage::helper('webpos')->__('All Permissions')),
            array('value'=>array(
                array('value' => '2', 'label' => Mage::helper('webpos')->__('Create Orders')),
            ),'label'=> Mage::helper('webpos')->__('Create Orders')),
            array('value'=>array(
                array('value' => '3', 'label' => Mage::helper('webpos')->__('Created by this user')),
                array('value' => '4', 'label' => Mage::helper('webpos')->__('Created by other staff')),
                array('value' => '5', 'label' => Mage::helper('webpos')->__('All orders')),
            ),'label'=> Mage::helper('webpos')->__('View Orders')),
            array('value'=>array(
                array('value' => '6', 'label' => Mage::helper('webpos')->__('Manage orders created by this user')),
                array('value' => '7', 'label' => Mage::helper('webpos')->__('Manage orders created by other users')),
                array('value' => '8', 'label' => Mage::helper('webpos')->__('Manage all orders')),
            ),'label'=> Mage::helper('webpos')->__('Manage Orders'))

        );
        return $options;
    }

}
