<?php

class Magestore_Inventorycustomer_Block_Adminhtml_Allcustomers_Renderer_Customertype extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    /**
     * Display customer type 1 = VIP, 2 = Normal, 3 = Not Satisfied
     * 
     * @param Varien_Object $row
     * @return string
     */
    public function render(Varien_Object $row) {
        $html = '';
        $customerType = $row->getData('customer_satisfaction_type');

        switch ($customerType) {
            case 1:
                $html .= '<div style="text-transform: uppercase;font:bold 10px/16px Arial, Helvetica, sans-serif;background-color:#3CB861;color:#fff;width:100%;height:100%"> ' . $this->__('VIP') . ' </div>';
                break;
            case 2:
                $html .= '<div style="text-transform: uppercase;font:bold 10px/16px Arial, Helvetica, sans-serif;background-color:#589AFF;color:#fff;width:100%;height:100%"> ' . $this->__('Normal') . ' </div>';
                break;
            case 3:
                $html .= '<div style="text-transform: uppercase;font:bold 10px/16px Arial, Helvetica, sans-serif;background-color:#E41101;color:#fff;width:100%;height:100%"> ' . $this->__('Not Satisfied') . ' </div>';
                break;
            default:
                break;
        }

        return $html;
    }

}
