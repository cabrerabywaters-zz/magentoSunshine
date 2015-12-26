<?php

class Magestore_Inventorycustomer_Block_Adminhtml_Manageinteractions_Grid extends Magestore_Inventorycustomer_Block_Adminhtml_Abstractgrid {

    public function __construct() {
        parent::__construct();
        $this->setId('manageinteractionsGrid');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection() {
        $interactionCollection = Mage::helper('inventorycustomer/manageinteractions')->getListInteractions();

        $this->setCollection($interactionCollection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        
        $this->addColumn('action', array(
            'header' => Mage::helper('inventorycustomer')->__('Action'),
            'align' => 'left',
            'index' => 'action',
            'type' => 'options',
            'options' => Mage::getSingleton('inventorycustomer/system_config_source_action')->getOptionArray(),
        ));
        
        $this->addColumn('telephone', array(
            'header' => Mage::helper('inventorycustomer')->__('Customer'),
            'align' => 'right',
            'width' => '100px',
            'index' => 'telephone',
            'renderer' => 'inventorycustomer/adminhtml_manageinteractions_renderer_customertype'
        ));
        
        $this->addColumn('result', array(
            'header' => Mage::helper('inventorycustomer')->__('Result'),
            'align' => 'left',
            'index' => 'result',
            'type' => 'options',
            'options' => Mage::getSingleton('inventorycustomer/system_config_source_result')->getOptionArray(),
        ));
        
        $this->addColumn('date', array(
            'header' => Mage::helper('inventorycustomer')->__('Date'),
            'align' => 'right',
            'width' => '150px',
            'index' => 'interaction_created_at',
            'filter_index' => 'main_table.created_at',
            'type' => 'date',
            'format' => 'd/M/Y',
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
