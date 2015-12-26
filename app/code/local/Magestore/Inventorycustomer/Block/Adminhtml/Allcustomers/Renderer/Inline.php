<?php

class Magestore_Inventorycustomer_Block_Adminhtml_Allcustomers_Renderer_Inline
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $customerId = $row->getId();
        $columnIndex = $this->getColumn()->getIndex() . "";
        $elementId = $columnIndex . $customerId;
        switch ($columnIndex) {
            case 'name':
                $columnIndexCode = 1;
                break;
            case 'email':
                $columnIndexCode = 2;
                break;
            case 'telephone':
                $columnIndexCode = 3;
                break;
            case 'customer_satisfaction_type':
                $columnIndexCode = 4;
                break;
        }
        $url = Mage::helper('adminhtml')->getUrl('*/*/updatefield', array('id' => $customerId, 'columnIndexCode' => $columnIndexCode));
        $html = '<div id="' . $elementId . '" style="min-height:20px;">';
        $html .= parent::render($row);
        $html .= '</div>';
        $html .= '<script type="text/javascript">new Ajax.InPlaceEditor("' . $elementId . '", "' . $url . '", {okText: "", cancelText:".....", highlightColor:"#6ADADA"});</script>';
 
        return $html;
    }
 
}