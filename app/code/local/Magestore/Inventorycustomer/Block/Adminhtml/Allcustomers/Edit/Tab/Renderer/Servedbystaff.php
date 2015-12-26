<?php

class Magestore_Inventorycustomer_Block_Adminhtml_Allcustomers_Edit_Tab_Renderer_Servedbystaff extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    /**
     * Get Admin user name who served an order
     * 
     * @param Varien_Object $row
     * @return string
     */
    public function render(Varien_Object $row) {
        $userId = $row->getData('served_by_staff');
        $user = Mage::getModel('admin/user')->load($userId);
        if ($user->getId()) {
            return $user->getEmail();
        }
        
        // If no admin found
        return "N/A";
    }

}
