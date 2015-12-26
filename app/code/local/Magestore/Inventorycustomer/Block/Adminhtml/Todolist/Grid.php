<?php

class Magestore_Inventorycustomer_Block_Adminhtml_Todolist_Grid extends Magestore_Inventorycustomer_Block_Adminhtml_Abstractgrid {

    public function __construct() {
        parent::__construct();
        $this->setId('todolistGrid');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection() {
        $todolistCollection = Mage::helper('inventorycustomer/todolist')->getTodolist();

        // Sort grid data
        $this->_sortCollection($todolistCollection);
        $this->setCollection($todolistCollection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {

        $this->addColumn('customer_interaction_id', array(
            'header_css_class' => 'a-center',
            'align' => 'center',
            'width' => '25px',
            'index' => 'customer_interaction_id',
            'type' => 'checkbox',
            'renderer' => 'inventorycustomer/adminhtml_todolist_renderer_checkstatus'
        ));
        
        $this->addColumn('next_action', array(
            'header' => Mage::helper('inventorycustomer')->__('Things To Do'),
            'align' => 'left',
            'index' => 'next_action',
            'type' => 'options',
            'options' => Mage::getSingleton('inventorycustomer/system_config_source_action')->getOptionArray(),
            'renderer' => 'inventorycustomer/adminhtml_todolist_renderer_checkstatus'
        ));
        
        $this->addColumn('telephone', array(
            'header' => Mage::helper('inventorycustomer')->__('Customer'),
            'align' => 'right',
            'width' => '100px',
            'index' => 'telephone',
            'renderer' => 'inventorycustomer/adminhtml_todolist_renderer_checkstatus'
        ));
        
        $this->addColumn('remind_at', array(
            'header' => Mage::helper('inventorycustomer')->__('Due Date'),
            'align' => 'right',
            'width' => '150px',
            'index' => 'remind_at',
            'type' => 'date',
            'renderer' => 'inventorycustomer/adminhtml_todolist_renderer_checkstatus'
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
            default :
                $field = $alias;
        }
        return $field;
    }

}
