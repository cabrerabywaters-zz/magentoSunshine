<?php

class Magestore_Inventorycustomer_Block_Adminhtml_Returningcustomers_Grid extends Magestore_Inventorycustomer_Block_Adminhtml_Abstractgrid {

    public function __construct() {
        parent::__construct();
        $this->setId('returningcustomersGrid');
        $this->setDefaultSort('telephone');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection() {
        $customerCollection = Mage::helper('inventorycustomer/returningcustomers')->getCustomersHaveCompleteOrder($this->getRequestData());

        $this->setCollection($customerCollection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {

        $this->addColumn('telephone', array(
            'header' => Mage::helper('inventorycustomer')->__('Phone'),
            'align' => 'left',
            'index' => 'telephone',
            'renderer' => 'inventorycustomer/adminhtml_returningcustomers_renderer_customerphone'
        ));
        
        $this->addColumn('orders', array(
            'header' => Mage::helper('inventorycustomer')->__('Orders'),
            'align' => 'left',
            'index' => 'entity_id',
            'filter' => false,
            'sortable' => false,
            'renderer' => 'inventorycustomer/adminhtml_returningcustomers_renderer_orders'
        ));
        
        $this->addColumn('ratio', array(
            'header' => Mage::helper('inventorycustomer')->__('Ratio'),
            'align' => 'left',
            'index' => 'entity_id',
            'filter' => false,
            'sortable' => false,
            'renderer' => 'inventorycustomer/adminhtml_returningcustomers_renderer_orderratio'
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row) {
        return $this->getUrl('adminhtml/customer/edit', array('id' => $row->getId()));
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
            default :
                $field = $alias;
        }
        return $field;
    }

}
