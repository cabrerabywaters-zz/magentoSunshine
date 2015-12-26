<?php

class Magestore_Inventorycustomer_Block_Adminhtml_Manageinteractions_Renderer_Customertype extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    /**
     * Display customer type 1 = VIP, 2 = Normal, 3 = Not Satisfied
     * 
     * @param Varien_Object $row
     * @return string
     */
    public function render(Varien_Object $row) {
        $html = '';
        $customerType = $row->getData('customer_satisfaction_type');
        $customerPhone = $row->getData('telephone');

        switch ($customerType) {
            case 1:
                $html .= '<div style="text-transform: uppercase;font: Arial, Helvetica, sans-serif;font-weight: bold;background-color:#3CB861;color:#fff;width:100%;height:100%"> ' . $customerPhone . ' </div>';
                break;
            case 2:
                $html .= '<div style="text-transform: uppercase;font: Arial, Helvetica, sans-serif;font-weight: bold;background-color:#589AFF;color:#fff;width:100%;height:100%"> ' . $customerPhone . ' </div>';
                break;
            case 3:
                $html .= '<div style="text-transform: uppercase;font: Arial, Helvetica, sans-serif;font-weight: bold;background-color:#E41101;color:#fff;width:100%;height:100%"> ' . $customerPhone . ' </div>';
                break;
            default:
                break;
        }

        return $html;
    }

}
