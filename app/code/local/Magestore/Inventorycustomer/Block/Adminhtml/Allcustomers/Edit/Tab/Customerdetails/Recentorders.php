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
class Magestore_Inventorycustomer_Block_Adminhtml_Allcustomers_Edit_Tab_Customerdetails_Recentorders extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('inventorycustomer_allcustomers_customerdetails_recentorders_grid');
        $this->setDefaultSort('created_at', 'desc');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareLayout() {
        return parent::_prepareLayout();
    }

    protected function _prepareCollection() {
        $recentOrdersCollection = Mage::getModel('sales/order')->getCollection()
                ->addFieldToSelect(array('entity_id', 'created_at', 'increment_id', 'grand_total', 'coupon_code', 'served_by_staff', 'warranty_date', 'warranty_result'))
                ->addFieldToFilter('customer_id', $this->getRequest()->getParam("id"))
                ->addFieldToFilter('status', array('eq' => 'complete'));
        $this->setCollection($recentOrdersCollection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $currencyCode = Mage::app()->getStore()->getBaseCurrency()->getCode();
        
        $this->addColumn('created_at', array(
            'header' => Mage::helper('inventorycustomer')->__('Purchased On'),
            'align' => 'left',
            'index' => 'created_at',
            'width' => '100px',
            'type' => 'date',
            'format' => 'd/M/Y',
        ));

        $this->addColumn('increment_id', array(
            'header' => Mage::helper('inventorycustomer')->__('Order Number'),
            'align' => 'left',
            'index' => 'increment_id',
            'width' => '120px',
        ));

        $this->addColumn('items', array(
            'header' => Mage::helper('inventorycustomer')->__('Items'),
            'align' => 'left',
            'index' => 'entity_id',
            'sortable' => false,
            'filter'    => false,
            'renderer' => 'inventorycustomer/adminhtml_allcustomers_edit_tab_renderer_orderitems'
        ));

        $this->addColumn('grand_total', array(
            'header' => Mage::helper('inventorycustomer')->__('Value'),
            'align' => 'left',
            'index' => 'grand_total',
            'type' => 'price',
            'currency_code' => $currencyCode,
        ));

        $this->addColumn('coupon_code', array(
            'header' => Mage::helper('inventorycustomer')->__('Coupon'),
            'align' => 'left',
            'index' => 'coupon_code',
        ));

        $this->addColumn('bought_at', array(
            'header' => Mage::helper('inventorycustomer')->__('Bought At'),
            'align' => 'left',
            'index' => 'entity_id',
            'sortable' => false,
            'filter'    => false,
            'renderer' => 'inventorycustomer/adminhtml_allcustomers_edit_tab_renderer_boughtat'
        ));

        $this->addColumn('served_by_staff', array(
            'header' => Mage::helper('inventorycustomer')->__('Staff'),
            'align' => 'left',
            'index' => 'served_by_staff',
            'sortable' => false,
            'filter'    => false,
            'renderer' => 'inventorycustomer/adminhtml_allcustomers_edit_tab_renderer_servedbystaff'
        ));
        
        $this->addColumn('warranty_date', array(
            'header' => Mage::helper('inventorycustomer')->__('Warranty Date'),
            'align' => 'left',
            'index' => 'warranty_date',
            'width' => '100px',
            'type' => 'date',
            'format' => 'd/M/Y',
            'renderer' => 'inventorycustomer/adminhtml_allcustomers_edit_tab_renderer_recentordersinline',
        ));

        $this->addColumn('warranty_result', array(
            'header' => Mage::helper('inventorycustomer')->__('Warranty Result'),
            'align' => 'left',
            'index' => 'warranty_result',
            'renderer' => 'inventorycustomer/adminhtml_allcustomers_edit_tab_renderer_recentordersinline',
        ));
        
        $this->addColumn('action',
            array(
                'header'    => Mage::helper('catalog')->__('Action'),
                'width'     => '50px',
                'type'      => 'action',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('catalog')->__('View'),
                        'url'     => array(
                            'base'=>'adminhtml/sales_order/view',
                        ),
                        'field'   => 'order_id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'entity_id',
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row) {
        return false;
    }
    
    public function getGridUrl() {
        return $this->getUrl('*/*/recentordersgrid', array('_current' => true));
    }

    public function getHeadersVisibility() {
        return ($this->getCollection()->getSize() > 0);
    }

}
