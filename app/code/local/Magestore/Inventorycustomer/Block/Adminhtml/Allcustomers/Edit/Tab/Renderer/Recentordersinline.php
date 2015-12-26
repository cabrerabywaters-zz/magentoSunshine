<?php

class Magestore_Inventorycustomer_Block_Adminhtml_Allcustomers_Edit_Tab_Renderer_Recentordersinline
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $orderId = $row->getId();
        $columnIndex = $this->getColumn()->getIndex() . "";
        $elementId = $columnIndex . $orderId;
        switch ($columnIndex) {
            case 'warranty_date':
                $columnIndexCode = 1;
                break;
            case 'warranty_result':
                $columnIndexCode = 2;
                break;
            default:
                break;
        }
        $url = Mage::helper('adminhtml')->getUrl('inventorycustomeradmin/adminhtml_allcustomers/updateorder', array('order_id' => $orderId, 'columnIndexCode' => $columnIndexCode));
        $html = '<div id="' . $elementId . '" style="min-height:20px;">';
        $html .= parent::render($row);
        $html .= '</div>';
        $html .= '<script type="text/javascript">new Ajax.InPlaceEditor("' . $elementId . '", "' . $url . '", {okText: "", cancelText:".....", highlightColor:"#6ADADA"});</script>';
 
        return $html;
    }
 
}