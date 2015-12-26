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
 * Inventory Customer
 * 
 * @category    Magestore
 * @package     Magestore_Inventory
 * @author      Magestore Developer
 */
class Magestore_Inventorycustomer_Block_Adminhtml_Allcustomers_Edit_Tab_Customerdetails_Interactionhistory extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('interactionhistoryGrid');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareLayout() {
        return parent::_prepareLayout();
    }

    protected function _prepareCollection() {
        $interactionHistoryCollection = Mage::getModel('inventorycustomer/customerinteraction')->getCollection()
                ->addFieldToFilter('customer_id', $this->getRequest()->getParam("id"));
        $this->setCollection($interactionHistoryCollection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        
        $this->addColumn('created_at', array(
            'header' => Mage::helper('inventorycustomer')->__('Date'),
            'align' => 'left',
            'index' => 'created_at',
            'width' => '100px',
            'type' => 'date',
            'format' => 'd/M/Y',
        ));

        $this->addColumn('action', array(
            'header' => Mage::helper('inventorycustomer')->__('Action'),
            'align' => 'left',
            'index' => 'action',
            'type' => 'options',
            'options' => Mage::getSingleton('inventorycustomer/system_config_source_action')->getOptionArray(),
        ));

        $this->addColumn('result', array(
            'header' => Mage::helper('inventorycustomer')->__('Result'),
            'align' => 'left',
            'index' => 'result',
            'type' => 'options',
            'options' => Mage::getSingleton('inventorycustomer/system_config_source_result')->getOptionArray(),
        ));
        
        $this->addColumn('next_action', array(
            'header' => Mage::helper('inventorycustomer')->__('Next Action'),
            'align' => 'left',
            'index' => 'next_action',
            'type' => 'options',
            'options' => Mage::getSingleton('inventorycustomer/system_config_source_action')->getOptionArray(),
        ));
        
        $this->addColumn('remind_at', array(
            'header' => Mage::helper('inventorycustomer')->__('Reminder'),
            'align' => 'left',
            'index' => 'remind_at',
            'width' => '100px',
            'type' => 'date',
            'format' => 'd/M/Y',
        ));

        return parent::_prepareColumns();
    }

    public function getHeadersVisibility() {
        return ($this->getCollection()->getSize() > 0);
    }
    
    public function getRowUrl($row) {
        return false;
    }

    public function getGridUrl() {
        return $this->getUrl('inventorycustomeradmin/adminhtml_allcustomers/interactionhistorygrid', array('_current' => true));
    }

}
