<?php

class Magestore_Inventoryreports_Block_Adminhtml_Reportcontent_Renderer_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    public function render(Varien_Object $row) {        
        //get row order ids
        $orderIds = $row->getAllOrderId();
        $filter .= 'orderids='.$orderIds;
        $filter = base64_encode($filter);
        $orderUrl = Mage::helper("adminhtml")->getUrl('inventoryreportsadmin/adminhtml_sales/orders',array('top_filter'=>$filter,"_secure" => Mage::app()->getStore()->isCurrentlySecure()));
        $html .= "<a href='$orderUrl'>".$this->__('View Orders List')."</a>";
        return $html;
    }
}
