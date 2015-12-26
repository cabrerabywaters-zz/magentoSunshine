<?php

/**
 * Magestore
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the Magestore.com license that is
 * available through the world-wide-web at this URL:
 * http://www.magestore.com/license-agreement.html
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category    Magestore
 * @package     Magestore_Inventory
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */

/**
 * Inventory Supplier Edit Block
 * 
 * @category     Magestore
 * @package     Magestore_Inventory
 * @author      Magestore Developer
 */
class Magestore_Inventorycustomer_Block_Adminhtml_Allcustomers_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

    public function __construct() {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'inventorycustomer';
        $this->_controller = 'adminhtml_allcustomers';
        
        $this->removeButton('delete');
        $this->_addButton('edit_customer', array(
            'label' => Mage::helper('inventorycustomer')->__('Edit Customer'),
            'onclick' => 'setLocation(\'' . $this->getUrl('adminhtml/customer/edit', array('_current' => true, 'id' => $this->getRequest()->getParam('id'))) . '\')',
                ), -100);
    }

    /**

     * get text to show in header when edit an item
     *
     * @return string
     */
    public function getHeaderText() {
        if (Mage::registry('inventorycustomer_customer_data') && Mage::registry('inventorycustomer_customer_data')->getId()
        ) {
            return Mage::helper('inventorycustomer')->__("%s", $this->htmlEscape(Mage::registry('inventorycustomer_customer_data')->getName())
            );
        }
        return Mage::helper('inventorycustomer')->__('New Customer');
    }

}
