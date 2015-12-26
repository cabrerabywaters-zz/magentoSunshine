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
 * @package     Magestore_Inventorysupplyneeds
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
class Magestore_Inventorycustomer_Block_Adminhtml_Allcustomers_Header extends Mage_Adminhtml_Block_Template {
    
    /**
     * prepare block's layout
     *
     * @return Magestore_Inventoryreports_Block_Inventoryreports
     */
    protected function _prepareLayout() {
        $this->setTemplate('inventorycustomer/allcustomers/header.phtml');
        return parent::_prepareLayout();
    }
    
    protected function getTotalCustomers() {
        return Mage::helper('inventorycustomer/allcustomers')->getCustomersHaveCompleteOrder()->getSize();
    }
}