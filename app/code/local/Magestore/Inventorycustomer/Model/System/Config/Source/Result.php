<?php

class Magestore_Inventorycustomer_Model_System_Config_Source_Result extends Varien_Object {

    /**
     * Options getter
     *
     * @return array
     */
    static public function getOptionArray() {
        $predefinedResult = Mage::getStoreConfig('inventoryplus/customer/predefined_result');
        $predefinedResultArray = explode(",", $predefinedResult);
        
        $data = array();
        $i = 1;
        foreach ($predefinedResultArray as $resultStr) {
            $data[$i] = Mage::helper('inventorycustomer')->__($resultStr);
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
