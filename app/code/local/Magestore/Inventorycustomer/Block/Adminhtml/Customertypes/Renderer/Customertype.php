<?php

class Magestore_Inventorycustomer_Block_Adminhtml_Customertypes_Renderer_Customertype extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    /**
     * Change color of row for each type of customer
     * 
     * @param Varien_Object $row
     * @return string
     */
    public function render(Varien_Object $row) {
        $customerId = $row->getData('entity_id');
        $showNotesUrl = Mage::helper("adminhtml")->getUrl('inventorycustomeradmin/adminhtml_customertypes/notes', array('id'=> $customerId));
        $customerType = $row->getData('customer_satisfaction_type');
        $customerEmail = $row->getData('email');
        $customerPhone =  $row->getData('telephone');
        $customerName = $row->getData('name');
        $html = '';
        switch ($customerType) {
            case 1:
                if ($customerPhone) {
                    $html .= "<div id='customer" . $customerId . "' draggable='true' ondragstart='handleDrag(event)' class='customer-types-grid-row' style='background-color:#29A329;'> " . $customerPhone . " - " . $customerName . " <a class='customer-types-notes-link' href='' onclick='window.open( "."\"" . $showNotesUrl . "\"". "," ."\"" . $this->__('Notes') . "\""."," ."\"" . 'scrollbars=yes, resizable=yes, width=1000, height=300, top=150, left=200' . "\""."); return false;' target='_blank'>" . $this->__('(i)'). "</a>" . " </div>";
                } else {
                    $html .= "<div id='customer" . $customerId . "' draggable='true' ondragstart='handleDrag(event)' class='customer-types-grid-row' style='background-color:#29A329;'> " . $customerEmail . " - " . $customerName . " <a class='customer-types-notes-link' href='' onclick='window.open( "."\"" . $showNotesUrl . "\"". "," ."\"" . $this->__('Notes') . "\""."," ."\"" . 'scrollbars=yes, resizable=yes, width=1000, height=300, top=150, left=200' . "\""."); return false;' target='_blank'>" . $this->__('(i)'). "</a>" . " </div>";
                }
                break;
            case 2:
                if ($customerPhone) {
                    $html .= "<div id='customer" . $customerId . "' draggable='true' ondragstart='handleDrag(event)' class='customer-types-grid-row' style='background-color:#008AE6;'> " . $customerPhone . " - " . $customerName . " <a class='customer-types-notes-link' href='' onclick='window.open( "."\"" . $showNotesUrl . "\"". "," ."\"" . $this->__('Notes') . "\""."," ."\"" . 'scrollbars=yes, resizable=yes, width=1000, height=300, top=150, left=200' . "\""."); return false;' target='_blank'>" . $this->__('(i)'). "</a>" . " </div>";
                } else {
                    $html .= "<div id='customer" . $customerId . "' draggable='true' ondragstart='handleDrag(event)' class='customer-types-grid-row' style='background-color:#008AE6;'> " . $customerEmail . " - " . $customerName . " <a class='customer-types-notes-link' href='' onclick='window.open( "."\"" . $showNotesUrl . "\"". "," ."\"" . $this->__('Notes') . "\""."," ."\"" . 'scrollbars=yes, resizable=yes, width=1000, height=300, top=150, left=200' . "\""."); return false;' target='_blank'>" . $this->__('(i)'). "</a>" . " </div>";
                }
                break;
            case 3:
                if ($customerPhone) {
                    $html .= "<div id='customer" . $customerId . "' draggable='true' ondragstart='handleDrag(event)' class='customer-types-grid-row' style='background-color:#E60000;'> " . $customerPhone . " - " . $customerName . " <a class='customer-types-notes-link' href='' onclick='window.open( "."\"" . $showNotesUrl . "\"". "," ."\"" . $this->__('Notes') . "\""."," ."\"" . 'scrollbars=yes, resizable=yes, width=1000, height=300, top=150, left=200' . "\""."); return false;' target='_blank'>" . $this->__('(i)'). "</a>" . " </div>";
                } else {
                    $html .= "<div id='customer" . $customerId . "' draggable='true' ondragstart='handleDrag(event)' class='customer-types-grid-row' style='background-color:#E60000;'> " . $customerEmail . " - " . $customerName . " <a class='customer-types-notes-link' href='' onclick='window.open( "."\"" . $showNotesUrl . "\"". "," ."\"" . $this->__('Notes') . "\""."," ."\"" . 'scrollbars=yes, resizable=yes, width=1000, height=300, top=150, left=200' . "\""."); return false;' target='_blank'>" . $this->__('(i)'). "</a>" . " </div>";
                }
                break;
        }
        return $html;
    }

}
