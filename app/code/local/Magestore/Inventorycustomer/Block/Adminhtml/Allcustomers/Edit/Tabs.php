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
 * Inventory Customer Edit Tabs Block
 * 
 * @category    Magestore
 * @package     Magestore_Inventory
 * @author      Magestore Developer
 */
class Magestore_Inventorycustomer_Block_Adminhtml_Allcustomers_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    public function __construct() {
        parent::__construct();
        $this->setId('customer_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('inventorycustomer')->__('Customer Details'));
    }

    /**
     * prepare before render block to html
     *
     * @return Magestore_Inventorycustomer_Block_Adminhtml_Allcustomers_Edit_Tabs
     */
    protected function _beforeToHtml() {
        
        $this->addTab('overview_section', array(
            'label' => Mage::helper('inventorycustomer')->__('Overview'),
            'title' => Mage::helper('inventorycustomer')->__('Overview'),
            'content' => $this->getLayout()
                    ->createBlock('inventorycustomer/adminhtml_allcustomers_edit_tab_customerdetails')
                    ->toHtml(),
        ));
        
        $this->addTab('form_section', array(
            'label' => 'Additional Information',
            'title' => 'Additional Information',
            'content' => $this->getLayout()
                ->createBlock('inventorycustomer/adminhtml_allcustomers_edit_tab_form')
                ->toHtml()
        ));

        return parent::_beforeToHtml();
    }

}
