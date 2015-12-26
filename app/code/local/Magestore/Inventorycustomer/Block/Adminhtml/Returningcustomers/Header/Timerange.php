<?php

class Magestore_Inventorycustomer_Block_Adminhtml_Returningcustomers_Header_Timerange extends Mage_Core_Block_Template {

    /**
     * prepare block's layout
     *
     * @return Magestore_Inventorycustomer_Block_Adminhtml_Returningcustomers_Header_Timerange
     */
    protected function _prepareLayout() {
        $this->setTemplate('inventorycustomer/returningcustomers/header/timerange.phtml');
        return parent::_prepareLayout();
    }

}
