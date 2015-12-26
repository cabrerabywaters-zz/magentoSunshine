<?php

class Magestore_Inventorycustomer_Block_Adminhtml_Allcustomers_Grid extends Magestore_Inventorycustomer_Block_Adminhtml_Abstractgrid {

    public function __construct() {
        parent::__construct();
        $this->setId('allcustomersGrid');
        $this->setDefaultSort('total_value');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection() {
        $customersCollection = Mage::helper('inventorycustomer/allcustomers')->getCustomersHaveCompleteOrder();

        if (Mage::getSingleton("inventorycustomer/session")->getData("searchValue")) {
            $searchValue = Mage::getSingleton("inventorycustomer/session")->getData("searchValue");
            $customersCollection->addAttributeToFilter(
                    array(
                        array('attribute' => 'email', 'like' => '%' . $searchValue . '%'),
                        array('attribute' => 'telephone', 'like' => '%' . $searchValue . '%')
                    )
            );
            Mage::getSingleton("inventorycustomer/session")->setData("searchValue", null);
        }

        $this->setCollection($customersCollection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $currencyCode = Mage::app()->getStore()->getBaseCurrency()->getCode();

        $this->addColumn('name', array(
            'header' => Mage::helper('inventorycustomer')->__('Full Name'),
            'align' => 'left',
            'index' => 'name',
            'renderer' => 'inventorycustomer/adminhtml_allcustomers_renderer_inline',
        ));

        $this->addColumn('email', array(
            'header' => Mage::helper('inventorycustomer')->__('Email'),
            'align' => 'left',
            'index' => 'email',
            'renderer' => 'inventorycustomer/adminhtml_allcustomers_renderer_inline',
        ));

        $this->addColumn('telephone', array(
            'header' => Mage::helper('inventorycustomer')->__('Phone Number'),
            'align' => 'left',
            'index' => 'telephone',
            'renderer' => 'inventorycustomer/adminhtml_allcustomers_renderer_inline',
        ));
        
        $this->addColumn('created_at', array(
            'header' => Mage::helper('inventorycustomer')->__('Created Date'),
            'align' => 'left',
            'index' => 'created_at',
            'type' => 'date',
            'format' => 'd/M/Y',
        ));

        $this->addColumn('last_order_date', array(
            'header' => Mage::helper('inventorycustomer')->__('Recent Ordered'),
            'align' => 'left',
            'index' => 'last_order_date',
            'type' => 'date',
            'format' => 'd/M/Y',
            'filter_condition_callback' => array($this, '_filterDateCallback'),
        ));

        $this->addColumn('number_orders', array(
            'header' => Mage::helper('inventorycustomer')->__('Num. Orders'),
            'align' => 'left',
            'index' => 'number_orders',
            'type' => 'number',
            'filter_condition_callback' => array($this, '_filterNumberCallback'),
        ));

        $this->addColumn('number_items', array(
            'header' => Mage::helper('inventorycustomer')->__('Num. Items'),
            'align' => 'left',
            'index' => 'number_items',
            'type' => 'number',
            'filter_condition_callback' => array($this, '_filterNumberCallback'),
        ));

        $this->addColumn('total_value', array(
            'header' => Mage::helper('inventorycustomer')->__('Total Value'),
            'width' => '150px',
            'align' => 'left',
            'type' => 'price',
            'currency_code' => $currencyCode,
            'index' => 'total_value',
            'filter_condition_callback' => array($this, '_filterNumberCallback'),
        ));

        $this->addColumn('customer_satisfaction_type', array(
            'header' => Mage::helper('inventorycustomer')->__('Customer Type'),
            'align' => 'center',
            'width' => '80px',
            'index' => 'customer_satisfaction_type',
            'type' => 'options',
            'options' => Mage::getSingleton('inventorycustomer/attribute_source_customer')->getOptionArray(),
            'renderer' => 'inventorycustomer/adminhtml_allcustomers_renderer_customertype'
        ));
        
        $this->addColumn('action',
            array(
                'header'    => Mage::helper('catalog')->__('Action'),
                'width'     => '50px',
                'type'      => 'action',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('catalog')->__('Edit'),
                        'url'     => array(
                            'base'=>'*/*/edit',
                        ),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'entity_id',
        ));

        $this->addCSVExport();
        
        return parent::_prepareColumns();
    }

    public function getRowUrl($row) {
        return false;
    }

    public function getGridUrl() {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }

    /**
     * Get real filed from alias in sql
     * 
     * @param string $alias
     * @return string
     */
    protected function _getRealFieldFromAlias($alias) {
        $field = null;
        switch ($alias) {
            case 'last_order_date':
                $field = 'max(order.created_at)';
                break;
            case 'number_orders':
                $field = 'IFNULL(count(order.entity_id), 0)';
                break;
            case 'number_items':
                $field = 'IFNULL(sum(order.total_qty_ordered), 0)';
                break;
            case 'total_value':
                $field = 'IFNULL(sum(order.grand_total), 0)';
                break;
            default :
                $field = $alias;
        }
        return $field;
    }

}
