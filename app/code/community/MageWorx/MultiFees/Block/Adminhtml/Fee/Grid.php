<?php
/**
 * MageWorx
 * Multi Fees Extension
 *
 * @category   MageWorx
 * @package    MageWorx_MultiFees
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */
class MageWorx_MultiFees_Block_Adminhtml_Fee_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('fee_id');
        $this->setDefaultSort('id');
        $this->setDefaultDir(Varien_Data_Collection::SORT_ORDER_DESC);
	$this->setSaveParametersInSession(true);
    }

    /**
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection() {
        $collection = Mage::getResourceModel('mageworx_multifees/fee_collection')
            ->addLabels(0)
            ->addStoresVisibility();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * @return $this
     */
    protected function _prepareColumns() {
        $helper = Mage::helper('mageworx_multifees');
        
        $this->addColumn('id', array(
            'header' => Mage::helper('catalog')->__('ID'),
            'type' => 'number',
            'width' => '80px',
            'index' => 'fee_id',
        ));
        
        $this->addColumn('name', array(
            'header' => Mage::helper('catalog')->__('Name'),
            'index' => 'title'
        ));

        $this->addColumn('type', array(
            'header' => Mage::helper('catalog')->__('Type'),
            'width' => '100px',
            'index' => 'type',
            'type' => 'options',
            'options' => $helper->getTypeArray(),
        ));
        
        
        $this->addColumn('input_type', array(
            'header' => Mage::helper('catalog')->__('Input Type'),
            'width' => '100px',
            'index' => 'input_type',
            'type' => 'options',
            'options' => $helper->getInputTypeArray(),
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('stores', array(
                'header' => Mage::helper('catalog')->__('Store View'),
                'width' => '200px',
                'index' => 'stores',
                'type' => 'store',
                'store_view' => true,
                'sortable' => false,
                'filter_condition_callback'
                => array($this, '_filterStoreCondition'),
            ));
        }

        $this->addColumn('required', array(
            'header' => $helper->__('Required'),
            'width' => '80px',
            'index' => 'required',
            'sortable' => false,
            'type' => 'options',
            'options' => $helper->getNoYesArray(),
            'align' => 'center'
        ));

        $this->addColumn('sort_order', array(
            'header' => Mage::helper('catalog')->__('Sort Order'),
            'type' => 'number',
            'width' => '80px',
            'index' => 'sort_order',
        ));

        
        $this->addColumn('total_ordered', array(
            'header' => $helper->__('Ordered'),
            'type' => 'number',
            'width' => '80px',
            'index' => 'total_ordered',
        ));
        
        $currencyCode = $this->getCurrentCurrencyCode();
        $this->addColumn('total_base_amount', array(
            'header' => $helper->__('Total'),
            'type' => 'currency',
            'currency_code' => $currencyCode,
            'width' => '80px',
            'index' => 'total_base_amount',
        ));
        
        
        $this->addColumn('status', array(
            'header' => $helper->__('Status'),
            'width' => '80px',
            'index' => 'status',
            'type' => 'options',
            'options' => $helper->getStatusArray(),
            'align' => 'center'
        ));

        $this->addColumn('action', 
            array(
                'header'    => Mage::helper('catalog')->__('Action'),
                'width'     => '50px',
                'type'      => 'action',
                'getter'     => 'getId',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('catalog')->__('Edit'),
                        'url'     => array('base'=>'*/*/edit'),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
                'align' => 'center'            
        ));

        return parent::_prepareColumns();
    }

    /**
     * @param $row
     * @return string
     */
    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    /**
     * @return mixed|string
     */
    public function getCurrentCurrencyCode() {
        if (is_null($this->_currentCurrencyCode)) {
            $this->_currentCurrencyCode = (count($this->_storeIds) > 0)
                ? Mage::app()->getStore(array_shift($this->_storeIds))->getBaseCurrencyCode()
                : Mage::app()->getStore()->getBaseCurrencyCode();
        }
        return $this->_currentCurrencyCode;
    }

    /**
     * @param $column
     * @return $this
     */
    protected function _addColumnFilterToCollection($column)
    {
        if($column->getIndex()=='stores') {
            $this->getCollection()->addStoreFilter($column->getFilter()->getCondition(), false);
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    /**
     * @param $collection
     * @param $column
     */
    protected function _filterStoreCondition($collection, $column) {
        if (!$value = $column->getFilter()->getValue()) return;
        $this->getCollection()->addStoreFilter($value);
    }

    /**
     * @return $this|Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareMassaction() {
        $helper = Mage::helper('mageworx_multifees');
        
        $this->setMassactionIdField('fee_id');
        $this->getMassactionBlock()->setFormFieldName('fee');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('catalog')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => $helper->__('Are you sure you want to do this?')
        ));
                
        $statuses = array();
        $statuses[''] = '';
        $array = $helper->getStatusArray();
        foreach($array as $key=>$value) {
             $statuses[$key] = $value;
        }

        $this->getMassactionBlock()->addItem('status', array(
            'label' => Mage::helper('catalog')->__('Change status'),
            'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('catalog')->__('Status'),
                    'values' => $statuses
                )
            )
        ));

        return $this;
    }

}