<?php

class Magestore_Inventorycustomer_Block_Adminhtml_Returningcustomers_Renderer_Customerphone extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    /**
     * Display customer type 1 = VIP, 2 = Normal, 3 = Not Satisfied
     * 
     * @param Varien_Object $row
     * @return string
     */
    public function render(Varien_Object $row) {
        $html = '';
        $customerPhone = $row->getData('telephone');
        $customerEmail = $row->getData('email');
        $customerName = $row->getData('name');
        $customerType = $row->getData('customer_satisfaction_type');

        switch ($customerType) {
            case 1:
                if ($customerPhone) {
                    $html .= '<div style="font: Arial, Helvetica, sans-serif;font-weight: bold;background-color:#3CB861;color:#fff;width:100%;height:100%"> ' . $customerPhone . ' - ' . $customerName . ' </div>';
                } else {
                    $html .= '<div style="font: Arial, Helvetica, sans-serif;font-weight: bold;background-color:#3CB861;color:#fff;width:100%;height:100%"> ' . $customerEmail . ' - ' . $customerName . ' </div>';
                }
                break;
            case 2:
                if ($customerPhone) {
                    $html .= '<div style="font: Arial, Helvetica, sans-serif;font-weight: bold;background-color:#589AFF;color:#fff;width:100%;height:100%"> ' . $customerPhone . ' - ' . $customerName . ' </div>';
                } else {
                    $html .= '<div style="font: Arial, Helvetica, sans-serif;font-weight: bold;background-color:#589AFF;color:#fff;width:100%;height:100%"> ' . $customerEmail . ' - ' . $customerName . ' </div>';
                }
                break;
            case 3:
                if ($customerPhone) {
                    $html .= '<div style="font: Arial, Helvetica, sans-serif;font-weight: bold;background-color:#E41101;color:#fff;width:100%;height:100%"> ' . $customerPhone . ' - ' . $customerName . ' </div>';
                } else {
                    $html .= '<div style="font: Arial, Helvetica, sans-serif;font-weight: bold;background-color:#E41101;color:#fff;width:100%;height:100%"> ' . $customerEmail . ' - ' . $customerName . ' </div>';
                }
                break;
            default:
                break;
        }

        return $html;
    }

}
