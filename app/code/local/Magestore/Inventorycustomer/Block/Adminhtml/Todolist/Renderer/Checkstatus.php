<?php

class Magestore_Inventorycustomer_Block_Adminhtml_Todolist_Renderer_Checkstatus extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    /**
     * Display customer type 1 = VIP, 2 = Normal, 3 = Not Satisfied
     * 
     * @param Varien_Object $row
     * @return string
     */
    public function render(Varien_Object $row) {
        $html = '';
        $columnIndex = $this->getColumn()->getIndex();
        $remindAt = $row->getData('remind_at');
        $isDone = $row->getData('is_done');

        if (strcmp($columnIndex, 'customer_interaction_id') == 0) {
            if ($isDone == 0) { 
                $data = '<input type="checkbox" value="' . $row->getData('customer_interaction_id') . '" onclick="return deleteTodoItem(this);">';  
            } else {
                $data = '<input disabled type="checkbox" value="' . $row->getData('customer_interaction_id') . '" onclick="return deleteTodoItem(this);">';  
            }
        }

        if (strcmp($columnIndex, 'next_action') == 0) {
            $optionArray = Mage::getSingleton('inventorycustomer/system_config_source_action')->getOptionArray();
            $data = $optionArray[$row->getData('next_action')];
        }
        if (strcmp($columnIndex, 'remind_at') == 0) {
            $remindDate = new Datetime($remindAt);
            $data = $remindDate->format('d/m/Y');
        }
        if (strcmp($columnIndex, 'telephone') == 0) {
            $data = $row->getData('telephone');
        }
        
        if ($isDone == 1) {
            $html .= '<div style="text-decoration: line-through;font:bold Arial, Helvetica, sans-serif;background-color:#CCCCCC;color:#000;width:100%;height:100%"> ' . $data . ' </div>';
        } else {
            $today = new Datetime();
            $today->setTime(0, 0, 0);
            $remindDay = new DateTime($remindAt);

            if ($today > $remindDay) {
                $html .= '<div style="font:bold Arial, Helvetica, sans-serif;background-color:#E41101;color:#000;width:100%;height:100%"> ' . $data . ' </div>';
            } elseif ($today == $remindDay) {
                $html .= '<div style="font:bold Arial, Helvetica, sans-serif;background-color:#FF9933;color:#000;width:100%;height:100%"> ' . $data . ' </div>';
            } else {
                $html .= '<div style="font:bold Arial, Helvetica, sans-serif;background-color:#5CD65C;color:#000;width:100%;height:100%"> ' . $data . ' </div>';
            }
        }

        return $html;
    }

}
