<?php

class Magestore_Inventorycustomer_Block_Adminhtml_Customertypes_Customergrid_Notsatisfied extends Magestore_Inventorycustomer_Block_Adminhtml_Abstractgrid {

    public function __construct() {
        parent::__construct();
        $this->setId('notsatisfiedcustomersGrid');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection() {
        $notsatisfiedCustomersCollection = Mage::helper('inventorycustomer/customertypes')->getNotsatisfiedCustomers();
        $this->setCollection($notsatisfiedCustomersCollection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {

        $this->addColumn('telephone', array(
            'header' => Mage::helper('inventorycustomer')->__('Not Satisfied'),
            'index' => 'telephone',
            'header_css_class'=>'a-center',
            'renderer' => 'inventorycustomer/adminhtml_customertypes_renderer_customertype'
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row) {
        return $this->getUrl('adminhtml/customer/edit', array('id' => $row->getId()));
    }

    public function getGridUrl() {
        return $this->getUrl('*/*/notsatisfiedcustomersgrid', array('_current' => true));
    }

    /**
     * Get real filed from alias in sql
     * 
     * @param string $alias
     * @return string
     */
    protected function _getRealFieldFromAlias($alias) {
//        $field = null;
//        $report = $this->getReport();
//        switch ($alias) {
//            case 'last_order_date':
//                $field = 'max(order.created_at)';
//                break;
//            case 'number_orders':
//                $field = 'IFNULL(count(order.entity_id), 0)';
//                break;
//            case 'number_items':
//                $field = 'IFNULL(sum(order.total_qty_ordered), 0)';
//                break;
//            case 'total_value':
//                $field = 'IFNULL(sum(order.grand_total), 0)';
//                break;
//            default :
//                $field = $alias;
//        }
//        return $field;
    }

}
