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
class Magestore_Inventorycustomer_Block_Adminhtml_Returningcustomers_Averageratio extends Magestore_Inventorycustomer_Block_Adminhtml_Container {
    
    /**
     * prepare block's layout
     *
     * @return Magestore_Inventorycustomer_Block_Adminhtml_Returningcustomers_Averageratio
     */
    protected function _prepareLayout() {
        $this->setTemplate('inventorycustomer/returningcustomers/averageratio.phtml');
        return parent::_prepareLayout();
    }
    
    public function calculateAverageRatio() {
        return Mage::helper('inventorycustomer/returningcustomers')->getCustomerOrderAverageRatio($this->getRequestData());
    }

}