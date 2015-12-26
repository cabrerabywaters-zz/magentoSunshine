<?php

class Magestore_Inventorycustomer_Block_Adminhtml_Returningcustomers_Renderer_Orderratio extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    /**
     * Display the average time a customer make orders
     * 
     * @param Varien_Object $row
     * @return string
     */
    public function render(Varien_Object $row) {
        $datefrom = Mage::getSingleton('inventorycustomer/session')->getData('dateFrom');
        $dateto = Mage::getSingleton('inventorycustomer/session')->getData('dateTo');


        $html = '<div>';
        $customerId = $row->getData('entity_id');

        $customerOrders = Mage::helper('inventorycustomer/returningcustomers')->getReturningCustomerOrders($customerId);
        $customerOrders->addFieldToFilter('created_at', array(
            'from' => $datefrom,
            'to' => $dateto,
            'date' => true,
        ));

        $totalOrders = $customerOrders->getSize();
        if ($totalOrders > 1) {
            $firstOrderDate = $customerOrders->getFirstItem()->getData('created_at');
            $lastOrderDate = $customerOrders->getLastItem()->getData('created_at');
            $html = Mage::helper('inventorycustomer/returningcustomers')->getFormattedTimeRange($firstOrderDate, $lastOrderDate, $totalOrders, $html);
        } elseif ($totalOrders == 1) {
            $html .= "N/A";
//            $firstOrderDate = $datefrom;
//            $lastOrderDate = $dateto;
//            $html = Mage::helper('inventorycustomer/returningcustomers')->getFormattedTimeRange($firstOrderDate, $lastOrderDate, $totalOrders, $html);
        } else {
            $html .= "Chưa mua tiếp";
        }
        $html .= '</div>';

        return $html;
    }

}
