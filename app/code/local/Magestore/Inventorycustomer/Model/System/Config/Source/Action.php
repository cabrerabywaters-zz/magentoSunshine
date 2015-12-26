<?php

class Magestore_Inventorycustomer_Model_System_Config_Source_Action extends Varien_Object {

    /**
     * Options getter
     *
     * @return array
     */
    static public function getOptionArray() {
        $predefinedAction = Mage::getStoreConfig('inventoryplus/customer/predefined_action');
        $predefinedActionArray = explode(",", $predefinedAction);
        
        $data = array();
        $i = 1;
        foreach ($predefinedActionArray as $actionStr) {
            $data[$i] = Mage::helper('inventorycustomer')->__($actionStr);
            $i++;
        }
        return $data;
    }

    static public function getOptionHash() {
        $options = array();
        foreach (self::getOptionArray() as $value => $label)
            $options[] = array(
                'value' => $value,
                'label' => $label
            );
        return $options;
    }

}
