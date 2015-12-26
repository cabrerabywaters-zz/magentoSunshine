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
 * @package     Magestore_Inventorycustomer
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */

/**
 * Inventoryreports Adminhtml Block
 * 
 * @category    Magestore
 * @package     Magestore_Inventorycustomer
 * @author      Magestore Developer
 */
class Magestore_Inventorycustomer_Block_Adminhtml_Customertypes_Customergrid_Notes extends Mage_Adminhtml_Block_Template {
    
    /**
     * Get title above textarea
     * 
     * @return string
     */
    public function getTitle() {
        return "Customer Notes";
    }

        /**
     * Get customer Id
     * 
     * @return int
     */
    public function getCustomerId() {
        return $this->getRequest()->getParam('id');
    }
    
    /**
     * Get customer
     * 
     * @return Mage_Catalog_Model_Customer
     */
    public function getCustomer() {
        if (!$this->hasData('customer')) {
            $customer = Mage::getModel('customer/customer')->load($this->getCustomerId());
            $this->setData('customer', $customer);
        }
        return $this->getData('customer');
    }
    
    /**
     * Get notes of customer
     * 
     * @return string
     */
    public function getCustomerNotes() {
        return $this->getCustomer()->getData('customer_notes');
    }

}