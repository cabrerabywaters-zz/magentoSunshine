<?php

class Magestore_Inventorycustomer_Block_Adminhtml_Returningcustomers_Renderer_Orders extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    /**
     * Display customer type 1 = VIP, 2 = Normal, 3 = Not Satisfied
     * 
     * @param Varien_Object $row
     * @return string
     */
    public function render(Varien_Object $row) {
        $datefrom = Mage::getSingleton('inventorycustomer/session')->getData('dateFrom');
        $dateto = Mage::getSingleton('inventorycustomer/session')->getData('dateTo');

        $customerId = $row->getData('entity_id');

        $customerOrders = Mage::helper('inventorycustomer/returningcustomers')->getReturningCustomerOrders($customerId);
        $customerOrders->addFieldToFilter('created_at', array(
            'from' => $datefrom,
            'to' => $dateto,
            'date' => true,
        ));


        $numberCustomers = $customerOrders->getSize();
        if ($numberCustomers <= 5) {
            $html = '<table>';
            $i = 1;
            foreach ($customerOrders as $order) {
                $createdAt = new DateTime($order->getData('created_at'));
                $formatDate = $createdAt->format('d-m-Y');
                $html .= '<tr>';
                $html .= '<td width="30%">Order ' . $i . '</td>';
                $html .= '<td>' . $formatDate . '</td>';
                $html .= '</tr>';
                $i++;
            }
            $html .= '</table>';
        } else {
            $html = '<table>';
            $cloneCustomerDisplayFirst = clone $customerOrders;
            $cloneCustomerDisplayFirst->getSelect()->limit(5);
            $i = 1;
            foreach ($cloneCustomerDisplayFirst as $showFirstOrder) {
                $createdAt = new DateTime($showFirstOrder->getData('created_at'));
                $formatDate = $createdAt->format('d-m-Y');
                $html .= '<tr>';
                $html .= '<td width="30%">Order ' . $i . '</td>';
                $html .= '<td>' . $formatDate . '</td>';
                $html .= '</tr>';
                $i++;
            }
            $html .= '</table>';
            
            $cloneCustomerDisplayAfter = clone $customerOrders;
            $cloneCustomerDisplayAfter->getSelect()->limit($numberCustomers - 5, 6);
            $html .= '<div id="slidedown' . $customerId . '" style="display:none;">';
            $html .= '<div>';
            $html .= '<table>';
            $j = 6;
            foreach ($cloneCustomerDisplayAfter as $showAfterOrder) {
                $createdAt = new DateTime($showAfterOrder->getData('created_at'));
                $formatDate = $createdAt->format('d-m-Y');
                $html .= '<tr>';
                $html .= '<td width="30%">Order ' . $j . '</td>';
                $html .= '<td>' . $formatDate . '</td>';
                $html .= '</tr>';
                $j++;
            }
            $html .= '</table>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= "<a href='#' id='load-more-order' onclick='Effect.toggle(\"slidedown" . $customerId . "\", \"slide\"); return false;'>Show</a>";
        }

        return $html;
    }

}
