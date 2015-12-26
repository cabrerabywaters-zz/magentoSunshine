<?php

class Magestore_Inventorycustomer_Model_Mysql4_Customerinteraction extends Mage_Core_Model_Mysql4_Abstract {

    protected function _construct() {
        $this->_init('inventorycustomer/customerinteraction', 'customer_interaction_id');
    }

}
