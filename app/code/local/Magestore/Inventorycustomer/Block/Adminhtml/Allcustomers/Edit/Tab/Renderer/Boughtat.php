<?php

class Magestore_Inventorycustomer_Block_Adminhtml_Allcustomers_Edit_Tab_Renderer_Boughtat extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    /**
     * Display Warehouse name from order_id
     * 
     * @param Varien_Object $row
     * @return string
     */
    public function render(Varien_Object $row) {
        $orderId = $row->getData('entity_id');
        $warehouseOrder = Mage::getModel('inventoryplus/warehouse_order')->getCollection()
                ->addFieldToFilter('order_id', $orderId);
        
        // Check if all warehouse_order's order_id are the same
        // If not, return "Online"
        $warehouseId = $warehouseOrder->getFirstItem()->getWarehouseId();
        foreach ($warehouseOrder as $row) {
            if ($row->getWarehouseId() != $warehouseId) {
                return "Online";
            }
        }
        
        // If all order_id are the same, get warehouse name
        $warehouse = Mage::getModel('inventoryplus/warehouse')->load($warehouseId);
        if ($warehouse->getId()) {
            return $warehouse->getWarehouseName();
        }
        
        // If can not find warehouse name, return "Online"
        return "Online";
    }

}
