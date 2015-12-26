<?php

class Magestore_Inventorycustomer_Block_Adminhtml_Allcustomers_Edit_Tab_Renderer_Orderitems extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    /**
     * Display list of items (sku) in each order
     * 
     * @param Varien_Object $row
     * @return string
     */
    public function render(Varien_Object $row) {
        $html = '';
        $orderId = $row->getData('entity_id');
        $orderItemsCollection = Mage::getModel('sales/order_item')->getCollection()
                ->addFieldToSelect(array('sku', 'name'))
                ->addFieldToFilter('order_id', $orderId)
                ->addFieldToFilter('parent_item_id', array('null' => true));
        foreach ($orderItemsCollection as $item) {
            $html .= '<div>' . $item->getSku() . '<br>';
        }
        $html .= '</div>';
        return $html;
    }

}
